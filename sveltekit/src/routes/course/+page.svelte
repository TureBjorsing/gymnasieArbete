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

<svelte:head>
  <title>Bana</title>
</svelte:head>

{#await getCourses() then course}
    {#if course.error == "Course not found"}
    <h1>Tomt</h1>
    {:else}
        <section class="courseGrid">
        {#each course as course}
            <Course courseData={course} />
        {/each}
        </section>
    {/if}
    <button id="addCourse" onclick={() => location.href="/createCourse"}>Lägg till bana</button>
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

    #addCourse {
        margin: 2rem auto 0 auto;
        padding: 1rem 2rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, background-color 0.3s;

        &:hover {
            background-color: #e0e0e0;
            transform: scale(1.02);
        }

        display: block;
        text-align: center;
    }

    @media (max-width: 768px) {
        .courseGrid {
            display:block;
        }
    }
</style>