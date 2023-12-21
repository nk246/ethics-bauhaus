<?php include 'header.php'; ?>

<main id="entryContainer">
    <div class="entry">
        <!--<h3 class="question"></h3>-->
        <p class="answer"></p>
        <div class="details">
            <span class="name"></span><span class="comma"></span><span class="location"></span>
        </div>
    </div>
</main>

<style>
    .entry {
        transition: opacity 0.4s ease;
    }

    @media screen and (max-width: 320px) {
        .entry {
        transition: opacity 0.2s ease;
    }
    }
</style>

<script>
    let isLastEntryNormalColor = true; // Variable to track the last state
    let intervalID; // Variable to store the interval ID
    let isVisible = true;


    // Check if the page is currently hidden or visible
    function isPageHidden() {
        return document.hidden || document.msHidden || document.webkitHidden || document.mozHidden;
    }

    function fetchAndDisplayEntries() {
        fetch('data/data.json')
            .then(response => response.json())
            .then(data => {
                // Filter entries with both question and answer
                const validEntries = data.filter(entry => entry.question && entry.answer);
                const randomIndex = Math.floor(Math.random() * validEntries.length);
                const randomEntry = validEntries[randomIndex];

                const entryContainer = document.getElementById('entryContainer');
                const currentEntry = entryContainer.querySelector('.entry');
                const newEntry = currentEntry.cloneNode(true);

                //newEntry.querySelector('.question').innerText = randomEntry.question;
                newEntry.querySelector('.answer').innerText = randomEntry.answer;
                
                const nameElement = newEntry.querySelector('.name');
                const locationElement = newEntry.querySelector('.location');
                const commaElement = newEntry.querySelector('.comma');

                nameElement.innerText = randomEntry.name;
                locationElement.innerText = randomEntry.location;

                // Show or hide the comma based on the presence of name and/or location
                if (randomEntry.name && randomEntry.location) {
                    commaElement.innerText = ', ';
                    commaElement.style.display = 'inline'; // Show the comma
                } else {
                    commaElement.innerText = '';
                    commaElement.style.display = 'none'; // Hide the comma
                }

                // Set initial opacity to 0 for smooth fade-in transition
                newEntry.style.opacity = '0';

                entryContainer.appendChild(newEntry);

                // Trigger reflow before applying opacity transition
                newEntry.getBoundingClientRect();

                // Fade out the current entry
                currentEntry.style.opacity = '0';

                // Fade in the new entry
                newEntry.style.opacity = '1';

                // Remove the current entry after fade-in transition ends
                newEntry.addEventListener('transitionend', () => {
                    entryContainer.removeChild(currentEntry);
                });

                // Add alternating colors to the new entry based on the last state
                setTimeout(() => {
                    if (isLastEntryNormalColor) {
                        entryContainer.classList.remove('normal-color');
                        entryContainer.classList.add('alternate-color');
                        isLastEntryNormalColor = false;
                    } else {
                        entryContainer.classList.remove('alternate-color');
                        entryContainer.classList.add('normal-color');
                        isLastEntryNormalColor = true;
                    }
                }, 100); // Delay of 100 milliseconds
            })
            .catch(error => {
                console.log('Error:', error);
            });
    }

    // Function to handle page visibility change
    function handleVisibilityChange() {
        if (isPageHidden()) {
            isVisible = false;
            clearInterval(intervalID);
        } else {
            isVisible = true;
            clearInterval(intervalID);
            intervalID = setInterval(fetchAndDisplayEntries, 10000);
        }
    }

    // Listen for the visibility change event
    document.addEventListener('visibilitychange', handleVisibilityChange);

    // Start the interval initially
    intervalID = setInterval(fetchAndDisplayEntries, 10000);
    fetchAndDisplayEntries();
</script>


<?php include 'footer.php'; ?>
