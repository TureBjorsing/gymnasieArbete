<script>
    import CourseStats from "$lib/components/CourseStats.svelte";

    import { onMount } from "svelte";

    async function getCourses() {
        const url = '/api/getCourse.php?cid=none';
        
        const response = await fetch(url);
        const courses = await response.json();
        return courses;
    }

    onMount(() => { getCourses(); });
</script>

<svelte:head>
  <title>Statistik</title>
</svelte:head>

{#await getCourses() then course}
    {#if course.error == "Course not found"}
    <h1>Tom</h1>
    {:else}
        <section class="courseGrid">
            {#each course as course}
                <CourseStats courseData={course}/>
            {/each}
        </section>
    {/if}
{:catch error}
    <p>Error: {error.message}</p>
{/await}

<style lang="scss">
    .courseGrid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-top: 2rem;
        margin-left: 1rem;
        margin-right: 1rem;
    }
</style>