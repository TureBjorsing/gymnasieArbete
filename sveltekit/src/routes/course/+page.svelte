<script>
    import { onMount } from "svelte";
    import Course from "$lib/components/Course.svelte";

    async function getCourses() {
        const url = '/api/getCourse.php?cid=none';
        
        const response = await fetch(url);
        const courses = await response.json();
        return courses;
    }

    onMount(() => { getCourses(); });
</script>

{#await getCourses() then course}
    {#if course.error == "Course not found"}
    <h1>Tomt</h1>
    {:else}
        {#each course as course}
            <Course courseData={course} />
        {/each}
    {/if}
    <button onclick={() => location.href="/createCourse"}>Lägg till bana</button>
{:catch error}
    <p>Error: {error.message}</p>
{/await}

<style lang="scss">

</style>