<script>
    import Nav from "./Nav.svelte";

    async function isLoggedIn() {
        const response = await fetch('/api/isLoggedIn.php');
        return await response.json();
    }
</script>

{#await isLoggedIn() then data}

    <header>
        <h1>Golf Stats</h1>
        <p>Håll koll på ditt golfspel!</p>
        {#if data.loggedIn}
        <Nav />
        {/if}
    </header>

{:catch error}
    <p>Error: {error.messages}</p>
{/await}

<style lang="scss">
    header {
        background-color: #004d40; // mörkgrönt
        color: white;
        padding: 1rem;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);

        h1 {
            font-size: 4rem;
            margin: 0;
        }
    }
</style>