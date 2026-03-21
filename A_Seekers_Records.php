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

    // $Stream_Category = isset($_POST['Stream_Category']) ? htmlspecialchars($_POST['Stream_Category']) : '';
    $Seeker_Type    = $_POST['Seeker_Type'] ?? '';

    $Search = !empty($Seeker_Type);

    $Params = [];
    $D_Type = "";

    $Where = " WHERE ( Access_Gate = ? OR Access_Gate = ? ) ";
    $Params = ["Grant", "Re-Grant"];
    $D_Type = "ss";

    if ($Search || isset($_POST['Search'])) {
        if (!empty($Seeker_Type)) {
            $Where .= " AND Seeker_Type LIKE ? ";
            $Params[] = "%" . htmlspecialchars($Seeker_Type) . "%";
            $D_Type .= "s";
        }
    }

    $Order_Query = " ORDER BY date(Reg_Time) DESC ";

    $Count_Query = "SELECT COUNT(DISTINCT Seeker_ID) AS Total
                        FROM `Seeker` 
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

    $Select_Query = "SELECT * FROM `Seeker` $Where ";

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
            <button onclick="window.location.href = 'A_Experts_Records.php'" class="btn">Experts</button>
            <button onclick="window.location.href = 'A_Seekers_Records.php'" class="btn active">Seekers</button>
            <button onclick="window.location.href = 'A_Streams_Records.php'" class="btn">Streams</button>
        </div>
        <div class="Header">
            <h1 class="text-center">Seekers</h1>
        </div>
        <div class="Search p-3 mb-3">
            <form action="" method="post" novalidate class="container">
                <!-- <input type="hidden" name="Page" value="<?php echo $Page; ?>"> -->
                <div class="row g-md-5 mb-2 d-flex justify-content-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="Seeker_Type" class="form-label ms-2">Seeker Type :</label>
                        <div class="form-group">
                            <select class="form-select" name="Seeker_Type" id="Seeker_Type">
                                <option value="">--Select The Seeker Type--</option>
                                <option value="School Student" <?= ($Seeker_Type === 'School Student') ? "Selected" : "" ?>>School Student</option>
                                <option value="College Student" <?= ($Seeker_Type === 'College Student') ? "Selected" : "" ?>>College Student</option>
                                <option value="Working Professional" <?= ($Seeker_Type === 'Working Professional') ? "Selected" : "" ?>>Working Professional</option>
                            </select>
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
                            <div class="Card-img d-flex justify-content-center m-4">
                                <img src="./Expert_Cluster_Official_Images/Seeker_Profile_Pic/<?= html_entity_decode($Row['Profile_Pic']) ?>"
                                    alt="<?= html_entity_decode($Row['Profile_Pic']) ?>"
                                    class="img-fluid rounded">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="card-header mb-3">
                                    <h3 class="card-title fw-semibold text-center"><?= html_entity_decode($Row['First_Name']) . " " . html_entity_decode($Row['Last_Name']) ?></h3>
                                </div>
                                <div class="card-body">
                                    <h5 class=""><strong>Seeker Type : </strong><?= html_entity_decode($Row['Seeker_Type']) ?></h5>
                                    <h5 class=""><strong>Skilled In : </strong><?= html_entity_decode($Row['Skill']) ?></h5>
                                </div>
                                <div class="card-footer d-flex justify-content-center gap-2">
                                    <?php
                                    echo "
                                            <button type='button' class='btn view-btn view-more-expert-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewMoreStreamModal'
                                                data-ID='" . $Row['Seeker_ID'] . "'
                                                data-Seeker_Name='" . $Row['First_Name'] . $Row['Last_Name'] . "'
                                                data-DOB='" . $Row['Date_Of_Birth'] . "'
                                                data-Phone_Number='" . $Row['Phone_Number'] . "'
                                                data-E_Mail='" . $Row['E_Mail'] . "'
                                                data-City='" . $Row['City'] . "'
                                                data-Country='" . $Row['Country'] . "'
                                                data-Seeker_Type='" . $Row['Seeker_Type'] . "'
                                                data-Skill='" . $Row['Skill'] . "'>
                                                View
                                            </button>
                                        ";

                                    if ($Row['Certification'] == NULL) {
                                        echo " ";
                                    } else {
                                        echo "
                                            <button type='button' class='btn view-btn view-Certi-seeker-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewCertiStreamModal'
                                                data-Professional_Certification='" . $Row['Certification'] . "'>
                                                <i class='fa-solid fa-certificate'></i>
                                            </button>
                                        ";
                                    }

                                    if ($Row['Resume'] == NULL) {
                                        echo " ";
                                    } else {
                                        echo "
                                            <button type='button' class='btn view-btn view-Resume-expert-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewResumeStreamModal'
                                                data-Resume='" . $Row['Resume'] . "'>
                                                <i class='fa-solid fa-square-poll-horizontal'></i>
                                            </button>
                                        ";
                                    }
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
        window.location.href = 'A_Seeker_Access_Restrict.php';
    }
</script>

<!-- Stream Dropdown -->
<script>
    // Define your types for each category
    const types = {
        "Academic & Knowledge Streams": ["Fundamental Natural Sciences", "STEM Academic Disciplines", "Humanities And Culture Studies", "Health And Medical Sciences", "Applied Technology Studies", "Engineering And Technology", "Arts And Literary Studies", "Law & Governance"],
        "Career & Professional Skills": ["Type 2A", "Type 2B"],
        "Lifestyle, Growth & Social Impact": ["Type 3A", "Type 3B", "Type 3C", "Type 3D"],
        "Technology & Creative Fields": ["Type 4A"],
        cat5: ["Type 5A", "Type 5B"]
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

<!-- View Detail Modal -->
<div class="modal fade" id="viewMoreStreamModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="viewMoreModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg">

            <!-- Header -->
            <div class="modal-header bg-light">
                <h1 class="modal-title fw-bold" id="viewMoreModalLabel">
                    Seeker Profile Details
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-4 fs-5">

                <!-- SECTION -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Basic Information</h5>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Seeker ID</div>
                        <div class="col-md-8" id="modalID"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Full Name</div>
                        <div class="col-md-8" id="modalSeeker_Name"></div>
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
                        <div class="col-md-4 fw-semibold">Seeker Type</div>
                        <div class="col-md-8" id="modal_Seeker_Type"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-semibold">Skilled In</div>
                        <div class="col-md-8" id="modal_Skill"></div>
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
            document.getElementById('modalSeeker_Name').textContent = this.getAttribute('data-Seeker_Name');
            document.getElementById('modalDOB').textContent = this.getAttribute('data-DOB');
            document.getElementById('modalP_No').textContent = this.getAttribute('data-Phone_Number');
            document.getElementById('modalE_Mail').textContent = this.getAttribute('data-E_Mail');
            document.getElementById('modal_City').textContent = this.getAttribute('data-City');
            document.getElementById('modal_Country').textContent = this.getAttribute('data-Country');
            document.getElementById('modal_Seeker_Type').textContent = this.getAttribute('data-Seeker_Type');
            document.getElementById('modal_Skill').textContent = this.getAttribute('data-Skill');
        });
    });
</script>

<!-- View Certificate Modal -->
<div class="modal fade" id="viewCertiStreamModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="viewCertiModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg">

            <!-- Header -->
            <div class="modal-header bg-light">
                <h1 class="modal-title fw-bold" id="viewCertiModalLabel">
                    Seeker Certificate
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-4 fs-5">

                <!-- SECTION -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Seeker Certificate</h5>
                    <div class="text-center d-flex justify-content-center">
                        <iframe id="modalSeeker_Certificates"
                            src=""
                            class="w-100 rounded shadow-sm"
                            style="height: 500px; display: none;"
                            frameborder="0">
                        </iframe>

                        <img id="modalSeeker_Image"
                            class="img-fluid rounded shadow-sm"
                            style="max-height: 400px; display: none;"
                            alt="Seeker Certificate Image">
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
    document.querySelectorAll('.view-Certi-seeker-btn').forEach(button => {
        button.addEventListener('click', function() {

            let file = this.getAttribute('data-Professional_Certification');

            if (!file) return;

            file = file.trim().replace(/^["']|["']$/g, '');

            const basePath = 'Expert_Cluster_Official_Images/Seeker_Certificates/';
            const fullPath = basePath + file;

            const iframe = document.getElementById('modalSeeker_Certificates');
            const img = document.getElementById('modalSeeker_Image');

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

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
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
                    <div class="text-center d-flex justify-content-center">
                        <iframe id="modalExpert_Resume"
                            src=""
                            class="w-100 rounded shadow-sm"
                            style="height: 500px; display: none;"
                            frameborder="0">
                        </iframe>

                        <img id="modalExpert_Image"
                            class="img-fluid rounded shadow-sm"
                            style="max-height: 800px; display: none;"
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

            const basePath = 'Expert_Cluster_Official_Images/Seeker_Resumes/';
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