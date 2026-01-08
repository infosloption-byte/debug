<!-- SIDEBAR --> 
<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            <a href="{{url('profile/index')}}">

            @if(Auth::user()->image)
                <img src="{{url('storage/')}}/{{Auth::user()->image}}" class="rounded-circle user-photo" 
                alt="User Profile Picture">
            @else
                <div class="no-image social_icon linkedin float-left" style="margin-right: 10px">
                    <span>
                        {{(strtoupper(substr(Auth::user()->employee->first_name,0,1)))}}{{(strtoupper(substr(Auth::user()->employee->last_name,0,1)))}}
                    </span>
                </div>
            @endif

            </a>
            <div class="dropdown" style="margin-top: 2px">
                <a href="{{url('profile/index')}}" class="user-name">
                    @if(Auth::user())
                        <strong>Hello! {{Auth::user()->employee->first_name}}</strong>
                    @else
                        -
                    @endif
                </a>  
                <span><small style="font-size: 11px">{{Auth::user()->employee->department->name}}</small></span>
            </div>
            <hr>
            
        </div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            @if(\Entrust::ability('admin','dashboard'))
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#hr_menu">Main</a>
            </li>
            @endif

            @if(\Entrust::ability('admin','user.roles,employee,departments,permisson.manage,location,location.type'))
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#project_menu">
                    <i class="fa fa-cogs"></i>
                </a>
            </li>
            @endif
        </ul>
            
        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane animated fadeIn @show('admin.dashboard.*') @show('brand.manage.*') @show('category.manage.*') @show('asset.manage.*') @show('inquiry.manage.*') @show('job.manage.*') @show('material.manage.*') @show('service.manage.*') @show('workrequest.manage.*') @show('dealer.manage.*') @show('service-center.manage.*') @show('technician.manage.*') @show('customer.manage.*') @show('warranty.manage.*') @show('profile.manage.*') @show('warpath.manage.*') @show('location.*') @show('meta.*')" id="hr_menu">
                <nav class="sidebar-nav">
                    <ul class="main-menu metismenu">

                        @if(\Entrust::can('dashboard'))
                        <li class="@active('admin.dashboard.*')">
                            <a href="{{url('/dashboard')}}">
                                <i class="icn-search-delivery-service-tool"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('location'))
                        <li class="@active('location.*')">
                            <a href="{{url('location/list')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Location Manager</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('warranty'))
                        <li class="@active('warranty.*')">
                            <a href="{{url('warranty/index')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Warranty Manager</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('asset'))
                        <li class="@active('asset.*')">
                            <a href="{{url('asset/index')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Asset Manager</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('service-center'))
                        <li class="@active('service-center.*')">
                            <a href="{{url('service-center/index')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Service Center Manager</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('technician'))
                        <li class="@active('technician.*')">
                            <a href="{{url('technician/index')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Technician Manager</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('dealer'))
                        <li class="@active('dealer.*')">
                            <a href="{{url('dealer/index')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Dealer Manager</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('customer'))
                        <li class="@active('customer.*')">
                            <a href="{{url('customer/index')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Customer Manager</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('inquiry'))
                        <li class="@active('inquiry.*')">
                            <a href="{{url('inquiry/index')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Inquiry Manager</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('workrequest'))
                        <li class="@active('workrequest.*')">
                            <a href="{{url('workrequest/index')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Work Request</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('job'))
                        <li class="@active('job.*')">
                            <a href="{{url('job/index')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Job Manager</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('material'))
                        <li class="@active('material.*')">
                            <a href="{{url('material/index')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Material Manager</span>
                            </a>
                        </li>
                        @endif

                        @if(\Entrust::can('service'))
                        <li class="@active('service.*')">
                            <a href="{{url('service/index')}}">
                                <i class="icn-international-delivery"></i>
                                <span>Service Manager</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>

            <div class="tab-pane animated fadeIn @show('user.role.*') @show('employee.*') @show('department.*') @show('hierarchy.*') @show('perm.manage.*')" id="project_menu">
                <nav class="sidebar-nav">
                    <ul class="main-menu metismenu">

                        @if(\Entrust::can('user.roles'))
                        <li class="@active('user.role.*')">
                            <a href="#Clients" class="has-arrow"><i class="icon-lock"></i><span>User Roles</span></a>
                            <ul>
                                <li><a href="{{url('user/role/list')}}">User Roles List</a></li>
                            </ul>
                        </li>
                        @endif

                        @if(\Entrust::can('permisson.manage'))
                        <li class="@active('perm.manage.*')">
                            <a href="#Clients" class="has-arrow"><i class="icon-lock"></i><span>Permmisson</span></a>
                            <ul>
                                <li><a href="{{url('permisson/list')}}">Permmisson List</a></li>
                            </ul>
                        </li>
                        @endif

                        @if(\Entrust::can('departments'))
                        <li class="@active('department.*')">
                            <a href="#Clients" class="has-arrow"><i class="icon-puzzle"></i><span>Departments</span></a>
                            <ul>
                                <li class="@active('department.list')"><a href="{{url('department/list')}}">Department List</a></li>
                            </ul>
                        </li>  
                        @endif

                        @if(\Entrust::can('hierarchy'))
                        <li class="@active('hierarchy.*')">
                            <a href="#Clients" class="has-arrow"><i class="icon-puzzle"></i><span>Employee Hierarchy</span></a>
                            <ul>
                                <li class="@active('hierarchy.list')"><a href="{{url('hierarchy/list')}}">Hierarchy List</a></li>
                            </ul>
                        </li>  
                        @endif

                        @if(\Entrust::can('employee'))
                        <li class="@active('employee.*')">
                            <a href="#Clients" class="has-arrow"><i class="icon-users"></i><span>Employee</span></a>
                            <ul>
                                <li class="@active('employee.list')"><a href="{{url('employee/list')}}">Employee List</a></li>
                            </ul>
                        </li>
                        @endif

                    </ul>                        
                </nav>                    
            </div>

        </div>          
    </div>
</div>
<!-- SIDEBAR