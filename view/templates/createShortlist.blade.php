@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light">Shortlist Applicant.</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
                <li class="breadcrumb-item active text-light">Create Shortlist</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-sm-5">
                <div class="card p-2">
                    <div class="card-title">Applicant Information</div>
                    <div class="card-body">

                        <div class="text-center">
                            <img src="{{$userDetails['image_url']}}" width="200" class="rounded-circle" style="object-fit: cover; border: 3px solid #333" alt="">
                        </div>

                        <div class="row my-3">
                            <div class="col-sm-4 fw-bold">Fullname</div>
                            <div class="col-sm-8">{{$userDetails['name']}}</div>
                        </div>

                        <div class="row my-3">
                            <div class="col-sm-4 fw-bold">NIN</div>
                            <div class="col-sm-8">{{$userDetails['nin']}}</div>
                        </div>

                        <div class="row my-3">
                            <div class="col-sm-4 fw-bold">Gender</div>
                            <div class="col-sm-8">{{$userDetails['gender']}}</div>
                        </div>

                        <div class="row my-3">
                            <div class="col-sm-4 fw-bold">District</div>
                            <div class="col-sm-8">{{$userDetails['district']}}</div>
                        </div>

                        <div class="row my-3">
                            <div class="col-sm-4 fw-bold">Village</div>
                            <div class="col-sm-8">{{$userDetails['village']}}</div>
                        </div>

                        <div class="row my-3">
                            <div class="col-sm-4 fw-bold">Contact</div>
                            <div class="col-sm-8">{{$userDetails['phone']}}</div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-sm-5">
                <div class="card p-2">


                    <div class="row my-3">
                        <div class="col-sm-4 fw-bold">Job Title</div>
                    </div>
                    <div class="">{{$jobDetails['title']}}</div>
                    <div class="row my-3">
                        <div class="col-sm-4 fw-bold">Job Description</div>
                    </div>
                    <div class="">{!!$jobDetails['description']!!}</div>

                    <hr>
                    <form action="" class="form needs-validation mt-2" novalidate id="create-shortlist-form">
                        <div class="form-group">
                            <input type="hidden" name="application-id" value="{{$applicationId}}">
                            <label for="">Shorlist Notes</label>
                            <textarea name="notes" id="" rows="5" class="form-control mt-2" placeholder="Enter Notes Here" required></textarea>

                            <div class="invalid-feedback">Please provide notes to the applicant</div>
                        </div>

                        <div class="text-start">
                            <button type="submit" class="btn btn-sm btn-primary my-2">Shortlist {{$userDetails['name']}}</button>
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
        $("#create-shortlist-form").submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {

                let formData = new FormData(this);

                $.ajax({
                    method: "POST",
                    url: "/{{$appName}}/shortlist/create/",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Toastify({
                            text: response.message || "Record Saved Successfully",
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