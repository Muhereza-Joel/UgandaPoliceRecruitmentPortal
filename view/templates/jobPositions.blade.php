@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Job Positions</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Job Positions</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="col-sm-8">
        <form class="row g-3" id="add-job-form">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Create New Position</h5>

              <!-- Floating Labels Form -->
              <div class="col-md-12">
                <div class="form-floating">
                  <input autocomplete="off" type="text" class="form-control" name="title" id="job-title" placeholder="Job Title" required>
                  <label for="job-title">Job Title</label>
                </div>
              </div>

            </div>
          </div>

          <div class="card">
            <h5 class="card-title">Job Description</h5>
            <div class="card-body">
              <!-- Job Description -->
              <div class="col-md-12">
                <div class="form-group">
                  <div id="description-editor" style="height: 150px; margin-top: 10px;"></div>
                  <input type="hidden" name="description" id="description">
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <h5 class="card-title">Job Requirements</h5>
            <div class="card-body">
              <!-- Requirements -->
              <div class="col-md-12">
                <div class="form-group">
                  <div id="requirements-editor" style="height: 200px; margin-top: 10px;"></div>
                  <input type="hidden" name="requirements" id="requirements">
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <h5 class="card-title">Job Responsibilities</h5>
            <div class="card-body">
              <!-- Responsibilities -->
              <div class="col-md-12">
                <div class="form-group">
                  <div id="responsibilities-editor" style="height: 200px; margin-top: 10px;"></div>
                  <input type="hidden" name="responsibilities" id="responsibilities">
                </div>
              </div>
            </div>
          </div>

          <div class="text-start">
            <button type="submit" class="btn btn-primary btn-sm">Submit Job Position</button>
          </div>


        </form><!-- End floating Labels Form -->
      </div>
    </div>
  </section>

</main><!-- End #main -->

@include('partials/footer')

<script>
  var descriptionEditor = new Quill('#description-editor', {
    theme: 'snow',
    placeholder: 'Write a job description here...',
  });

  var requirementsEditor = new Quill('#requirements-editor', {
    theme: 'snow',
    placeholder: 'Write job requirements here...',
  });

  var responsibilitiesEditor = new Quill('#responsibilities-editor', {
    theme: 'snow',
    placeholder: 'Write job responsibilities here...',
  });
</script>

<script>
  $(document).ready(function() {

    $('#add-job-form').submit(function(event) {

      event.preventDefault();

      $('#description').val(descriptionEditor.root.innerHTML);
      $('#requirements').val(requirementsEditor.root.innerHTML);
      $('#responsibilities').val(responsibilitiesEditor.root.innerHTML);

      if (this.checkValidity() === true) {

        let formData = new FormData(this);

        $.ajax({
          method: "POST",
          url: "/{{$appName}}/jobs/create/",
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            Toastify({
              text: response.message || "Position Saved Successfully",
              duration: 4000,
              gravity: 'bottom',
              position: 'left',
              backgroundColor: '#32a852',
            }).showToast();

            setTimeout(function(){window.location.reload()}, 4500)
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