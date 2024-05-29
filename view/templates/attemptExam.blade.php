@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light">Attempt Exam</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
                <li class="breadcrumb-item active text-light">Attempt Exam</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="card mx-3" id="timer-card">
                <div class="card-body">
                    <span id="time" style="display: none;">{{$time}}</span>
                    <div id="timer" class="col-sm-12 text-center h3 my-4"></div>

                </div>
            </div>
            <div id="question-container" class="col-sm-12"></div>

            <div class="col-sm-2">
                <button id="next-btn" class="btn btn-sm btn-success p-2">Submit Answer And Move To Next Question.</button>
            </div>

            <!-- Completion message -->
            <div id="completion-message" class="col-sm-12 text-center my-4" style="display: none;">
                <div class="alert alert-success" role="alert">
                    You have completed the test. Well done!
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

@include('partials/footer')


@include('partials/footer')

<script>
    $(document).ready(function() {
        var currentQuestionIndex = 0;
        var questions = []; // Array to store questions and options data
        const optionLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
        var totalTime = parseInt($('#time').text()) * 60; // Total time in seconds

        // Function to load questions from the server
        function loadQuestions() {
            $.ajax({
                url: '/{{$appName}}/test/questions/?test_id=' + '{{$test_id}}&user_id=' + '{{$user_id}}',
                method: 'GET',
                success: function(response) {
                    questions = response;
                    if (questions.length === 0) {
                        $('#timer-card').hide(); // Hide timer if no questions
                        $('#question-container').html(`
                            <div class="alert alert-warning" role="alert">
                                No questions available for this exam.
                            </div>
                        `);
                        $('#next-btn').hide();
                    } else {
                        showQuestion();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function showQuestion() {
            if (currentQuestionIndex < questions.length) {
                var currentQuestion = questions[currentQuestionIndex];
                $('#question-container').html(`
                    <div class="card my-2 p-4">
                        <div class="card-body">
                            <h2 class="card-title">${currentQuestion.question_text}</h2>
                            <ul class="list-group">
                                ${currentQuestion.options.map((option, index) =>
                                    `<li class="list-group-item">
                                        <input type="radio" name="option" value="${option.option_id}" id="option${option.option_id}">
                                        <label class="ms-3" for="option${option.option_id}">${optionLetters[index]}. ${option.option_text}</label>
                                    </li>`
                                ).join('')}
                            </ul>
                        </div>
                    </div>
                `);
            } else {
                $('#next-btn').hide();
                $('#completion-message').show();
            }
        }

        // Function to format time in MM:SS format
        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        // Function to update the timer
        function updateTimer() {
            $('#timer').text(formatTime(totalTime));
            if (totalTime <= 0) {
                clearInterval(timerInterval);
                $('#next-btn').hide();
                $('#completion-message').html('<div class="alert alert-danger" role="alert">Time is up! The test is over.</div>').show();
                // Redirect to the exam page
                window.location.href = '/{{$appName}}/exam/';
            }
            totalTime--;
        }

        // Start the timer
        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer(); // Initialize the timer display immediately

        // Event listener for the Next button
        $('#next-btn').click(function() {
            var selectedOption = $('input[name="option"]:checked').val();
            if (selectedOption) {
                // Submit the user's response
                submitResponse(selectedOption);
                // Move to the next question
                currentQuestionIndex++;
                if (currentQuestionIndex < questions.length) {
                    showQuestion();
                } else {
                    $('#next-btn').hide();
                    $('#completion-message').show();
                }
            } else {
                Toastify({
                    text: 'Please select an option.',
                    duration: 4000,
                    gravity: 'top',
                    position: 'center',
                    backgroundColor: 'red',
                }).showToast();
            }
        });

        // Function to submit the user's response
        function submitResponse(selectedOption) {
            $.ajax({
                url: '/{{$appName}}/responses/create/',
                method: 'POST',
                data: {
                    user_id: '{{$user_id}}', // Replace 'your_user_id' with the actual user ID
                    test_id: '{{$test_id}}', // Replace 'your_test_id' with the actual test ID
                    question_id: questions[currentQuestionIndex].question_id,
                    selected_option_id: selectedOption
                },
                success: function(response) {
                    console.log(response); // Handle success response if needed
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Load questions when the page is ready
        loadQuestions();
    });
</script>
