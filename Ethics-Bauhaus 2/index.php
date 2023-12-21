<?php include 'header.php'; ?>

<main>
    <h2>Display Entries</h2>

    <div id="entryContainer">
        <div id="currentEntry">
            <h3 id="question"></h3>
            <p id="answer"></p>
            <div id="details">
                <span id="name"></span>, <span id="location"></span>
            </div>
        </div>
    </div>
</main>

<script>
    function fetchAndDisplayEntries() {
        fetch('data.json')
            .then(response => response.json())
            .then(data => {
                const entries = data;
                const randomIndex = Math.floor(Math.random() * entries.length);
                const randomEntry = entries[randomIndex];

                document.getElementById('question').innerText = randomEntry.question;
                document.getElementById('answer').innerText = randomEntry.answer;
                document.getElementById('name').innerText = randomEntry.name;
                document.getElementById('location').innerText = randomEntry.location;
            })
            .catch(error => {
                console.log('Error:', error);
            });
    }

    setInterval(fetchAndDisplayEntries, 10000);
    fetchAndDisplayEntries();
</script>

<?php include 'footer.php'; ?>
