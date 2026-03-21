<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expert Cluster | Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="./Expert_Cluster_Images/Expert Cluster.jpg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Aboreto&family=Big+Shoulders+Stencil:opsz,wght@10..72,100..900&family=Cinzel:wght@400..900&family=Cormorant+Upright:wght@300;400;500;600;700&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Pacifico&family=Text+Me+One&family=Zilla+Slab+Highlight:wght@400;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
            --gray-color: #6c757d;
            --light-gray: #e9ecef;
            --border-radius: 8px;
            --box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }

        body {
            background-image:
                url("Expert_Cluster_Images/Expert_Cluster_Image_7.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            /* padding: 20px; */
            overflow: hidden;
        }

        body::-webkit-scrollbar {
            height: 0px;
            width: 0px;
            background: transparent;
        }

        .Container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #ffffffff;
            margin: 0px 8px;
        }

        /* Main Content Layout */
        .main-content {
            margin-left: 250px;
            height: 100vh;
            overflow: hidden;
        }


        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #9b1ecc 0%, #663cd0 100%);
            color: rgba(3, 36, 28, 0.9);
            padding: 1.5rem 1rem;
            box-shadow: var(--box-shadow);
            overflow-y: scroll;
            scrollbar-width: 0px;
            transition: var(--transition);
            z-index: 99;
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .header h1 {
            font-size: clamp(1.3rem, 2vw, 1.6rem);
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            font-family: "Aboreto";
        }

        .nav-menu {
            list-style: none;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.3rem 0rem;
            border-radius: none;
            text-decoration: none;
            transition: var(--transition);
            font-family: "Cormorant Upright";
            font-weight: bolder;
            font-size: clamp(1rem, 1.1vw, 1.1rem);
        }

        .nav-link:hover,
        .nav-link.active {
            color: white;
            font-size: clamp(1.1rem, 0.95vw, 0.95rem);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        .menu-title {
            font-family: "Josefin Sans";
            font-size: 0.6rem;
            font-weight: 350;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-left: -2rem;
        }

        /* .collapse .nav-link {
            font-size: 1rem;
            opacity: 0.9;
        }

        .collapse .nav-link:hover {
            opacity: 1;
            transform: translateX(4px);
        } */

        .nav-link[aria-expanded="true"] .fa-chevron-down {
            transform: rotate(180deg);
            transition: 0.3s ease;
        }

        /* Content Area */
        .content {
            height: 100%;
            overflow-y: auto;
            padding: 0rem 1.5rem;

            /* Firefox */
            scrollbar-width: none;

            /* IE / Edge (legacy) */
            -ms-overflow-style: none;
        }

        .content::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari */
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 90;
        }

        .overlay.active {
            opacity: 1;
            visibility: visible;
        }

        @media (max-width: 1024px) {

            .menu-toggle {
                display: block;
            }

            .sidebar {
                top: 0;
                left: -260px;
                height: 100vh;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                height: calc(100vh - 72px);
            }
        }


        @media screen and (max-width: 576px) {
            header {
                padding: 1rem;
            }

            .search-bar {
                display: none;
            }

            .content {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="Container">
        <!-- Header -->
        <div class="overlay" id="overlay"></div>
        <div class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </div>


        <!-- Main Content -->
        <div class="main-content">
            <!-- Sidebar -->
            <aside class="sidebar" id="sidebar">
                <div class="header">
                    <h1 class="text-center">Expert Cluster</h1>
                </div>
                <li class="nav-item" style="list-style: none; margin-left: 30px;">
                    <a href="./Admin_Dashboard.php" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <ul class="nav-menu" id="sidebarAccordion">

                    <div class="menu-title">Expert Management</div>
                    <li class="nav-item">
                        <a href="A_Expert_Register_Form.php" class="nav-link">
                            <i class="fa-solid fa-user-plus"></i>
                            <span>Expert Registration</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="A_Expert_Access_Control.php" class="nav-link">
                            <i class="fa-solid fa-user-shield"></i>
                            <span>Expert Control</span>
                        </a>
                    </li>

                    <div class="menu-title">Seeker Management</div>
                    <li class="nav-item">
                        <a href="./A_Seeker_Access_Control.php" class="nav-link">
                            <i class="fa-solid fa-user-check"></i>
                            <span>Seeker Control</span>
                        </a>
                    </li>

                    <div class="menu-title">Streams Management</div>
                    <li class="nav-item">
                        <a href="./A_Add_Streams.php" class="nav-link">
                            <i class="fa-solid fa-layer-group"></i>
                            <span>New Streams</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./A_Stream_Access_Control.php" class="nav-link">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Stream Control</span>
                        </a>
                    </li>

                    <div class="menu-title">Core Records</div>
                    <li class="nav-item">
                        <a href="./A_Core_Records.php" class="nav-link">
                            <i class="fa-solid fa-database"></i>
                            <span>Core Records</span>
                        </a>
                    </li>

                    <div class="menu-title">Queries And Answers</div>
                    <li class="nav-item">
                        <a href="./A_Queries_Records.php" class="nav-link">
                            <i class="fa-solid fa-database"></i>
                            <span>Query Records</span>
                        </a>
                    </li>

                    <!-- <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse"
                            href="#usersDropdown"
                            role="button"
                            aria-expanded="false"
                            aria-controls="usersDropdown">
                            <div>
                                <i class="fas fa-users"></i>
                                <span>Users</span>
                            </div>
                            <i class="fas fa-chevron-down small"></i>
                        </a>

                        <ul class="collapse nav-menu ps-4"
                            id="usersDropdown"
                            data-bs-parent="#sidebarAccordion">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Add User</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-edit"></i>
                                    <span>Manage Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-shield"></i>
                                    <span>User Roles</span>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse"
                            href="#Drop"
                            role="button"
                            aria-expanded="false"
                            aria-controls="Drop">
                            <div>
                                <i class="fas fa-users"></i>
                                <span>Users</span>
                            </div>
                            <i class="fas fa-chevron-down small"></i>
                        </a>

                        <ul class="collapse nav-menu ps-4"
                            id="Drop"
                            data-bs-parent="#sidebarAccordion">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Add User</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-edit"></i>
                                    <span>Manage Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-shield"></i>
                                    <span>User Roles</span>
                                </a>
                            </li>
                        </ul>
                    </li> -->

                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Analytics</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li> -->
                </ul>

                <ul class="nav-menu">
                    <div class="menu-title">Support</div>
                    <li class="nav-item">
                        <a href="./Sign_In.php" class="nav-link">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Log Out</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-question-circle"></i>
                            <span>Help Center</span>
                        </a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-envelope"></i>
                            <span>Contact</span>
                        </a>
                    </li> -->
                </ul>
            </aside>

            <!-- Content Area -->
            <main class="content">


                <script>
                    // Set current date
                    function setCurrentDate() {
                        const now = new Date();
                        const options = {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        const dateString = now.toLocaleDateString('en-US', options);
                        document.getElementById('currentDate').textContent = dateString;
                    }

                    // Mobile menu toggle
                    const menuToggle = document.getElementById('menuToggle');
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('overlay');

                    menuToggle.addEventListener('click', function() {
                        sidebar.classList.toggle('active');
                        overlay.classList.toggle('active');
                    });

                    overlay.addEventListener('click', function() {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    });

                    // Set active nav link
                    const navLinks = document.querySelectorAll('.nav-link');
                    navLinks.forEach(link => {
                        link.addEventListener('click', function(e) {
                            if (!this.classList.contains('active')) {
                                navLinks.forEach(item => item.classList.remove('active'));
                                this.classList.add('active');
                            }

                            // On mobile, close sidebar after clicking a link
                            if (window.innerWidth <= 768) {
                                sidebar.classList.remove('active');
                                overlay.classList.remove('active');
                            }
                        });
                    });

                    // Simulate live data updates
                    function updateStats() {
                        // In a real app, this would fetch data from an API
                        const revenueElement = document.querySelector('.revenue .stat-value');
                        const usersElement = document.querySelector('.users .stat-value');

                        // Generate random variations for demo purposes
                        const revenueChange = (Math.random() * 200 - 100).toFixed(0);
                        const usersChange = (Math.random() * 50 - 25).toFixed(0);

                        // Parse current values
                        let revenue = parseInt(revenueElement.textContent.replace('$', '').replace(',', ''));
                        let users = parseInt(usersElement.textContent.replace(',', ''));

                        // Apply changes
                        revenue += parseInt(revenueChange);
                        users += parseInt(usersChange);

                        // Update display
                        revenueElement.textContent = '$' + revenue.toLocaleString();
                        usersElement.textContent = users.toLocaleString();

                        // Update change indicators
                        const revenueChangeElement = document.querySelector('.revenue .stat-change');
                        const usersChangeElement = document.querySelector('.users .stat-change');

                        revenueChangeElement.innerHTML = `<i class="fas fa-arrow-${revenueChange >= 0 ? 'up' : 'down'}"></i>
                                            <span>${Math.abs(revenueChange)} from last update</span>`;
                        revenueChangeElement.className = `stat-change ${revenueChange >= 0 ? 'positive' : 'negative'}`;

                        usersChangeElement.innerHTML = `<i class="fas fa-arrow-${usersChange >= 0 ? 'up' : 'down'}"></i>
                                          <span>${Math.abs(usersChange)} from last update</span>`;
                        usersChangeElement.className = `stat-change ${usersChange >= 0 ? 'positive' : 'negative'}`;
                    }

                    // Initialize dashboard
                    document.addEventListener('DOMContentLoaded', function() {
                        setCurrentDate();

                        // Update stats every 10 seconds for demo purposes
                        setInterval(updateStats, 10000);

                        // Add some interactivity to stat cards
                        const statCards = document.querySelectorAll('.stat-card');
                        statCards.forEach(card => {
                            card.addEventListener('click', function() {
                                alert(`You clicked on ${this.querySelector('.stat-title').textContent}`);
                            });
                        });
                    });
                </script>
</body>

</html>