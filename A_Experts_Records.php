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
        $_SESSION['AS_Current_Page'] = 1;
    }

    if (isset($_POST['Search'])) {
        $_SESSION['AS_Current_Page'] = 1;
    }

    if (isset($_POST['Page'])) {
        $_SESSION['AS_Current_Page'] = $_POST['Page'];
    } elseif (!isset($_SESSION['AS_Current_Page'])) {
        $_SESSION['AS_Current_Page'] = 1;
    }

    $Page = $_SESSION['AS_Current_Page'];
    $Page = max(1, (int)$Page);
    $Start = ($Page - 1) * $Limit;

    $Min        = $_POST['Min'] ?? '';
    $Max        = $_POST['Max'] ?? '';
    $Stream     = $_POST['Stream'] ?? '';
    $Expertise  = $_POST['Expertise'] ?? '';

    $Search = !empty($Min) || !empty($Max) || !empty($Stream) || !empty($Expertise);

    $Params = [];
    $D_Type = "";

    $Where = " WHERE (E.Access_Gate = ?  OR E.Access_Gate = ?) ";
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
            $Where .= " AND E.Expertise LIKE ? ";
            $Params[] = "%$Expertise%";
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
}
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Aboreto&family=Big+Shoulders+Stencil:opsz,wght@10..72,100..900&family=Cinzel:wght@400..900&family=Cormorant+Upright:wght@300;400;500;600;700&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Pacifico&family=Text+Me+One&family=Zilla+Slab+Highlight:wght@400;700&display=swap');

    /* Nav-Bar */

    .Nav-Bar {
        background: #ddcaf6dd;
        border-radius: 20px;
        position: sticky;
        top: 1rem;
        z-index: 999;
    }

    .Nav-Bar .btn {
        font-size: clamp(1rem, 1.8vw, 1.5rem);
        padding: 0.1rem 1rem;
        font-weight: bolder;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(73, 11, 89, 0.25);
    }

    /* Haeding */

    .Header h1 {
        font-family: "Aboreto";
        font-size: clamp(1.8rem, 3.3vw, 3rem);
        font-weight: 500;
        color: #ffffffff;
    }

    /* Search Form, Container */

    .Search {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 20px;
    }

    label {
        font-family: "Cormorant Upright";
        font-size: clamp(1.3rem, 1.5vw, 1.8rem) !important;
        font-weight: bold;
        color: rgba(38, 0, 37, 1);
    }

    .form-control,
    .form-select {
        border: 2px solid rgba(239, 233, 238, 0.5);
        border-radius: 6px;
        font-family: "Cormorant Upright";
        font-weight: 900;
        font-size: clamp(0.8rem, 1vw, 1.3rem);
        transition: all 0.3s ease;
        background: rgba(243, 229, 246, 0.7);
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        height: 42px;
        width: 100%;
    }

    .form-control:focus {
        color: #2e2d2dff;
        font-size: clamp(0.8rem, 1.3vw, 1.8rem);
        font-weight: 600;
        border-color: #260523c2;
        box-shadow: 0 0 0 0.2rem rgba(12, 0, 14, 0.25);
        background: rgba(255, 255, 255, 0.1);
    }

    .form-select:focus {
        color: #2e2d2dff;
        font-weight: 600;
        border-color: #260523c2;
        box-shadow: 0 0 0 0.2rem rgba(12, 0, 14, 0.25);
        background: rgba(0, 0, 0, 0.1);
    }

    input[type="text"]:not(:placeholder-shown) {
        color: #2e2d2dff;
    }

    .form-control::placeholder {
        color: #2e2d2dff;
        font-size: clamp(0.8rem, 1.5vw, 1.1rem);
        opacity: 0.9;
    }

    .form-select {
        color: #2e2d2dff;
        font-size: clamp(0.8rem, 1.5vw, 1.1rem);
    }

    .form-select option {
        font-family: "Cormorant Upright";
        background: rgba(232, 212, 237, 0.8);
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
        border: none;
        color: rgba(29, 3, 36, 0.8);
        font-weight: 500;
    }

    .btn {
        font-family: "Cormorant Upright";
        font-weight: bolder;
        font-size: clamp(1.1rem, 1.8vw, 1.7rem);
        /* border: 2px solid rgba(38, 0, 37, 1); */
        background: rgba(38, 0, 37, 0.8);
        color: #ffffffff;
    }

    /* Cards */
    .card {
        background: #d2b6e1dc;
        border: 3px solid rgba(255, 255, 255, 0.5);
        color: #0e0115c2;
    }

    .Card-img img {
        max-width: 300px;
        max-height: 300px;
        border-radius: 1rem;
        border: 0.2rem solid rgba(255, 255, 255, 0.5);
    }

    .card-title {
        font-family: "Aboreto";
        font-size: clamp(1.2rem, 1.5vw, 1.8rem);
    }

    .card-body h5 {
        font-family: "Cormorant Upright";
        font-weight: 600;
    }

    .Stream_Btn {
        border: none;
        border-radius: 5px;
        background: rgba(141, 70, 203, 0.3);
        color: rgba(29, 3, 36, 0.8);
        font-family: 'Cormorant Upright';
        font-size: 1.1rem;
        font-weight: 800;
        transition: all ease 0.2s;
    }

    .Stream_Btn:hover {
        color: rgba(29, 3, 36, 0.8);
        background: rgba(179, 80, 207, 0.3);
    }

    .view-btn {
        font-size: clamp(1rem, 1.2vw, 1.7rem);
    }

    /* Pagination */
    .page-item button {
        background: #1b012adc !important;
        color: #ffffffff;
        font-family: "Cormorant Upright";
        font-size: clamp(1rem, 1.3vw, 1.8rem);
        font-weight: bolder;
    }

    .page-item button:hover {
        color: #ffffffff;
    }

    .Pagi-Caption p {
        color: #ffffffff;
        font-family: "Cormorant Upright";
        font-size: clamp(1.2rem, 1.8vw, 1.6rem);
        font-weight: bolder;
    }

    /* Modal */

    .modal-header h1 {
        font-family: "Cormorant Upright";
        font-weight: 900;
        font-size: clamp(1.3rem, 2vw, 1.8rem);
        color: #0e0115c2;
    }

    .modal-body {
        font-family: "Cormorant Upright";
        font-weight: 900;
        color: #0e0115c2;
    }

    .modal-body h5 {
        color: rgba(113, 6, 143, 1);
    }
</style>

<main class="content">
    <div class="Wrapper">
        <div class="Nav-Bar container-fluid d-flex flex-wrap justify-content-center align-items-center gap-3 mb-4 p-3">
            <button onclick="window.location.href = 'A_Core_Records.php'" class="btn">Back</button>
            <button onclick="window.location.href = 'A_Experts_Records.php'" class="btn active">Experts</button>
            <button onclick="window.location.href = 'A_Seekers_Records.php'" class="btn">Seekers</button>
            <button onclick="window.location.href = 'A_Streams_Records.php'" class="btn">Streams</button>
        </div>
        <div class="Header">
            <h1 class="text-center">Experts</h1>
        </div>
        <div class="Search p-3 mb-3">
            <form action="" method="post" novalidate class="container">
                <label for="Experience">Experience :</label>
                <div class="row g-3 g-md-5 md-2">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="Min">Min Years :</label>
                        <div class="form-group">
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
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="Max">Max Years :</label>
                        <div class="form-group">
                            <select class="form-select" name="Max" id="Max">
                                <option value="">--Max Years--</option>
                                <option value="0" <?= ($Max === 'NULL') ? "Selected" : "" ?>>Any</option>
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
                </div>

                <div class="row g-3 g-md-5 mb-2">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="Stream" class="form-label ms-2">Stream Name :</label>
                        <div class="form-group">
                            <select class="form-select" name="Stream" id="Stream">
                                <option value="">--Select The Stream--</option>
                                <?php
                                $Gate = "Grant";
                                $Select_Stream_Query = "SELECT Stream FROM `Streams` WHERE Access_Gate = ? ORDER BY Stream_Category ASC";
                                $Select_Stream_Query_SQL = $Connection->prepare($Select_Stream_Query);
                                $Select_Stream_Query_SQL->bind_param("s", $Gate);
                                $Select_Stream_Query_SQL->execute();
                                $Stream_Result = $Select_Stream_Query_SQL->get_result();
                                while ($Stream_Row = $Stream_Result->fetch_assoc()) {
                                    $S_Nor_Stream = $Stream_Row['Stream'];
                                    $S_Stream = html_entity_decode($Stream_Row['Stream']);
                                ?>
                                    <option value="<?= $S_Nor_Stream ?>" <?= ($S_Stream === $Stream) ? "Selected" : "" ?>><?= $S_Stream ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 mb-md-0">
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
                        <div class="card w-auto h-auto shadow-sm rounded-4 overflow-hidden">
                            <div class="Card-img d-flex justify-content-center mt-3">
                                <img src="./Expert_Cluster_Official_Images/Expert_Profile_Pic/<?= html_entity_decode($Row['Profile_Pic']) ?>"
                                    alt="<?= html_entity_decode($Row['Profile_Pic']) ?>"
                                    class="img-fluid rounded">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="card-header mb-3">
                                    <h3 class="card-title fw-semibold text-center"><?= html_entity_decode($Row['First_Name']) . " " . html_entity_decode($Row['Last_Name']) ?></h3>
                                </div>
                                <div class="card-body">
                                    <h5 class=""><strong>Qualification : </strong><?= html_entity_decode($Row['Qualification']) ?></h5>
                                    <h5 class=""><strong>Expert In : </strong><?= html_entity_decode($Row['Expert_In']) ?></h5>
                                    <h5 class=""><strong>Designation : </strong><?= html_entity_decode($Row['Designation']) ?></h5>
                                    <h5 class=""><strong>Organization : </strong><?= html_entity_decode($Row['Organization_Name']) ?><strong class="m-2 p-1 badge" style="background: rgba(29, 3, 36, 0.8); font-family: 'Aboreto';"><?= html_entity_decode($Row['Years_of_Experience']) ?></strong></h5>
                                    <h5 class="card-text"><strong>Streams : </strong></h5>
                                    <?php
                                    $Stream = array_map('trim', explode(',', $Row['Streams']));
                                    foreach ($Stream as $Subject) {
                                    ?>
                                        <button class="Stream_Btn m-1 p-2" onclick="applyStreamFilter('<?= $Subject ?>')">
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
                            </div>
                        </div>
                    </div>
            <?php
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
</main>
</div>
</div>

<!-- Re-Set -->

<script>
    function Form_Reset() {
        window.location.href = 'A_Expert_Access_Activate.php';
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