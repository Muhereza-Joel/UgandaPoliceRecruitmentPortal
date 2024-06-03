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
        <div class="alert alert-dark">
          <h2 class="fw-bold">Uganda Police Force</h2>
          <span class="text-success">{{$appName}}</span>
          <hr>
          <h5>Welcome back, {{$username}}</h5>
        </div>

      </div>
      <div class="col-sm-5"></div>
      
    </div>
    <div class="row">
     @if($role == 'Administrator')
     <div class="col-sm-3">
       <div class="card p-2">
         <div class="card-title">ShortListed Aplicants</div>
         <div class="card-body">
          <h1>{{$shorlistCount}}</h1>
         </div>
       </div>

     </div>

     <div class="col-sm-3">
       <div class="card p-2">
         <div class="card-title">Pending Aplicantions</div>
         <div class="card-body">
          <h1>{{$pendingCount}}</h1>
         </div>
       </div>

     </div>

     <div class="col-sm-3">
       <div class="card p-2">
         <div class="card-title">Aplicantions In Review</div>
         <div class="card-body">
          <h1>{{$reviewingCount}}</h1>
         </div>
       </div>

     </div>


     <div class="col-sm-3">
       <div class="card p-2">
         <div class="card-title text-success">Accepted Aplicantions</div>
         <div class="card-body">
          <h1 class="text-success">{{$acceptedCount}}</h1>
         </div>
       </div>

     </div>


     


     <div class="col-sm-3">
       <div class="card p-2">
         <div class="card-title text-danger">Rejected Aplicantions</div>
         <div class="card-body">
          <h1 class="text-danger">{{$rejectedCount}}</h1>
         </div>
       </div>

     </div>


     @endif
    </div>
  </section>

</main><!-- End #main -->

@include('partials/footer')