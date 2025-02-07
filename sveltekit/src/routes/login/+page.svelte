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
    <input type="text" name="user"><br>

    <label for="pwd">Lösenord</label>
    <input type="password" name="pwd"><br>

    <input type="submit" value="Check">
</form>

<a href="register">Registrera dig</a>