<script>
    import CourseStats from "./CourseStats.svelte";
    import { onMount } from "svelte";

    async function getUser() {
        const response = await fetch("/api/getUser.php");
        return await response.json();
    }

    async function logout() {
        const response = await fetch("/api/logout.php");
        return await response;
    }

    async function getCourse(cid) {
        const url = '/api/getCourse.php?cid=' + cid;
        
        const response = await fetch(url);
        const courses = await response.json();
        return courses;
    }

    onMount(() => { getUser(); });
</script>

{#await getUser() then user}
{#await getCourse(user.lastPlayed) then course}
    <section id="welcome">
        <p>Välkommen, {user.firstname} {user.lastname}!</p>
        <p>Hoppas du har en fantastisk dag för golf!</p>
    </section>

    {#if course && course.length > 0}
        <section id="recentActivity">
            <h2>Senaste aktivitet:</h2>
            {#each course as course}
            <CourseStats courseData={course}/>
            {/each}
        </section>
    {:else}
        <p>Inga senaste aktiviteter hittades.</p>
    {/if}

    <section id="logout">
        <a href="/" onclick = {logout} data-sveltekit-reload>Logga ut</a>
    </section>
{/await}
{:catch error}
    <p>Error: {error.message}</p>
{/await}

<style lang="scss">
    #welcome {
        text-align: center;
        margin-bottom: 2rem;
        padding: 1rem;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

        p {
            font-size: 1.2rem;
            color: #333;
        }
    }

    #recentActivity {
        margin: 2rem auto;
        padding: 1rem;
        max-width: 800px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

        h2 {
            font-size: 1.5rem;
            color: #004d40; // mörkgrön
            margin-bottom: 1rem;
        }

    }

    a {
        display: inline-block;
        margin: 2rem auto;
        padding: 0.75rem 1.5rem;
        background-color: #d32f2f;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
        text-align: center;
        transition: background-color 0.3s;

        &:hover {
            background-color: #b71c1c;
        }
    }

    #logout {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        #welcome {
            padding: 0.8rem;
            p {
                font-size: 1.4rem;
            }
        }

        #recentActivity {
            padding: 0.8rem;
            h2 {
                font-size: 1.6rem;
            }
        }

        a {
            padding: 0.8rem 1.5rem;
            font-size: 1.2rem;
        }
    }

    @media (max-width: 480px) {
        #welcome {
            padding: 0.5rem;
            p {
                font-size: 1.6rem;
            }
        }

        #recentActivity {
            padding: 0.5rem;
            h2 {
                font-size: 1.8rem;
            }
        }

        a {
            padding: 0.8rem 1.5rem;
            font-size: 1.4rem;
        }
    }
</style>