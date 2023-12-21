<?php
// Read the existing JSON data from the file
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

// Get the form data
$question1 = $_POST['question1'];
$question2 = $_POST['question2'];
$question3 = $_POST['question3'];
$name = $_POST['name'];
$location = $_POST['location'];

// Generate a new ID
$newId = count($data) + 1;

// Create a new entry with the general fields and ID
$newEntry = array(
    'id' => $newId,
    'name' => $name,
    'location' => $location
);

// Check which question was answered
if (!empty($question1)) {
    $newEntry['question'] = 'Question 1';
    $newEntry['answer'] = $question1;
} elseif (!empty($question2)) {
    $newEntry['question'] = 'Question 2';
    $newEntry['answer'] = $question2;
} elseif (!empty($question3)) {
    $newEntry['question'] = 'Question 3';
    $newEntry['answer'] = $question3;
}

// Add the new entry to the data array
$data[] = $newEntry;

// Convert the data array to JSON
$newJsonData = json_encode($data, JSON_PRETTY_PRINT);

// Write the JSON data back to the file
file_put_contents('data.json', $newJsonData);

header('Location: index.php');
exit();
?>
