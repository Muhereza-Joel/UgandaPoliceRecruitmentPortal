<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light">View Aplication Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
                <li class="breadcrumb-item active text-light">View application</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row p-2">
            <div class="card py-4  px-2 my-3">
                <div class="card-body">
                    <div class="h5 text-secondary fw-bold">Job Title</div>
                    <div><?php echo e($application['title']); ?></div>
                    <small class="text-info">Posted On <?php echo e($application['created_at']); ?></small>
                    <hr>
                    <div class="h5 text-secondary fw-bold">Job Description</div>
                    <div><?php echo $application['description']; ?></div><br>

                </div>
            </div>

            <div class="card py-4  px-2 my-3">
                <div class="card-body">
                    <div class="h5 text-secondary fw-bold">Applicant Information</div>

                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">Full Name</div>
                        <div class="col-lg-9 col-md-8 text-dark"><?php echo e($application['name']); ?></div>
                    </div>
                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">NIN Number</div>
                        <div class="col-lg-9 col-md-8 text-dark"><?php echo e($application['nin']); ?></div>
                    </div>
                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">Date of Birth</div>
                        <div class="col-lg-9 col-md-8 text-dark"><?php echo e($application['dob']); ?></div>
                    </div>
                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">Gender</div>
                        <div class="col-lg-9 col-md-8 text-dark"><?php echo e($application['gender']); ?></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">Company</div>
                        <div class="col-lg-9 col-md-8 text-dark"><?php echo e($application['company']); ?></div>
                    </div>
                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">Job</div>
                        <div class="col-lg-9 col-md-8 text-dark"><?php echo e($application['job']); ?></div>
                    </div>
                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">NIN Number</div>
                        <div class="col-lg-9 col-md-8 text-dark"><?php echo e($application['nin']); ?></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">Country</div>
                        <div class="col-lg-9 col-md-8 text-dark"><?php echo e($application['country']); ?></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">District</div>
                        <div class="col-lg-9 col-md-8 text-dark"><?php echo e($application['district']); ?></div>
                    </div>
                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">Village</div>
                        <div class="col-lg-9 col-md-8 text-dark"><?php echo e($application['village']); ?></div>
                    </div>

                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">Phone</div>
                        <div class="col-lg-9 col-md-8 text-dark"><?php echo e($application['phone']); ?></div>
                    </div>

                    <div class="row my-4">
                        <div class="col-lg-3 col-md-4 label fw-bold text-dark">Curriculum Vitae</div>
                        <a href="<?php echo e($application['file_url']); ?>" class="btn btn-sm btn-success">Download CV</a>
                    </div>

                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>