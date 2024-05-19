<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light">Apply Now</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
                <li class="breadcrumb-item active text-light">Create Application</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="card py-4  px-2 my-3">
            <div class="card-body">
                <div class="h5 text-secondary fw-bold">Job Title</div>
                <div><?php echo e($job['title']); ?></div>
                <small class="text-info">Posted On <?php echo e($job['created_at']); ?></small>
                <hr>
                <div class="h5 text-secondary fw-bold">Description</div>
                <div><?php echo $job['description']; ?></div><br>
                <div class="h5 text-secondary fw-bold">Requirements</div>
                <div><?php echo $job['requirements']; ?></div>
            </div>
        </div>

        <div class="card py-4  px-2 my-3">
            <div class="card-body">
                <div class="h5 text-secondary fw-bold">Your Personal Information</div>
                <div class="alert alert-warning">Please click <a href="/<?php echo e($appName); ?>/auth/user/profile/">here</a> if you want to update your profile.</div>
                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">Full Name</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['name']); ?></div>
                </div>
                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">NIN Number</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['nin']); ?></div>
                </div>
                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">Date of Birth</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['dob']); ?></div>
                </div>
                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">Gender</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['gender']); ?></div>
                </div>

                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">Company</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['company']); ?></div>
                </div>
                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">Job</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['job']); ?></div>
                </div>
                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">NIN Number</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['nin']); ?></div>
                </div>

                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">Email</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['email']); ?></div>
                </div>

                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">Country</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['country']); ?></div>
                </div>

                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">District</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['district']); ?></div>
                </div>
                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">Village</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['village']); ?></div>
                </div>

                <div class="row my-2">
                    <div class="col-lg-3 col-md-4 label fw-bold text-dark">Phone</div>
                    <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['phone']); ?></div>
                </div>

            </div>
        </div>

        <div class="card py-4 px-2 my-3">
            <div class="h5 text-secondary fw-bold">Please add required documents according to the job requirements.</div>
            <small class="text-danger">Only PDF Files are allowed</small><br>
            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="form-group d-flex align-items-center">
                    <input required class="form-control me-2 w-75 file-input" type="file" name="pdf" accept="application/pdf">
                    <div class="invalid-feedback">Please choose a pdf file.</div>
                </div>
                <!-- <button type="button" class="btn btn-secondary btn-sm mt-3" id="addFileInput">Add Another File</button> -->
            </form>
            <div class="alert alert-warning p-2 mt-3">Please review your application before you click submit application,
                if your confident that the Information is correct, click submit application..
            </div>
        </div>


        <button class="btn btn-sm btn-primary" id="submit-application-btn" data-id="<?php echo e($job['id']); ?>">Submit Application</button>

    </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {
        $('#addFileInput').on('click', function() {
            var fileInputHtml = '<div class="form-group d-flex align-items-center mt-3">' +
                '<input required class="form-control me-2 w-75 file-input" type="file" name="pdf[]" accept="application/pdf">' +
                '<div class="invalid-feedback">Please choose a pdf file.</div>' +
                '</div>';
            $(fileInputHtml).insertBefore($(this));
        });

        $(document).on('change', '.file-input', function() {
            var pdfInput = $(this)[0];
            var file = pdfInput.files[0];
            var maxSize = 5 * 1024 * 1024; // 5MB in bytes

            if (file && file.size > maxSize) {
                Toastify({
                    text: 'The selected file is too large. Please choose a file smaller than 5MB.',
                    duration: 5000,
                    gravity: 'bottom',
                    position: 'left',
                    backgroundColor: 'red',
                }).showToast();

                $(this).val('');
            }
        });

        $('#submit-application-btn').click(function() {
            var positionId = $(this).data('id');

            $.ajax({
                method: 'post',
                url: `/<?php echo e($appName); ?>/jobs/applications/create/?position_id=${positionId}`,
                processData: false,
                contentType: false,
                success: function(response) {
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        gravity: 'bottom',
                        position: 'left',
                        backgroundColor: 'green',
                    }).showToast();

                    // Upload files sequentially with delay
                    $('.file-input').each(function() {
                        var fileInput = $(this)[0];
                        var files = fileInput.files;
                        var applicationId = response.last_insert_id;

                        function uploadFile(index) {
                            if (index >= files.length) return;

                            var formData = new FormData();
                            formData.append('pdf', files[index]);
                            formData.append('application_id', applicationId);

                            $.ajax({
                                method: 'post',
                                url: `/<?php echo e($appName); ?>/file-upload/`,
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(uploadResponse) {
                                    Toastify({
                                        text: 'File uploaded successfully',
                                        duration: 3000,
                                        gravity: 'bottom',
                                        position: 'left',
                                        backgroundColor: 'green',
                                    }).showToast();

                                    // Upload next file after delay
                                    setTimeout(function() {
                                        uploadFile(index + 1);
                                    }, 1000); // 1-second delay
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    Toastify({
                                        text: 'An error occurred while uploading the file',
                                        duration: 3000,
                                        gravity: 'bottom',
                                        position: 'left',
                                        backgroundColor: 'red',
                                    }).showToast();

                                    // Upload next file after delay, even on error
                                    setTimeout(function() {
                                        uploadFile(index + 1);
                                    }, 1000); // 1-second delay
                                }
                            });
                        }

                        uploadFile(0);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An Error occurred, failed to submit application');
                }
            });
        });


    });
</script>