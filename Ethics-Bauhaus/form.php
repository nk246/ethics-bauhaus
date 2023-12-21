<?php include 'header.php'; ?>

<main>
    <h2>Contact Form</h2>

    <form action="process_form.php" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">

        <label for="location">Location:</label>
        <input type="location" name="location" id="location">

        <label for="question1">Question 1:</label>
        <input type="text" name="question1" id="question1" onchange="handleQuestionChange(1)">

        <label for="question2">Question 2:</label>
        <input type="text" name="question2" id="question2" onchange="handleQuestionChange(2)">

        <label for="question3">Question 3:</label>
        <input type="text" name="question3" id="question3" onchange="handleQuestionChange(3)">

        <button type="submit">Submit</button>
    </form>
</main>

<script>
    function handleQuestionChange(questionNumber) {
        var questionField = document.getElementById('question' + questionNumber);
        var otherQuestionFields = document.querySelectorAll('input[name^="question"]:not(#question' + questionNumber + ')');

        if (questionField.value !== '') {
            questionField.disabled = false;
            questionField.classList.remove('grayed-out');

            otherQuestionFields.forEach(function(field) {
                field.disabled = true;
                field.classList.add('grayed-out');
                field.value = '';
            });
        } else {
            otherQuestionFields.forEach(function(field) {
                field.disabled = false;
                field.classList.remove('grayed-out');
            });
        }
    }
</script>

<?php include 'footer.php'; ?>
