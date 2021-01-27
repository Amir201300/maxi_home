<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    <div class="user-profile dropdown m-t-20">
                        <div class="user-pic">

                            <img src="{{getAdminImage()}}" alt="users" class="rounded-circle img-fluid"/>

                        </div>
                        <div class="user-content hide-menu m-t-10">
                            <h5 class="nameOfUser m-b-10 user-name font-medium">{{ Auth::guard('Admin')->user()->name }}</h5>
                            <a href="javascript:void(0)" class="btn btn-circle btn-sm m-r-5" id="Userdd" role="button"
                               data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="ti-settings"></i>
                            </a>
                            <a href="javascript:void(0)" title="Logout" class="btn btn-circle btn-sm">
                                <i class="ti-power-off"></i>
                            </a>
                            <div class="dropdown-menu animated flipInY" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="{{route('profile.index')}}">
                                    <a class="dropdown-item" href="{{route('user.logout')}}">
                                        <i class="fa fa-power-off m-r-5 m-l-5"></i> تسجيل الخروج</a>
                            </div>
                        </div>
                    </div>
                    <!-- End User Profile-->
                </li>
                <!-- main routes section-->
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">الاعدادات الرئيسية</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('admin.dashboard')}}"
                       aria-expanded="false">
                        <i class="fa fa-home"></i>
                        <span class="hide-menu">الصفحة الرئيسية</span>
                    </a>
                </li>


                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                       aria-expanded="false">
                        <i class="icon-Add-UserStar"></i>
                        <span class="hide-menu"> انواع المستخدمين </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('AdminType.index')}}"
                               aria-expanded="false">
                                <i class="icon-Administrator"></i>
                                <span class="hide-menu">انواع الموظفين</span>
                            </a>
                        </li>


                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark"
                               href="{{route('StatusTypes.index',['type'=>1])}}" aria-expanded="false">
                                <i class="icon-Add-UserStar"></i>
                                <span class="hide-menu">انواع العملاء</span>
                            </a>
                        </li>


                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark"
                               href="{{route('StatusTypes.index',['type'=>2])}}" aria-expanded="false">
                                <i class="icon-Add-User"></i>
                                <span class="hide-menu">انواع الموردون</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                       aria-expanded="false">
                        <i class="icon-Clothing-Store"></i>
                        <span class="hide-menu"> الفروع والاقسام واليومية </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('Store.index')}}"
                               aria-expanded="false">
                                <i class="icon-Clothing-Store"></i>
                                <span class="hide-menu">الفروع</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('Category.index')}}"
                               aria-expanded="false">
                                <i class="icon-Bulleted-List"></i>
                                <span class="hide-menu">الاقسام الخاصة بالمنتجات</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('PaymentType.index')}}"
                               aria-expanded="false">
                                <i class="icon-Money-2"></i>
                                <span class="hide-menu">بنود الدفع الخاصة باليومية</span>
                            </a>
                        </li>

                    </ul>
                </li>


                <!--end main routes section-->

                <!-- seconds routes section-->
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">المستخدمين والمنتجات</span>
                </li>
                <!-- users routes section-->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                       aria-expanded="false">
                        <i class="icon-Checked-User"></i>
                        <span class="hide-menu"> مستخدمي التطبيق </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('User.index')}}"
                               aria-expanded="false">
                                <i class="icon-Add-User"></i>
                                <span class="hide-menu">العملاء</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('Supplier.index')}}"
                               aria-expanded="false">
                                <i class="icon-Checked-User"></i>
                                <span class="hide-menu">الموردون</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link  waves-effect waves-dark" href="{{route('Admin.index')}}"
                               aria-expanded="false">
                                <i class="icon-User"></i>
                                <span class="hide-menu">الموظفين</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end users routes section-->

                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('Product.index')}}"
                       aria-expanded="false">
                        <i class="icon-Shopping-Bag"></i>
                        <span class="hide-menu">المنتجات</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('MoneyDaily.index')}}"
                       aria-expanded="false">
                        <i class="icon-Money-2"></i>
                        <span class="hide-menu">اليومية</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link  waves-effect waves-dark" href="{{route('InvoiceSale.index')}}"
                       aria-expanded="false">
                        <i class="icon-Memory-Card3"></i>
                        <span class="hide-menu">فواتير البيع</span>
                    </a>
                </li>
                <!--end seconds routes section-->

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
