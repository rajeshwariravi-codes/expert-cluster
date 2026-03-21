<?php
session_start();
$U_Name = $_SESSION["U_Name"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>User Dashboard </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="Images/Logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;600&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      list-style: none;
      text-decoration: none;
    }

    body {
      font-family: 'Josefin Sans', sans-serif;
      background-image: url(Images/Home\ Dashboard.jpeg);
      background-repeat: no-repeat;
      background-size: cover;
      background-attachment: fixed;
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 260px;
      height: 100%;
      background: linear-gradient(to bottom, rgba(7, 194, 246, 0.98), rgba(8, 176, 198, 0.78), rgba(11, 137, 172, 0.7));
      padding: 20px;
      overflow-y: auto;
      transition: transform 0.4s ease;
      z-index: 1000;
    }

    .sidebar h2,
    .sidebar span {
      color: #fff;
      text-align: center;
      margin-bottom: 20px;
    }

    .sidebar ul li {
      padding: 12px 20px;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }

    .sidebar ul li:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: translateX(5px);
      border-radius: 5px;
    }

    .sidebar ul li a {
      color: #fff;
    }

    .sidebar ul .dropdown-btn::after {
      content: '\f107';
      font-family: "Font Awesome 5 Free";
      float: right;
      transition: transform 0.3s;
    }

    .sidebar ul .dropdown-btn.active::after {
      transform: rotate(180deg);
    }

    .dropdown-container {
      display: none;
      padding-left: 20px;
      animation: fadeIn 0.3s ease-in-out;
    }

    .dropdown-container a {
      color: #fff;
      display: block;
      padding: 6px 0;
      font-size: 14px;
      transition: transform 0.2s;
    }

    .dropdown-container a:hover {
      text-decoration: underline;
      transform: translateX(5px);
    }

    .main-content {
      margin-left: 260px;
      padding: 40px 20px;
      flex-grow: 1;
      transition: margin-left 0.3s ease;
    }

    .hamburger {
      display: none;
      position: fixed;
      top: 15px;
      left: 15px;
      font-size: 24px;
      cursor: pointer;
      color: #333;
      z-index: 1100;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-5px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      .hamburger {
        display: block;
      }

      .sidebar {
        transform: translateX(-100%);
        position: fixed;
        height: 100%;
        width: 240px;
      }

      .sidebar.active {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
        padding: 80px 15px 20px;
      }
    }

    .sidebar ul li:hover+.dropdown-container,
    .dropdown-container:hover {
      display: block !important;
    }

    .dropdown-container {
      display: none;
    }

    .sidebar ul li:hover~.dropdown-container:not(:hover) {
      display: none;
    }
  </style>
</head>

<body>

  <div class="hamburger" id="hamburger">
    <i class="fas fa-bars"></i>
  </div>

  <div class="sidebar" id="sidebar">
    <div style="text-align: center; margin-bottom: 25px;">
      <?php
      $server = "localhost";
      $user = "root";
      $pass = "";
      $db = "PC_Grid";
      $con = mysqli_connect($server, $user, $pass, $db);

      if ($con) {
        $q = "SELECT * FROM User_Reg WHERE Name = '$U_Name';";
        $sql = mysqli_query($con, $q);
        if ($sql) {
          while ($ro = mysqli_fetch_row($sql)) {
            echo "
            <img src='Offcial_Profiles/$ro[12]' alt='Logo' style='width: 45px; height: 45px; border-radius: 50%; border: 2px solid white;''>
            <br><span style='font-size: 22px; font-weight: bold;'> Welcome <br> $ro[1]</span>
            </div>
            ";
          }
        }
      }
      ?>

      <ul>

        <li><a href="User_Profile.php" style="color:white;"><i class="	far fa-user"></i> Profile</a></li>
        <li><a href="Search_Worker.php" style="color:white;"><i class="fa fa-search"></i> Search</a></li>
        <li><a href="Posted_Jobs.php" style="color:white;"><i class="fas fa-briefcase"></i> My Jobs</a></li>

        <li>
          <div class="dropdown-btn"><i class="fas fa-comments"></i> Feedback</div>
          <div class="dropdown-container">
            <a href="User_Feedback.php" style="color:white;">Worker Feedback</a>
            <a href="C_User_Feedback.php" style="color:white;">Website Feedback</a>
          </div>
        </li>


        <li class="dropdown-btn"><i class="fas fa-envelope"></i> Messages</li>
        <div class="dropdown-container">
          <a href="M_User-Admin.php">Admin</a>
          <a href="M_User-Worker.php">Worker</a>
        </div>
        <li class="dropdown-btn"><i class="fas fa-exclamation-circle"></i> Report</li>
        <div class="dropdown-container">
          <a href="User_Report.php" style="color:white;">Worker Report</a>
          <a href="C_User_Report.php" style="color:white;">Website Report</a>
          <a href="C_User_Response.php" style="color:white;">Website Response</a>
        </div>
        <li><a href="Home_Page.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </div>


    <div class="main-content" id="main-content">



    </div>

    <script>
      const hamburger = document.getElementById('hamburger');
      const sidebar = document.getElementById('sidebar');
      const dropdownBtns = document.querySelectorAll('.dropdown-btn');

      hamburger.addEventListener('click', () => {
        sidebar.classList.toggle('active');
      });

      dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          this.classList.toggle('active');
          const dropdown = this.nextElementSibling;
          dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
      });
    </script>

</body>

</html>