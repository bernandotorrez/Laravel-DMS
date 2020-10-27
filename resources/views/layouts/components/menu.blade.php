<div class="topbar-nav header navbar" role="banner">
    <nav id="topbar">
        <ul class="navbar-nav theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="{{ url()->route('home.index') }}"">
                    <img src="assets/img/90x90.jpg" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="/home" class="nav-link"> CORK </a>
            </li>
        </ul>

        <ul class="list-unstyled menu-categories" id="topAccordion">

            <li class="menu single-menu {{ Request::is('home') ? 'active' : '' }}">
                <a href="{{ url()->route('home.index') }}">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Home</span>
                    </div>
                </a>
            </li>


            <li class="menu single-menu {{ Request::is('about') ? 'active' : '' }}">
                <a href="{{ url()->route('about.index') }}">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-info">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <span>About</span>
                    </div>
                </a>
            </li>

            <li class="menu single-menu">
                <a href="#starter-kit" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle autodroprown">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-plus-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        <span>Master Data</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-chevron-down">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>
                <ul class="collapse submenu list-unstyled" id="starter-kit" data-parent="#topAccordion">
                    <li class="{{ Request::is('car-model') ? 'active' : '' }}">
                        <a href="{{ url()->route('car-model.index') }}"> Car Model </a>
                    </li>
                    <li>
                        <a href="starter_kit_breadcrumb.html"> Car Type </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>