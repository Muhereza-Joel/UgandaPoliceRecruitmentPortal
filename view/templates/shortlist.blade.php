@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">{{$role == 'Administrator' ? 'All Shortisted Candidates' : 'My Shortlist'}}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">shortlist</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

    <div class="row">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{$role == 'Administrator' ? 'All Shortisted Candidates' : 'Your Shortlist'}}</h5>

          <!-- Table with stripped rows -->
          <table class="table table-striped datatable">
            <thead>
              <tr>
                <th scope="col">SNo</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Job Title</th>
                <th scope="col">Status</th>
                <th scope="col">Notes</th>

                @if($role == 'Administrator')
                 <th scope="col">Action</th>
                @endif

              </tr>
            </thead>
            <tbody>
              @foreach($shortlist as $item)
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$item['name']}}</td>
                <td>{{$item['phone']}}</td>
                <td>{{$item['title']}}</td>
                <td>
                  @if($item['status'] == 'shortlisted')
                    <span class="badge bg-success">Shortlisted</span>
                    
                  @endif
                </td>
                <td>{{$item['notes']}}</td>
                @if($role == 'Administrator')
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
                @endif
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