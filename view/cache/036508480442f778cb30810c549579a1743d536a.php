<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light">Compose Email</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
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
                        You are Sending An Email To <strong><?php echo e($userDetails['name']); ?></strong><br>
                        <small class="text-success fw-bold">Make changes to email and body where necessary</small>
                        <hr>
                    </div>

                    <form action="" class="needs-validation" novalidate id="compose-mail-form">
                        <div class="form-group my-2">
                            <label for="" class="fw-bold">Email</label>
                            <input placeholder="Email goes here" required type="text" name="to" value="<?php echo e($userDetails['email']); ?>" class="form-control">
                            <div class="invalid-feedback">Please provide email address of receipient</div>
                        </div>
                        <div class="form-group my-2">
                            <label for="" class="fw-bold">Subject</label>
                            <input placeholder="Subject goes here" required type="text" name="subject" value="Thankyou For Applying" class="form-control">
                            <div class="invalid-feedback">Please provide subject for email</div>
                        </div>
                        <div class="form-group my-2">
                            <label for="" class="fw-bold">Body</label>
                            <textarea placeholder="Body goes here" required name="body" id="" rows="5" class="form-control"><?php echo e($shortlist['notes']); ?></textarea>
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

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {
        $("#compose-mail-form").submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {

                let formData = new FormData(this);

                $.ajax({
                    method: "POST",
                    url: "/<?php echo e($appName); ?>/mail/create/",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
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