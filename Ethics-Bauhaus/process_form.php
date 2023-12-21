<?php
$question1 = $_POST['question1'] ?? '';
$question2 = $_POST['question2'] ?? '';
$question3 = $_POST['question3'] ?? '';
$name = $_POST['name'] ?? '';
$location = $_POST['location'] ?? '';

// Load blacklist
$blacklistData = file_get_contents('blacklist.json');
$blacklist = json_decode($blacklistData, true)['words'] ?? [];

// Check if any field contains inappropriate words
if (containsInappropriateWords($question1, $blacklist) ||
    containsInappropriateWords($name, $blacklist) ||
    containsInappropriateWords($location, $blacklist)) {
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

// Load data.json
$jsonData = file_get_contents('data/data.json');
$data = json_decode($jsonData, true) ?? [];

// Generate new ID
$newId = count($data) + 1;

// Create a new entry in the json
$newEntry = array(
    'id' => $newId,
    'name' => $name,
    'location' => $location
);

$answeredCount = 0;

// Check if question 1 is answered
if (!empty($question1)) {
    $newEntry['question'] = 'Question to the Future';
    $newEntry['answer'] = $question1;
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

// Write new entry to data array and convert to json
$data[] = $newEntry;
$newJsonData = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents('data/data.json', $newJsonData);
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
