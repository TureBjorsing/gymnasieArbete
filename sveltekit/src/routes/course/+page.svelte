<script>
    import { onMount } from "svelte";
    import Course from "$lib/components/Course.svelte";

    async function getCourses() {
        const url = '/api/getCourse.php';
        
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
            <Course courseData={course} />
        {/each}
    {/if}
{:catch error}
    <p>Error: {error.message}</p>
{/await}

<style lang="scss">

</style>