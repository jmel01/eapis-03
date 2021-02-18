<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
        <img src="{{ asset('/images/app/NCIP_logo150x150.png') }}" alt="NCIP Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{ config('app.name', 'NCIP-EAPIS') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="far fa-chart-bar nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>



                @unlessrole('Applicant')
                @can('grant-browse')
                <li class="nav-item">
                    <a href="{{ route('showAllApplication') }}" class="nav-link">
                        <i class="far fa-thumbs-up nav-icon"></i>
                        <p>All Applications</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('showAllApproved') }}" class="nav-link">
                        <i class="far fa-thumbs-up nav-icon"></i>
                        <p>Approved Applications</p>
                    </a>
                </li>
                @endcan

                @can('grant-browse')
                <li class="nav-item">
                    <a href="/grants" class="nav-link">
                        <i class="fas fa-university nav-icon"></i>
                        <p>Grants/Scholarship</p>
                    </a>
                </li>
                @endcan

                @can('report-browse')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>Reports<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('formA') }}" class="nav-link">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Summary of Grant Status</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('formB') }}" class="nav-link">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Report of Graduates</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('formC') }}" class="nav-link">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Report of Termination</p>
                            </a>
                        </li>

                        <!--  <li class="nav-item">
                            <a href="{{ route('formD') }}" class="nav-link">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Form D x</p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="{{ route('formE') }}" class="nav-link">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Report on Disbursement</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('formF') }}" class="nav-link">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Actual Disbursement</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('formG') }}" class="nav-link">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Actual Payment of Grantees</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="{{ route('formH') }}" class="nav-link">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Form H x</p>
                            </a>
                        </li> -->

                    </ul>
                </li>
                @endcan

                @can('announcement-browse')
                <li class="nav-item">
                    <a href="{{ route('calendars.index') }}" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>Announcement</p>
                    </a>
                </li>
                @endcan

                @hasanyrole('Admin|Executive Officer|Regional Officer|Provincial Officer|Community Service Officer')
                <li class="nav-item">
                    <a href="{{ route('myDocument') }}" class="nav-link">
                        <i class="far fa-folder-open nav-icon"></i>
                        <p>My Documents</p>
                    </a>
                </li>
                @endhasanyrole

                @can('user-browse')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>User Management<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="far fa-address-book nav-icon"></i>
                                <p>User List</p>
                            </a>
                        </li>

                        @can('role-browse')
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link">
                                <i class="fas fa-user-lock nav-icon"></i>
                                <p>Roles and Permission</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('requirements-browse')
                <li class="nav-item">
                    <a href="{{ route('requirements.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-toolbox"></i>
                        <p>Requirement Management</p>
                    </a>
                </li>
                @endcan

                @can('ethnogroups-browse')
                <li class="nav-item">
                    <a href="{{ route('ethnogroups.index') }}" class="nav-link">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Ethnogroups</p>
                    </a>
                </li>
                @endcan

                @endunlessrole

                @role('Admin')
                <li class="nav-item">
                    <a href="/activity-logs" class="nav-link">
                        <i class="fas fa-clipboard-list nav-icon"></i>
                        <p>Activity Logs</p>
                    </a>
                </li>
                @endrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>