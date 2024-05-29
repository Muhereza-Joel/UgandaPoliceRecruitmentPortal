<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Start Aptitude Test</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Aptitude Test</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

  <div class="row g-2">
    <?php if(empty($myTest)): ?>
      <div class="col-12">
        <div class="alert alert-warning"><strong>No test details available you at the moment.</strong></div>
      </div>
    <?php else: ?>
      <div class="col-sm-6">
        <div class="card p-2">
          <div class="card-title">Details of Job You Applied For</div>
          <div class="card-body">
            <small class="fw-bold">Job Title</small>
            <h5><?php echo e($myTest['job_title']); ?></h5><br>
            <small class="fw-bold">Job Description</small>
            <p><?php echo $myTest['job_description']; ?></p><br>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card p-2">
          <div class="card-title">Aptitude Test Details</div>
          <div class="card-body">
            <small class="fw-bold">Test Title</small>
            <h5><?php echo e($myTest['test_title']); ?></h5><br>

            <small class="fw-bold">Test Description</small>
            <p><?php echo $myTest['test_description']; ?></p><br>

            <small class="fw-bold">Test Duration</small>
            <p><?php echo e($myTest['duration_minutes']); ?> Minutes</p><br>

            <small class="fw-bold">Number of Questions</small>
            <p><?php echo e($myTest['question_count']); ?> Questions</p><br>

            <small class="fw-bold">Total Marks</small>
            <p><?php echo e($myTest['total_marks']); ?></p><br>

            <?php if($myTest['mapping_status'] == 'closed'): ?>
              <div class="alert alert-info"><strong>Test is not active, you will do the test when it's active</strong></div>
            <?php else: ?>
              <a href="/<?php echo e($appName); ?>/exam/attempt?id=<?php echo e($myTest['test_id']); ?>&time=<?php echo e($myTest['duration_minutes']); ?>" class="btn btn-sm btn-primary">Start Test</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
    
  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
