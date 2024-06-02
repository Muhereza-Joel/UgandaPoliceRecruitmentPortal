<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light"><?php echo e($role == 'Administrator' ? 'All Shortisted Candidates' : 'My Shortlist'); ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
                <li class="breadcrumb-item active text-light">shortlist</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="row g-0 p-2">
            <div class="alert alert-info">You can enter the district name in the input to get shortlisted applicants from that district and if you want to get the whole list, click export pdf without providing the district name.</div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e($role == 'Administrator' ? 'All Shortisted Candidates' : 'Your Shortlist'); ?></h5>

                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <form action="">
                                <input type="text" name="district" id="districtInput" placeholder="Enter district" class="form-control">

                            </form>
                        </div>
                        <div>
                            <button id="exportButton" class="btn btn-primary btn-sm">Export To PDF</button>
                        </div>
                    </div>

                    <!-- Table with stripped rows -->
                    <table class="table table-striped datatable" id="shortlist-table">
                        <thead>
                            <tr>
                                <th scope="col">SNo</th>
                                <th scope="col">Name</th>
                                <?php if($role == 'Administrator'): ?>
                                <th scope="col">District</th>
                                <?php endif; ?>
                                <th scope="col">Phone</th>
                                <th scope="col">Job Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Notes</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $shortlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th scope="row"><?php echo e($loop->iteration); ?></th>
                                <td><?php echo e($item['name']); ?></td>
                                <?php if($role == 'Administrator'): ?>
                                <td><?php echo e($item['district']); ?></td>
                                <?php endif; ?>
                                <td><?php echo e($item['phone']); ?></td>
                                <td><?php echo e($item['title']); ?></td>
                                <td>
                                    <?php if($item['status'] == 'shortlisted'): ?>
                                    <span class="badge bg-success">Shortlisted on <?php echo e($item['created_at']); ?></span>

                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($item['notes']); ?></td>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>
        </div>

    </section>

    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframe" width="100%" height="500px" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {
        $('#exportButton').click(function() {
            var district = $('#districtInput').val();
            var formData = new FormData();
            formData.append('district', district);
            $.ajax({
                method: 'POST',
                url: '/<?php echo e($appName); ?>/pdf/shortlist/export/',
                processData: false,
                contentType: false,
                data:formData,
                success: function(response) {
                    var pdfData = response;

                    $("#pdfIframe").attr("src", "data:application/pdf;base64," + pdfData);
                    $("#pdfModal").modal("show");

                },
                error: function(xhr, status, error) {

                }
            });
        });
    });
</script>