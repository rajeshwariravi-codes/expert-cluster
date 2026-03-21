<?php
include './Database.php';
include './Admin_Dashboard.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if ($Connection) {

    $Limit = 6;

    if (!isset($_SESSION['Limit']) || $_SESSION['Limit'] != $Limit) {
        $_SESSION['Limit'] = $Limit;
        $_SESSION['ASC_Current_Page'] = 1;
    }

    if (isset($_POST['Search'])) {
        $_SESSION['ASC_Current_Page'] = 1;
    }

    if (isset($_POST['Page'])) {
        $_SESSION['ASC_Current_Page'] = $_POST['Page'];
    } elseif (!isset($_SESSION['ASC_Current_Page'])) {
        $_SESSION['ASC_Current_Page'] = 1;
    }

    $Page = $_SESSION['ASC_Current_Page'];
    $Page = max(1, (int)$Page);
    $Start = ($Page - 1) * $Limit;

    // $Stream_Category = isset($_POST['Stream_Category']) ? htmlspecialchars($_POST['Stream_Category']) : '';
    $Stream_Category    = $_POST['Stream_Category'] ?? '';
    $Stream_Type        = $_POST['Stream_Type'] ?? '';
    $Stream             = $_POST['Stream'] ?? '';
    $Stream_Description = $_POST['Stream_Description'] ?? '';

    $Search = !empty($Stream_Category) || !empty($Stream_Type) || !empty($Stream) || !empty($Stream_Description);

    $Params = [];
    $D_Type = "";

    $Where = " WHERE (S.Access_Gate = ? OR S.Access_Gate = ?) ";
    $Params = ["Grant", "Re-Grant"];
    $D_Type = "ss";

    if ($Search || isset($_POST['Search'])) {
        if (!empty($Stream_Category)) {
            $Where .= " AND S.Stream_Category LIKE ? ";
            $Params[] = "%" . htmlspecialchars($Stream_Category) . "%";
            $D_Type .= "s";
        }

        if (!empty($Stream_Type)) {
            $Where .= " AND S.Stream_Type = ? ";
            $Params[] = $Stream_Type;
            $D_Type .= "s";
        }

        if (!empty($Stream)) {
            $Where .= " AND S.Stream LIKE ?";
            $Params[] = "%$Stream%";
            $D_Type .= "s";
        }

        if (!empty($Stream_Description)) {
            $Where .= " AND S.Stream_Description LIKE ? ";
            $Params[] = "%$Stream_Description%";
            $D_Type .= "s";
        }
    }

    $Order_Query = " ORDER BY S.Stream_Category ASC ";

    $Count_Query = "SELECT COUNT(DISTINCT S.Stream_ID) AS Total
                        FROM Streams S
                        LEFT JOIN Stream_Tags T ON S.Stream_ID = T.Stream_ID
                        $Where";
    $Count_Query_SQL = $Connection->prepare($Count_Query);
    $Count_Query_SQL->bind_param($D_Type, ...$Params);
    $Count_Query_SQL->execute();
    $Count_Result = $Count_Query_SQL->get_result();
    $Total_Records = $Count_Result->fetch_array()['Total'];
    $Total_Pages = ceil($Total_Records / $Limit);

    // Pagination
    $Start_Page = max(1, $Page - 2);
    $End_Page = min($Total_Pages, $Start_Page + 3);
    if ($End_Page - $Start_Page < 3) {
        $Start_Page = max(1, $End_Page - 3);
    }

    $Select_Query = "SELECT S.*, GROUP_CONCAT(CONCAT('#', T.Tag_Keywords) SEPARATOR ' ') AS Key_Words FROM Streams S LEFT JOIN Stream_Tags T ON S.Stream_ID = T.Stream_ID $Where GROUP BY S.Stream_ID ";

    $Full_Select_Query = $Select_Query . $Order_Query . "LIMIT ?, ?";
    $Select_Query_SQL = $Connection->prepare($Full_Select_Query);
    $Full_D_Type = $D_Type . "ii";
    $Full_Params = array_merge($Params, [$Start, $Limit]);
    $Select_Query_SQL->bind_param($Full_D_Type, ...$Full_Params);
    $Select_Query_SQL->execute();
    $Result = $Select_Query_SQL->get_result();

    function Sent_Expert_Mail($Expert_Name, $Expert_Mail, $Stream_ID, $Stream_Category, $Stream_Type, $Stream)
    {
        $Name = htmlentities($Expert_Name);
        $Email = htmlentities($Expert_Mail);
        $mailsubject = "Administrative Update: Stream Access Temporarily Restricted";
        $mailsender = "Expert Cluster";
        $message = '
            <html>
            <head>
                <style>
                    @import url("https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Josefin+Sans:wght@400;600&display=swap");

                    body {
                        font-family: "Josefin Sans", "Cinzel", sans-serif;
                        font-size: 15px;
                        color: #333;
                        background-color: #f4f6fb;
                        padding: 20px;
                        line-height: 1.7;
                    }

                    .container {
                        max-width: 600px;
                        margin: auto;
                        background-color: #ffffff;
                        padding: 30px;
                        border-radius: 12px;
                        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
                    }

                    .header {
                        font-family: "Cinzel", serif;
                        font-size: 23px;
                        font-weight: 700;
                        color: #f59e0b; /* amber = temporary restriction */
                        margin-bottom: 20px;
                        text-align: center;
                    }

                    p {
                        font-size: 16px;
                        margin-bottom: 15px;
                    }

                    .highlight-box {
                        background-color: #fffbeb;
                        border-left: 4px solid #f59e0b;
                        border-radius: 10px;
                        padding: 20px;
                        margin: 20px 0;
                    }

                    .label {
                        font-weight: 600;
                        color: #555;
                    }

                    .value {
                        font-size: 16px;
                        color: #111;
                        margin-bottom: 8px;
                    }

                    .note {
                        font-size: 15px;
                        color: #555;
                        margin-top: 10px;
                    }

                    .footer {
                        margin-top: 30px;
                        font-size: 14px;
                        color: #777;
                        text-align: center;
                    }

                    a {
                        color: #4f46e5;
                        text-decoration: none;
                    }
                </style>
            </head>

            <body>
                <div class="container">
                    <div class="header">Stream Access Temporarily Restricted</div>

                    <p>
                        Hello ' . htmlspecialchars($Expert_Name) . ',
                    </p>

                    <p>
                        This is to inform you that, following an administrative review, one of your registered streams on the
                        <strong>Expert Cluster</strong> platform has been placed under a <strong>temporary restriction</strong>.
                    </p>

                    <div class="highlight-box">
                        <div class="value">
                            <span class="label">Stream ID:</span><br>
                            <strong>' . htmlspecialchars($Stream_ID) . '</strong>
                        </div>

                        <div class="value">
                            <span class="label">Category:</span><br>
                            ' . htmlspecialchars($Stream_Category) . '
                        </div>

                        <div class="value">
                            <span class="label">Type:</span><br>
                            ' . htmlspecialchars($Stream_Type) . '
                        </div>

                        <div class="value">
                            <span class="label">Stream Name:</span><br>
                            <strong>' . htmlspecialchars($Stream) . '</strong>
                        </div>
                    </div>

                    <p class="note">
                        During this period, this specific stream will not be visible to learners, and new queries related to it
                        will be temporarily paused. Your expert account and other approved streams remain fully active.
                    </p>

                    <p class="note">
                        Once the review process is completed and the stream meets platform guidelines, access will be restored
                        automatically. No immediate action is required from your end unless further clarification is requested.
                    </p>

                    <p class="note">
                        We appreciate your continued collaboration in maintaining quality, accuracy, and trust across the
                        Expert Cluster ecosystem.
                    </p>

                    <div class="footer">
                        Regards,<br>
                        <strong>Expert Cluster Admin Team</strong><br>
                        <a href="mailto:expertcluster.moon@gmail.com">expertcluster.moon@gmail.com</a>
                    </div>
                </div>
            </body>
            </html>
        ';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'expertcluster.moon@gmail.com';
        $mail->Password = 'dckl jpqd kcbb jzky';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->setFrom('expertcluster.moon@gmail.com', $mailsender);
        $mail->addAddress($Email, $Name);
        $mail->Subject = $mailsubject;
        $mail->Body = $message;
        $mail->send();
    }

    function Sent_Seeker_Mail($Seeker_Name, $Seeker_Mail, $Stream_ID, $Stream_Category, $Stream_Type, $Stream)
    {
        $Name = htmlentities($Seeker_Name);
        $Email = htmlentities($Seeker_Mail);
        $mailsubject = "Administrative Update: Stream Access Temporarily Restricted";
        $mailsender = "Expert Cluster";
        $message = '
            <html>
            <head>
                <style>
                    @import url("https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Josefin+Sans:wght@400;600&display=swap");

                    body {
                        font-family: "Josefin Sans", "Cinzel", sans-serif;
                        font-size: 15px;
                        color: #333;
                        background-color: #f4f6fb;
                        padding: 20px;
                        line-height: 1.7;
                    }

                    .container {
                        max-width: 600px;
                        margin: auto;
                        background-color: #ffffff;
                        padding: 30px;
                        border-radius: 12px;
                        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
                    }

                    .header {
                        font-family: "Cinzel", serif;
                        font-size: 23px;
                        font-weight: 700;
                        color: #f59e0b; /* amber = temporary restriction */
                        margin-bottom: 20px;
                        text-align: center;
                    }

                    p {
                        font-size: 16px;
                        margin-bottom: 15px;
                    }

                    .highlight-box {
                        background-color: #fffbeb;
                        border-left: 4px solid #f59e0b;
                        border-radius: 10px;
                        padding: 20px;
                        margin: 20px 0;
                    }

                    .label {
                        font-weight: 600;
                        color: #555;
                    }

                    .value {
                        font-size: 16px;
                        color: #111;
                        margin-bottom: 8px;
                    }

                    .note {
                        font-size: 15px;
                        color: #555;
                        margin-top: 10px;
                    }

                    .footer {
                        margin-top: 30px;
                        font-size: 14px;
                        color: #777;
                        text-align: center;
                    }

                    a {
                        color: #4f46e5;
                        text-decoration: none;
                    }
                </style>
            </head>

            <body>
                <div class="container">
                    <div class="header">Stream Access Temporarily Restricted</div>

                    <p>
                        Hello ' . htmlspecialchars($Seeker_Name) . ',
                    </p>

                    <p>
                        This is to inform you that a stream you were following on the
                        <strong>Expert Cluster</strong> platform has been placed under a <strong>temporary restriction</strong>.
                    </p>

                    <div class="highlight-box">
                        <div class="value">
                            <span class="label">Stream ID:</span><br>
                            <strong>' . htmlspecialchars($Stream_ID) . '</strong>
                        </div>

                        <div class="value">
                            <span class="label">Category:</span><br>
                            ' . htmlspecialchars($Stream_Category) . '
                        </div>

                        <div class="value">
                            <span class="label">Type:</span><br>
                            ' . htmlspecialchars($Stream_Type) . '
                        </div>

                        <div class="value">
                            <span class="label">Stream Name:</span><br>
                            <strong>' . htmlspecialchars($Stream) . '</strong>
                        </div>
                    </div>

                    <p class="note">
                        During this period, you will not be able to raise new queries for this stream. Other streams and your account remain fully active.
                    </p>

                    <p class="note">
                        Once the review is completed and the stream meets platform guidelines, access will be restored automatically.
                    </p>

                    <p class="note">
                        Thank you for your patience and for being an active part of the Expert Cluster community.
                    </p>

                    <div class="footer">
                        Regards,<br>
                        <strong>Expert Cluster Admin Team</strong><br>
                        <a href="mailto:expertcluster.moon@gmail.com">expertcluster.moon@gmail.com</a>
                    </div>
                </div>
            </body>
            </html>
        ';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'expertcluster.moon@gmail.com';
        $mail->Password = 'dckl jpqd kcbb jzky';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->setFrom('expertcluster.moon@gmail.com', $mailsender);
        $mail->addAddress($Email, $Name);
        $mail->Subject = $mailsubject;
        $mail->Body = $message;
        $mail->send();
    }

    // Deny
    if (isset($_POST['Deny'])) {
        $Access_Grant = "Grant";
        $Access_Re_Grant = "Re-Grant";

        // Expert Info

        $Expert_Name = [];
        $Expert_Mail = [];
        $Select_Expert_Query = "SELECT `First_Name`, `Last_Name`, `E_Mail` FROM `Expert` WHERE (`Access_Gate` = ? OR `Access_Gate` = ?)";
        $Select_Expert_Query_SQL = $Connection->prepare($Select_Expert_Query);
        $Select_Expert_Query_SQL->bind_param("ss", $Access_Grant, $Access_Re_Grant);
        $Select_Expert_Query_SQL->execute();
        $Expert_Result = $Select_Expert_Query_SQL->get_result();
        $Expert_No = $Expert_Result->num_rows;
        while ($Row = $Expert_Result->fetch_assoc()) {
            $Expert_Name[] = $Row['First_Name'] . " " . $Row['Last_Name'];
            $Expert_Mail[] = $Row['E_Mail'];
        }

        // Seeker Info

        $Seeker_Name = [];
        $Seeker_Mail = [];
        $Select_Seeker_Query = "SELECT `First_Name`, `Last_Name`, `E_Mail` FROM `Seeker` WHERE (`Access_Gate` = ? OR `Access_Gate` = ?)";
        $Select_Seeker_Query_SQL = $Connection->prepare($Select_Seeker_Query);
        $Select_Seeker_Query_SQL->bind_param("ss", $Access_Grant, $Access_Re_Grant);
        $Select_Seeker_Query_SQL->execute();
        $Seeker_Result = $Select_Seeker_Query_SQL->get_result();
        $Seeker_No = $Seeker_Result->num_rows;
        while ($Row = $Seeker_Result->fetch_assoc()) {
            $Seeker_Name[] = $Row['First_Name'] . " " . $Row['Last_Name'];
            $Seeker_Mail[] = $Row['E_Mail'];
        }

        $Stream_ID = $_POST['Stream_ID'];
        $Stream_Category = $_POST['Stream_Category'];
        $Stream_Description = $_POST['Stream_Description'];
        $Stream_Type = $_POST['Stream_Type'];
        $Stream = $_POST['Stream'];
        $Gate = "Deny";
        $Update_Query = "UPDATE `Streams` SET `Access_Gate` = ? WHERE `Stream_ID` = ?";
        $Update_Query_SQL = $Connection->prepare($Update_Query);
        $Update_Query_SQL->bind_param("ss", $Gate, $Stream_ID);
        if ($Update_Query_SQL->execute()) {

            for ($i = 0; $i < $Expert_No; $i++) {
                Sent_Expert_Mail($Expert_Name[$i], $Expert_Mail[$i], $Stream_ID, $Stream_Category, $Stream_Type, $Stream);
            }
            for ($i = 0; $i < $Seeker_No; $i++) {
                Sent_Seeker_Mail($Seeker_Name[$i], $Seeker_Mail[$i], $Stream_ID, $Stream_Category, $Stream_Type, $Stream);
            }

            echo "
                <script>
                    alert('Stream access has been denied✨');
                    window.location.href = 'A_Stream_Access_Restrict.php';
                </script>
                ";
        }
    }
}
?>

<link rel="stylesheet" href="./A_Stream_Access_Panel.css">

<main class="content p-2">
    <div class="Wrapper">
        <div class="Nav-Bar container-fluid d-flex flex-wrap justify-content-center align-items-center gap-3 mb-4 p-3">
            <button onclick="window.location.href = 'A_Stream_Access_Control.php'" class="btn">Back</button>
            <button onclick="window.location.href = 'A_Stream_Access_Restrict.php'" class="btn active">Restrict</button>
            <button onclick="window.location.href = 'A_Stream_Access_Reactivate.php'" class="btn">Reactivate</button>
        </div>
        <div class="Header">
            <h1 class="text-center py-3">Streams</h1>
        </div>
        <div class="Search mb-3">
            <form action="" method="post" novalidate class="container py-3">
                <!-- <input type="hidden" name="Page" value="<?php echo $Page; ?>"> -->
                <div class="row d-flex justify-content-center">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="Stream_Category" class="form-label ms-2">Stream Category :</label>
                        <div class="form-group">
                            <select class="form-select" name="Stream_Category" id="Stream_Category" onchange="updateTypes()">
                                <option value="">--Select The Stream Category--</option>
                                <option value="Academic & Knowledge Streams" <?= ($Stream_Category === 'Academic & Knowledge Streams') ? "Selected" : "" ?>>Academic & Knowledge Streams</option>
                                <option value="Career & Professional Skills" <?= ($Stream_Category === 'Career & Professional Skills') ? "Selected" : "" ?>>Career & Professional Skills</option>
                                <option value="Lifestyle, Growth & Social Impact" <?= ($Stream_Category === 'Lifestyle, Growth & Social Impact') ? "Selected" : "" ?>>Lifestyle, Growth & Social Impact</option>
                                <option value="Technology & Creative Fields" <?= ($Stream_Category === 'Technology & Creative Fields') ? "Selected" : "" ?>>Technology & Creative Fields</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="Stream_Type" class="form-label ms-2">Stream Type :</label>
                        <div class="form-group">
                            <select class="form-select" name="Stream_Type" id="Stream_Type">
                                <option value="">--Select The Stream Type--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="Stream" class="form-label ms-2">Stream Name :</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="Stream" id="Stream" placeholder="Enter The Stream Name" value="<?= $Stream ?>" autocomplete="off">

                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="Stream_Description" class="form-label ms-2">Stream Description :</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="Stream_Description" id="Stream_Description" placeholder="Enter The Stream Description" value="<?= $Stream_Description ?>" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="row g-3 g-md-5 mb-2">
                    <div class="text-center">
                        <button class="btn m-2" name="Search" type="submit">Search</button>
                        <button class="btn m-2" name="Re-Set" type="button" onclick="Form_Reset()">Reset</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="Card-Wrapper row d-flex justify-content-center">
            <?php
            if ($Result->num_rows > 0) {
                $Serial_No = $Start + 1;
                while ($Row = $Result->fetch_assoc()) {
            ?>
                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                        <div class="card shadow-sm rounded-4 overflow-hidden">
                            <span class="img-serial"><?= $Serial_No ?></span>
                            <img class="img-fluid" src="./Expert_Cluster_Official_Images/Streams/<?= htmlspecialchars($Row['Stream_Image']) ?>" alt="<?= $Row['Stream_Image'] ?>" loading="lazy">
                            <div class="card-header mb-3">
                                <h3 class="card-title fw-semibold text-center"><?= $Row['Stream'] ?></h3>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="card-details">
                                    <p class=""><strong>Stream ID : </strong><?= $Row['Stream_ID'] ?></p>
                                    <p class=""><strong>Stream Category : </strong> <?= $Row['Stream_Category'] ?></p>
                                    <p class=""><strong>Stream Type : </strong> <?= $Row['Stream_Type'] ?></p>
                                </div>
                                <p class="card-text px-5 pt-3 pb-5"><?= $Row['Stream_Description'] ?></p>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <form action="" method="post">
                                    <input type="hidden" name="Stream_ID" id="Stream_ID" value="<?= $Row['Stream_ID'] ?>">
                                    <input type="hidden" name="Stream_Category" id="Stream_Category" value="<?= $Row['Stream_Category'] ?>">
                                    <input type="hidden" name="Stream_Description" id="Stream_Description" value="<?= $Row['Stream_Description'] ?>">
                                    <input type="hidden" name="Stream_Type" id="Stream_Type" value="<?= $Row['Stream_Type'] ?>">
                                    <input type="hidden" name="Stream" id="Stream" value="<?= $Row['Stream'] ?>">
                                    <?php
                                    echo "
                                            <button type='submit' class='btn fs-5' onclick='' name='Deny'>Deny</button>
                                        ";
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                    $Serial_No++;
                }
            }
            ?>
        </div>
    </div>

    <!-- Smart Pagination (Always show 4 pages) -->
    <?php if ($Total_Pages > 1): ?>
        <nav aria-label=" Page navigation">
            <ul class="pagination d-flex justify-content-center align-items-center">
                <!-- Previous Button -->
                <?php if ($Page > 1): ?>
                    <li class="page-item">
                        <form method="post" class="pagination-form">
                            <input type="hidden" name="Page" value="<?php echo $Page - 1; ?>">
                            <input type="hidden" name="Stream_Category" value="<?php echo $Stream_Category; ?>">
                            <input type="hidden" name="Stream_Type" value="<?php echo $Stream_Type; ?>">
                            <input type="hidden" name="Stream" value="<?php echo $Stream; ?>">
                            <input type="hidden" name="Stream_Description" value="<?php echo $Stream_Description; ?>">
                            <button type="submit" class="page-link">
                                <i class="fa fa-chevron-left"></i> Previous
                            </button>
                        </form>
                    </li>
                <?php endif; ?>

                <!-- Page Numbers (Always show 4 pages) -->
                <?php for ($i = $Start_Page; $i <= $End_Page; $i++): ?>
                    <li class="page-item <?php echo ($i == $Page) ? 'active' : ''; ?>">
                        <form method="post" class="pagination-form">
                            <input type="hidden" name="Page" value="<?php echo $i; ?>">
                            <input type="hidden" name="Stream_Category" value="<?php echo $Stream_Category; ?>">
                            <input type="hidden" name="Stream_Type" value="<?php echo $Stream_Type; ?>">
                            <input type="hidden" name="Stream" value="<?php echo $Stream; ?>">
                            <input type="hidden" name="Stream_Description" value="<?php echo $Stream_Description; ?>">
                            <button type="submit" class="page-link"><?php echo $i; ?></button>
                        </form>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <?php if ($Page < $Total_Pages): ?>
                    <li class="page-item">
                        <form method="post" class="pagination-form">
                            <input type="hidden" name="Page" value="<?php echo $Page + 1; ?>">
                            <input type="hidden" name="Stream_Category" value="<?php echo $Stream_Category; ?>">
                            <input type="hidden" name="Stream_Type" value="<?php echo $Stream_Type; ?>">
                            <input type="hidden" name="Stream" value="<?php echo $Stream; ?>">
                            <input type="hidden" name="Stream_Description" value="<?php echo $Stream_Description; ?>">
                            <button type="submit" class="page-link">
                                Next <i class="fa fa-chevron-right"></i>
                            </button>
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>

    <div class="Pagi-Caption text-center mt-3">
        <p>Showing <?php echo ($Start + 1); ?> to <?php echo min($Start + $Limit, $Total_Records); ?> of <?php echo $Total_Records; ?> entries</p>
    </div>

    <!-- Re-Set -->

    <script>
        function Form_Reset() {
            window.location.href = 'A_Streams.php';
        }
    </script>

    <!-- Stream Dropdown -->
    <script>
        // Define your types for each category
        const types = {
            "Academic & Knowledge Streams": ["Fundamental Natural Sciences", "STEM Academic Disciplines", "Humanities And Culture Studies", "Health And Medical Sciences", "Applied Technology Studies", "Engineering And Technology", "Arts And Literary Studies", "Law & Governance"],
            "Career & Professional Skills": ["Career Development Skills", "Professional Teaching Practices", "Financial Literacy Essentials", "Interpersonal Soft Skills", "Guidance and Counseling", "Strategic Business Practices", "Legal Systems And Policies"],
            "Lifestyle, Growth & Social Impact": ["Self Growth And Excellence", "Lifestyle Enrichment Skills", "Community And Social Impact", "Emergency Safety Preparedness", "Holistic Health & Wellness"],
            "Technology & Creative Fields": ["Modern Technological Systems", "Cyber Defense & Security", "Design And Interface Strategy", "Creative Visual Arts", "Digital Media Production", "Creative Visual Technology"]
        };

        const previouslySelectedType =
            "<?= htmlspecialchars_decode($_POST['Stream_Type'] ?? '') ?>";

        function updateTypes() {
            const Category_Select = document.getElementById("Stream_Category");
            const Type_Select = document.getElementById("Stream_Type");
            const Selected_Category = Category_Select.value;

            Type_Select.innerHTML = "<option value=''>Select Type</option>";

            if (Selected_Category && types[Selected_Category]) {
                types[Selected_Category].forEach(type => {
                    const option = document.createElement("option");
                    option.value = type;
                    option.text = type;

                    // 🔑 Memory injection
                    if (type === previouslySelectedType) {
                        option.selected = true;
                    }

                    Type_Select.appendChild(option);
                });
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            updateTypes();
        });
    </script>

    <!-- View Modal -->

    <div class="modal fade" id="viewMoreStreamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewMoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewMoreModalLabel">More Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Image Section -->
                    <div class="text-center mb-3">
                        <img id="modalStream_Img" src="" alt="Stream Image" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
                    </div>

                    <!-- Details Section -->
                    <div class="mb-2">
                        <h6><strong>Stream ID:</strong> <span id="modalID"></span></h6>
                        <h6><strong>Category:</strong> <span id="modalStream_Category"></span></h6>
                        <h6><strong>Type:</strong> <span id="modalStream_type"></span></h6>
                        <h6><strong>Stream:</strong> <span id="modalStream"></span></h6>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <h6><strong>Description:</strong></h6>
                        <p id="modalStream_Description"></p>
                    </div>

                    <!-- Tags -->
                    <div>
                        <h6><strong>Tags:</strong></h6>
                        <div id="modalStream_Tags" class="d-flex flex-wrap gap-2">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.querySelectorAll('.view-more-stream-btn').forEach(button => {
            button.addEventListener('click', function() {

                document.getElementById('modalID').textContent = this.getAttribute('data-ID');
                document.getElementById('modalStream_Category').textContent = this.getAttribute('data-Stream_Category');
                document.getElementById('modalStream_type').textContent = this.getAttribute('data-Stream_Type');
                document.getElementById('modalStream').textContent = this.getAttribute('data-Stream');
                document.getElementById('modalStream_Description').textContent = this.getAttribute('data-Stream_Description');
                document.getElementById('modalStream_Tags').textContent = this.getAttribute('data-Stream_Tags');

                const imgFile = this.getAttribute('data-Stream_Img'); // e.g., 'Fundamental_Natural_Sciences_Genetics.jpg'
                const imgPath = imgFile ? 'Expert_Cluster_Official_Images/Streams/' + imgFile : 'Expert_Cluster_Official_Images/Streams/placeholder.jpg';
                document.getElementById('modalStream_Img').src = imgPath;
            });
        });
    </script>
</main>
</div>
</div>