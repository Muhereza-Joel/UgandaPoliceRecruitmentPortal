<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  
  @if($role == 'Administrator')
  
  <li class="nav-item">
    <a class="nav-link " href="/{{$appName}}/dashboard/">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li class="nav-heading mb-3">Pages</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="/{{$appName}}/job-positions/">
      <i class="bi bi-card-list"></i>
      <span>Job Positions</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="/{{$appName}}/job-positions/listing/">
      <i class="bi bi-card-list"></i>
      <span>Jobs</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="/{{$appName}}/applications/">
      <i class="bi bi-card-list"></i>
      <span>Applicantions</span>
    </a>
  </li>

  
  
  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/{{$appName}}/shortlist/">
      <i class="bi bi-card-list"></i>
      <span>Short List</span>
    </a>
  </li>

  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/{{$appName}}/manage-exams/">
      <i class="bi bi-cart"></i>
      <span>Manage Exams</span>
    </a>
  </li>

  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/{{$appName}}/users/">
      <i class="bi bi-cart"></i>
      <span>Users</span>
    </a>
  </li>

  @endif

  @if($role == 'User')
  <li class="nav-item pb-2">
    <a class="nav-link " href="/{{$appName}}/dashboard/">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/{{$appName}}/job-positions/listing/">
      <i class="bi bi-card-list"></i>
      <span>Jobs</span>
    </a>
  </li>


  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/{{$appName}}/my-applications/">
      <i class="bi bi-card-list"></i>
      <span>My Applications</span>
    </a>
  </li>

  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/{{$appName}}/u/shortlist/">
      <i class="bi bi-card-list"></i>
      <span>Shortlist</span>
    </a>
  </li>
  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/{{$appName}}/exam/">
      <i class="bi bi-card-list"></i>
      <span>Apptitute Test</span>
    </a>
  </li>

  @endif

</ul>

</aside><!-- End Sidebar-->