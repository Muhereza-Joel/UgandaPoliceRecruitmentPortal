<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light">Assign Test To Job Post</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
                <li class="breadcrumb-item active text-light">Assign Test</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">

                <div class="card p-2">
                    <div class="card-title">Job Details To Assign Test</div>
                    <div class="card-body">
                        <div class="alert alert-light">
                            <h2 class="text-success"><?php echo e($job['title']); ?></h2>
                            <p class="text-secondary"><?php echo $job['description']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Current Tests in the system</h5>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped" id="exams-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Test Title</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Total Marks</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row"><?php echo e($loop->iteration); ?></th>
                                    <td><?php echo e($test['title']); ?></td>
                                    <td><?php echo e($test['duration_minutes']); ?> minutes</td>
                                    <td><?php echo e($test['total_marks']); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Select Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="actionDropdown">

                                                <?php if($role == 'Administrator'): ?>
                                                <a href="/<?php echo e($appName); ?>/jobs/assign-test/?test-id=<?php echo e($test['test_id']); ?>&job-id=<?php echo e($job['id']); ?>" class="dropdown-item" id="assign-btn">
                                                    Assign This Test
                                                </a>


                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>


            </div>

            <div class="col-sm-4">
                <?php if(!empty($jobAssignment)): ?>
                <div class="card p-2">
                    <div class="card-body">
                        <div class="card-title">Current Test Assigned To: <?php echo e($job['title']); ?></div>
                        <div class="alert alert-light">
                            <h5><?php echo e($jobAssignment['title']); ?></h5>
                            <hr>
                            <span class="fw-bold">Description</span>
                            <p><?php echo e($jobAssignment['description']); ?></p>

                            <hr>
                            <span class="fw-bold">Duration</span>
                            <p><?php echo e($jobAssignment['duration_minutes']); ?></p>
                        </div>

                        <a href="/<?php echo e($appName); ?>/jobs/drop-test/?id=<?php echo e($jobAssignment['mapping_id']); ?>" class="btn btn-sm btn-danger" id="drop-text-btn">Drop Assignment</a>

                    </div>
                </div>
                <?php else: ?>
                <div class="card p-2">
                    <div class="card-body">
                        <div class="card-title">No Test Assigned for <?php echo e($job['title']); ?></div>
                        <div class="alert alert-warning">
                            <p>No current test assignment available for this job.</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>



        </div>
    </section>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="confirmDeleteModalLabel">Confirm Your Action</h5>

                </div>
                <div class="modal-body">
                    <h6 class="text-dark">Are you sure you want to execute this action?</h6>
                    <div class="alert alert-warning p-1 mt-2">Note that this will drop this assignment, if you want applicants to attempt a test again against this job, you have to re-assign it again.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Yes, Drop Test</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmAssignModal" tabindex="-1" role="dialog" aria-labelledby="confirmAssignModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="confirmAssignModalLabel">Confirm Your Action</h5>

                </div>
                <div class="modal-body">
                    <h6 class="text-dark">Are you sure you want to execute this action?</h6>
                    <div class="alert alert-warning">Note that if this position has a test already, a new assignment replaces the existing test</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="cancel-assign-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmAssignBtn" class="btn btn-success btn-sm">Yes, Assign Test</button>
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {
        $('#exams-table').on('click', '#assign-btn', function(event) {
            event.preventDefault();

            var removeUrl = $(this).attr('href');

            $('#confirmAssignModal').modal('show');
            $('#cancel-assign-btn').click(function() {
                $('#confirmAssignModal').modal('hide');

            })

            $('#confirmAssignModal').on('click', '#confirmAssignBtn', function() {
                $.post(removeUrl, function(response) {
                    Toastify({
                        text: response.message || 'Test Assigned successfully',
                        duration: 2000,
                        gravity: 'bottom',
                        backgroundColor: 'green',
                    }).showToast();

                    setTimeout(function() {
                        window.location.reload();

                    }, 3000)
                });
            });
        })

        $('#drop-text-btn').on('click', function(event) {
            event.preventDefault();

            var removeUrl = $(this).attr('href');

            $('#confirmDeleteModal').modal('show');
            $('#cancel-btn').click(function() {
                $('#confirmDeleteModal').modal('hide');

            })

            $('#confirmDeleteModal').on('click', '#confirmDeleteBtn', function() {
                $.post(removeUrl, function(response) {
                    Toastify({
                        text: response.message || 'Assignment Droped successfully',
                        duration: 2000,
                        gravity: 'bottom',
                        backgroundColor: 'green',
                    }).showToast();

                    setTimeout(function() {
                        window.location.reload();

                    }, 3000)
                });
            });
        })
    })
</script>