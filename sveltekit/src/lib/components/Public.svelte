<script>
    let check = $state();

    async function auth(e) {
        e.preventDefault();
        const data = new FormData(e.target);
        const url = "/api/login.php";

        const response = await fetch(url, {
            method: "post",
            body: data,
            credentials: 'include'
        });

        check = await response.json();

        if (check.success) {
            document.location.href = "/";
        }
    }
</script>

<form method="post" onsubmit = {auth}>
    <label for="user">Användarnamn</label>
    <input type="text" name="user" id="user"><br>

    <label for="pwd">Lösenord</label>
    <input type="password" name="pwd" id="pwd"><br>

    <input type="submit" value="Logga in">
</form>

<p>Har du inget konto:</p>
<a href="register">Registrera dig</a>

<style lang="scss">
    form {
        max-width: 40rem;
        margin: 2rem auto;
        padding: 2rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        }

        input[type="submit"] {
            width: 70%;
            padding: 1rem;
            background-color: #00796b; // Medium grön
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1.6rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;

            &:hover {
                background-color: #004d40; // mörkgrönt
            }
        }
    }

    p {
        text-align: center;
        margin-top: 1rem;
        font-size: 1rem;
        color: #555;
    }

    a {
        display: block;
        text-align: center;
        margin-top: 0.5rem;
        color: #00796b; // Medium grön
        text-decoration: none;
        font-weight: bold;

        &:hover {
            color: #004d40; // mörkgrönt
        }
    }
</style>