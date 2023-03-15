<!-- partial:../../partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Topics management</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.department.management') }}">
                <i class="mdi mdi-home-modern menu-icon"></i>
                <span class="menu-title">Manage Department</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.account.management') }}">
                <i class="mdi mdi-contact-mail menu-icon"></i>
                <span class="menu-title">Manage Account</span>
            </a>
        </li>
    </ul>
</nav>
<!-- partial -->
