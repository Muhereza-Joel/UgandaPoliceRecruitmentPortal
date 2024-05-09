@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Job Applications</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Job Applications</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    
  </section>

</main><!-- End #main -->

@include('partials/footer')