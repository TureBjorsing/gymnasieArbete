<script>
    async function getUser() {
        const response = await fetch("/api/getUser.php");
        return await response.json();
    }

    async function logout() {
        const response = await fetch("/api/logout.php");
        return await response;
    }
</script>

{#await getUser() then user}
    <p>Hej {user.firstname} {user.lastname}!</p>
    <a href="/" onclick = {logout} data-sveltekit-reload>Logga ut</a>
    <a href="course">Spela</a>


{:catch error}
    <p>Error: {error.message}</p>
{/await}