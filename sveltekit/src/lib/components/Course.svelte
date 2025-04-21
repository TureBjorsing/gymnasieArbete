<script>
    let { courseData } = $props();

    let deleteBool = $state(false);

    async function deleteCourse() {
        const url = '/api/deleteCourse.php?cid=' + courseData.cid;

        const response = await fetch(url);

        alert("Banan är borttagen");
    }

    function goForward() {
        if(!deleteBool) {
            location.href="spela/" + courseData.cid + "/" + courseData.holes;
        }
    }
</script>

<section onclick={goForward} role="none">
    <h1>{courseData.name}</h1>
    <p>Holes: {courseData.holes}</p>
    <p>Par: {courseData.par}</p>
    {#if !isNaN(courseData.averageScore)}
        <p>Average Score: {courseData.averageScoreScore}</p>
    {/if}
    <button onclick={() => {
        deleteBool = true;
        deleteCourse();
        location.href = "/course";
        }}>Ta bort</button>
</section>

<style lang="scss">
section {
    border: solid 1px;
    cursor: pointer;
}
</style>