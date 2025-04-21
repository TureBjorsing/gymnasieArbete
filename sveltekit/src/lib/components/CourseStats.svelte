<script>
    let { courseData } = $props();
</script>

<section>
    <h1>{courseData.name}</h1>
    <p>Holes: {courseData.holes}</p>
    <p>Par: {courseData.par}</p>
    <p>Average Score: {Math.floor(courseData.averageScore)}</p>
    <p>Fairway: {courseData.averageScore}</p>
    <p>Vänster: {Math.floor(courseData.fairwayMissL * 100)}%</p>
    <p>Mitten: {Math.floor(courseData.fairwayHit * 100)}%</p>
    <p>Höger: {Math.floor(courseData.fairwayMissR * 100)}%</p>
    <p>Green träff: {Math.floor(courseData.greenHit * 100)}%</p>
</section>

<style lang="scss">
    section {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        background-color: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>