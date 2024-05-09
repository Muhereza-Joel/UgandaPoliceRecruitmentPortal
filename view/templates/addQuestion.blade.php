@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light">Add Questions To Test</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
                <li class="breadcrumb-item active text-light">Add Question</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-4">
                <div class="card p-2">
                    <div class="card-title">Test Details</div>
                    <div class="card-body">
                        <h6 class="fw-bold">Test title</h6>
                        <p>{{$test['title']}}</p><br>

                        <h6 class="fw-bold">Test Description</h6>
                        <p>{{$test['description']}}</p>

                    </div>
                </div>

                <div class="card p-2">
                    <div class="card-title">Create Question</div>
                    <div class="card-body">
                        <form class="row g-3 needs-validation" novalidate="" id="create-question-form">
                            <div class="form-group">
                                <label for="question-text">Question Body</label>
                                <br>
                                <input type="hidden" name="test-id" value="{{$test['test_id']}}">
                                <textarea class="form-control" autocomplete="off" name="question-text" rows="4" id="question-text" required></textarea>
                                <div class="invalid-feedback">Question body is required.</div>
                            </div>
                            <div class="text-start">
                                <button class="btn btn-sm btn-primary mt-2">Add Question To Test</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">



                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Questions For This Test</h5>

                        @foreach($questions as $index => $question)
                        <!-- Default Accordion -->
                        <div class="accordion" id="accordionExample{{$index}}">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{$index}}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$index}}" aria-expanded="true" aria-controls="collapse{{$index}}">
                                        Question No. {{$index + 1}}
                                    </button>
                                </h2>
                                <div id="collapse{{$index}}" class="accordion-collapse collapse" aria-labelledby="heading{{$index}}" data-bs-parent="#accordionExample{{$index}}">
                                    <div class="accordion-body">
                                        {{$question['question_text']}}
                                        <hr>
                                        <div class="text-end">
                                            <!-- Button to trigger add options modal -->
                                            <button type="button" class="btn btn-primary btn-sm" id="addOptionsModalTrigger{{$index}}" data-bs-toggle="modal" data-bs-target="#addOptionsModal{{$index}}" data-question-id="{{$question['question_id']}}">
                                                Add Answers
                                            </button>

                                            <!-- Button to trigger view options modal -->
                                            <button type="button" class="btn btn-secondary btn-sm btn-view-options" data-bs-toggle="modal" data-bs-target="#viewOptionsModal{{$index}}" data-question-index={{$index}} data-question-id="{{$question['question_id']}}">
                                                View Options
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Default Accordion Example -->
                        <!-- Modal for adding options -->
                        <div class="modal fade" id="addOptionsModal{{$index}}" tabindex="-1" aria-labelledby="addOptionsModalLabel{{$index}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addOptionsModalLabel{{$index}}">Add Options For Question {{$index + 1}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form to add options -->
                                        <form>
                                            <div class="mb-3">
                                                <label for="optionInput{{$index}}" class="form-label">Option</label>
                                                <input autocomplete="off" type="text" class="form-control" id="optionInput{{$index}}" placeholder="Enter option">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" id="isAnswer{{$index}}">
                                                    <label class="form-check-label" for="isAnswer{{$index}}">
                                                        Mark as Answer
                                                    </label>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary btn-sm btn-save-option" data-index="{{$index}}">Save Option</button>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Modal for viewing options -->
                        <div class="modal fade" id="viewOptionsModal{{$index}}" tabindex="-1" aria-labelledby="viewOptionsModalLabel{{$index}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewOptionsModalLabel{{$index}}">Viewing Options Question {{$index + 1}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Display options here -->
                                        <ul class="list-group" id="optionsList{{$index}}">
                                            <!-- Options will be dynamically added here -->
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @endforeach
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Function to handle form submission
                                function submitForm(index) {
                                    var optionInput = document.getElementById("optionInput" + index).value;
                                    var isAnswer = document.getElementById("isAnswer" + index).checked;
                                    var questionId = document.getElementById("addOptionsModalTrigger" + index).getAttribute("data-question-id");

                                    // Create form data
                                    var formData = new FormData();
                                    formData.append("option-text", optionInput);
                                    formData.append("is-correct", isAnswer ? 1 : 0);
                                    formData.append("question-id", questionId);

                                    // Send POST request
                                    fetch("/{{$appName}}/options/create/", {
                                            method: "POST",
                                            body: formData
                                        })
                                        .then(function(response) {
                                            if (response.ok) {
                                                // Reset input fields on success
                                                document.getElementById("optionInput" + index).value = "";
                                                document.getElementById("isAnswer" + index).checked = false;
                                                Toastify({
                                                    text: response.message || "Option Saved Successfully",
                                                    duration: 2000,
                                                    gravity: 'bottom',
                                                    position: 'left',
                                                    backgroundColor: '#32a852',
                                                }).showToast();

                                            } else {
                                                console.error("Failed to submit form");
                                            }
                                        })
                                        .catch(function(error) {
                                            Toastify({
                                                text: "An Error Occured",
                                                duration: 4000,
                                                gravity: 'bottom',
                                                position: 'left',
                                                backgroundColor: 'red',
                                            }).showToast();
                                        });
                                }

                                // Attach event listeners to "Save Option" buttons
                                var saveButtons = document.querySelectorAll(".btn-save-option");
                                saveButtons.forEach(function(button) {
                                    button.addEventListener("click", function(event) {
                                        var index = button.getAttribute("data-index");
                                        submitForm(index);
                                    });
                                });
                            });
                        </script>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Function to fetch and display options
                                function fetchOptions(questionId, index) {
                                    // Fetch options for the given question ID
                                    fetch("/{{$appName}}/options/all/?question-id=" + questionId)
                                        .then(function(response) {
                                            if (response.ok) {
                                                return response.json();
                                            } else {
                                                throw new Error("Failed to fetch options");
                                            }
                                        })
                                        .then(function(data) {
                                            // Build and display the options
                                            var optionsList = document.getElementById("optionsList"+index);
                                            
                                            optionsList.innerHTML = ""; // Clear previous options

                                            data.forEach(function(option) {
                                                var optionItem = document.createElement("li");
                                                optionItem.classList.add("list-group-item");

                                                var radioInput = document.createElement("input");
                                                radioInput.type = "radio";
                                                radioInput.name = "options{{$index}}";
                                                radioInput.checked = option.is_correct == 1 ? 'checked' : '';
                                                radioInput.classList.add("form-check-input");
                                                radioInput.setAttribute("data-option-id", option.option_id);

                                                var label = document.createElement("label");
                                                label.classList.add("form-check-label");
                                                label.textContent = option.option_text;

                                                var deleteButton = document.createElement("button");
                                                deleteButton.textContent = "Remove Option";
                                                deleteButton.classList.add("btn", "btn-danger", "btn-sm", "ms-4");
                                                deleteButton.addEventListener("click", function() {
                                                    // Function to handle option deletion
                                                    deleteOption(option.option_id);
                                                });

                                                optionItem.appendChild(radioInput);
                                                optionItem.appendChild(label);
                                                optionItem.appendChild(deleteButton);
                                                optionsList.appendChild(optionItem);
                                            });
                                        })
                                        .catch(function(error) {
                                            console.error("Error fetching options:", error);
                                        });
                                }

                                // Function to handle option deletion
                                function deleteOption(optionId) {
                                    // Send DELETE request to delete the option
                                    fetch("/{{$appName}}/options/delete/?id=" + optionId, {
                                            method: "POST"
                                        })
                                        .then(function(response) {
                                            if (response.ok) {
                                                // If deletion successful, re-fetch options
                                                fetchOptions(optionId);
                                                Toastify({
                                                    text: "Option deleted successfully",
                                                    duration: 2000,
                                                    gravity: 'bottom',
                                                    position: 'left',
                                                    backgroundColor: '#32a852',
                                                }).showToast();
                                            } else {
                                                throw new Error("Failed to delete option");
                                            }
                                        })
                                        .catch(function(error) {
                                            console.error("Error deleting option:", error);
                                            Toastify({
                                                text: "Failed to delete option",
                                                duration: 2000,
                                                gravity: 'bottom',
                                                position: 'left',
                                                backgroundColor: 'red',
                                            }).showToast();
                                        });
                                }

                                // Attach event listener to "View Options" buttons
                                var viewButtons = document.querySelectorAll(".btn-view-options");
                                viewButtons.forEach(function(button) {
                                    button.addEventListener("click", function(event) {
                                        var questionId = button.getAttribute("data-question-id");
                                        var index = button.getAttribute("data-question-index");
                                        fetchOptions(questionId, index);
                                    });
                                });
                            });
                        </script>




                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

@include('partials/footer')

<script>
    $(document).ready(function() {

        $('#create-question-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {

                let formData = new FormData(this);

                $.ajax({
                    method: "POST",
                    url: "/{{$appName}}/questions/create/",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Toastify({
                            text: response.message || "Question Saved Successfully",
                            duration: 2000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: '#32a852',
                        }).showToast();

                        setTimeout(function() {
                            window.location.reload()
                        }, 2100)
                    },
                    error: function(response) {
                        Toastify({
                            text: response.message || "An Error Occured",
                            duration: 4000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: 'red',
                        }).showToast();
                    }
                })

            }
        })
    })
</script>