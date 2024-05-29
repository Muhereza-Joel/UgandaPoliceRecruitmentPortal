<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Jobs</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Jobs</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <?php $__currentLoopData = $listing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card py-4  px-2 my-3">
      <div class="card-body">
        <div class="h5 text-secondary fw-bold">Job Title</div>
        <div><?php echo e($job['title']); ?></div>
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
        <a href="/<?php echo e($appName); ?>/job-positions/listing/view?action=view&id=<?php echo e($job['id']); ?>" class="btn btn-secondary btn-sm">View Job Details</a>
        
        <?php if($role == 'Administrator'): ?>
        <a href="/<?php echo e($appName); ?>/job-positions/listing/assign-exam?id=<?php echo e($job['id']); ?>" class="btn btn-primary btn-sm">Assign Apptitude Test</a>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>