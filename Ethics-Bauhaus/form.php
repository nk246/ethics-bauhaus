<?php include 'header.php'; ?>

<main id="form-page" class="form-page-main">
    <h2>Question to the Future</h2>

    <p>Exactly 100 years back, Bauhaus students presented their work for the first time in public. Back then they used a range of tools. It was a new idea to combine handcraft with artistic practice and study in  interdisciplinary environments to create answers for the questions of that time. The students imagined what the society of the future will look like and which tools people will be using in the next 100 years.</p>
    <p class="form-sub-paragraph">The cyberworld has started. Now it's your turn. Ask a question about the technological development of tools over the next 100 years from now.</p>
    
    <form action="process_form.php" method="post" class="quest-form">

        <label for="question1">So, what's your Question to the Future?</label>
        <input type="text" name="question1" id="question1" onchange="handleQuestionChange(1)" >
        <div class="name-location">
        <div class="name">
        <label for="name">What's your Name?</label>
        <input type="text" name="name" id="name">
        </div>

        <div class="location">
        <label for="location">Where are you from?</label>
        <input type="text" name="location" id="location">
        </div>
        </div>

        <button type="submit" id="submitBtn" disabled>Submit</button>
    </form>
</main>

<script>
    function handleQuestionChange(questionNumber) {
        var questionField = document.getElementById('question' + questionNumber);
        var otherQuestionFields = document.querySelectorAll('input[name^="question"]:not(#question' + questionNumber + ')');
        var submitButton = document.getElementById('submitBtn');

        if (questionField.value !== '') {
            questionField.disabled = false;
            questionField.classList.remove('grayed-out');

            otherQuestionFields.forEach(function(field) {
                field.disabled = true;
                field.classList.add('grayed-out');
                field.value = '';
            });

            submitButton.disabled = false;
        } else {
            otherQuestionFields.forEach(function(field) {
                field.disabled = false;
                field.classList.remove('grayed-out');
            });

            submitButton.disabled = true;
        }
    }
</script>

<?php include 'footer.php'; ?>
