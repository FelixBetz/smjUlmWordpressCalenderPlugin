<script lang="ts">
  import { onMount } from "svelte";

  import type { Event } from "./lib/interfaces";
  import { getCalenderAssets } from "./lib/api";
  import CCalender from "./lib/cCalender.svelte";

  let events: Event[] = [];

  onMount(async () => {
    events = await getCalenderAssets();
  });
</script>

<div id="calender">
  {#if events.length > 0}
    <CCalender {events} />
  {/if}
</div>
