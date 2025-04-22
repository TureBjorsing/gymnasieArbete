<script>
    import { onMount } from "svelte";

    let { fairwayMissPercent, greenMissPercent, score, cid } = $props();
    
    async function sendStats() {
        const data = new FormData();
        const url = '/api/sendStats.php';

        data.append("fairwayMissL", fairwayMissPercent.left);
        data.append("fairwayMissR", fairwayMissPercent.right);
        data.append("fairwayHit", fairwayMissPercent.middle);
        data.append("greenHit", greenMissPercent.hit);
        data.append("score", score);
        data.append("cid", cid);

        const response = await fetch(url, {
            method: 'post',
            body: data
        });
    }

    onMount(() => { sendStats(); });
</script>

<h1>Resultat</h1>

<p id="score">Score: {score}</p>

<section id="fairway">
    <p>Fairway</p>
    <section id="fairwayItems">
        <p id="left">{Math.floor(fairwayMissPercent.left * 100)}%</p>
        <p id="middle">{Math.floor(fairwayMissPercent.middle * 100)}%</p>
        <p id="right">{Math.floor(fairwayMissPercent.right * 100)}%</p>
    </section>
</section>

<section id="green">
    <p>Green</p>
    <section id="greenItems">
        <p id="up">{Math.floor(greenMissPercent.up * 100)}%</p>
        <p id="down">{Math.floor(greenMissPercent.down * 100)}%</p>
        <p id="left">{Math.floor(greenMissPercent.left * 100)}%</p>
        <p id="hit">{Math.floor(greenMissPercent.hit * 100)}%</p>
        <p id="right">{Math.floor(greenMissPercent.right * 100)}%</p>
    </section>
</section>

<button onclick={() => location.href = '/'}>Gå hem</button>

<style lang="scss">
    h1 {
        text-align: center;
        font-size: 2.5rem;
        margin: 1rem 0;
    }

    #score {
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 2rem;
    }

    #fairway {
        text-align: center;
        margin-bottom: 2rem;

        p {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        #fairwayItems {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 15rem;
            background-color: #00796b;
            border-radius: 4px;
            overflow: hidden;
            margin: 0 auto;

            p {
                flex: 1;
                height: 9rem;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #00796b;
                color: white;
                font-size: 1.5rem;
                font-weight: bold;
                margin-bottom: 0;
            }

            #middle {
                border-left: 2px solid #004d40;
                border-right: 2px solid #004d40;
            }
        }
    }

    #green {
        text-align: center;
        margin-bottom: 2rem;

        p {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        #greenItems {
            display: grid;
            grid-template-areas: 
                ". up ."
                "left hit right"
                ". down .";
            
            gap: 0.5rem;
            justify-content: center;
            align-items: center;
            width: 12rem;
            margin: 0 auto;

            p {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 3.5rem;
                height: 3.5rem;
                background-color: #00796b;
                color: white;
                font-size: 1.2rem;
                font-weight: bold;
                border-radius: 4px;
            }

            #up { grid-area: up; }
            #left { grid-area: left; }
            #hit { grid-area: hit; }
            #right { grid-area: right; }
            #down { grid-area: down; }
        }
    }

    button {
        display: block;
        margin: 2rem auto;
        padding: 1rem 2rem;
        background-color: #00796b;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1.2rem;
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
</style>