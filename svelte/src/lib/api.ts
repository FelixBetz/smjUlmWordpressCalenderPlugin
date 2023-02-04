import type { Event } from "./interfaces";

import ICAL from "ical.js";

export function repeatStringToGerman(str) {
  if (str["DAILY"]) {
    return "täglich";
  }
  if (str["WEEKLY"]) {
    return "wöchentlich";
  }
  if (str["MONTHLY"]) {
    return "monatlich";
  }
  if (str["YEARLY"]) {
    return "jährlich";
  }

  return "";
}

async function dowloadIcsFile(url: string) {
  let ret_events: ICAL.Event = [];

  let response = await fetch(url).then((res) => res.text());
  let jcalData = ICAL.parse(response);
  var comp = new ICAL.Component(jcalData);

  var vevents = comp.getAllSubcomponents("vevent");
  for (let vevent of vevents) {
    var event = new ICAL.Event(vevent);
    ret_events.push(event);
  }

  return ret_events;
}

export async function getCalenderAssets(): Promise<Event[]> {
  console.log("safdasdf ");
  let events: Event[] = [];
  let icsUrl =
    "https://smj-ulm.de/wp-content/plugins/smj-ulm-cal/data/calender.ics";
  let resposne = await dowloadIcsFile(icsUrl).then((res) => {
    for (let event of res) {
      /*if (event.dtend == undefined) {
        event.dtend = event.dtstart;
      }

      let repeatStr = "";
      let repeatUntil = null;
      if (event.rrule != undefined) {
        //format of rrule: FREQ=MONTHLY;UNTIL=20230201T235959Z
        let repeatSplit = event.rrule.split(";");
        repeatStr = repeatStringToGerman(repeatSplit[0].split("=")[1]);
        repeatUntil = icsTimestampToDate(repeatSplit[1].split("=")[1]);
      }*/

      console.log(repeatStringToGerman(event.getRecurrenceTypes()));

      let jsonDateStart = event.startDate.toJSON();
      if (jsonDateStart["isDate"]) {
        let oneDay = ICAL.Duration.fromSeconds(-24 * 3600);
        event.endDate.addDuration(oneDay);
      }

      events.push({
        name: event.summary,
        description: event.description,
        startDatetime: event.startDate.toJSDate(),
        endDatetime: event.endDate.toJSDate(),
        isAllDay: jsonDateStart["isDate"],
        repeatStr: repeatStringToGerman(event.getRecurrenceTypes()),
      });
    }

    //sort events by startDatetime
    events.sort((a: Event, b: Event) =>
      a.startDatetime < b.startDatetime ? -1 : 1
    );
    return events;
  });

  return resposne;
}
