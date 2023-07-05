<!DOCTYPE html>
<html>
<head>
    <title>Random Row Display</title>
    <style>
        .slide-container {
            position: relative;
            height: 150px;
            overflow: hidden;
        }

        .slide {
            position: absolute;
            width: 100%;
            animation: slideAnimation 10s infinite;
        }

        @keyframes slideAnimation {
            0% {
                top: 0;
            }

            10% {
                top: -150px;
            }

            20% {
                top: -300px;
            }

            /* Add more keyframes for additional rows */
        }
    </style>
</head>
<body>
    <h1>Random Row Display</h1>

    <div class="slide-container">
        <div class="slide" id="random-row">
            <h2>Random Row</h2>
            <p><strong>Data:</strong> <span id="name"></span></p>
        </div>
    </div>

    <script>
        // Function to load CSV file asynchronously
        function loadCSVFile(file, callback) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    callback(xhr.responseText);
                }
            };
            xhr.open('GET', file, true);
            xhr.send();
        }

        // Function to parse CSV data into an array of rows
        function parseCSVData(csvData) {
            var rows = csvData.split('\n');
            return rows.map(function(row) {
                return row.split(';');
            });
        }

        // Function to retrieve a random row from the CSV data
        function getRandomRow(csvData) {
            var rows = parseCSVData(csvData);
            var randomIndex = Math.floor(Math.random() * rows.length);
            return rows[randomIndex];
        }

        // Function to display the random row data
        function displayRandomRow(csvData) {
            var randomRow = getRandomRow(csvData);
            document.getElementById('name').textContent = randomRow[0];
        }

        // Load CSV file and display initial random row
        loadCSVFile('p/Users/nicolaskrewer/Documents/UNI/4.Semester/Ethics/data/data.csv', function(csvData) {
            displayRandomRow(csvData);

            // Set interval to display a new random row every 10 seconds
            setInterval(function() {
                displayRandomRow(csvData);
            }, 10000); // 10 seconds
        });
    </script>
</body>
</html>