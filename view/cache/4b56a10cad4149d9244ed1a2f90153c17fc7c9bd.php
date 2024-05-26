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

    <div class="row">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><?php echo e($role == 'Administrator' ? 'All Shortisted Candidates' : 'Your Shortlist'); ?></h5>

          <!-- Table with stripped rows -->
          <table class="table table-striped datatable" id="shortlist-table">
            <thead>
              <tr>
                <th scope="col">SNo</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Job Title</th>
                <th scope="col">Status</th>
                <th scope="col">Notes</th>

                <?php if($role == 'Administrator'): ?>
                 <th scope="col">Action</th>
                <?php endif; ?>

              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $shortlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <th scope="row"><?php echo e($loop->iteration); ?></th>
                <td><?php echo e($item['name']); ?></td>
                <td><?php echo e($item['phone']); ?></td>
                <td><?php echo e($item['title']); ?></td>
                <td>
                  <?php if($item['status'] == 'shortlisted'): ?>
                    <span class="badge bg-success">Shortlisted</span>
                    
                  <?php endif; ?>
                </td>
                <td><?php echo e($item['notes']); ?></td>
                <?php if($role == 'Administrator'): ?>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Select Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionDropdown">

                      <?php if($role == 'Administrator'): ?>

                        <a href="/<?php echo e($appName); ?>/shortlist/mail?shortlist_id=<?php echo e($item['shortlist_id']); ?>&applicant_id=<?php echo e($item['user_id']); ?>" class="dropdown-item">Send Email</a>

                      <?php endif; ?>
                    </div>
                  </div>
                </td>
                <?php endif; ?>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            </tbody>
          </table>
          <!-- End Table with stripped rows -->

        </div>
      </div>
    </div>

  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>