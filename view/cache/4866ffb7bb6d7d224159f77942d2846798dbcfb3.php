<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Results For All Tests</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Results</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

  <div class="row p-2">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>SNo.</th>
                        <th>Applicant</th>
                        <th>District</th>
                        <th>Phone</th>
                        <th>Exam Title</th>
                        <th>Questions Passed</th>
                        <th>Total Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($result['person_name']); ?></td>
                        <td><?php echo e($result['district']); ?></td>
                        <td><?php echo e($result['phone']); ?></td>
                        <td><?php echo e($result['test_title']); ?></td>
                        <td><?php echo e($result['correct_questions_count']); ?> out of <?php echo e($result['total_questions_count']); ?></td>
                        <td><?php echo e($result['total_marks']); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
  </div>
    
  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>