<ul>
    <li><a href="/">Hem</a></li>
    <li><a href="/course">Spela</a></li>
    <li><a href="/stats">Statistik</a></li>
</ul>

<style lang="scss">
    ul {
        list-style: none;
        display: flex;
        justify-content: flex-end;
        padding: 0.5rem 1rem;
        margin: 0;

        li {
            margin-left: 1rem;
            background-color: #00796b; // Medium grön
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: transform 0.2;

            &:hover {
                transform: scale(1.05);
            }
        }

        a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            transition: color 0,3s;

            &:hover {
                color: #b2dfdb; // ljusgrön
            }
        }
    }
</style>