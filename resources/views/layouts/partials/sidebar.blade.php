<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="{{ url('admin/dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            
                            <a class="nav-link" href="{{ route('folders.index') }}">
                                <div class="sb-nav-link-icon"><i class="fa fa-gears"></i></div>
                                Folders
                            </a>
                            <a class="nav-link" href="{{ route('files.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Files
                            </a>
                            <a class="nav-link" href="{{ route('files.shared') }}">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-file"></i></div>
                                Shared Files
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <div>{{ Auth::user()->name }}</div>
                    </div>
                </nav>