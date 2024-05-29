@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Start Aptitude Test</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Aptitude Test</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

  <div class="row g-2">
    @if(empty($myTest))
      <div class="col-12">
        <div class="alert alert-warning"><strong>No test details available you at the moment.</strong></div>
      </div>
    @else
      <div class="col-sm-6">
        <div class="card p-2">
          <div class="card-title">Details of Job You Applied For</div>
          <div class="card-body">
            <small class="fw-bold">Job Title</small>
            <h5>{{$myTest['job_title']}}</h5><br>
            <small class="fw-bold">Job Description</small>
            <p>{!!$myTest['job_description']!!}</p><br>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card p-2">
          <div class="card-title">Aptitude Test Details</div>
          <div class="card-body">
            <small class="fw-bold">Test Title</small>
            <h5>{{$myTest['test_title']}}</h5><br>

            <small class="fw-bold">Test Description</small>
            <p>{!!$myTest['test_description']!!}</p><br>

            <small class="fw-bold">Test Duration</small>
            <p>{{$myTest['duration_minutes']}} Minutes</p><br>

            <small class="fw-bold">Number of Questions</small>
            <p>{{$myTest['question_count']}} Questions</p><br>

            <small class="fw-bold">Total Marks</small>
            <p>{{$myTest['total_marks']}}</p><br>

            @if($myTest['mapping_status'] == 'closed')
              <div class="alert alert-info"><strong>Test is not active, you will do the test when it's active</strong></div>
            @else
              <a href="/{{$appName}}/exam/attempt?id={{$myTest['test_id']}}&time={{$myTest['duration_minutes']}}" class="btn btn-sm btn-primary">Start Test</a>
            @endif
          </div>
        </div>
      </div>
    @endif
  </div>
    
  </section>

</main><!-- End #main -->

@include('partials/footer')
