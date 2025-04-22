<script>
    import '$lib/global.scss';
    import Private from '$lib/components/Private.svelte';
    import Public from '$lib/components/Public.svelte';

    async function isLoggedIn() {
        const response = await fetch('/api/isLoggedIn.php');
        return await response.json();
    }
 </script>

<svelte:head>
  <title>Hem</title>
</svelte:head>

{#await isLoggedIn() then data}
    {#if data.loggedIn}
        <Private />
    {:else}
        <Public />
    {/if}
{:catch error}
    <p>Error: {error.messages}</p>
{/await}