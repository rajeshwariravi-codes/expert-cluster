<?php
include './Database.php';
session_start();
$Expert_ID = $_SESSION['Expert_ID'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expert Cluster | Expert Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="./Expert_Cluster_Images/Expert Cluster.jpg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./Dashboard.css">

    <style>
        body {
            background-image:
                url("Expert_Cluster_Images/Expert_Cluster_Image_8.jpg");
        }
    </style>
</head>

<body>

    <?php
    if ($Connection) {
        $Select_Query = "SELECT * FROM `Expert` WHERE Expert_ID = ?";
        $Select_Query_SQL = $Connection->prepare($Select_Query);
        $Select_Query_SQL->bind_param("s", $Expert_ID);
        $Select_Query_SQL->execute();
        $Result = $Select_Query_SQL->get_result();
        if ($Row = $Result->fetch_assoc()) {
            $Expert_Name = $Row['First_Name'] . " " . $Row['Last_Name'];
        }
    }
    ?>

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
                    <h3 class="">Hi!</h3>
                    <h1 class=""><?= $Expert_Name ?></h1>
                </div>
                <li class="nav-item" style="list-style: none; margin-left: 30px;">
                    <a href="./Expert_Dashboard.php" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <ul class="nav-menu" id="sidebarAccordion">

                    <div class="menu-title">Profile</div>

                    <li class="nav-item">
                        <a href="./E_Profile.php" class="nav-link">
                            <i class="fa-solid fa-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>

                    <div class="menu-title">Stream Records</div>

                    <li class="nav-item">
                        <a href="./E_Streams_Records.php" class="nav-link">
                            <i class="fa-solid fa-database"></i>
                            <span>Streams Records</span>
                        </a>
                    </li>

                    <div class="menu-title">Q&A Record</div>

                    <li class="nav-item">
                        <a href="./E_Query_&_Answer_Control.php" class="nav-link">
                            <i class="fa-solid fa-clipboard-question"></i>
                            <span>Q&A Record</span>
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