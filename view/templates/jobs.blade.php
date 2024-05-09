@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Jobs</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Jobs</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    @foreach($listing as $job)
    <div class="card py-4  px-2 my-3">
      <div class="card-body">
        <div class="h5 text-secondary fw-bold">Job Title</div>
        <div>{{$job['title']}}</div>
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
        <a href="/{{$appName}}/job-positions/listing/view?action=view&id={{$job['id']}}" class="btn btn-secondary btn-sm">View Job Details</a>
        
      </div>
    </div>
    @endforeach
  </section>

</main><!-- End #main -->

@include('partials/footer')