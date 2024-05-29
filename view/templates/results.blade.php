@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Results For All Tests</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active text-light">Results</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

  <div class="row p-2">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>SNo.</th>
                        <th>Applicant</th>
                        <th>Exam Title</th>
                        <th>Questions Passed</th>
                        <th>Total Marks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$result['person_name']}}</td>
                        <td>{{$result['test_title']}}</td>
                        <td>{{$result['correct_questions_count']}} out of {{$result['total_questions_count']}}</td>
                        <td>{{$result['total_marks']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
    
  </section>

</main><!-- End #main -->

@include('partials/footer')