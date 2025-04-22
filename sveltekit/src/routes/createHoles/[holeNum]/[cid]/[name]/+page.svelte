<script>
    import { page } from '$app/state';

    let holeArr = $state([]);
    let currentHole = $state(1);

    for(let i = 0; i < page.params.holeNum; i++) {
        holeArr[i] = 0;
    }

    function nextHole() {
        if(currentHole != holeArr.length) {
            currentHole++;
        } else {
            currentHole = 1;
        }
    }

    function previousHole() {
        if(currentHole != 1) {
            currentHole--;
        } else {
            currentHole = holeArr.length;
        }
    }

    function done() {
        let done = true;
        for(let i = 0; i < holeArr.length; i++) {
            if(holeArr[i] == 0) {
                done = false;
                break;
            }
        }

        if(done) {
            for(let i = 0; i < holeArr.length; i++) {
                createHole(holeArr[i]);
            }

            location.href = "/course";
        } else {
            alert("Alla hål måste fyllas i");
        }
    }

    async function createHole(par) {
        const url = '/api/createHole.php?par=' + par + '&cid=' + page.params.cid + '&name=' + page.params.name;

        const response = await fetch(url);
    }
</script>

<svelte:head>
  <title>Skapa Hål</title>
</svelte:head>

<section id="container">
    <p>Hål {currentHole}</p>

    <input type="number" bind:value = {holeArr[currentHole - 1]}>

    <section id="btn">
        <button onclick={previousHole}>Backa</button>
        <button onclick={nextHole}>Nästa</button>
    </section>

    <button id="done" onclick={done}>Klar</button>
</section>

<style lang="scss">
    #container {
        max-width: 40rem;
        margin: 2rem auto;
        padding: 2rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        text-align: center;

        p {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
        color: #333;
        }

        input {
            width: 90%;
            padding: 0.8rem 0.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1.4rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        #btn {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;

            button {
                padding: 0.8rem 1.5rem;
                font-size: 1.4rem;
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

        #done {
            display: block;
            width: 80%;
            padding: 1rem;
            font-size: 1.6rem;
            font-weight: bold;
            color: #fff;
            background-color: #00796b;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 auto;
            transition: background-color 0.3s;

            &:hover {
                background-color: #00695c;
            }
        }
    }
</style>