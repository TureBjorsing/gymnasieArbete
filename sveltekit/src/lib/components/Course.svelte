<script>
    let { courseData } = $props();
</script>

<section onclick={() => location.href="spela/" + courseData.cid + "/" + courseData.holes} role="none">
    <h1>{courseData.name}</h1>
    <p>Holes: {courseData.holes}</p>
    <p>Par: {courseData.par}</p>
    {#if !isNaN(courseData.averageScore)}
        <p>Average Score: {courseData.averageScoreScore}</p>
    {/if}
</section>

<style lang="scss">
section {
    border: solid 1px;
    cursor: pointer;
}
</style>