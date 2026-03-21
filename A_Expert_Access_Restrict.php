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
        $_SESSION['AA_Current_Page'] = 1;
    }

    if (isset($_POST['Search'])) {
        $_SESSION['AA_Current_Page'] = 1;
    }

    if (isset($_POST['Page'])) {
        $_SESSION['AA_Current_Page'] = $_POST['Page'];
    } elseif (!isset($_SESSION['AA_Current_Page'])) {
        $_SESSION['AA_Current_Page'] = 1;
    }

    $Page = $_SESSION['AA_Current_Page'];
    $Page = max(1, (int)$Page);
    $Start = ($Page - 1) * $Limit;

    $Min        = $_POST['Min'] ?? '';
    $Max        = $_POST['Max'] ?? '';
    $Stream     = $_POST['Stream'] ?? '';
    $Expertise  = $_POST['Expertise'] ?? '';

    $Search = !empty($Min) || !empty($Max) || !empty($Stream) || !empty($Expertise);

    $Params = [];
    $D_Type = "";

    $Where = " WHERE ( E.Access_Gate = ? OR E.Access_Gate = ? ) ";
    $Params = ["Grant", "Re-Grant"];
    $D_Type = "ss";

    if ($Search || isset($_POST['Search'])) {

        if (!empty($Min) && !empty($Max)) {
            $Where .= " AND E.Years_of_Experience BETWEEN ? AND ? ";
            $Params[] = $Min;
            $Params[] = $Max;
            $D_Type .= "ss";
        }

        if (!empty($Stream)) {
            $Where .= " AND S.Stream_Name LIKE ? ";
            $Params[] = "%" . $Stream . "%";
            $D_Type .= "s";
        }

        if (!empty($Expertise)) {
            $Where .= " AND E.Expert_In LIKE ? ";
            $Params[] = "%" . $Expertise . "%";
            $D_Type .= "s";
        }
    }

    $Order_Query = " ORDER BY date(E.Reg_Time) DESC ";

    $Count_Query = "SELECT COUNT(DISTINCT E.Expert_ID) AS Total
                        FROM `Expert` E
                        LEFT JOIN `Expert_Tags` T ON E.Expert_ID = T.Expert_ID 
                        LEFT JOIN `Expert_Streams` S ON E.Expert_ID = S.Expert_ID
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

    $Select_Query = "SELECT E.*, GROUP_CONCAT(CONCAT('#', T.Tags_Keywords) SEPARATOR ' ') AS Key_Words, GROUP_CONCAT(DISTINCT S.Stream_Name SEPARATOR ',') AS Streams FROM `Expert` E LEFT JOIN `Expert_Tags` T ON E.Expert_ID = T.Expert_ID LEFT JOIN `Expert_Streams` S ON E.Expert_ID = S.Expert_ID $Where GROUP BY E.Expert_ID ";

    $Full_Select_Query = $Select_Query . $Order_Query . "LIMIT ?, ?";
    $Select_Query_SQL = $Connection->prepare($Full_Select_Query);
    $Full_D_Type = $D_Type . "ii";
    $Full_Params = array_merge($Params, [$Start, $Limit]);
    $Select_Query_SQL->bind_param($Full_D_Type, ...$Full_Params);
    $Select_Query_SQL->execute();
    $Result = $Select_Query_SQL->get_result();

    function Sent_Mail($Expert_Name, $E_Mail, $Expert_ID)
    {
        $Name = htmlentities($Expert_Name);
        $Email = htmlentities($E_Mail);
        $mailsubject = "Your Expert Cluster Registration Status";
        $mailsender = "Expert Cluster";

        $message = '
            <html>
            <head>
                <style>
                    @import url("https://fonts.googleapis.com/css2?family=Aboreto&family=Cinzel:wght@400;700&family=Josefin+Sans:wght@400;700&display=swap");

                    body {
                        font-family: "Aboreto", "Josefin Sans", "Cinzel", sans-serif;
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
                        font-size: 24px;
                        font-weight: 700;
                        color: #f59e0b; /* amber for pending */
                        margin-bottom: 20px;
                        text-align: center;
                    }

                    p {
                        font-size: 16px;
                        margin-bottom: 15px;
                    }

                    .highlight-box {
                        background-color: #fff7ed; /* light amber */
                        border-radius: 12px;
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
                    <div class="header">Hello ' . $Name . ',</div>

                    <p>
                        Your expert profile has been successfully created on the <strong>Expert Cluster</strong> platform. 
                        However, your access to teach learners is currently <strong>pending approval</strong> by the admin.
                    </p>

                    <div class="highlight-box">
                        <div class="value">
                            <span class="label">Expert ID:</span><br>
                            <strong>' . htmlspecialchars($Expert_ID) . '</strong>
                        </div>
                    </div>

                    <p class="note">
                        Once the admin grants access, you will receive a confirmation email and will be able to log in and start teaching in your selected streams. 
                        We appreciate your patience.
                    </p>

                    <div class="footer">
                        Best regards,<br>
                        <strong>Expert Cluster Team</strong><br>
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
        function Generate_Password($Length = 8)
        {
            $Upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $Lower = 'abcdefghijklmnopqrstuvwxyz';
            $Number = '0123456789';
            $Symbol = '@#$!';

            $All = $Upper . $Lower . $Number . $Symbol;

            $Password  = $Upper[random_int(0, strlen($Upper) - 1)];
            $Password .= $Lower[random_int(0, strlen($Lower) - 1)];
            $Password .= $Number[random_int(0, strlen($Number) - 1)];
            $Password .= $Symbol[random_int(0, strlen($Symbol) - 1)];

            for ($i = 4; $i < $Length; $i++) {
                $Password .= $All[random_int(0, strlen($All) - 1)];
            }

            return str_shuffle($Password);
        }

        $Password = Generate_Password();
        $Expert_Name = $_POST['Expert_Name'];
        $E_Mail = $_POST['E_Mail'];
        $Expert_ID = $_POST['Expert_ID'];
        $Gate = "Deny";
        $Update_Query = "UPDATE `Expert` SET `Password` = ?, `Access_Gate` = ? WHERE `Expert_ID` = ?";
        $Update_Query_SQL = $Connection->prepare($Update_Query);
        $Update_Query_SQL->bind_param("sss", $Password, $Gate, $Expert_ID);
        if ($Update_Query_SQL->execute()) {
            Sent_Mail($Expert_Name, $E_Mail, $Expert_ID);
            echo "
                <script>
                    alert ('Expert access has been denied✨');
                    window.location.href = 'A_Expert_Access_Restrict.php';
                </script>
            ";
        }
    }
}
?>

<link rel="stylesheet" href="./A_Control_Access_Panel.css">

<main class="content">
    <div class="Wrapper">
        <div class="Nav-Bar container-fluid d-flex flex-wrap justify-content-center align-items-center gap-3 mb-4 p-3">
            <button onclick="window.location.href = 'A_Expert_Access_Control.php'" class="btn">Back</button>
            <button onclick="window.location.href = 'A_Expert_Access_Activate.php'" class="btn">Activate</button>
            <button onclick="window.location.href = 'A_Expert_Access_Restrict.php'" class="btn active">Restrict</button>
            <button onclick="window.location.href = 'A_Expert_Access_Reactivate.php'" class="btn">Reactivate</button>
        </div>
        <div class="Header">
            <h1 class="text-center py-3">Experts</h1>
        </div>
        <div class="Search mb-3">
            <form action="" method="post" novalidate class="container py-3">
                <label for="Experience">Experience :</label>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="Min" class="form-label ms-2">Min Years :</label>
                        <div class="form-group">
                            <select class="form-select" name="Min" id="Min">
                                <option value="">--Min Years--</option>
                                <option value="NULL" <?= ($Min === 'NULL') ? "Selected" : "" ?>>Any</option>
                                <option value="1" <?= ($Min === '1') ? "Selected" : "" ?>>1</option>
                                <option value="2" <?= ($Min === '2') ? "Selected" : "" ?>>2</option>
                                <option value="3" <?= ($Min === '3') ? "Selected" : "" ?>>3</option>
                                <option value="5" <?= ($Min === '5') ? "Selected" : "" ?>>5</option>
                                <option value="7" <?= ($Min === '7') ? "Selected" : "" ?>>7</option>
                                <option value="10" <?= ($Min === '10') ? "Selected" : "" ?>>10</option>
                                <option value="15" <?= ($Min === '15') ? "Selected" : "" ?>>15</option>
                                <option value="20" <?= ($Min === '20') ? "Selected" : "" ?>>20</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="Max" class="form-label ms-2">Max Years :</label>
                        <div class="form-group">
                            <select class="form-select" name="Max" id="Max">
                                <option value="">--Max Years--</option>
                                <option value="NULL" <?= ($Max === 'NULL') ? "Selected" : "" ?>>Any</option>
                                <option value="1" <?= ($Max === '1') ? "Selected" : "" ?>>1</option>
                                <option value="2" <?= ($Max === '2') ? "Selected" : "" ?>>2</option>
                                <option value="3" <?= ($Max === '3') ? "Selected" : "" ?>>3</option>
                                <option value="5" <?= ($Max === '5') ? "Selected" : "" ?>>5</option>
                                <option value="7" <?= ($Max === '7') ? "Selected" : "" ?>>7</option>
                                <option value="10" <?= ($Max === '10') ? "Selected" : "" ?>>10</option>
                                <option value="15" <?= ($Max === '15') ? "Selected" : "" ?>>15</option>
                                <option value="20" <?= ($Max === '20') ? "Selected" : "" ?>>20</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="Stream" class="form-label ms-2">Stream Name :</label>
                        <div class="form-group">
                            <select class="form-select" name="Stream" id="Stream">
                                <option value="">--Select The Stream--</option>
                                <?php
                                $Grant = "Grant";
                                $Re_Grant = "Re-Grant";
                                $Select_Stream_Query = "SELECT Stream FROM `Streams` WHERE ( Access_Gate = ? OR Access_Gate = ? ) ORDER BY Stream ASC";
                                $Select_Stream_Query_SQL = $Connection->prepare($Select_Stream_Query);
                                $Select_Stream_Query_SQL->bind_param("ss", $Grant, $Re_Grant);
                                $Select_Stream_Query_SQL->execute();
                                $Stream_Result = $Select_Stream_Query_SQL->get_result();
                                while ($Stream_Row = $Stream_Result->fetch_assoc()) {
                                    $S_Nor_Stream = htmlspecialchars($Stream_Row['Stream'], ENT_QUOTES, 'UTF-8');
                                    $S_Stream = html_entity_decode($Stream_Row['Stream']);
                                ?>
                                    <option value="<?= $S_Nor_Stream ?>" <?= ($S_Stream === $Stream) ? "Selected" : "" ?>><?= $S_Stream ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="Expertise" class="form-label ms-2">Expertise :</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="Expertise" id="Expertise" placeholder="Enter The Expertise" value="<?= $Expertise ?>" autocomplete="off">
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
        <div class="Card-Wrapper m-3 row d-flex justify-content-center">
            <?php
            if ($Result->num_rows > 0) {
                $Serial_No = $Start + 1;
                while ($Row = $Result->fetch_assoc()) {
            ?>

                    <div class="col-md-4 mb-4 d-flex justify-content-center align-items-center">
                        <div class="card shadow-sm rounded-4 overflow-hidden">
                            <div class="Card-img d-flex justify-content-center mt-3">
                                <img src="./Expert_Cluster_Official_Images/Expert_Profile_Pic/<?= html_entity_decode($Row['Profile_Pic']) ?>"
                                    alt="<?= html_entity_decode($Row['Profile_Pic']) ?>"
                                    class="img-fluid rounded">
                            </div>
                            <div class="card-body d-flex flex-column mt-4">
                                <div class="card-header mb-3">
                                    <h3 class="card-title fw-semibold text-center"><?= html_entity_decode($Row['First_Name']) . " " . html_entity_decode($Row['Last_Name']) ?></h3>
                                </div>
                                <div class="card-body" style="margin-top: 10px;">
                                    <h6 class=""><strong>Qualification : </strong><?= html_entity_decode($Row['Qualification']) ?></h6>
                                    <h6 class=""><strong>Expert In : </strong><?= html_entity_decode($Row['Expert_In']) ?></h6>
                                    <h6 class=""><strong>Designation : </strong><?= html_entity_decode($Row['Designation']) ?></h6>
                                    <h6 class=""><strong>Organization : </strong><?= html_entity_decode($Row['Organization_Name']) ?><strong class="m-2 p-1 badge" style="background: rgba(98, 48, 127, 0.8); font-family: 'Aboreto';"><?= html_entity_decode($Row['Years_of_Experience']) ?></strong></h6>
                                    <h6 class="card-text"><strong>Streams : </strong></h6>
                                    <?php
                                    $Stream = array_map('trim', explode(',', $Row['Streams']));
                                    foreach ($Stream as $Subject) {
                                    ?>
                                        <button class="Stream_Btn p-1" onclick="applyStreamFilter('<?= htmlspecialchars($Subject, ENT_QUOTES, 'UTF-8') ?>')">
                                            <?= htmlspecialchars(html_entity_decode($Subject), ENT_QUOTES, 'UTF-8') ?>
                                        </button>
                                    <?php
                                    }
                                    ?>
                                    <script>
                                        function applyStreamFilter(stream) {
                                            const streamSelect = document.getElementById('Stream');

                                            // Set dropdown value
                                            for (let option of streamSelect.options) {
                                                if (option.value.trim() === stream.trim()) {
                                                    option.selected = true;
                                                    break;
                                                }
                                            }

                                            // Submit the form
                                            streamSelect.form.submit();
                                        }
                                    </script>
                                </div>
                                <div class="card-footer d-flex justify-content-center gap-2">
                                    <?php
                                    echo "
                                            <button type='button' class='btn view-btn view-more-expert-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewMoreStreamModal'
                                                data-ID='" . $Row['Expert_ID'] . "'
                                                data-Expert_Name='" . $Row['First_Name'] . $Row['Last_Name'] . "'
                                                data-Date_Of_Birth='" . $Row['Date_Of_Birth'] . "'
                                                data-Phone_Number='" . $Row['Phone_Number'] . "'
                                                data-E_Mail='" . $Row['E_Mail'] . "'
                                                data-City='" . $Row['City'] . "'
                                                data-Country='" . $Row['Country'] . "'
                                                data-Qualification='" . $Row['Qualification'] . "'
                                                data-Expert_In='" . $Row['Expert_In'] . "'
                                                data-Designation='" . $Row['Designation'] . "'
                                                data-Organization_Name='" . $Row['Organization_Name'] . "'
                                                data-Years_of_Experience='" . $Row['Years_of_Experience'] . "'
                                                data-Streams='" . $Row['Streams'] . "
                                                data-Key_Words='" . $Row['Key_Words'] . "'>
                                                View
                                            </button>
                                        ";

                                    echo "
                                            <button type='button' class='btn view-btn view-Certi-expert-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewCertiStreamModal'
                                                data-Professional_Certification='" . $Row['Professional_Certification'] . "'>
                                                <i class='fa-solid fa-certificate'></i>
                                            </button>
                                        ";

                                    echo "
                                            <button type='button' class='btn view-btn view-Resume-expert-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewResumeStreamModal'
                                                data-Resume='" . $Row['Resume'] . "'>
                                                <i class='fa-solid fa-square-poll-horizontal'></i>
                                            </button>
                                        ";
                                    ?>
                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    <form action="" method="post">
                                        <input type="hidden" name="Expert_ID" id="Expert_ID" value="<?= $Row['Expert_ID'] ?>">
                                        <input type="hidden" name="Expert_Name" id="Expert_Name" value="<?= html_entity_decode($Row['First_Name']) . " " . html_entity_decode($Row['Last_Name']) ?>">
                                        <input type="hidden" name="E_Mail" id="E_Mail" value="<?= html_entity_decode($Row['E_Mail']) ?>">
                                        <?php
                                        echo "
                                            <button type='submit' class='btn fs-5' name='Deny'>Deny</button>
                                        ";
                                        ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <h3 class="No_Experts text-center text-muted p-2">No experts available at the moment.</h3>
            <?php
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
</main>
</div>
</div>

<!-- Re-Set -->

<script>
    function Form_Reset() {
        window.location.href = 'A_Expert_Access_Restrict.php';
    }
</script>

<!-- View Detail Modal -->
<div class="modal fade" id="viewMoreStreamModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="viewMoreModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg">

            <!-- Header -->
            <div class="modal-header bg-light">
                <h1 class="modal-title fw-bold" id="viewMoreModalLabel">
                    Expert Profile Details
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-4 fs-5">

                <!-- SECTION -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Basic Information</h5>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Expert ID</div>
                        <div class="col-md-8" id="modalID"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Full Name</div>
                        <div class="col-md-8" id="modalExpert_Name"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Date of Birth</div>
                        <div class="col-md-8" id="modalDOB"></div>
                    </div>
                </div>

                <!-- SECTION -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Contact Details</h5>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Phone Number</div>
                        <div class="col-md-8" id="modalP_No"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Email Address</div>
                        <div class="col-md-8" id="modalE_Mail"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Location</div>
                        <div class="col-md-8">
                            <span id="modal_City"></span>,
                            <span id="modal_Country"></span>
                        </div>
                    </div>
                </div>

                <!-- SECTION -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Professional Profile</h5>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Qualification</div>
                        <div class="col-md-8" id="modal_Qualification"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Designation</div>
                        <div class="col-md-8" id="modalDesig"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Organization</div>
                        <div class="col-md-8" id="modalOrganization"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Expertise</div>
                        <div class="col-md-8" id="modal_Expert_In"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Years of Experience</div>
                        <div class="col-md-8" id="modalYOE"></div>
                    </div>
                </div>

                <!-- SECTION -->
                <div>
                    <h5 class="fw-bold mb-3">Streams & Keywords</h5>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">Streams</div>
                        <div class="col-md-8" id="modalStreams"></div>
                    </div>

                    <div>
                        <div class="fw-semibold mb-2">Key Words</div>
                        <div id="modalKey_Words" class="d-flex flex-wrap gap-2 fs-6">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn px-5"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.view-more-expert-btn').forEach(button => {
        button.addEventListener('click', function() {

            document.getElementById('modalID').textContent = this.getAttribute('data-ID');
            document.getElementById('modalExpert_Name').textContent = this.getAttribute('data-Expert_Name');
            document.getElementById('modalDOB').textContent = this.getAttribute('data-Date_Of_Birth');
            document.getElementById('modalP_No').textContent = this.getAttribute('data-Phone_Number');
            document.getElementById('modalE_Mail').textContent = this.getAttribute('data-E_Mail');
            document.getElementById('modal_City').textContent = this.getAttribute('data-City');
            document.getElementById('modal_Country').textContent = this.getAttribute('data-Country');
            document.getElementById('modal_Qualification').textContent = this.getAttribute('data-Qualification');
            document.getElementById('modal_Expert_In').textContent = this.getAttribute('data-Expert_In');
            document.getElementById('modalDesig').textContent = this.getAttribute('data-Designation');
            document.getElementById('modalOrganization').textContent = this.getAttribute('data-Organization_Name');
            document.getElementById('modalYOE').textContent = this.getAttribute('data-Years_of_Experience');
            document.getElementById('modalStreams').textContent = this.getAttribute('data-Streams');
            document.getElementById('modalKey_Words').textContent = this.getAttribute('data-Key_Words');
        });
    });
</script>

<!-- View Certificate Modal -->
<div class="modal fade" id="viewCertiStreamModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="viewCertiModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg">

            <!-- Header -->
            <div class="modal-header bg-light">
                <h1 class="modal-title fw-bold" id="viewCertiModalLabel">
                    Expert Certificate
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-4 fs-5">

                <!-- SECTION -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Expert Certificate</h5>
                    <div class="text-center">
                        <iframe id="modalExpert_Certificates"
                            src=""
                            class="w-100 rounded shadow-sm"
                            style="height: 500px; display: none;"
                            frameborder="0">
                        </iframe>

                        <img id="modalExpert_Image"
                            class="img-fluid rounded shadow-sm"
                            style="max-height: 400px; display: none;"
                            alt="Expert Certificate Image">
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn px-5"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.view-Certi-expert-btn').forEach(button => {
        button.addEventListener('click', function() {

            let file = this.getAttribute('data-Professional_Certification');

            if (!file) return;

            file = file.trim().replace(/^["']|["']$/g, '');

            const basePath = 'Expert_Cluster_Official_Images/Expert_Certificates/';
            const fullPath = basePath + file;

            const iframe = document.getElementById('modalExpert_Certificates');
            const img = document.getElementById('modalExpert_Image');

            const extension = file.split('.').pop().toLowerCase();

            // Reset
            iframe.style.display = 'none';
            img.style.display = 'none';

            if (['pdf'].includes(extension)) {
                iframe.src = fullPath;
                iframe.style.display = 'block';
            } else if (['jpg', 'jpeg', 'png', 'webp'].includes(extension)) {
                img.src = fullPath;
                img.style.display = 'block';
            } else {
                iframe.src = basePath + 'placeholder.pdf';
                iframe.style.display = 'block';
            }
        });
    });
</script>

<!-- View Resume Modal -->
<div class="modal fade" id="viewResumeStreamModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="viewResumeModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg">

            <!-- Header -->
            <div class="modal-header bg-light">
                <h1 class="modal-title fw-bold" id="viewResumeModalLabel">
                    Expert Resume
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-4 fs-5">

                <!-- SECTION -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Expert Resume</h5>
                    <div class="text-center">
                        <iframe id="modalExpert_Resume"
                            src=""
                            class="w-100 rounded shadow-sm"
                            style="height: 500px; display: none;"
                            frameborder="0">
                        </iframe>

                        <img id="modalExpert_Image"
                            class="img-fluid rounded shadow-sm"
                            style="max-height: 400px; display: none;"
                            alt="Expert Resume Image">
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn px-5"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.view-Resume-expert-btn').forEach(button => {
        button.addEventListener('click', function() {

            let file = this.getAttribute('data-Resume');

            if (!file) return;

            file = file.trim().replace(/^["']|["']$/g, '');

            const basePath = 'Expert_Cluster_Official_Images/Expert_Resumes/';
            const fullPath = basePath + file;

            const iframe = document.getElementById('modalExpert_Resume');
            const img = document.getElementById('modalExpert_Image');

            const extension = file.split('.').pop().toLowerCase();

            // Reset
            iframe.style.display = 'none';
            img.style.display = 'none';

            if (['pdf'].includes(extension)) {
                iframe.src = fullPath;
                iframe.style.display = 'block';
            } else if (['jpg', 'jpeg', 'png', 'webp'].includes(extension)) {
                img.src = fullPath;
                img.style.display = 'block';
            } else {
                iframe.src = basePath + 'placeholder.pdf';
                iframe.style.display = 'block';
            }
        });
    });
</script>