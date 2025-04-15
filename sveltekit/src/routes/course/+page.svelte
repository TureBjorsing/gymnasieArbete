<script>
    import { onMount } from "svelte";

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
        <section onclick={() => location.href="spela/" + course.name + "/" + course.holes} role="none">
            <h1>{course.name}</h1>
            <p>Holes: {course.holes}</p>
            <p>Par: {course.par}</p>
            {#if !isNaN(course.bestScore)}
                <p>Best Score: {course.bestScore}</p>
            {/if}
        </section>
    {/if}
{:catch error}
    <p>Error: {error.message}</p>
{/await}

<style lang="scss">
    section {
        border: solid 1px;
        cursor: pointer;
    }
</style>