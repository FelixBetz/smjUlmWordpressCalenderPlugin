"""
    This module syncs a master calendery to destination calendars by category.
"""

import os
import argparse
from functools import partial
import caldav


USERNAME = "FelixBetz"
PASSWORD = "*****"


def filter_event_by_category(arg_event, arg_sync_categories):
    """filter if event at least one event category is in sync_categories"""
    # CATEGORIES key does not exists => no categories
    if not "CATEGORIES" in arg_event.icalendar_component:
        return False

    for event_category in arg_event.icalendar_component["CATEGORIES"].cats:
        if event_category.title().lower() in arg_sync_categories:
            return True

    return False


def sync_calender(arg_source_events, arg_destination_calendar, arg_sync_categories):
    """sync given source event to destination calendar by sync categories"""
    # only filter if at least one sync category
    if len(arg_sync_categories) > 0:
        # all categories to lowe case
        arg_sync_categories = [c.lower() for c in arg_sync_categories]
        filter_func = partial(
            filter_event_by_category, arg_sync_categories=arg_sync_categories
        )
        arg_source_events = list(filter(filter_func, arg_source_events))

    destination_events = arg_destination_calendar.events()

    src_calendar_uids = []
    for event in arg_source_events:
        src_calendar_uids.append(event.icalendar_component["uid"])

    # Copy events from the source to the destination calendar
    for source_event in arg_source_events:
        event_data = source_event.data
        arg_destination_calendar.save_event(event_data)

    for event in destination_events:
        if not event.icalendar_component["uid"] in src_calendar_uids:
            print("delte event " + event.icalendar_component["summary"])
            event.delete()


if __name__ == "__main__":
    # Create the parser
    parser = argparse.ArgumentParser(description="Script description")

    # --master-url
    parser.add_argument(
        "--master-url", type=str, required=True, help="URL for the master"
    )

    # --sync-calendars
    parser.add_argument(
        "--sync-calendars",
        nargs="+",
        type=str,
        required=True,
        help="List of calendars to synchronize",
    )

    # --sync-categories
    parser.add_argument(
        "--sync-categories",
        nargs="+",
        type=str,
        required=True,
        help="List of categories to synchronize",
    )

    args = parser.parse_args()
    master_url = args.master_url
    sync_calendars = args.sync_calendars
    sync_categories = args.sync_categories

    # Your code logic using the master_url parameter
    # print("Master URL:", sync_categories)
    with open(
        os.path.dirname(__file__) + "/out_test.txt", "w", encoding="utf-8"
    ) as file:
        file.write("Kalender:\n")
        for c in sync_calendars:
            file.write("\t" + c + "\n")

        file.write("\nKategorien:\n")
        for c in sync_categories:
            file.write("\t" + c + "\n")

        client = caldav.DAVClient(
            url=master_url,
            username=USERNAME,
            password=PASSWORD,
        )
        master_calender_events = client.calendar(url=master_url).events()

        file.write("\nSync Kalender:\n")
        for i, calendar_url in enumerate(sync_calendars):
            calendar = client.calendar(url=calendar_url)
            calendar_categories = sync_categories[i].split(",")
            sync_calender(master_calender_events, calendar, calendar_categories)

            file.write("\t- " + calendar_url + "\n")
            for c in calendar_categories:
                file.write("\t\t- " + c + "\n")
