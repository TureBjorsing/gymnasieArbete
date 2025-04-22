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

<svelte:head>
  <title>Spela</title>
</svelte:head>

{#if showResults}
    <Results fairwayMissPercent={fairwayMissPercent} greenMissPercent={greenMissPercent} score={score} cid={page.params.cid}/>
{:else}
    {#await getHoles() then holes}
        <section id="holeInfo">
            <h2>Hål {currentHole}</h2>
            <p>Par: {holes[currentHole - 1].par}</p>
        </section>

        <section id="scoreControls">
            <button onclick={dec}>-</button>
            <h1>{holeArr[currentHole-1].score}</h1>
            <button onclick={() => holeArr[currentHole - 1].score++}>+</button>
        </section>

        <section id="fairwayControls">
            <p>Fairway</p>
            <section id="fairwayBtn">
                <button class="left" onclick={() => holeArr[currentHole - 1].fairway = "l"}>&#8592;</button>  <!-- l = left, m = middle, r = right-->
                <button class="middle" onclick={() => holeArr[currentHole - 1].fairway = "m"}>&#8593;</button>
                <button class="right" onclick={() => holeArr[currentHole - 1].fairway = "r"}>&#8594;</button>
            </section>
        </section>

        <section id="greenControls">
            <p>Green</p>
            <section id="greenBtn">
                <button class="left" onclick={() => holeArr[currentHole - 1].green = "l"}>&#8592;</button>   <!-- l = left, u = long, r = right, d = short, h = hit-->
                <button class="middle" onclick={() => holeArr[currentHole - 1].green = "h"}>&#215;</button>
                <button class="right" onclick={() => holeArr[currentHole - 1].green = "r"}>&#8594;</button>
                <button class="up" onclick={() => holeArr[currentHole - 1].green = "u"}>&#8593;</button>
                <button class="down" onclick={() => holeArr[currentHole - 1].green = "d"}>&#8595;</button>
            </section>
        </section>

        <section id="navigation">
            <button onclick={previousHole}>Backa</button>
            <button onclick={nextHole}>Nästa</button>
        </section>

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
                    <td>&#215;</td>
                    {:else}
                    <td></td>
                    {/if}
                    {/each}
                </tr>
            </tbody>
        </table>

        <button id="endBtn" onclick={end}>Avsluta</button>
    {:catch error}
        <p>Error: {error.message}</p>
    {/await}
{/if}

<style lang="scss">
    #holeInfo {
        text-align: center;
        margin-top: 1rem;   
        margin-bottom: 1rem;

        h2 {
            font-size: 2rem;
        }
    }

    #scoreControls, #navigation {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 1rem;

        button {
            margin: 0 0.5rem;
            padding: 0.5rem 1rem;
            background-color: #00796b;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;

            &:hover {
                background-color: #004d40;
            }

            &:active {
                background-color: #003d33;
            }
        }
    }

    #fairwayControls {
        text-align: center;
        margin-bottom: 2rem;

        p {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        #fairwayBtn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 12rem; 
            background-color: #00796b;
            border-radius: 4px;
            overflow: hidden;
            margin: 0 auto;

            button {
                flex: 1; // varje knapp tar lika plats
                height: 7rem;
                background-color: #00796b;
                color: white;
                border: none;
                font-size: 1.5rem;
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s;

                &:hover {
                    background-color: #00695c;
                }

                &:active {
                    background-color: #003d33;
                }
            }

            .middle {
                border-left: 2px solid #004d40;
                border-right: 2px solid #004d40;
            }
        }
    }

    #greenControls {
        text-align: center;
        margin-bottom: 2rem;

        p {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        #greenBtn {
            display: grid;
            grid-template-areas: 
                '. up .'
                'left middle right'
                '. down .';
            gap: 0.5rem;
            justify-content: center;

            .left { grid-area: left; }
            .middle { grid-area: middle; }
            .right { grid-area: right; }
            .up { grid-area: up; }
            .down { grid-area: down; }

            button {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 3rem;
                height: 3rem;
                padding: 1rem;
                background-color: #00796b;
                color: white;
                border: none;
                border-radius: 4px;
                font-size: 1.5rem;
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s;

                &:hover {
                    background-color: #00695c;
                }

                &:active {
                    background-color: #003d33;
                }
            }
        }
    }    

    #scoreControls {
        h1 {
            margin: 0 1rem;
            font-size: 4rem;
        }
    }

    table {
        margin: 1rem auto;
        border-collapse: collapse;
        text-align: center;

        td {
            padding: 0.5rem 1rem;
            border: 1px solid #ccc;
        } 
    }

    #endBtn {
        display: block;
        margin: 2rem auto;
        padding: 1rem 2rem;
        background-color: #d32f2f;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;

        &:hover {
            background-color: #b71c1c;
        }
    }
</style>