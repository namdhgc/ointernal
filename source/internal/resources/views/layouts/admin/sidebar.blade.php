<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item">
                <a href="{{ URL::Route('adm-index') }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ Lang::get('admin/sidebar.home') }}</span>
                    <span class="selected"></span>
                    <!-- <span class="arrow open"></span> -->
                </a>
            </li>
            <!-- <li class="heading">
                <h3 class="uppercase">Thông tin chung</h3>
            </li> -->

            <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], '/news' )? 'active open':'' }}
                                {{ str_contains( $_SERVER['REQUEST_URI'], 'upload-news' )? 'active open':'' }} ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-briefcase"></i>
                    <span class="title">{{ Lang::get('admin/sidebar.information') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], '/news' )? 'active open':'' }}">
                        <a href="{{ URL::Route('adm-news') }}" class="nav-link ">
                            <i class="icon-layers"></i>
                            <span class="title">{{ Lang::get('admin/sidebar.news') }}</span>
                        </a>
                    </li>
                    <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'upload-news' )? 'active open':'' }}">
                        <a href="{{ URL::Route('adm-get-upload-news') }}" class="nav-link ">
                            <i class="icon-docs"></i>
                            <span class="title">{{ Lang::get('admin/sidebar.upload_news') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- <li class="heading">
                <h3 class="uppercase">Layouts</h3>
            </li> -->


            <!-- <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class=" icon-wrench"></i>
                    <span class="title">{{ Lang::get('admin/sidebar.rule') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="#" class="nav-link ">
                            <span class="title">{{ Lang::get('admin/sidebar.worktime_rule') }}</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="#" class="nav-link ">
                            <span class="title">{{ Lang::get('admin/sidebar.dayoff_rule') }}</span>
                        </a>
                    </li>
                </ul>
            </li> -->
            <!-- <li class="heading">
                <h3 class="uppercase">Pages</h3>
            </li> -->

            <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'upload-file' )? 'active open':'' }} ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-docs"></i>
                    <span class="title">{{ Lang::get('admin/sidebar.document_management') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="#" class="nav-link ">
                            <i class="icon-book-open"></i>
                            <span class="title">{{ Lang::get('admin/sidebar.rule') }}</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="#" class="nav-link ">
                            <i class="icon-docs"></i>
                            <span class="title">{{ Lang::get('admin/sidebar.document') }}</span>
                        </a>
                    </li>
                    <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'upload-file' )? 'active open':'' }} ">
                        <a href="{{ URL::Route('adm-upload-file') }}" class="nav-link ">
                            <i class="icon-cloud-upload"></i>
                            <span class="title">{{ Lang::get('admin/sidebar.upload_file') }}</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'register_employee' )? 'active open':'' }}
                                {{ str_contains( $_SERVER['REQUEST_URI'], 'working-employee' )? 'active open':'' }}
                                {{ str_contains( $_SERVER['REQUEST_URI'], 'resigned-employee' )? 'active open':'' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-user"></i>
                    <span class="title">{{ Lang::get('admin/sidebar.employee_management') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'register_employee' )? 'active open':'' }} ">
                        <a href="{{ URL::Route('adm-register_employee') }}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">{{ Lang::get('admin/sidebar.register_employee') }}</span>
                        </a>
                    </li>
                    <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'working-employee' )? 'active open':'' }} ">
                        <a href="{{ URL::Route('adm-working_employee') }}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">{{ Lang::get('admin/sidebar.working_employee') }}</span>
                        </a>
                    </li>
                    <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'resigned-employee' )? 'active open':'' }}  ">
                        <a href="{{ URL::Route('adm-resigned_employee') }}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">{{ Lang::get('admin/sidebar.worked_employee') }}</span>
                        </a>
                    </li>

                </ul>
            </li>
            <!-- <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-social-dribbble"></i>
                    <span class="title">{{ Lang::get('admin/sidebar.device_management') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ URL::Route('adm-device') }}" class="nav-link ">
                            <i class="icon-info"></i>
                            <span class="title">{{ Lang::get('admin/sidebar.all_device') }}</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="#" class="nav-link ">
                            <i class="icon-info"></i>
                            <span class="title">{{ Lang::get('admin/sidebar.unused_device') }}</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="#" class="nav-link ">
                            <i class="icon-call-end"></i>
                            <span class="title">{{ Lang::get('admin/sidebar.used_device') }}</span>
                        </a>
                    </li>

                </ul>
            </li> -->
            <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'summary' )? 'active open':'' }}
                                {{ str_contains( $_SERVER['REQUEST_URI'], 'timesheet' )? 'active open':'' }}
                                {{ str_contains( $_SERVER['REQUEST_URI'], 'overtime' )? 'active open':'' }}
                                {{ str_contains( $_SERVER['REQUEST_URI'], 'leave_request' )? 'active open':'' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-social-dribbble"></i>
                    <span class="title">{{ Lang::get('admin/sidebar.time_sheet_management') }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'summary' )? 'active open':'' }} ">
                        <a href="{{ URL::Route('adm-summary') }}" class="nav-link ">
                            <span class="title">{{ Lang::get('admin/sidebar.summary') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'timesheet' )? 'active open':'' }} ">
                        <a href="{{ URL::Route('adm-timesheet') }}" class="nav-link ">
                            <span class="title">{{ Lang::get('admin/sidebar.worktime_sheet') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'overtime' )? 'active open':'' }} ">
                        <a href="{{ URL::Route('adm-overtime') }}" class="nav-link ">
                            <span class="title">{{ Lang::get('admin/sidebar.over_time_sheet') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <!-- <input type="text" value="{{ $_SERVER['REQUEST_URI'] }}">
                    <input type="text" value="{{ Route::getCurrentRoute()->getPath() }}"> -->
                    <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'leave_request' )? 'active open':'' }} ">
                        <a href="{{ URL::Route('adm-leave_request') }}" class="nav-link ">
                            <span class="title">{{ Lang::get('admin/sidebar.leave_absence_request') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ str_contains( $_SERVER['REQUEST_URI'], 'setting' )? 'active open':'' }}">
                <a href="{{ URL::Route('adm-setting') }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ Lang::get('admin/sidebar.setting') }}</span>
                    <span class="selected"></span>
                    <!-- <span class="arrow open"></span> -->
                </a>
            </li>

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
