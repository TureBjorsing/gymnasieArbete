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

{#await getCourses() then course}
    {#if course.error == "Course not found"}
    <h1>Empty</h1>
    {:else}
        {#each course as course}
            <CourseStats courseData={course}/>
        {/each}
    {/if}
{:catch error}
    <p>Error: {error.message}</p>
{/await}