@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <div class="col-sm-7">
        <div class="alert alert-light">
          <h2 class="fw-bold">Uganda Police Force</h2>
          <span class="text-success">{{$appName}}</span>
          <hr>
          <h5>Welcome back, {{$username}}</h5>
        </div>

        <div class="row">
         
        </div>
      </div>
      <div class="col-sm-5"></div>

    </div>
  </section>

</main><!-- End #main -->

@include('partials/footer')