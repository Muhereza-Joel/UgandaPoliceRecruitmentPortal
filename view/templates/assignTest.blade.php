@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light">Assign Test To Job Post</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
                <li class="breadcrumb-item active text-light">Assign Test</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">

                <div class="card p-2">
                    <div class="card-title">Job Details To Assign Test</div>
                    <div class="card-body">
                        <div class="alert alert-light">
                            <h2 class="text-success">{{$job['title']}}</h2>
                            <p class="text-secondary">{!!$job['description']!!}</p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Current Tests in the system</h5>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped" id="exams-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Test Title</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Total Marks</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tests as $test)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$test['title']}}</td>
                                    <td>{{$test['duration_minutes']}} minutes</td>
                                    <td>{{$test['total_marks']}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Select Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="actionDropdown">

                                                @if($role == 'Administrator')
                                                <a href="/{{$appName}}/jobs/assign-test/?test-id={{$test['test_id']}}&job-id={{$job['id']}}" class="dropdown-item" id="assign-btn">
                                                    Assign This Test
                                                </a>


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

            <div class="col-sm-4">
                @if(!empty($jobAssignment))
                <div class="card p-2">
                    <div class="card-body">
                        <div class="card-title">Current Test Assigned To: {{$job['title']}}</div>
                        <div class="alert alert-light">
                            <h5>{{$jobAssignment['title']}}</h5>
                            <hr>
                            <span class="fw-bold">Description</span>
                            <p>{{$jobAssignment['description']}}</p>

                            <hr>
                            <span class="fw-bold">Duration</span>
                            <p>{{$jobAssignment['duration_minutes']}}</p>
                        </div>

                        <a href="/{{$appName}}/jobs/drop-test/?id={{$jobAssignment['mapping_id']}}" class="btn btn-sm btn-danger" id="drop-text-btn">Drop Assignment</a>

                    </div>
                </div>
                @else
                <div class="card p-2">
                    <div class="card-body">
                        <div class="card-title">No Test Assigned for {{$job['title']}}</div>
                        <div class="alert alert-warning">
                            <p>No current test assignment available for this job.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>



        </div>
    </section>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="confirmDeleteModalLabel">Confirm Your Action</h5>

                </div>
                <div class="modal-body">
                    <h6 class="text-dark">Are you sure you want to execute this action?</h6>
                    <div class="alert alert-warning p-1 mt-2">Note that this will drop this assignment, if you want applicants to attempt a test again against this job, you have to re-assign it again.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Yes, Drop Test</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmAssignModal" tabindex="-1" role="dialog" aria-labelledby="confirmAssignModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="confirmAssignModalLabel">Confirm Your Action</h5>

                </div>
                <div class="modal-body">
                    <h6 class="text-dark">Are you sure you want to execute this action?</h6>
                    <div class="alert alert-warning">Note that if this position has a test already, a new assignment replaces the existing test</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="cancel-assign-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmAssignBtn" class="btn btn-success btn-sm">Yes, Assign Test</button>
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->

@include('partials/footer')

<script>
    $(document).ready(function() {
        $('#exams-table').on('click', '#assign-btn', function(event) {
            event.preventDefault();

            var removeUrl = $(this).attr('href');

            $('#confirmAssignModal').modal('show');
            $('#cancel-assign-btn').click(function() {
                $('#confirmAssignModal').modal('hide');

            })

            $('#confirmAssignModal').on('click', '#confirmAssignBtn', function() {
                $.post(removeUrl, function(response) {
                    Toastify({
                        text: response.message || 'Test Assigned successfully',
                        duration: 2000,
                        gravity: 'bottom',
                        backgroundColor: 'green',
                    }).showToast();

                    setTimeout(function() {
                        window.location.reload();

                    }, 3000)
                });
            });
        })

        $('#drop-text-btn').on('click', function(event) {
            event.preventDefault();

            var removeUrl = $(this).attr('href');

            $('#confirmDeleteModal').modal('show');
            $('#cancel-btn').click(function() {
                $('#confirmDeleteModal').modal('hide');

            })

            $('#confirmDeleteModal').on('click', '#confirmDeleteBtn', function() {
                $.post(removeUrl, function(response) {
                    Toastify({
                        text: response.message || 'Assignment Droped successfully',
                        duration: 2000,
                        gravity: 'bottom',
                        backgroundColor: 'green',
                    }).showToast();

                    setTimeout(function() {
                        window.location.reload();

                    }, 3000)
                });
            });
        })
    })
</script>