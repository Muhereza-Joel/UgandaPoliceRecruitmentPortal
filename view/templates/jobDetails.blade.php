@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Job Details</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Job Details</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard" id="jobs-listing">
    <div class="card py-4  px-2 my-3">
      <div class="card-body">
        <div class="h5 text-secondary fw-bold">Job Title</div>
        <div>{{$job['title']}}</div>
        <small class="text-info">Posted On {{$job['created_at']}}</small>
        <hr>
        <div class="h5 text-secondary fw-bold">Description</div>
        <div>{!!$job['description']!!}</div><br>

        @if($action == 'view')
        <div class="h5 text-secondary fw-bold">Requirements</div>
        <div>{!!$job['requirements']!!}</div>

        <div class="h5 text-secondary fw-bold">Responsibilities</div>
        <div>{!!$job['requirements']!!}</div>
        @endif
        <hr>
        <form id="deleteForm" action="/{{$appName}}/jobs/delete/" method="POST">
          <div class="d-flex">
            <a href="/{{$appName}}/job-positions/listing/apply?id={{$job['id']}}" class="btn btn-primary btn-sm me-2">Apply Now</a>
            @if($role == 'Administrator')
            <input type="hidden" name="id" value="{{$job['id']}}">
            <button type="button" class="btn btn-danger btn-sm" id="remove-btn" data-toggle="modal" data-target="#confirmDeleteModal">Delete Job</button>
            @endif

          </div>
        </form>
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
          <h6 class="text-dark">Are you sure you want to remove this job?</h6>
          <div class="alert alert-warning">Note that this will also delete applications, shortlisted candidates, and all results associated with this job.</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Yes, Remove Job</button>
        </div>
      </div>
    </div>
  </div>

</main><!-- End #main -->

@include('partials/footer')

<script>
  $(document).ready(function() {
    var removeUrl;

    $('#jobs-listing').on('click', '#remove-btn', function(event) {
      event.preventDefault();
      $('#confirmDeleteModal').modal('show');
      removeUrl = $('#deleteForm').attr('action');
    });

    $('#confirmDeleteBtn').click(function() {
      $.ajax({
        url: removeUrl,
        type: 'POST',
        data: $('#deleteForm').serialize(),
        success: function(response) {
          Toastify({
            text: response.message || 'Item removed successfully',
            duration: 2000,
            gravity: 'bottom',
            backgroundColor: '#161b22',
          }).showToast();

          setTimeout(function() {
            window.location.href = '/{{$appName}}/job-positions/listing/';
          }, 2300);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
      $('#confirmDeleteModal').modal('hide');
    });

    $('#cancel-btn').click(function() {
      $('#confirmDeleteModal').modal('hide');
    });

    $('#confirmDeleteModal').on('hidden.bs.modal', function() {
      $('#deleteForm').off('submit');
    });
  });
</script>