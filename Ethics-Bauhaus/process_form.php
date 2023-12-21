<?php
// Get the form data
$question1 = $_POST['question1'] ?? '';
$question2 = $_POST['question2'] ?? '';
$question3 = $_POST['question3'] ?? '';
$name = $_POST['name'] ?? '';
$location = $_POST['location'] ?? '';

// Load the blacklist from a JSON file
$blacklistData = file_get_contents('blacklist.json');
$blacklist = json_decode($blacklistData, true)['words'] ?? [];

// Check if any field contains inappropriate words
if (containsInappropriateWords($question1, $blacklist) ||
    containsInappropriateWords($question2, $blacklist) ||
    containsInappropriateWords($question3, $blacklist) ||
    containsInappropriateWords($name, $blacklist) ||
    containsInappropriateWords($location, $blacklist)) {
    // Display the appropriate message and stop further processing
    include 'header.php';
?>
<main id="processed">
    <h2>Sorry, your submission cannot be accepted.</h2>
    <p>You used words that violate our guidelines.</p>
    <button onclick="goBackToQuestions()">Back to the Questions</button>
</main>

<script>
    function goBackToQuestions() {
        window.location.href = 'index.php';
    }
</script>

<?php
    include 'footer.php';
    exit();
}

include 'header.php';

// Read the existing JSON data from the file
$jsonData = file_get_contents('data/data.json');
$data = json_decode($jsonData, true) ?? [];

// Generate a new ID
$newId = count($data) + 1;

// Create a new entry with the general fields and ID
$newEntry = array(
    'id' => $newId,
    'name' => $name,
    'location' => $location
);

// Count the number of questions answered
$answeredCount = 0;

// Check if question 1 is answered
if (!empty($question1)) {
    $newEntry['question'] = 'Question to the Future';
    $newEntry['answer'] = $question1;
    $answeredCount++;
}

// Check if question 2 is answered
if (!empty($question2)) {
    $newEntry['question'] = 'Question 2';
    $newEntry['answer'] = $question2;
    $answeredCount++;
}

// Check if question 3 is answered
if (!empty($question3)) {
    $newEntry['question'] = 'Question 3';
    $newEntry['answer'] = $question3;
    $answeredCount++;
}

// Make sure only one question is answered
if ($answeredCount !== 1) {
    // Display the appropriate message and stop further processing
?>
<main id="processed">
    <h2>Sorry, your submission cannot be accepted.</h2>
    <p>Only one question should be answered.</p>
    <button onclick="goBackToQuestions()">Back to the Questions</button>
</main>

<script>
    function goBackToQuestions() {
        window.location.href = 'index.php';
    }
</script>

<?php
    include 'footer.php';
    exit();
}

// Add the new entry to the data array
$data[] = $newEntry;

// Convert the data array to JSON
$newJsonData = json_encode($data, JSON_PRETTY_PRINT);

// Write the JSON data back to the file
file_put_contents('data/data.json', $newJsonData);

// Display the success message and the "Back to the Questions" button
?>
<main id="processed">
    <h2>Thank you for your submission!</h2>
    <p>Your response has been recorded.</p>
    <button onclick="goBackToQuestions()">Back to the form</button>
</main>

<script>
    function goBackToQuestions() {
        window.location.href = 'form.php';
    }
</script>

<?php
include 'footer.php';

function containsInappropriateWords($content, $blacklist)
{
    foreach ($blacklist as $word) {
        if (stripos($content, $word) !== false) {
            return true;
        }
    }
    return false;
}
?>
