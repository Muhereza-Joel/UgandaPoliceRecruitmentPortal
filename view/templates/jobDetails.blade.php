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

  <section class="section dashboard">
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
        <a href="/{{$appName}}/job-positions/listing/apply?id={{$job['id']}}" class="btn btn-primary btn-sm">Apply Now</a>
        @if($role == 'Administrator')
        <a href="#" class="btn btn-success btn-sm">Update Job</a>
        <a href="#" class="btn btn-danger btn-sm">Delete Job</a>
        @endif
      </div>
    </div>
  </section>

</main><!-- End #main -->

@include('partials/footer')