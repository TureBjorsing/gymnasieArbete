<script>
    import { page } from '$app/state';

    import { onMount } from "svelte";

    import Results from '$lib/components/Results.svelte';
    let showResults = $state(false);

    let currentHole = $state(1);
    let holeArr = $state([]);

    let fairwayMissPercent = $state({left: 0, middle: 0, right: 0});
    let greenMissPercent = $state({left: 0, up: 0, right: 0, down: 0, hit: 0});
    let score = $state(0);

    for(let i = 0; i < page.params.holeAmount; i++) {
        holeArr[i] = {score: 0, fairway: null, green: null};
    }

    async function getHoles() {
        const url = '/api/getHoles.php?cid=' + page.params.cid;

        const response = await fetch(url);
        const holes = await response.json();
        return holes;
    }
    
    function dec() {
        if(holeArr[currentHole - 1].score > 0) {
            holeArr[currentHole - 1].score--;
        }
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

    function end() {
        let done = true;
        for(let i = 0; i < holeArr.length; i++) {
            if(holeArr[i].score == 0 || holeArr[i].fairway == null || holeArr[i].green == null) {
                done = false;
                break;
            }
        }
        
        if(done) {
            let fairwayMissL = 0;
            let fairwayMissR = 0;
            let fairwayHit = 0;

            let greenMissL = 0;
            let greenMissU = 0;
            let greenMissR = 0;
            let greenMissD = 0;
            let greenHit = 0;

            for(let i = 0; i < holeArr.length; i++) {
                switch(holeArr[i].fairway) {
                    case "l":
                        fairwayMissL++;
                        break;
                    case "r":
                        fairwayMissR++;
                        break;
                    case "m":
                        fairwayHit++;
                }

                switch(holeArr[i].green) {
                    case "l":
                        greenMissL++;
                        break;
                    case "u":
                        greenMissU++;
                        break;
                    case "r":
                        greenMissR++;
                        break;
                    case "d":
                        greenMissD++;
                        break;
                    case "h":
                        greenHit++;
                }
            }

            for(let i = 0; i < holeArr.length; i++) {
                score += holeArr[i].score;
            }

            fairwayMissPercent.left = fairwayMissL / holeArr.length;
            fairwayMissPercent.middle = fairwayHit / holeArr.length;
            fairwayMissPercent.right = fairwayMissR / holeArr.length;

            greenMissPercent.left = greenMissL / holeArr.length;
            greenMissPercent.up = greenMissU / holeArr.length;
            greenMissPercent.right = greenMissR / holeArr.length;
            greenMissPercent.down = greenMissD / holeArr.length;
            greenMissPercent.hit = greenHit / holeArr.length;

            showResults = true;
        } else {
            alert("Något hål saknar score");
        }
    }

    onMount(() => { getHoles(); });
</script>

{#if showResults}
    <Results fairwayMissPercent={fairwayMissPercent} greenMissPercent={greenMissPercent} score={score} cid={page.params.cid}/>
{:else}
    {#await getHoles() then holes}
        <h2>Hål {currentHole}</h2>
        <p>Par: {holes[currentHole - 1].par}</p>

        <button onclick={dec}>-</button>
        <h1>{holeArr[currentHole-1].score}</h1>
        <button onclick={() => holeArr[currentHole - 1].score++}>+</button>

        <p>Fairway</p>
        <button onclick={() => holeArr[currentHole - 1].fairway = "l"}>&#8592;</button>  <!-- l = left, m = middle, r = right-->
        <button onclick={() => holeArr[currentHole - 1].fairway = "m"}>&#8593;</button>
        <button onclick={() => holeArr[currentHole - 1].fairway = "r"}>&#8594;</button>

        <p>Green</p>
        <button onclick={() => holeArr[currentHole - 1].green = "h"}>x</button>
        <button onclick={() => holeArr[currentHole - 1].green = "l"}>&#8592;</button>   <!-- l = left, u = long, r = right, d = short, h = hit-->
        <button onclick={() => holeArr[currentHole - 1].green = "u"}>&#8593;</button>
        <button onclick={() => holeArr[currentHole - 1].green = "r"}>&#8594;</button>
        <button onclick={() => holeArr[currentHole - 1].green = "d"}>&#8595;</button>

        <br>
        <button onclick={previousHole}>Backa</button>
        <button onclick={nextHole}>Nästa</button>

        <table>
            <tbody>
                <tr>
                    <td>Hål</td>
                    {#each holeArr, i}
                    <td>{i + 1}</td>
                    {/each}
                </tr>
                <tr>
                    <td>Par</td>
                    {#each holeArr, i}
                    <td>{holes[i].par}</td>
                    {/each}
                </tr>
                <tr>
                    <td>Slag</td>
                    {#each holeArr as hole}
                    <td>{hole.score}</td>
                    {/each}
                </tr>
                <tr>
                    <td>Fairway</td>
                    {#each holeArr as hole}
                    {#if hole.fairway == "l"}
                    <td>&#8592;</td>
                    {:else if hole.fairway == "m"}
                    <td>&#8593;</td>
                    {:else if hole.fairway == "r"}
                    <td>&#8594;</td>
                    {:else}
                    <td></td>
                    {/if}
                    {/each}
                </tr>
                <tr>
                    <td>Green</td>
                    {#each holeArr as hole}
                    {#if hole.green == "l"}
                    <td>&#8592;</td>
                    {:else if hole.green == "u"}
                    <td>&#8593;</td>
                    {:else if hole.green == "r"}
                    <td>&#8594;</td>
                    {:else if hole.green == "d"}
                    <td>&#8595;</td>
                    {:else if hole.green == "h"}
                    <td>x</td>
                    {:else}
                    <td></td>
                    {/if}
                    {/each}
                </tr>
            </tbody>
        </table>

        <button onclick={end}>Avsluta</button>
    {:catch error}
        <p>Error: {error.message}</p>
    {/await}
{/if}

<style lang="scss">
    table {
        td {
            border: 1px solid black;
        }
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>