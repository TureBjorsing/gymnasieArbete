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

<p>Score: {score}</p>

<p>Fairway</p>
<p>{Math.floor(fairwayMissPercent.left * 100)}%</p>
<p>{Math.floor(fairwayMissPercent.middle * 100)}%</p>
<p>{Math.floor(fairwayMissPercent.right * 100)}%</p>

<p>Green</p>
<p>{Math.floor(greenMissPercent.up * 100)}%</p>
<p>{Math.floor(greenMissPercent.left * 100)}%</p>
<p>{Math.floor(greenMissPercent.hit * 100)}%</p>
<p>{Math.floor(greenMissPercent.right * 100)}%</p>
<p>{Math.floor(greenMissPercent.down * 100)}%</p>

<button>Gå vidare</button>