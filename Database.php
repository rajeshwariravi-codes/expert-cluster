    <?php
    // Database Connection

    $Server_Name        = "localhost";
    $User_Name          = "root";
    $Password           = "";
    $Database_Name      = "Expert_Cluster";

    $Connection         = new mysqli($Server_Name, $User_Name, $Password, $Database_Name);

    // Connection Check

    if ($Connection->connect_error) {
        die("Database Connection Failed : " . $Connection->connect_error);
    }

    ?>