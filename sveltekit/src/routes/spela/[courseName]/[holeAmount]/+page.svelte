<script>
    import { page } from '$app/state';
    let { data } = $props();

    import { onMount } from "svelte";

    let currentHole = $state(1);
    let holeArr = $state([]);

    for(let i = 0; i < page.params.holeAmount; i++) {
        holeArr[i] = {score: 0, fairway: null, green: null};
    }

    async function getHoles() {
        const url = '/api/getHoles.php?cName=' + page.params.courseName;

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
            alert("klar");
        } else {
            alert("Något hål saknar score");
        }
    }

    onMount(() => { getHoles(); });
</script>

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
    <button onclick={() => holeArr[currentHole - 1].green = "l"}>&#8592;</button>   <!-- l = left, u = long, r = right, d = short-->
    <button onclick={() => holeArr[currentHole - 1].green = "u"}>&#8593;</button>
    <button onclick={() => holeArr[currentHole - 1].green = "r"}>&#8594;</button>
    <button onclick={() => holeArr[currentHole - 1].green = "d"}>&#8595;</button>

    <br>
    <button onclick={previousHole}>Back</button>
    <button onclick={nextHole}>Next</button>

    <table>
        <tbody>
            <tr>
                <td>Hål</td>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
                <td>11</td>
                <td>12</td>
                <td>13</td>
                <td>14</td>
                <td>15</td>
                <td>16</td>
                <td>17</td>
                <td>18</td>
            </tr>
            <tr>
                <td>Par</td>
                {#each holeArr as hole, i}
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
                <td>&#8596;</td>
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

<style lang="scss">
    table {
        td {
            border: 1px solid black;
        }
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>