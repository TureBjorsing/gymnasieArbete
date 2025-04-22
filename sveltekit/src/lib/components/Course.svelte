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
        <p>Average Score: {Math.floor(courseData.averageScore)}</p>
    {/if}
    <button onclick={() => {
        deleteBool = true;
        deleteCourse();
        location.href = "/course";
        }}>Ta bort</button>
</section>

<style lang="scss">
section {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: transform 0.2s;

    &:hover {
        transform: scale(1.01);
    }

    h1 {
        margin-bottom: 1rem;
    }

    p {
        margin-bottom: 0.5rem;
    }

    button {
        margin-top: 1rem;
        padding: 0.5rem 1rem;
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
}
</style>