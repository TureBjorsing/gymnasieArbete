<script>
    async function createCourse(e) {
        e.preventDefault();
        const data = new FormData(e.target);
        const url = '/api/createCourse.php';

        const response = await fetch(url, {
            method: "post",
            body: data
        });

        const cid = await response.json();

        if(cid.error) {
            alert("Något blev fel. Banor kan inte ha samma namn");
        }

        location.href = "/createHoles/" + data.get('holeNum') + "/" + cid.cid + "/" + cid.name;
    }
</script>

<svelte:head>
  <title>Skapa Bana</title>
</svelte:head>

<form method="post" onsubmit={createCourse}>
    <label for="name">Banans namn</label>
    <input type="text" name="name" size=30><br>

    <label for="holeNum">Antal hål</label>
    <input type="number" name="holeNum"><br>

    <label for="Par">Banans par</label>
    <input type="number" name="par"><br>

    <input type="submit" value="Gå vidare">
</form>

<style lang="scss">
    form {
        max-width: 40rem;
        margin: 2rem auto;
        padding: 2rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #fff;

        label {
            display: block;
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 0.5rem 0;
            margin-bottom: 1.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1.4rem;
        }

        input[type="number"] {
            margin-bottom: 2rem;
        }

        input[type='submit'] {
            display: block;
            width: 100%;
            padding: 1rem;
            font-size: 1.6rem;
            font-weight: bold;
            color: #fff;
            background-color: #00796b;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;

            &:hover {
                background-color: #00695c;
            }
        }
    }
</style>