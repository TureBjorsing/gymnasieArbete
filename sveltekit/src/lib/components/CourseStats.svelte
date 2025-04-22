<script>
    let { courseData } = $props();
</script>

<section>
    <h1>{courseData.name}</h1>
    <p>Holes: {courseData.holes}</p>
    <p>Par: {courseData.par}</p>
    <p>Average Score: {Math.floor(courseData.averageScore)}</p>
    <p>Green träff: {Math.floor(courseData.greenHit * 100)}%</p>
    <br>
    <p id="fairwayLable">Fairway:</p>
    <div class="fairway">
        <p>Vänster: {Math.floor(courseData.fairwayMissL * 100)}%</p>
        <p>Mitten: {Math.floor(courseData.fairwayHit * 100)}%</p>
        <p>Höger: {Math.floor(courseData.fairwayMissR * 100)}%</p>
    </div>
</section>

<style lang="scss">
    section {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        background-color: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

        h1 {
            margin-bottom: 1rem;
        }

        p {
            margin-bottom: 0.5rem;
        }

        #fairwayLable {
            margin-left: 5rem;
        }

        .fairway {
        display: flex;
        justify-content: space-evenly;
        margin-top: 1rem;
        }
    }

    
</style>