<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Popsi'<span>s</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link">
                    <i class="link-icon" data-feather="grid"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/dish" class="nav-link">
                    <i class="link-icon fa-solid fa-bowl-food"></i>
                    <span class="link-title">Dish</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/booking" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Booking</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/food_order" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Food Order</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Reports</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="emails">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/email/inbox.html" class="nav-link">Billing Report</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Booking Report</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/compose.html" class="nav-link">Food Order Report</a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false"
                    aria-controls="uiComponents">
                    <i class="link-icon" data-feather="feather"></i>
                    <span class="link-title">UI Kit</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="uiComponents">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/ui-components/accordion.html" class="nav-link">Accordion</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/alerts.html" class="nav-link">Alerts</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/badges.html" class="nav-link">Badges</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/breadcrumbs.html" class="nav-link">Breadcrumbs</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/buttons.html" class="nav-link">Buttons</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/button-group.html" class="nav-link">Button group</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/cards.html" class="nav-link">Cards</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/carousel.html" class="nav-link">Carousel</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/collapse.html" class="nav-link">Collapse</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/dropdowns.html" class="nav-link">Dropdowns</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/list-group.html" class="nav-link">List group</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/media-object.html" class="nav-link">Media object</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/modal.html" class="nav-link">Modal</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/navs.html" class="nav-link">Navs</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/navbar.html" class="nav-link">Navbar</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/pagination.html" class="nav-link">Pagination</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/popover.html" class="nav-link">Popovers</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/progress.html" class="nav-link">Progress</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/scrollbar.html" class="nav-link">Scrollbar</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/scrollspy.html" class="nav-link">Scrollspy</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/spinners.html" class="nav-link">Spinners</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/tabs.html" class="nav-link">Tabs</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/ui-components/tooltips.html" class="nav-link">Tooltips</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button"
                    aria-expanded="false" aria-controls="advancedUI">
                    <i class="link-icon" data-feather="anchor"></i>
                    <span class="link-title">Advanced UI</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="advancedUI">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/advanced-ui/cropper.html" class="nav-link">Cropper</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Owl carousel</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/advanced-ui/sortablejs.html" class="nav-link">SortableJs</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/advanced-ui/sweet-alert.html" class="nav-link">Sweet Alert</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#forms" role="button" aria-expanded="false"
                    aria-controls="forms">
                    <i class="link-icon" data-feather="inbox"></i>
                    <span class="link-title">Forms</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="forms">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/forms/basic-elements.html" class="nav-link">Basic Elements</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/forms/advanced-elements.html" class="nav-link">Advanced Elements</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/forms/editors.html" class="nav-link">Editors</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/forms/wizard.html" class="nav-link">Wizard</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#charts" role="button" aria-expanded="false"
                    aria-controls="charts">
                    <i class="link-icon" data-feather="pie-chart"></i>
                    <span class="link-title">Charts</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="charts">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/charts/apex.html" class="nav-link">Apex</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/charts/chartjs.html" class="nav-link">ChartJs</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/charts/flot.html" class="nav-link">Flot</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/charts/morrisjs.html" class="nav-link">Morris</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/charts/peity.html" class="nav-link">Peity</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/charts/sparkline.html" class="nav-link">Sparkline</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#tables" role="button" aria-expanded="false"
                    aria-controls="tables">
                    <i class="link-icon" data-feather="layout"></i>
                    <span class="link-title">Table</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="tables">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/tables/basic-table.html" class="nav-link">Basic Tables</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/tables/data-table.html" class="nav-link">Data Table</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#icons" role="button" aria-expanded="false"
                    aria-controls="icons">
                    <i class="link-icon" data-feather="smile"></i>
                    <span class="link-title">Icons</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="icons">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/icons/feather-icons.html" class="nav-link">Feather Icons</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/icons/flag-icons.html" class="nav-link">Flag Icons</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/icons/mdi-icons.html" class="nav-link">Mdi Icons</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            <li class="nav-item nav-category">System</li>
            <li class="nav-item">
                <a href="/employee" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Employee List</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/position" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Position List</span>
                </a>
            </li>




            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" role="button"
                    aria-expanded="false" aria-controls="general-pages">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Customers</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="general-pages">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="/list" class="nav-link">

                                Customers List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/customer-account" class="nav-link">Customers Account</a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#authPages" role="button"
                    aria-expanded="false" aria-controls="authPages">
                    <i class="link-icon" data-feather="unlock"></i>
                    <span class="link-title">Authentication</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="authPages">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/auth/login.html" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/auth/register.html" class="nav-link">Register</a>
                        </li>
                    </ul>
                </div>
            </li> --}}


            <li class="nav-item nav-category">Authentication</li>
            <li class="nav-item">
                <a href="/user" class="nav-link">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">User List</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#errorPages" role="button"
                    aria-expanded="false" aria-controls="errorPages">
                    <i class="mdi mdi-account-multiple-outline"></i>
                    <i class="link-icon" data-feather="user-check"></i>
                    <span class="link-title">Roles & Permission</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="errorPages">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="permission" class="nav-link">All Permission</a>
                        </li>
                        <li class="nav-item">
                            <a href="role" class="nav-link">All Roles</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
