<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>    
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading"></li>
                <li>
                    <a href="{{route('home')}}" class="mm-active">
                        <i class="metismenu-icon pe-7s-display1"></i>
                        Dashboard
                    </a>
                </li>
                <li class="app-sidebar__heading"></li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-users"></i>
                        Employees
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        
                        <li>
                            <a href="{{route('admin.list-employees')}}">
                                <i class="metismenu-icon">
                                </i>List of Employees
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.list-attendances')}}">
                                <i class="metismenu-icon">
                                </i>Attendances
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.list-payrolls')}}">
                                <i class="metismenu-icon">
                                </i>Payroll
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{route('admin.list-cashadvances')}}">
                                <i class="metismenu-icon">
                                </i>Cash Advance
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Categories
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        
                        <li>
                            <a href="{{route('admin.list-position')}}">
                                <i class="metismenu-icon ">
                                </i>Positions

                            </a>
                            
                        </li>
                        <li>
                            <a href="{{route('admin.list-schedule')}}">
                                Schedule
                            </a>
                        </li>
                        <li>
                                <a href="{{route('admin.list-projects')}}">
                                <i class="metismenu-icon">
                                </i>Projects

                            </a>
                            
                        </li>
                        <li>
                            <a href="{{route('admin.list-services')}}">
                            <i class="metismenu-icon">
                            </i>Services

                        </a>
                       </li>
                       <li>
                        <a href="{{route('admin.list-holidays')}}">
                        <i class="metismenu-icon">
                        </i>Holidays
                    </a>
                   </li>
                    </ul>
                </li>

                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-users"></i>
                        Users
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        
                        <li>
                            <a href="{{route('admin.list-users')}}">
                                <i class="metismenu-icon">
                                </i>List of Users
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.list-users.register')}}">
                                <i class="metismenu-icon">
                                </i>New User
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{route('admin.company-profile')}}">
                        <i class="metismenu-icon pe-7s-global"></i>
                        Company Profile
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div> 