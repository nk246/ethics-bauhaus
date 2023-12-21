<?php include 'header.php'; ?>

<main id="entryContainer">
    <div class="entry">
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
    let isLastEntryNormalColor = true; 
    let intervalID; 
    let isVisible = true;


    // Check if page is currently hidden or visible
    function isPageHidden() {
        return document.hidden || document.msHidden || document.webkitHidden || document.mozHidden;
    }

    function fetchAndDisplayEntries() {
        fetch('data/data.json')
            .then(response => response.json())
            .then(data => {
                // Filter entries
                const validEntries = data.filter(entry => entry.question && entry.answer);
                const randomIndex = Math.floor(Math.random() * validEntries.length);
                const randomEntry = validEntries[randomIndex];

                const entryContainer = document.getElementById('entryContainer');
                const currentEntry = entryContainer.querySelector('.entry');
                const newEntry = currentEntry.cloneNode(true);

                newEntry.querySelector('.answer').innerText = randomEntry.answer;
                
                const nameElement = newEntry.querySelector('.name');
                const locationElement = newEntry.querySelector('.location');
                const commaElement = newEntry.querySelector('.comma');

                nameElement.innerText = randomEntry.name;
                locationElement.innerText = randomEntry.location;

                if (randomEntry.name && randomEntry.location) {
                    commaElement.innerText = ', ';
                    commaElement.style.display = 'inline';
                } else {
                    commaElement.innerText = '';
                    commaElement.style.display = 'none';
                }

                newEntry.style.opacity = '0';
                entryContainer.appendChild(newEntry);
                newEntry.getBoundingClientRect();
                currentEntry.style.opacity = '0';
                newEntry.style.opacity = '1';

                newEntry.addEventListener('transitionend', () => {
                    entryContainer.removeChild(currentEntry);
                });

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
                }, 100);
            })
            .catch(error => {
                console.log('Error:', error);
            });
    }

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

    document.addEventListener('visibilitychange', handleVisibilityChange);

    intervalID = setInterval(fetchAndDisplayEntries, 10000);
    fetchAndDisplayEntries();
</script>


<?php include 'footer.php'; ?>
