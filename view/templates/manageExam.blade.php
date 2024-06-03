@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Manage Exams</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
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

       <div class="alert alert-info">
        Please don't forget to assign the test you create here to the jobs you created. Be informed that re-assigning a test to a job that has a test already will update it to the new assignment.
       </div>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Current Tests in the system</h5>

            <!-- Table with stripped rows -->
            <table class="table table-striped" id="exams-table">
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
                @foreach($tests as $test)
                <tr>
                  <th scope="row">{{$loop->iteration}}</th>
                  <td>{{$test['title']}}</td>
                  <td>{{$test['duration_minutes']}} minutes</td>
                  <td>{{$test['total_marks']}}</td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="actionDropdown">

                        @if($role == 'Administrator')
                        <a href="#" class="dropdown-item">
                          Edit Test Details
                        </a>
                        <a href="/{{$appName}}/manage-exams/test/add-questions?test_id={{$test['test_id']}}" class="dropdown-item icon" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Questions you add to this test will be the ones applicants will answer when shortlisted and allowed to take aptitude test">
                          Add Questions To Test.
                        </a>
                        <a href="/{{$appName}}/test/delete/" class="dropdown-item icon text-danger" id="remove-btn" data-test-id="{{$test['test_id']}}">
                          Delete Test
                        </a>
                        @endif
                      </div>
                    </div>

                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>

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
          <h6 class="text-dark">Are you sure you want to execute this action?</h6>
          <div class="alert alert-danger mt-2">Note that this action will delete the test with all its questions.</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Yes, Delete Test</button>
        </div>
      </div>
    </div>
  </div>
</main><!-- End #main -->

@include('partials/footer')

<script>
  $(document).ready(function() {

    $("#create-test-form").submit(function(event) {
      event.preventDefault();

      if (this.checkValidity() === true) {
        let formData = new FormData(this);

        $.ajax({
          method: "POST",
          url: "/{{$appName}}/test/create/",
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
              window.location.reload();
            }, 4500);
          },
          error: function(response) {
            Toastify({
              text: response.message || "An Error Occurred",
              duration: 4000,
              gravity: 'bottom',
              position: 'left',
              backgroundColor: 'red',
            }).showToast();
          }
        });
      }
    });

    let testId;

    $('#exams-table').on('click', '#remove-btn', function(event) {
      event.preventDefault();
      testId = $(this).data('test-id');
      $('#confirmDeleteModal').modal('show');
    });

    $('#confirmDeleteModal').on('click', '#confirmDeleteBtn', function() {
      $.ajax({
        method: "POST",
        url: "/{{$appName}}/test/delete/",
        data: {
          id: testId
        },
        success: function(response) {
          Toastify({
            text: response.message || 'Test deleted successfully',
            duration: 2000,
            gravity: 'bottom',
            backgroundColor: 'green',
          }).showToast();

          setTimeout(function() {
            window.location.reload();
          }, 2300);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });

    $('#cancel-btn').click(function() {
      $('#confirmDeleteModal').modal('hide');
    });
  });
</script>
