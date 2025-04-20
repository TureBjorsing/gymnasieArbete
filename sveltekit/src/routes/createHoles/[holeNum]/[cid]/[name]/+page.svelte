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

<p>Hål {currentHole}</p>

<input type="number" bind:value = {holeArr[currentHole - 1]}>

<button onclick={nextHole}>Nästa</button>
<button onclick={previousHole}>Backa</button>
<br>

<button onclick={done}>Klar</button>