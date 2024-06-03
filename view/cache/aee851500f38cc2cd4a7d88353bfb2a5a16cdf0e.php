<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <div class="col-sm-7">
        <div class="alert alert-dark">
          <h2 class="fw-bold">Uganda Police Force</h2>
          <span class="text-success"><?php echo e($appName); ?></span>
          <hr>
          <h5>Welcome back, <?php echo e($username); ?></h5>
        </div>

      </div>
      <div class="col-sm-5"></div>
      
    </div>
    <div class="row">
     <?php if($role == 'Administrator'): ?>
     <div class="col-sm-3">
       <div class="card p-2">
         <div class="card-title">ShortListed Aplicants</div>
         <div class="card-body">
          <h1><?php echo e($shorlistCount); ?></h1>
         </div>
       </div>

     </div>

     <div class="col-sm-3">
       <div class="card p-2">
         <div class="card-title">Pending Aplicantions</div>
         <div class="card-body">
          <h1><?php echo e($pendingCount); ?></h1>
         </div>
       </div>

     </div>

     <div class="col-sm-3">
       <div class="card p-2">
         <div class="card-title">Aplicantions In Review</div>
         <div class="card-body">
          <h1><?php echo e($reviewingCount); ?></h1>
         </div>
       </div>

     </div>


     <div class="col-sm-3">
       <div class="card p-2">
         <div class="card-title text-success">Accepted Aplicantions</div>
         <div class="card-body">
          <h1 class="text-success"><?php echo e($acceptedCount); ?></h1>
         </div>
       </div>

     </div>


     


     <div class="col-sm-3">
       <div class="card p-2">
         <div class="card-title text-danger">Rejected Aplicantions</div>
         <div class="card-body">
          <h1 class="text-danger"><?php echo e($rejectedCount); ?></h1>
         </div>
       </div>

     </div>


     <?php endif; ?>
    </div>
  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>