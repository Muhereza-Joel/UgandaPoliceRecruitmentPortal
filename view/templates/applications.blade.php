@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<style>
  .table-responsive {
    width: 100%;
    overflow-x: auto;
  }
</style>

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">{{$role == 'Administrator' ? 'Job' : 'Your Job'}} Applications</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">{{$role == 'Administrator' ? 'Job' : 'Your'}} Applications</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

    <div class="row p-2 g-2">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Showing {{$role == 'Administrator' ? 'all' : 'your'}} applications</h5>

          <!-- Table with stripped rows -->
          <div class="table-responsive">
            <table class="table table-striped datatable table-responsive" id="applications-table">
              <thead>
                <tr>
                  <th scope="col">SNo</th>
                  <th scope="col">Name</th>
                  <th scope="col">Phone Number</th>
                  <th scope="col">Job Title</th>
                  <th scope="col">Status</th>
                  @if($role == 'Administrator')
                  <th scope="col">Action</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach($applications as $application)
                <tr>
                  <th scope="row">{{$loop->iteration}}</th>
                  <td>{{$application['name']}}</td>
                  <td>{{$application['phone']}}</td>
                  <td>{{$application['title']}}</td>
                  <td>
                    @if($application['status'] == 'pending')
                    <span class="badge bg-warning">Pending</span>
                    @elseif($application['status'] == 'accepted')
                    <span class="badge bg-success">Accepted</span>
                    @elseif($application['status'] == 'reviewing')
                    <span class="badge bg-info">Reviewing</span>
                    @elseif($application['status'] == 'rejected')
                    <span class="badge bg-danger">Rejected</span>
                    @endif
                  </td>
                  @if($role == 'Administrator')
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="actionDropdown">
                        @if($role == 'Administrator')
                        @if($application['status'] == 'pending')
                        <a href="/{{$appName}}/jobs/applications/update-status/?application_id={{$application['application_id']}}&status=reviewing" class="dropdown-item" id="review-application-btn">Review Application</a>
                        @endif
                        @if($application['status'] == 'reviewing')
                        <a href="/{{$appName}}/jobs/applications/update-status/?application_id={{$application['application_id']}}&status=accepted" class="dropdown-item" id="accept-application-btn">Accept Application</a>
                        @endif
                        @if($application['status'] == 'accepted')
                        <a href="/{{$appName}}/applications/create-shortlist?application_id={{$application['application_id']}}&applicant_id={{$application['applicant_id']}}&position_id={{$application['position_id']}}" class="dropdown-item text-success" id="shortlist-applicant-btn">Shortlist Applicant</a>
                        @endif
                        @if($application['status'] != 'rejected')
                        <a href="/{{$appName}}/jobs/applications/update-status/?application_id={{$application['application_id']}}&status=rejected" class="dropdown-item text-danger" id="reject-application-btn">Reject Application</a>
                        @endif
                        @endif
                      </div>
                    </div>
                  </td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- End Table with stripped rows -->

        </div>
      </div>
    </div>

  </section>

  <div class="modal fade" id="acceptApplicationModal" tabindex="-1" role="dialog" aria-labelledby="acceptApplicationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="acceptApplicationModalLabel">Confirm Your Action</h5>

        </div>
        <div class="modal-body">
          <h6 class="text-dark">Are you sure you want to execute this action?</h6>
          <div class="alert alert-info p-1 mt-2">Note that this action will migrate the application to the third level of application process</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-accept-application-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmacceptApplicationBtn" class="btn btn-secondary btn-sm">Yes, Update Application Status</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="reviewApplicationModal" tabindex="-1" role="dialog" aria-labelledby="reviewApplicationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="reviewApplicationModalLabel">Confirm Your Action</h5>

        </div>
        <div class="modal-body">
          <h6 class="text-dark">Are you sure you want to execute this action?</h6>
          <div class="alert alert-info p-1 mt-2">Note that this action will migrate the application to the second level of application process</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-review-application-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmreviewApplicationBtn" class="btn btn-secondary btn-sm">Yes, Update Application Status</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="rejectApplicationModal" tabindex="-1" role="dialog" aria-labelledby="rejectApplicationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="rejectApplicationModalLabel">Confirm Your Action</h5>

        </div>
        <div class="modal-body">
          <h6 class="text-dark">Are you sure you want to execute this action?</h6>
          <div class="alert alert-danger p-1 mt-2">Note that this action will cancel the application, please continue with caution because the action is undoable</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-reject-application-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmrejectApplicationBtn" class="btn btn-secondary btn-sm">Yes, Update Application Status</button>
        </div>
      </div>
    </div>
  </div>

</main><!-- End #main -->

@include('partials/footer')

<script>
  $(document).ready(function() {

    $('#applications-table').on('click', '#accept-application-btn', function(event) {
      event.preventDefault();

      var url = $(this).attr('href');

      $('#acceptApplicationModal').modal('show');
      $('#confirmacceptApplicationBtn').on('click', function(event) {
        $('#acceptApplicationModal').modal('hide');

        $.ajax({
          method: 'POST',
          url: url,
          success: function(response) {

            Toastify({
              text: response.message || "Application Status Updated Successfully...",
              duration: 4000,
              gravity: 'bottom',
              position: 'left',
              backgroundColor: 'green',
            }).showToast();

            setTimeout(function() {
              window.location.reload();
            }, 2000)
          },
          error: function() {}
        })
      })

      $('#cancel-accept-application-btn').on('click', function(event) {
        $('#acceptApplicationModal').modal('hide');
      })
    })

    $('#applications-table').on('click', '#review-application-btn', function(event) {
      event.preventDefault();

      var url = $(this).attr('href');

      $('#reviewApplicationModal').modal('show');
      $('#confirmreviewApplicationBtn').on('click', function(event) {
        $('#reviewApplicationModal').modal('hide');

        $.ajax({
          method: 'POST',
          url: url,
          success: function(response) {

            Toastify({
              text: response.message || "Application Status Updated Successfully...",
              duration: 4000,
              gravity: 'bottom',
              position: 'left',
              backgroundColor: 'green',
            }).showToast();

            setTimeout(function() {
              window.location.reload();
            }, 2000)
          },
          error: function() {}
        })
      })

      $('#cancel-review-application-btn').on('click', function(event) {
        $('#reviewApplicationModal').modal('hide');
      })
    })

    $('#applications-table').on('click', '#reject-application-btn', function(event) {
      event.preventDefault();

      var url = $(this).attr('href');

      $('#rejectApplicationModal').modal('show');
      $('#confirmrejectApplicationBtn').on('click', function(event) {
        $('#rejectApplicationModal').modal('hide');

        $.ajax({
          method: 'POST',
          url: url,
          success: function(response) {

            Toastify({
              text: response.message || "Application Status Updated Successfully...",
              duration: 4000,
              gravity: 'bottom',
              position: 'left',
              backgroundColor: 'green',
            }).showToast();

            setTimeout(function() {
              window.location.reload();
            }, 2000)
          },
          error: function() {}
        })
      })

      $('#cancel-reject-application-btn').on('click', function(event) {
        $('#rejectApplicationModal').modal('hide');
      })
    })
  })
</script>