<?php
include './Database.php';
include './Admin_Dashboard.php';

if ($Connection) {

    $Limit = 5;

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
    $Stream_Category    = $_POST['Stream_Category'] ?? '';
    $Stream_Type        = $_POST['Stream_Type'] ?? '';
    $Stream             = $_POST['Stream'] ?? '';
    $Stream_Description = $_POST['Stream_Description'] ?? '';

    $Search = !empty($Stream_Category) || !empty($Stream_Type) || !empty($Stream) || !empty($Stream_Description);

    $Params = [];
    $D_Type = "";

    $Where = " WHERE S.Access_Gate = ? ";
    $Params = ["Grant"];
    $D_Type = "s";

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

    $Order_Query = " ORDER BY date(S.Subject_Reg_Time) DESC ";

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
}
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Aboreto&family=Big+Shoulders+Stencil:opsz,wght@10..72,100..900&family=Cinzel:wght@400..900&family=Cormorant+Upright:wght@300;400;500;600;700&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Pacifico&family=Text+Me+One&family=Zilla+Slab+Highlight:wght@400;700&display=swap');

    /* Haeding */

    .Header h1 {
        font-family: "Aboreto";
        font-size: clamp(1.5rem, 3vw, 2.8rem);
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

    /* Table */

    .table-responsive {
        overflow-x: auto;
        scrollbar-width: none;
    }

    .table-responsive::-webkit-scrollbar {
        display: none;
    }

    th {
        background: rgba(255, 255, 255, 0.8) !important;
        font-family: "Cinzel";
        font-weight: bold;
        font-size: clamp(0.8rem, 1vw, 1.5rem);
        color: #0e0115c2 !important;
    }

    td {
        background: rgba(255, 255, 255, 0.5) !important;
        font-family: "Cormorant Upright";
        font-weight: bolder;
        font-size: clamp(0.9rem, 1.2vw, 1.6rem);
        color: #0e0115c2 !important;
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

    .modal-body h6 {
        font-size: clamp(1.2rem, 2vw, 1.5rem);
    }

    .modal-body p,
    .modal-body #modalStream_Tags {
        font-size: clamp(1rem, 1.8vw, 1.3rem);
        font-weight: 800;
    }

    #modalStream_Description {
        word-wrap: break-word;
        background: #e9cbf1cb;
        padding: 10px;
        border-radius: 8px;
    }

    #modalStream_Tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 5px;
    }
</style>

<main class="content">
    <div class="Wrapper">
        <div class="Header">
            <h1 class="text-center">Streams</h1>
        </div>
        <div class="Nav-Bar">

        </div>
        <div class="Search p-3 mb-3">
            <form action="" method="post" novalidate class="container">
                <!-- <input type="hidden" name="Page" value="<?php echo $Page; ?>"> -->
                <div class="row g-md-5 mb-2">
                    <div class="col-md-6 mb-3 mb-md-0">
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
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="Stream_Type" class="form-label ms-2">Stream Type :</label>
                        <div class="form-group">
                            <select class="form-select" name="Stream_Type" id="Stream_Type">
                                <option value="">--Select The Stream Type--</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row g-3 g-md-5 mb-2">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="Stream" class="form-label ms-2">Stream Name :</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="Stream" id="Stream" placeholder="Enter The Stream Name" value="<?= $Stream ?>" autocomplete="off">

                        </div>
                    </div>
                    <div class="col-md-6 mb-3 mb-md-0">
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
        <div class="table-responsive">
            <table class="table table-hover table-bordered w-100">
                <thead>
                    <tr class="text-center">
                        <th>Serial No</th>
                        <th>Stream ID</th>
                        <th>Stream Category</th>
                        <th>Stream Type</th>
                        <th>Stream</th>
                        <th>Stream Description</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if ($Result->num_rows > 0) {
                        $Serial_No = $Start + 1;
                        while ($Row = $Result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class = 'text-center'>" . $Serial_No . "</td>";
                            echo "<td>" . $Row["Stream_ID"] . "</td>";
                            echo "<td>" . $Row["Stream_Category"] . "</td>";
                            echo "<td>" . $Row["Stream_Type"] . "</td>";
                            echo "<td>" . $Row["Stream"] . "</td>";
                            echo "<td>" . $Row["Stream_Description"] . "</td>";
                            echo "<td>
                                    <button type='button' class='btn view-btn view-more-stream-btn mb-1' data-bs-toggle='modal' data-bs-target='#viewMoreStreamModal'
                                        data-ID='" . $Row['Stream_ID'] . "'
                                        data-Stream_Category='" . $Row['Stream_Category'] . "'
                                        data-Stream_Type='" . $Row['Stream_Type'] . "'
                                        data-Stream='" . $Row['Stream'] . "'
                                        data-Stream_Description='" . $Row['Stream_Description'] . "'
                                        data-Stream_Img='" . $Row['Stream_Image'] . "'
                                        data-Stream_Tags='" . $Row['Key_Words'] . "'>
                                        View
                                    </button>
                                </td>";
                            echo "</tr>";
                            $Serial_No++;
                        }
                    }
                    ?>
                </tbody>
            </table>
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