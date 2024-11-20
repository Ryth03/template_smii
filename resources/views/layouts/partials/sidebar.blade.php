<nav class="main-nav" role="navigation">

    <!-- Mobile menu toggle button (hamburger/x icon) -->
    <input id="main-menu-state" type="checkbox">
    <label class="main-menu-btn" for="main-menu-state">
        <span class="main-menu-btn-icon"></span> Toggle main menu visibility
    </label>

    <!-- Sample menu definition -->
    <ul id="main-menu" class="sm sm-blue">
        @can('view user dashboard hse')
        <li
            class="{{ request()->is('users*') || request()->is('department*') || request()->is('position*') || request()->is('level*') || request()->is('roles*') || request()->is('permissions*') || request()->is('get.master*') ? 'current' : '' }}">
            <a href="{{ route('hse.dashboard') }}" style="font-size: 18px;">
                <i data-feather="users" style="width: 18px; height: 18px;"></i>
                Dashboard
            </a>
        </li>
        @endcan
        @can('view security dashboard hse')
        <li
            class="{{ request()->is('users*') || request()->is('department*') || request()->is('position*') || request()->is('level*') || request()->is('roles*') || request()->is('permissions*') || request()->is('get.master*') ? 'current' : '' }}">
            <a href="{{ route('securityPost.table') }}" style="font-size: 18px;">
                <i data-feather="users" style="width: 18px; height: 18px;"></i>
                Security Post Table
            </a>
        </li>
        @endcan
        <li
            class="{{ request()->is('users*') || request()->is('department*') || request()->is('position*') || request()->is('level*') || request()->is('roles*') || request()->is('permissions*') || request()->is('get.master*') ? 'current' : '' }}">
            <a href="#" style="font-size: 18px;">
                <i data-feather="users" style="width: 18px; height: 18px;"></i>
                HSE
            </a>
            <ul>
                @can('review form hse')
                <li><a href="{{ route('review.table') }}"
                        class="{{ request()->is('department*') ? 'current' : '' }}"><i class="icon-Commit"><span
                                class="path1"></span><span class="path2"></span></i>Pending Review</a></li>
                @endcan
                @can('approve form hse')
                <li><a href="{{ route('approval.table') }}" class="{{ request()->is('position*') ? 'current' : '' }}"><i
                            class="icon-Commit"><span class="path1"></span><span
                                class="path2"></span></i>Pending Approval</a></li>
                @endcan
                @can('view all form hse')
                <li><a href="{{ route('viewAll.table') }}" class="{{ request()->is('level*') ? 'current' : '' }}"><i
                            class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>View All Form</a>
                </li>
                @endcan
                @can('view register form')
                <li><a href="{{ route('register.hse') }}" class="{{ request()->is('level*') ? 'current' : '' }}"><i
                            class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Register Form</a>
                </li>
                @endcan
            </ul>
        </li>
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
                    <li><a href="{{ route('get.master') }}" class="{{ request()->is('get.master*') ? 'current' : '' }}"><i
                                class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Get Data
                            Master </a>
                    </li>
                    <li><a href="{{ route('location.hse') }}" class="{{ request()->is('get.master*') ? 'current' : '' }}"><i
                        class="icon-Commit"><span class="path1"></span><span class="path2"></span></i> HSE Location </a>
                    </li>
                    
            </ul>
        </li>
        @endcan
            
    </ul>
</nav>
