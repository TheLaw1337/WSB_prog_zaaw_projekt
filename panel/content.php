<body onload="active()">
        <div id='app'>
            <div class='container-fluid'>
                <div class="row">
                    <!-- sidebar -->
                    <nav class="navbar shadow" id='sidebar'>
                        <div style="height:100%;">
                            <ul class="nav flex-column" id='menu' style='font-size: 0.9rem;'>
                                <a href="admin.php">
                                    <li class="mx-auto p-2 text-white" id='logo'>
                                        <!-- <img src="{{ asset('img/logo.svg') }}"/> -->
                                    </li>
                                </a>
                                <hr class='dropdown-divider' style='color:white' id='line'/>
                                <li class="nav-item">
                                    <a class="nav-link text-white" id='sales' href="events.php">
                                        <img src='../img/calendar-icon.svg'/>
                                        Eventy
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <!-- koniec sidebaru -->
                    <!-- topbar -->
                    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" id='topbar'>
                        <div class="container">
                            <a class="navbar-brand" href="admin.php">
                                Panel administracyjny
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse navbarSupportedContent">
                                <!-- lewa strona navbaru -->
                                <ul class="navbar-nav mr-auto">

                                </ul>
                                <!-- prawa strona navbaru -->
                                <ul class="navbar-nav ml-auto">
                                    <!-- hamburger button -->
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <?php echo $_SESSION['username']; ?> <span class="caret"></span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="reset-password.php">Zmień hasło</a>
                                            <a class="dropdown-item" href="logout.php">Wyloguj się</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <!-- koniec topbaru -->
                    <script>
                        window.addEventListener('resize', changeContentWidth);

                        function active()
                        {
                            var route = "{{Route::getCurrentRoute()->getName()}}";
                            if(route.includes('sales'))
                                route = 'sales';
                            else if(route.includes('costs'))
                                route = 'costs';
                            else if(route.includes('gas'))
                                route = 'gas';

                            var item = document.getElementById(route);
                            if(item)
                                item.style.textDecoration = "underline";
                            changeContentWidth();
                        }

                        function changeContentWidth()
                        {
                            var windowWidth = window.innerWidth;
                            var sidebarWidth = document.getElementById('sidebar').offsetWidth;
                            
                            document.getElementById('content').style.marginLeft = sidebarWidth+'px';
                            document.getElementById('content').style.width = (windowWidth - sidebarWidth)+'px';
                            topbar.style.left = sidebarWidth+'px';
                            topbar.style.width = (windowWidth - sidebarWidth)+'px';
                            sidebar.style.height = window.height;
                        }
                    </script>
                    <!-- content -->
                    <div class='' id='content'>
                        <main class='py-4'>
                            <div class="container">