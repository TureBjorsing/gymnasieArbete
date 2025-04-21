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

<form method="post" onsubmit={createCourse}>
    <label for="name">Banans namn</label>
    <input type="text" name="name" size=30><br>

    <label for="holeNum">Antal hål</label>
    <input type="number" name="holeNum"><br>

    <label for="Par">Banans par</label>
    <input type="number" name="par"><br>

    <input type="submit" value="Gå vidare">
</form>