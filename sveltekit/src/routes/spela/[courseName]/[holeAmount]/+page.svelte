<script>
    import { page } from '$app/state';
    let { data } = $props();

    import { onMount } from "svelte";

    let currentHole = $state(1);
    let score = $state(0);
    let holeArr = $state([]);

    for(let i = 0; i < page.params.holeAmount; i++) {
        holeArr[i] = 0;
    }

    async function getHoles() {
        const url = '/api/getHoles.php?cName=' + page.params.courseName;

        const response = await fetch(url);
        const holes = await response.json();
        return holes;
    }
    
    function dec() {
        if(score > 0) {
            score--;
        }
    }

    onMount(() => { getHoles(); });

    console.log(holeArr.length);
</script>

{#await getHoles() then holes}
    <h2>Hål {holeArr[currentHole - 1]}</h2>
    <p>Par: {holes[currentHole.par]}</p>

    <button onclick={dec}>-</button>
    <h1>{score}</h1>
    <button onclick={() => score++}>+</button>
    <br>
    <button>Back</button>
    <button>Next</button>
{:catch error}
    <p>Error: {error.message}</p>
{/await}