<nav class="main-nav" role="navigation">

    <!-- Mobile menu toggle button (hamburger/x icon) -->
    <input id="main-menu-state" type="checkbox">
    <label class="main-menu-btn" for="main-menu-state">
        <span class="main-menu-btn-icon"></span> Toggle main menu visibility
    </label>

    <!-- Sample menu definition -->
    <ul id="main-menu" class="sm sm-blue">
        <li
            class="{{ request()->is('dashboard*')  ? 'current' : '' }}">
            <a href="#" style="font-size: 18px;">
                <i data-feather="home" style="width: 18px; height: 18px;"></i>
                Dashboard
            </a>
            <ul>
            @can('view user dashboard hse')
            <li><a href="{{ route('hse.dashboard') }}"
                class="{{ request()->is('dashboard-hse') ? 'current' : '' }}"><i class="icon-Commit"><span
                class="path1"></span><span class="path2"></span></i>User Dashboard</a></li>
            @endcan
            @can('review form hse')
            <li><a href="{{ route('review.table') }}"
                class="{{ request()->is('dashboard-review') ? 'current' : '' }}"><i class="icon-Commit"><span
                class="path1"></span><span class="path2"></span></i>Review Dashboard</a></li>
            @endcan
            @can('approve form hse')
            <li><a href="{{ route('approval.table') }}" class="{{ request()->is('dashboard-approval') ? 'current' : '' }}"><i
                class="icon-Commit"><span class="path1"></span><span
                class="path2"></span></i>Approval Dashboard</a></li>
            @endcan
            @can('view security dashboard hse')
            <li><a href="{{ route('securityPost.table') }}" class="{{ request()->is('dashboard-security') ? 'current' : '' }}"><i
                class="icon-Commit"><span class="path1"></span><span
                class="path2"></span></i>Security Post Dashboard</a></li>
            @endcan
            </ul>
        </li>
        
        @can('view all form hse')
        <li
            class="{{ request()->is('viewAll-table') || request()->is('location') || request()->is('approver')  ? 'current' : '' }}">
            <a href="#" style="font-size: 18px;">
                <i data-feather="check-circle" style="width: 18px; height: 18px;"></i>
                HSE Management
            </a>
            <ul>
                @can('view all form hse')
                <li><a href="{{ route('viewAll.table') }}" class="{{ request()->is('viewAll-table') ? 'current' : '' }}"><i
                            class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>View All Work Permit</a>
                </li>
                @endcan
                @can('edit location hse')
                <li><a href="{{ route('location.hse') }}" class="{{ request()->is('location') ? 'current' : '' }}"><i
                        class="icon-Commit"><span class="path1"></span><span class="path2"></span></i> HSE Location </a>
                    </li>
                @endcan 
                @can('edit approver hse')
                <li><a href="{{ route('approver.view.hse') }}" class="{{ request()->is('approver') ? 'current' : '' }}"><i
                            class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Approval Level</a>
                </li>
                @endcan
                @can('view all form hse')
                <li><a href="" class="{{ request()->is('level*') ? 'current' : '' }}"><i
                            class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Job Evaluation</a>
                </li>
                @endcan
                @can('view all form hse')
                <li><a href="" class="{{ request()->is('level*') ? 'current' : '' }}"><i
                            class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Evaluation Report</a>
                </li>
                @endcan
                @can('view register form')
                <li><a href="{{ route('register.hse') }}" class="{{ request()->is('level*') ? 'current' : '' }}"><i
                            class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Register Form</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('edit location hse')
        <li
            class="{{ request()->is('users*') || request()->is('department*') || request()->is('position*') || request()->is('level*') || request()->is('roles*') || request()->is('permissions*') || request()->is('get.master*') ? 'current' : '' }}">
            <a href="#" style="font-size: 18px;">
                <i data-feather="users" style="width: 18px; height: 18px;"></i>
                User Management
            </a>
            <ul>

                    <li><a href="{{ route('users.index') }}" class="{{ request()->is('users*') ? 'current' : '' }}"><i
                                class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Users</a>
                    </li>


                    <li><a href="{{ route('department.index') }}"
                            class="{{ request()->is('department*') ? 'current' : '' }}"><i class="icon-Commit"><span
                                    class="path1"></span><span class="path2"></span></i>Departments</a></li>


                    <li><a href="{{ route('position.index') }}" class="{{ request()->is('position*') ? 'current' : '' }}"><i
                                class="icon-Commit"><span class="path1"></span><span
                                    class="path2"></span></i>Positions</a></li>


                    <li><a href="{{ route('level.index') }}" class="{{ request()->is('level*') ? 'current' : '' }}"><i
                                class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Levels</a>
                    </li>

                    <li><a href="{{ route('roles.index') }}" class="{{ request()->is('roles*') ? 'current' : '' }}"><i
                                class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Roles</a>
                    </li>
                    <li><a href="{{ route('permissions.index') }}"
                            class="{{ request()->is('permissions*') ? 'current' : '' }}"><i class="icon-Commit"><span
                                    class="path1"></span><span class="path2"></span></i>Permission</a></li>
                    
            </ul>
        </li>
        @endcan
            
    </ul>
</nav>
