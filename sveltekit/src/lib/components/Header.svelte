<script>
    import Nav from "./Nav.svelte";

    async function isLoggedIn() {
        const response = await fetch('/api/isLoggedIn.php');
        return await response.json();
    }
</script>

{#await isLoggedIn() then data}

    <header>
        <section>
            <h1>Golf Stats</h1>
            <p>Håll koll på ditt golfspel!</p>
        </section>
        {#if data.loggedIn}
        <Nav />
        {/if}
    </header>

{:catch error}
    <p>Error: {error.messages}</p>
{/await}

<style lang="scss">
    header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #004d40; // mörkgrönt
        color: white;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);

        section {
            text-align: center;
            flex-grow: 1;
        }

        h1 {
            font-size: 6rem;
            margin: 0;
        }

        p {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        header {
            flex-direction: column; // Stack elements vertically
            text-align: center;
        }

        h1 {
            font-size: 3rem; // Smaller font size for phones
        }

        p {
            font-size: 1.2rem; // Adjust paragraph font size
        }
    }

    @media (max-width: 480px) {
        h1 {
            font-size: 2.5rem; // Even smaller font size for very small screens
        }

        p {
            font-size: 1rem; // Adjust paragraph font size further
        }
    }
</style>