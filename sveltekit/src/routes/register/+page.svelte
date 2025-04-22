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

<svelte:head>
  <title>Registrera</title>
</svelte:head>

<form method="post" onsubmit = {register}>
    <label for="user" id="user">Användarnamn</label>
    <input type="text" name="user" size="30"><br>

    <label for="firstname" id="firstname">Förnamn</label>
    <input type="text" name="firstname" size="40"><br>

    <label for="lastname" id="lastname">Efternamn</label>
    <input type="text" name="lastname" size="40"><br>

    <label for="pwd" id="pwd">Lösenord</label>
    <input type="password" name="pwd" size="80"><br>

    <input type="submit">
</form>

<p>{check?.success ? "Du är registrerad" : ""}</p>

<a href="/">Logga in</a>

<style lang="scss">
    form {
        max-width: 40rem;
        margin: 2rem auto;
        padding: 2rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        text-align: center;

        label {
            display: block;
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 0.8rem;
            margin-bottom: 1.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1.4rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        input[type="submit"] {
            display: block;
            width: 70%;
            padding: 1rem;
            font-size: 1.6rem;
            font-weight: bold;
            color: #fff;
            background-color: #00796b;
            border: none;
            border-radius: 4px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;

            &:hover {
                background-color: #00695c;
            }
        }
    }

    p {
        text-align: center;
        font-size: 1.4rem;
        color: #00796b;
        margin-top: 1rem;
    }

    a {
        display: block;
        text-align: center;
        margin-top: 1rem;
        font-size: 1.4rem;
        color: #00796b;
        text-decoration: none;
        font-weight: bold;
        &:hover {
            color: #004d40;
        }
    }
</style>