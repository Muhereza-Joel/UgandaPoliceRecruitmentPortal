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

    <div class="row">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Showing all applications</h5>

          <!-- Table with stripped rows -->
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">SNo</th>
                <th scope="col">Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Job Title</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>

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
                  @endif
                </td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Select Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionDropdown">

                      @if($role == 'Administrator')



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

  </section>

</main><!-- End #main -->

@include('partials/footer')