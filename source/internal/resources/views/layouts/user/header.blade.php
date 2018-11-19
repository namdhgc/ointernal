<div class="page-header">
            <!-- BEGIN HEADER TOP -->
            <div class="page-header-top">
                <div class="container">
                    <!-- BEGIN LOGO -->
                    {{-- <div class="page-logo"> --}}
                        <a href="/">
                            <img src="{{ URL::asset('assets/layouts/layout3/img/logo-default.jpg')}}" alt="logo" class="logo-default">
                        </a>
                    {{-- </div> --}}
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler"></a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            
                            <li class="droddown dropdown-separator">
                                <span class="separator"></span>
                            </li>
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            @if(@Auth::check() == false)
                            <li class="dropdown" id="">
                                <a href="{{ URL::to('/login')}}" class="dropdown-toggle"  data-close-others="true">
                                    <i class="icon-key"></i>
                                </a>
                            </li>
                            @endif
                            @if(@Auth::check() == true)
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="{{ URL::asset('assets/layouts/layout3/img/avatar1.jpg')}}">
                                    <span class="username username-hide-mobile">{{@Auth::user()->displayName}}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="{{ URL::Route('user-change-password')}}">
                                            <i class="icon-user"></i> Đổi mật khẩu
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ URL::to('/logout')}}">
                                            <i class="icon-key"></i>{{Lang::get('user/header.logout')}}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
            </div>
            <!-- END HEADER TOP -->
            <!-- BEGIN HEADER MENU -->
            <div class="page-header-menu">
                <div class="container">
                    <!-- BEGIN HEADER SEARCH BOX -->
                    <form class="search-form" action="#page_general_search.html" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="query">
                            <span class="input-group-btn">
                                <a href="javascript:;" class="btn submit">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </span>
                        </div>
                    </form>
                    <!-- END HEADER SEARCH BOX -->
                    <!-- BEGIN MEGA MENU -->
                    <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                    <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                    <div class="hor-menu  ">
                        <ul class="nav navbar-nav">
                            <li class="menu-dropdown classic-menu-dropdown active">
                                <a href="/"> {{Lang::get('user/header.home')}}
                                    <span class="arrow"></span>
                                </a>
                            </li>
                            <!-- <li class="menu-dropdown classic-menu-dropdown ">
                                <a href="news"> {{Lang::get('user/header.news')}}
                                    {{-- <span class="arrow"></span> --}}
                                    <span class="badge badge-danger">2</span>
                                </a>
                                <ul class="dropdown-menu pull-left">
                                    <li class=" ">
                                        <a href="#" class="nav-link  "> {{Lang::get('user/header.general')}} </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#" class="nav-link  "> {{Lang::get('user/header.dev')}} </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#" class="nav-link  "> {{Lang::get('user/header.test')}} </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-dropdown classic-menu-dropdown ">
                                <a href="javascript:;"> {{Lang::get('user/header.download')}}
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu pull-left">
                                    <li class=" ">
                                        <a href="#" class="nav-link  "> {{Lang::get('user/header.general')}} </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#" class="nav-link  "> {{Lang::get('user/header.dev')}} </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#" class="nav-link  "> {{Lang::get('user/header.test')}} </a>
                                    </li>
                                </ul>
                            </li> -->
                            @if(Auth::check()==true)
                            <li class="menu-dropdown classic-menu-dropdown ">
                                <a href="javascript:;"> {{Lang::get('user/header.my_time_sheet')}}
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu pull-left">
                                    <li class="dropdown-submenu ">
                                        <a href="javascript:;" class="nav-link nav-toggle ">
                                            <i class="icon-briefcase"></i> {{Lang::get('user/header.log')}}
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="">
                                                <a href="{{ URL::to('timesheet_log')}}" class="nav-link"> {{Lang::get('user/header.timesheet')}}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="{{ URL::to('overtime_log')}}" class="nav-link"> {{Lang::get('user/header.over')}}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="{{ URL::to('leave_request_create')}}" class="nav-link nav-toggle "> {{Lang::get('user/header.create_leave_request')}}
                                                    <span class="arrow"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu ">
                                        <a href="javascript:;" class="nav-link nav-toggle ">
                                            <i class="icon-bar-chart"></i> {{Lang::get('user/header.report')}}
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class=" ">
                                                <a href="{{ URL::Route('user-summary')}}" class="nav-link "> {{Lang::get('user/header.summary')}} </a>
                                            </li>
                                            <li class=" ">
                                                <a href="{{ URL::to('timesheetReport')}}" class="nav-link "> {{Lang::get('user/header.timesheet')}} </a>
                                            </li>
                                            <li class=" ">
                                                <a href="{{ URL::to('overtimeReport')}}" class="nav-link "> {{Lang::get('user/header.over')}} </a>
                                            </li>
                                            <li class=" ">
                                                <a href="{{ URL::to('leaveRequestReport')}}" class="nav-link "> {{Lang::get('user/header.leave_request')}} </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            @endif

                            @if(Auth::check()==true)
                            <li class="menu-dropdown classic-menu-dropdown ">
                                <a href="javascript:;"> {{Lang::get('user/header.file')}}
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="">
                                        <a href="{{ URL::Route('user-upload-file')}}" class="nav-link"> {{Lang::get('user/header.upload_file')}}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif

                            <li class="menu-dropdown classic-menu-dropdown ">
                                <a href="javascript:;"> {{Lang::get('user/header.information')}}
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="">
                                        <a href="{{ URL::Route('user-news') }}" class="nav-link"> {{Lang::get('user/header.news')}}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- <li class="">
                                <a href="javascript:;"> {{Lang::get('user/header.employee')}}
                                    <span class="arrow"></span>
                                </a>
                            </li>
                            <li class="">
                                <a href="javascript:;"> {{Lang::get('user/header.forum')}}
                                    <span class="arrow"></span>
                                </a>
                            </li> -->
                        </ul>
                    </div>
                    <!-- END MEGA MENU -->
                </div>
            </div>
            <!-- END HEADER MENU -->
        </div>