<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Job Details</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Job Details</li>
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

        <?php if($action == 'view'): ?>
        <div class="h5 text-secondary fw-bold">Requirements</div>
        <div><?php echo $job['requirements']; ?></div>

        <div class="h5 text-secondary fw-bold">Responsibilities</div>
        <div><?php echo $job['requirements']; ?></div>
        <?php endif; ?>
        <hr>
        <a href="#" class="btn btn-primary btn-sm">Apply Now</a>
        <?php if($role == 'Administrator'): ?>
        <a href="#" class="btn btn-success btn-sm">Update Job</a>
        <a href="#" class="btn btn-danger btn-sm">Delete Job</a>
        <?php endif; ?>
      </div>
    </div>
  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>