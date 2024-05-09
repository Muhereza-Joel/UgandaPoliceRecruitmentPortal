<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Manage Exams</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Manage Exams</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Create New Aptitude Test</h5>


            <!-- Custom Styled Validation with Tooltips -->
            <form class="row g-3 needs-validation" novalidate="" id="create-test-form">
              <div class="col-md-12 position-relative">
                <label for="validationTooltip01" class="form-label">Test Title</label>
                <br><small class="text-secondary">This will be the public title visible to applicants</small>
                <input type="text" class="form-control" name="title" id="validationTooltip01" required="">
                <div class="invalid-tooltip">
                  Please your test a title.
                </div>
              </div>
              <div class="col-md-12 position-relative">
                <label for="validationTooltip02" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="" rows="5" id="validationTooltip02" required></textarea>
                <div class="invalid-tooltip">
                  Please add a description for the test.
                </div>
              </div>

              <div class="col-md-12 position-relative">
                <label for="validationTooltip03" class="form-label">Duration</label>
                <br><small class="text-secondary">Applicants will be timed by this duration during exam</small>
                <input type="number" class="form-control" name="duration" id="validationTooltip03" required="">
                <div class="invalid-tooltip">
                  Please provide duration for the test.
                </div>
              </div>

              <div class="col-md-12 position-relative">
                <label for="validationTooltip03" class="form-label">Total Marks</label>
                <br><small class="text-secondary">This will be used to calculate final score of an applicant</small>
                <input type="number" class="form-control" name="total-marks" id="validationTooltip03" required="">
                <div class="invalid-tooltip">
                  Please provide total marks for this test.
                </div>
              </div>


              <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">Create Test</button>
              </div>
            </form><!-- End Custom Styled Validation with Tooltips -->

          </div>
        </div>
      </div>
      <div class="col-lg-8">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Current Tests in the system</h5>

            <!-- Table with stripped rows -->
            <table class="table table-striped">
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
                        <a href="#" class="dropdown-item" >
                          Edit Test Details
                        </a>
                        <a href="/<?php echo e($appName); ?>/manage-exams/test/add-questions?test_id=<?php echo e($test['test_id']); ?>" class="dropdown-item icon" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Questions you add to this test will be the ones applicants will answer when shortlisted and allowed to take aptitude test">
                          Add Questions To Test.
                        </a>
                        <a href="#" class="dropdown-item icon text-danger">
                          Delete Test
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
    </div>

  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
  $(document).ready(function() {
    $("#create-test-form").submit(function(event) {
      event.preventDefault();

      if (this.checkValidity() === true) {

        let formData = new FormData(this);

        $.ajax({
          method: "POST",
          url: "/<?php echo e($appName); ?>/test/create/",
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            Toastify({
              text: response.message || "Test Saved Successfully",
              duration: 4000,
              gravity: 'bottom',
              position: 'left',
              backgroundColor: '#32a852',
            }).showToast();

            setTimeout(function() {
              window.location.reload()
            }, 4500)
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