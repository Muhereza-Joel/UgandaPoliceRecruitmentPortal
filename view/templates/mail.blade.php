@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light">Compose Email</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
                <li class="breadcrumb-item active text-light">Compose Email</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-sm-6">
                <div class="card p-2">
                    <div class="card-title">Compose Mail</div>
                    <div class="card-body">
                        You are Sending An Email To <strong>{{$userDetails['name']}}</strong><br>
                        <small class="text-success fw-bold">Make changes to email and body where necessary</small>
                        <hr>
                    </div>

                    <form action="" class="needs-validation" novalidate id="compose-mail-form">
                        <div class="form-group my-2">
                            <label for="" class="fw-bold">Email</label>
                            <input placeholder="Email goes here" required type="text" name="to" value="{{$userDetails['email']}}" class="form-control">
                            <div class="invalid-feedback">Please provide email address of receipient</div>
                        </div>
                        <div class="form-group my-2">
                            <label for="" class="fw-bold">Subject</label>
                            <input placeholder="Subject goes here" required type="text" name="subject" value="Thankyou For Applying" class="form-control">
                            <div class="invalid-feedback">Please provide subject for email</div>
                        </div>
                        <div class="form-group my-2">
                            <label for="" class="fw-bold">Body</label>
                            <textarea placeholder="Body goes here" required name="body" id="" rows="5" class="form-control">{{$shortlist['notes']}}</textarea>
                            <div class="invalid-feedback">Please provide body for email</div>
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-primary btn-sm">Send Email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

@include('partials/footer')

<script>
    $(document).ready(function() {
        $("#compose-mail-form").submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {
                let formData = new FormData(this);

                // Show loading toast
                const loadingToast = Toastify({
                    text: "Sending email, please wait...",
                    duration: -1, // Duration -1 means the toast will not automatically disappear
                    gravity: 'bottom',
                    position: 'left',
                    backgroundColor: '#222',
                }).showToast();

                $.ajax({
                    method: "POST",
                    url: "/{{$appName}}/mail/create/",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Remove loading toast
                        loadingToast.hideToast();

                        Toastify({
                            text: response.message || "Email Sent Successfully",
                            duration: 4000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: '#32a852',
                        }).showToast();

                        setTimeout(function() {
                            // window.location.reload()
                        }, 4500)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Remove loading toast
                        loadingToast.hideToast();

                        let message = "An error occurred";

                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            message = jqXHR.responseJSON.message;
                        } else if (jqXHR.responseText) {
                            try {
                                const response = JSON.parse(jqXHR.responseText);
                                if (response.message) {
                                    message = response.message;
                                }
                            } catch (e) {
                                // If response is not JSON, use the response text as is
                                message = jqXHR.responseText;
                            }
                        } else if (textStatus) {
                            message = textStatus;
                        } else if (errorThrown) {
                            message = errorThrown;
                        }

                        Toastify({
                            text: message,
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
