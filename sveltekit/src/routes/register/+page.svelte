<script>
    let check = $state();

    async function register(e) {
        e.preventDefault();
        const data = new FormData(e.target);
        const url = '/api/register.php';

        const response = await fetch(url, {
            method: 'post',
            body: data
        });

        check = await response.json();
    }
</script>

<form method="post" onsubmit = {register}>
    <label for="user">Användarnamn</label>
    <input type="text" name="user" size="30"><br>

    <label for="firstname">Förnamn</label>
    <input type="text" name="firstname" size="40"><br>

    <label for="lastname">Efternamn</label>
    <input type="text" name="lastname" size="40"><br>

    <label for="pwd">Lösenord</label>
    <input type="password" name="pwd" size="80"><br>

    <input type="submit" >
</form>

<p>{check.success ? "Du är registrerad" : ""}</p>

<a href="/">Logga in</a>