<script lang="ts">
  import { onMount } from "svelte";

  import type { Calender } from "./lib/interfaces";
  import { getCalenderAssets } from "./lib/api";
  import CCalender from "./lib/cCalender.svelte";

  let calenders: Calender[] = [];

  onMount(async () => {
    calenders = await getCalenderAssets();
  });
</script>

<div id="calender">
  {#if calenders.length > 0}
    <CCalender calender={calenders[0]} />
  {/if}
</div>
