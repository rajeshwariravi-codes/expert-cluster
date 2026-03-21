<?php
include './Database.php';
include './Expert_Dashboard.php';
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Aboreto&family=Big+Shoulders+Stencil:opsz,wght@10..72,100..900&family=Cinzel:wght@400..900&family=Cormorant+Upright:wght@300;400;500;600;700&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Pacifico&family=Radley:ital@0;1&family=Text+Me+One&family=Zilla+Slab+Highlight:wght@400;700&display=swap');
    /* Nav-Bar */

    .Nav-Bar {
        background: #cccaf6dd;
        border-radius: 20px;
        position: sticky;
        top: 1rem;
        z-index: 999;
    }

    .Nav-Bar .btn {
        font-size: clamp(1rem, 1.4vw, 1.2rem);
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
        font-size: clamp(1.5rem, 2.8vw, 2.6rem);
        font-weight: 500;
        color: #ffffffff;
    }

    /* T1_Search Form, Container */

    .Search {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 20px;
    }

    label {
        font-family: "Cormorant Upright";
        font-size: clamp(1rem, 1.2vw, 1.5rem) !important;
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
        background: rgba(230, 229, 246, 0.7);
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
        background: rgba(213, 212, 237, 0.8);
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
        border: none;
        color: rgba(29, 3, 36, 0.8);
        font-weight: 500;
    }

    .btn {
        font-family: "Cormorant Upright";
        font-weight: bolder;
        font-size: clamp(1rem, 1.5vw, 1.3rem);
        /* border: 2px solid rgba(38, 0, 37, 1); */
        background: rgba(20, 0, 38, 0.8);
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
        font-size: clamp(0.6rem, 1vw, 0.9rem);
        color: #0e0115c2 !important;
    }

    td {
        background: rgba(255, 255, 255, 0.6) !important;
        font-family: "Radley";
        font-weight: 500;
        font-size: clamp(0.8rem, 1.2vw, 1.1rem);
        color: #0e0115c2 !important;
    }

    .view-btn {
        font-size: clamp(0.8rem, 1.2vw, 1.1rem);
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
        font-size: clamp(0.8rem, 1.8vw, 1.3rem);
    }

    .modal-body p,
    .modal-body #modalQuery_Status {
        font-size: clamp(0.8rem, 1.8vw, 1.3rem);
        font-weight: 800;
    }

    #modalQuery,
    #modalAnswer {
        word-wrap: break-word;
        background: #e9cbf1cb;
        padding: 10px;
        border-radius: 8px;
    }

    #modalQuery_Status {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 5px;
    }
</style>

<main class="content">
    <div class="Wrapper">
        <div class="Nav-Bar container-fluid d-flex flex-wrap justify-content-center align-items-center gap-3 mb-4 p-3">
            <button onclick="window.location.href = 'E_Query_&_Answer_Control.php'" class="btn">Back</button>
            <button id="active-tab" class="btn active">Stream Based Answers</button>
            <button id="inactive-tab" class="btn">Expert Based Answers</button>
        </div>
        <div id="active-content" class="content-section fade-in">

            <?php
            if ($Connection) {

                $Stream_ID = [];
                $Select_Expert_Streams_Query = "SELECT `Stream_ID` FROM `Expert_Streams` WHERE Expert_ID = ?";
                $Select_Expert_Streams_Query_SQL = $Connection->prepare($Select_Expert_Streams_Query);
                $Select_Expert_Streams_Query_SQL->bind_param("s", $Expert_ID);
                $Select_Expert_Streams_Query_SQL->execute();
                $Stream_ID_Result = $Select_Expert_Streams_Query_SQL->get_result();
                while ($Stream_ID_Row = $Stream_ID_Result->fetch_assoc()) {
                    $Stream_ID[] = htmlspecialchars($Stream_ID_Row['Stream_ID'], ENT_QUOTES, 'UTF-8');
                }

                $T1_Limit = 5;

                if (!isset($_SESSION['T1_Limit']) || $_SESSION['T1_Limit'] != $T1_Limit) {
                    $_SESSION['T1_Limit'] = $T1_Limit;
                    $_SESSION['T1_AS_Current_Page'] = 1;
                }

                if (isset($_POST['T1_Search'])) {
                    $_SESSION['T1_AS_Current_Page'] = 1;
                }

                if (isset($_POST['T1_Page'])) {
                    $_SESSION['T1_AS_Current_Page'] = $_POST['T1_Page'];
                } elseif (!isset($_SESSION['T1_AS_Current_Page'])) {
                    $_SESSION['T1_AS_Current_Page'] = 1;
                }

                $T1_Page = $_SESSION['T1_AS_Current_Page'];
                $T1_Page = max(1, (int)$T1_Page);
                $T1_Start = ($T1_Page - 1) * $T1_Limit;

                // $T1_Stream_Category = isset($_POST['Stream_Category']) ? htmlspecialchars($_POST['Stream_Category']) : '';
                $T1_Stream          = $_POST['T1_Stream'] ?? '';
                $T1_Query_Title     = $_POST['T1_Query_Title'] ?? '';

                $T1_Search = !empty($T1_Query_Title) || !empty($T1_Stream);

                $T1_Params = [];
                $T1_D_Type = "";

                $Query_Status = "Resolved";
                $Marks = implode(",", array_fill(0, count($Stream_ID), '?'));
                $T1_Where = " WHERE Q.Query_ID LIKE ? AND Q.Stream_ID IN ($Marks) AND Q.Query_Status = ? ";
                $T1_Params[] = "%" . "SQU" . "%";
                foreach ($Stream_ID as $ID) {
                    $T1_Params[] = $ID;
                }
                $T1_Params[] = $Query_Status;
                $T1_D_Type = "ss";

                if ($T1_Search || isset($_POST['T1_Search'])) {
                    if (!empty($T1_Stream)) {
                        $T1_Where .= " AND Q.Stream_ID = ? ";
                        $T1_Params[] = htmlspecialchars($T1_Stream, ENT_QUOTES); // convert & → &amp;
                        $T1_D_Type .= "s";
                    }

                    if (!empty($T1_Query_Title)) {
                        $T1_Where .= " AND Q.Query_Title LIKE ?";
                        $T1_Params[] = "%$T1_Query_Title%";
                        $T1_D_Type .= "s";
                    }
                }

                $T1_Order_Query = " ORDER BY date(Q.Query_Reg_Time) DESC ";

                $T1_Count_Query = "SELECT COUNT(*) AS Total
                        FROM `Query` Q 
                        $T1_Where";
                $T1_Count_Query_SQL = $Connection->prepare($T1_Count_Query);
                $T1_Count_Query_SQL->bind_param($T1_D_Type, ...$T1_Params);
                $T1_Count_Query_SQL->execute();
                $T1_Count_Result = $T1_Count_Query_SQL->get_result();
                $T1_Total_Records = $T1_Count_Result->fetch_array()['Total'];
                $T1_Total_Pages = ceil($T1_Total_Records / $T1_Limit);

                // Pagination
                $T1_Start_Page = max(1, $T1_Page - 2);
                $T1_End_Page = min($T1_Total_Pages, $T1_Start_Page + 3);
                if ($T1_End_Page - $T1_Start_Page < 3) {
                    $T1_Start_Page = max(1, $T1_End_Page - 3);
                }

                $T1_Select_Query = "SELECT Q.*, A.*, S.Stream_Category, S.Stream_Type, S.Stream AS Stream_Name FROM `Query` Q LEFT JOIN `Answer` A ON Q.Query_ID = A.Query_ID LEFT JOIN `Streams` S ON S.Stream_ID = REPLACE(Q.Stream_ID, '&amp;', '&') $T1_Where ";

                $T1_Full_Select_Query = $T1_Select_Query . $T1_Order_Query . "Limit ?, ?";
                $T1_Select_Query_SQL = $Connection->prepare($T1_Full_Select_Query);
                $T1_Full_D_Type = $T1_D_Type . "ii";
                $T1_Full_Params = array_merge($T1_Params, [$T1_Start, $T1_Limit]);
                $T1_Select_Query_SQL->bind_param($T1_Full_D_Type, ...$T1_Full_Params);
                $T1_Select_Query_SQL->execute();
                $T1_Result = $T1_Select_Query_SQL->get_result();
            }
            ?>

            <div class="Header">
                <h1 class="text-center py-4">Answers By Streams</h1>
            </div>
            <div class="Search p-2 mb-3">
                <form action="" method="post" novalidate class="container py-4">
                    <!-- <input type="hidden" name="Page" value="<?php echo $T1_Page; ?>"> -->
                    <div class="row g-md-5 d-flex justify-content-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="T1_Stream" class="form-label ms-2">Stream :</label>
                            <div class="form-group">
                                <select class="form-select" name="T1_Stream" id="T1_Stream">
                                    <option value="">--Select The Stream--</option>
                                    <?php
                                    if ($Connection) {
                                        $Select_Stream_Query = "SELECT DISTINCT 
                                                                    REPLACE(Q.Stream_ID, '&amp;', '&') AS Stream_ID,
                                                                    S.Stream
                                                                FROM `Query` Q
                                                                LEFT JOIN Streams S 
                                                                    ON S.Stream_ID = REPLACE(Q.Stream_ID, '&amp;', '&')
                                                                WHERE Q.Seeker_ID = ?
                                                                AND Q.Query_ID LIKE ?
                                                            ";
                                        $Select_Stream_Query_SQL = $Connection->prepare($Select_Stream_Query);
                                        $Select_Stream_Query_SQL->bind_param("ss", $Seeker_ID, $SQU_ID);
                                        $SQU_ID = "%SQU%";
                                        $Select_Stream_Query_SQL->execute();
                                        $Stream_Result = $Select_Stream_Query_SQL->get_result();
                                        while ($Stream_Row = $Stream_Result->fetch_assoc()) {
                                    ?>
                                            <option value="<?= htmlspecialchars($Stream_Row['Stream_ID'], ENT_QUOTES, 'UTF-8') ?>"
                                                <?= ($T1_Stream == $Stream_Row['Stream_ID']) ? "selected" : "" ?>>
                                                <?= htmlspecialchars($Stream_Row['Stream']) ?>
                                            </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="T1_Query_Title" class="form-label ms-2">Query Title :</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="T1_Query_Title" id="T1_Query_Title" placeholder="Enter The Query Title" value="<?= $T1_Query_Title ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 g-md-5 pt-2">
                        <div class="text-center">
                            <button class="btn m-2" name="T1_Search" type="submit">Search</button>
                            <button class="btn m-2" name="Re-Set" type="button" onclick="Form_Reset()">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle w-100">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">S No</th>
                                <th scope="col">Reg Date</th>
                                <th scope="col">Stream </th>
                                <th scope="col">Query ID</th>
                                <th scope="col">Answer ID</th>
                                <th scope="col">Query Ref</th>
                                <th scope="col">Answer Ref</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($T1_Result->num_rows > 0) {
                                $T1_Serial_No = $T1_Start + 1;
                                while ($T1_Row = $T1_Result->fetch_assoc()) {
                                    $T1_Reg_Date = date("d-m-Y", strtotime($T1_Row['Query_Reg_Time']));
                                    $T1_Query_Title = html_entity_decode($T1_Row['Query_Title'], ENT_QUOTES, 'UTF-8');
                                    $T1_Answer_Title = html_entity_decode($T1_Row['Answer_Title'], ENT_QUOTES, 'UTF-8');
                                    // $T1_Query = htmlspecialchars($T1_Row['Query'], ENT_QUOTES, 'UTF-8');
                                    echo "<tr class='text-center'>";
                                    echo "<td scope='row' class = 'text-center'> {$T1_Serial_No} </td>";
                                    echo "<td scope='row'> {$T1_Reg_Date} </td>";
                                    echo "<td scope='row'> {$T1_Row["Stream_Name"]} </td>";
                                    echo "<td scope='row'> {$T1_Query_Title} </td>";
                                    echo "<td scope='row'> {$T1_Answer_Title} </td>";
                                    echo "<td scope='row'>
                                            <div class='d-flex justify-content-center align-items-center gap-2 flex-nowrap'>
                                                <button type='button' class='btn view-btn view-more-query-btn mb-1'
                                                data-bs-toggle='modal'
                                                data-bs-target='#viewMoreQueryModal'
                                                data-ID='{$T1_Row['Query_ID']}'
                                                data-Stream_ID='{$T1_Row['Stream_ID']}'
                                                data-Stream='{$T1_Row['Stream_Name']}'
                                                data-Query_Title='{$T1_Query_Title}'
                                                data-Query='{$T1_Row['Query']}'
                                                data-Query_Status='{$T1_Row['Query_Status']}'>
                                                <i class='fa-solid fa-eye'></i>
                                                </button>
                                                <button type='button' class='btn view-btn view-qdoc-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewQueryDocumentModal'
                                                data-Doc='" . $T1_Row['Query_Doc'] . "'>
                                                <i class='fa-solid fa-file'></i>
                                                </button>
                                            </div>
                                        </td>";
                                    echo "<td scope='row'>
                                            <div class='d-flex justify-content-center align-items-center gap-2 flex-nowrap'>
                                                <button type='button' class='btn view-btn view-more-answer-btn mb-1'
                                                    data-bs-toggle='modal'
                                                    data-bs-target='#viewMoreAnswerModal'
                                                    data-Answer_ID='{$T1_Row['Answer_ID']}'
                                                    data-Query_ID='{$T1_Row['Query_ID']}'
                                                    data-AExpert_ID='{$T1_Row['Expert_ID']}'
                                                    data-AStream_ID='{$T1_Row['Stream_ID']}'
                                                    data-AStream='{$T1_Row['Stream_Name']}'
                                                    data-Answer_Title='{$T1_Answer_Title}'
                                                    data-Answer='{$T1_Row['Answer']}'>
                                                    <i class='fa-solid fa-eye'></i>
                                                </button>
                                                <button type='button' class='btn view-btn view-adoc-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewAnswerDocumentModal'
                                                    data-ADoc='" . $T1_Row['Answer_Doc'] . "'>
                                                    <i class='fa-solid fa-file'></i>
                                                </button>
                                            </div>
                                        </td>";
                                    echo "</tr>";
                                    $T1_Serial_No++;
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center text-muted'>No records available at the moment.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Smart Pagination (Always show 4 pages) -->
            <?php if ($T1_Total_Pages > 1): ?>
                <nav aria-label=" Page navigation">
                    <ul class="pagination d-flex justify-content-center align-items-center">
                        <!-- Previous Button -->
                        <?php if ($T1_Page > 1): ?>
                            <li class="page-item">
                                <form method="post" class="pagination-form">
                                    <input type="hidden" name="T1_Page" value="<?php echo $T1_Page - 1; ?>">
                                    <input type="hidden" name="T1_Stream" value="<?php echo $T1_Stream; ?>">
                                    <input type="hidden" name="T1_Query_Title" value="<?php echo $T1_Query_Title; ?>">
                                    <button type="submit" class="page-link">
                                        <i class="fa fa-chevron-left"></i> Previous
                                    </button>
                                </form>
                            </li>
                        <?php endif; ?>

                        <!-- Page Numbers (Always show 4 pages) -->
                        <?php for ($T1_i = $T1_Start_Page; $T1_i <= $T1_End_Page; $T1_i++): ?>
                            <li class="page-item <?php echo ($i == $T1_Page) ? 'active' : ''; ?>">
                                <form method="post" class="pagination-form">
                                    <input type="hidden" name="T1_Page" value="<?php echo $T1_i; ?>">
                                    <input type="hidden" name="T1_Stream" value="<?php echo $T1_Stream; ?>">
                                    <input type="hidden" name="T1_Query_Title" value="<?php echo $T1_Query_Title; ?>">
                                    <button type="submit" class="page-link"><?php echo $T1_i; ?></button>
                                </form>
                            </li>
                        <?php endfor; ?>

                        <!-- Next Button -->
                        <?php if ($T1_Page < $T1_Total_Pages): ?>
                            <li class="page-item">
                                <form method="post" class="pagination-form">
                                    <input type="hidden" name="T1_Page" value="<?php echo $T1_Page + 1; ?>">
                                    <input type="hidden" name="T1_Stream" value="<?php echo $T1_Stream; ?>">
                                    <input type="hidden" name="T1_Query_Title" value="<?php echo $T1_Query_Title; ?>">
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
                <p>Showing <?php echo ($T1_Start + 1); ?> to <?php echo min($T1_Start + $T1_Limit, $T1_Total_Records); ?> of <?php echo $T1_Total_Records; ?> entries</p>
            </div>
        </div>


        <!-- Second Table -->
        <div id="inactive-content" class="content-section" style="display:none;">
            <?php
            if ($Connection) {

                $T2_Limit = 5;

                if (!isset($_SESSION['T2_Limit']) || $_SESSION['T2_Limit'] != $T2_Limit) {
                    $_SESSION['T2_Limit'] = $T2_Limit;
                    $_SESSION['T2_AS_Current_Page'] = 1;
                }

                if (isset($_POST['T2_Search'])) {
                    $_SESSION['T2_AS_Current_Page'] = 1;
                }

                if (isset($_POST['T2_Page'])) {
                    $_SESSION['T2_AS_Current_Page'] = $_POST['T2_Page'];
                } elseif (!isset($_SESSION['T2_AS_Current_Page'])) {
                    $_SESSION['T2_AS_Current_Page'] = 1;
                }

                $T2_Page = $_SESSION['T2_AS_Current_Page'];
                $T2_Page = max(1, (int)$T2_Page);
                $T2_Start = ($T2_Page - 1) * $T2_Limit;

                // $T2_Stream_Category = isset($_POST['Stream_Category']) ? htmlspecialchars($_POST['Stream_Category']) : '';
                $T2_Stream             = $_POST['T2_Stream'] ?? '';
                $T2_Query_Title        = $_POST['T2_Query_Title'] ?? '';

                $T2_Search = !empty($T2_Stream) || !empty($T2_Query_Title);

                $T2_Params = [];
                $T2_D_Type = "";

                $T2_Where = " WHERE Q.Query_ID LIKE ? AND Q.Seeker_ID = ? AND Q.Query_Status = ? ";
                $T2_Params[] = "%" . "EQU" . "%";
                $T2_Params[] = $Seeker_ID;
                $T2_Params[] = "Resolved";
                $T2_D_Type = "sss";

                if ($T2_Search || isset($_POST['T2_Search'])) {
                    if (!empty($T2_Stream)) {
                        $T2_Where .= " AND Q.Stream_ID LIKE ? ";
                        $T2_Params[] = "%" . htmlspecialchars($T2_Stream) . "%";
                        $T2_D_Type .= "s";
                    }

                    if (!empty($T2_Query_Title)) {
                        $T2_Where .= " AND Q.Query_Title LIKE ?";
                        $T2_Params[] = "%$T2_Query_Title%";
                        $T2_D_Type .= "s";
                    }
                }

                $T2_Order_Query = " ORDER BY date(Q.Query_Reg_Time) DESC ";

                $T2_Count_Query = "SELECT COUNT(*) AS Total
                        FROM Query Q 
                        $T2_Where";
                $T2_Count_Query_SQL = $Connection->prepare($T2_Count_Query);
                $T2_Count_Query_SQL->bind_param($T2_D_Type, ...$T2_Params);
                $T2_Count_Query_SQL->execute();
                $T2_Count_Result = $T2_Count_Query_SQL->get_result();
                $T2_Total_Records = $T2_Count_Result->fetch_array()['Total'];
                $T2_Total_Pages = ceil($T2_Total_Records / $T2_Limit);

                // Pagination
                $T2_Start_Page = max(1, $T2_Page - 2);
                $T2_End_Page = min($T2_Total_Pages, $T2_Start_Page + 3);
                if ($T2_End_Page - $T2_Start_Page < 3) {
                    $T2_Start_Page = max(1, $T2_End_Page - 3);
                }

                $T2_Select_Query = "SELECT Q.*, A.*, S.Stream_Category, S.Stream_Type, S.Stream AS Stream_Name FROM `Query` Q LEFT JOIN `Answer` A ON Q.Query_ID = A.Query_ID LEFT JOIN Streams S ON S.Stream_ID = REPLACE(Q.Stream_ID, '&amp;', '&') $T2_Where ";

                $T2_Full_Select_Query = $T2_Select_Query . $T2_Order_Query . "Limit ?, ?";
                $T2_Select_Query_SQL = $Connection->prepare($T2_Full_Select_Query);
                $T2_Full_D_Type = $T2_D_Type . "ii";
                $T2_Full_Params = array_merge($T2_Params, [$T2_Start, $T2_Limit]);
                $T2_Select_Query_SQL->bind_param($T2_Full_D_Type, ...$T2_Full_Params);
                $T2_Select_Query_SQL->execute();
                $T2_Result = $T2_Select_Query_SQL->get_result();
            }
            ?>

            <div class="Header">
                <h1 class="text-center py-4">Answers By Experts</h1>
            </div>
            <div class="Search p-2 mb-3">
                <form action="" method="post" novalidate class="container py-4">
                    <!-- <input type="hidden" name="Page" value="<?php echo $T2_Page; ?>"> -->
                    <div class="row g-md-5 d-flex justify-content-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="T2_Stream" class="form-label ms-2">Stream :</label>
                            <div class="form-group">
                                <select class="form-select" name="T2_Stream" id="T2_Stream">
                                    <option value="">--Select The Stream--</option>
                                    <?php
                                    if ($Connection) {
                                        $Select_Stream_Query = "SELECT DISTINCT 
                                                                    REPLACE(Q.Stream_ID, '&amp;', '&') AS Stream_ID,
                                                                    S.Stream
                                                                FROM `Query` Q
                                                                LEFT JOIN Streams S 
                                                                    ON S.Stream_ID = REPLACE(Q.Stream_ID, '&amp;', '&')
                                                                WHERE Q.Seeker_ID = ?
                                                                AND Q.Query_ID LIKE ?
                                                            ";
                                        $Select_Stream_Query_SQL = $Connection->prepare($Select_Stream_Query);
                                        $Select_Stream_Query_SQL->bind_param("ss", $Seeker_ID, $SQU_ID);
                                        $SQU_ID = "%EQU%";
                                        $Select_Stream_Query_SQL->execute();
                                        $Stream_Result = $Select_Stream_Query_SQL->get_result();
                                        while ($Stream_Row = $Stream_Result->fetch_assoc()) {
                                    ?>
                                            <option value="<?= htmlspecialchars($Stream_Row['Stream_ID'], ENT_QUOTES, 'UTF-8') ?>"
                                                <?= ($T2_Stream == $Stream_Row['Stream_ID']) ? "selected" : "" ?>>
                                                <?= htmlspecialchars($Stream_Row['Stream']) ?>
                                            </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="T2_Query_Title" class="form-label ms-2">Query Title :</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="T2_Query_Title" id="T2_Query_Title" placeholder="Enter The Query Title" value="<?= $T2_Query_Title ?>" autocomplete="off">

                            </div>
                        </div>
                    </div>
                    <div class="row g-3 g-md-5 pt-2">
                        <div class="text-center">
                            <button class="btn m-2" name="T2_Search" type="submit">Search</button>
                            <button class="btn m-2" name="Re-Set" type="button" onclick="Form_Reset()">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered w-100">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">S No</th>
                                <th scope="col">Reg Date</th>
                                <th scope="col">Stream </th>
                                <th scope="col">Query ID</th>
                                <th scope="col">Answer ID</th>
                                <th scope="col">Query Ref</th>
                                <th scope="col">Answer Ref</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($T2_Result->num_rows > 0) {
                                $T2_Serial_No = $T2_Start + 1;
                                while ($T2_Row = $T2_Result->fetch_assoc()) {
                                    $T2_Reg_Date = date("d-m-Y", strtotime($T2_Row['Query_Reg_Time']));
                                    $T2_Query_Title = html_entity_decode($T2_Row['Query_Title'], ENT_QUOTES, 'UTF-8');
                                    $T2_Answer_Title = html_entity_decode($T2_Row['Answer_Title'], ENT_QUOTES, 'UTF-8');
                                    // $T2_Query = htmlspecialchars($T2_Row['Query'], ENT_QUOTES, 'UTF-8');
                                    echo "<tr class='text-center'>";
                                    echo "<td scope='row' class = 'text-center'> {$T2_Serial_No} </td>";
                                    echo "<td scope='row'> {$T2_Reg_Date} </td>";
                                    echo "<td scope='row'> {$T2_Row["Stream_Name"]} </td>";
                                    echo "<td scope='row'> {$T2_Query_Title} </td>";
                                    echo "<td scope='row'> {$T2_Answer_Title} </td>";
                                    echo "<td scope='row'>
                                            <div class='d-flex justify-content-center align-items-center gap-2 flex-nowrap'>
                                                <button type='button' class='btn view-btn view-more-query-btn mb-1' data-bs-toggle='modal' data-bs-target='#viewMoreQueryModal'
                                                    data-ID='{$T2_Row['Query_ID']}'
                                                    data-Expert_ID='{$T2_Row['Expert_ID']}'
                                                    data-Stream_ID='{$T2_Row['Stream_ID']}'
                                                    data-Stream='{$T2_Row['Stream_Name']}'
                                                    data-Query_Title='{$T2_Query_Title}'
                                                    data-Query='{$T2_Row['Query']}'
                                                    data-Query_Status='{$T2_Row['Query_Status']}'>
                                                    <i class='fa-solid fa-eye'></i>
                                                </button>
                                                <button type='button' class='btn view-btn view-qdoc-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewQueryDocumentModal'
                                                    data-Doc='" . $T2_Row['Query_Doc'] . "'>
                                                    <i class='fa-solid fa-file'></i>
                                                </button>
                                            </div>
                                        </td>";
                                    echo "<td scope='row'>
                                            <div class='d-flex justify-content-center align-items-center gap-2 flex-nowrap'>
                                                <button type='button' class='btn view-btn view-more-answer-btn mb-1'
                                                    data-bs-toggle='modal'
                                                    data-bs-target='#viewMoreAnswerModal'
                                                    data-Answer_ID='{$T2_Row['Answer_ID']}'
                                                    data-Query_ID='{$T2_Row['Query_ID']}'
                                                    data-AExpert_ID='{$T2_Row['Expert_ID']}'
                                                    data-AStream_ID='{$T2_Row['Stream_ID']}'
                                                    data-AStream='{$T2_Row['Stream_Name']}'
                                                    data-Answer_Title='{$T2_Answer_Title}'
                                                    data-Answer='{$T2_Row['Answer']}'>
                                                    <i class='fa-solid fa-eye'></i>
                                                </button>
                                                <button type='button' class='btn view-btn view-adoc-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewAnswerDocumentModal'
                                                    data-ADoc='" . $T2_Row['Answer_Doc'] . "'>
                                                    <i class='fa-solid fa-file'></i>
                                                </button>
                                            </div>
                                    </td>";
                                    echo "</tr>";
                                    $T2_Serial_No++;
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center text-muted'>No records available at the moment.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Smart Pagination (Always show 4 pages) -->
            <?php if ($T2_Total_Pages > 1): ?>
                <nav aria-label=" Page navigation">
                    <ul class="pagination d-flex justify-content-center align-items-center">
                        <!-- Previous Button -->
                        <?php if ($T2_Page > 1): ?>
                            <li class="page-item">
                                <form method="post" class="pagination-form">
                                    <input type="hidden" name="T2_Page" value="<?php echo $T2_Page - 1; ?>">
                                    <input type="hidden" name="T2_Stream" value="<?php echo $T2_Stream; ?>">
                                    <input type="hidden" name="T2_Query_Title" value="<?php echo $T2_Query_Title; ?>">
                                    <button type="submit" class="page-link">
                                        <i class="fa fa-chevron-left"></i> Previous
                                    </button>
                                </form>
                            </li>
                        <?php endif; ?>

                        <!-- Page Numbers (Always show 4 pages) -->
                        <?php for ($T2_i = $T2_Start_Page; $T2_i <= $T2_End_Page; $T2_i++): ?>
                            <li class="page-item <?php echo ($T2_i == $T2_Page) ? 'active' : ''; ?>">
                                <form method="post" class="pagination-form">
                                    <input type="hidden" name="T2_Page" value="<?php echo $T2_i; ?>">
                                    <input type="hidden" name="T2_Stream" value="<?php echo $T2_Stream; ?>">
                                    <input type="hidden" name="T2_Query_Title" value="<?php echo $T2_Query_Title; ?>">
                                    <button type="submit" class="page-link"><?php echo $T2_i; ?></button>
                                </form>
                            </li>
                        <?php endfor; ?>

                        <!-- Next Button -->
                        <?php if ($T2_Page < $T2_Total_Pages): ?>
                            <li class="page-item">
                                <form method="post" class="pagination-form">
                                    <input type="hidden" name="T2_Page" value="<?php echo $T2_Page + 1; ?>">
                                    <input type="hidden" name="T2_Stream" value="<?php echo $T2_Stream; ?>">
                                    <input type="hidden" name="T2_Query_Title" value="<?php echo $T2_Query_Title; ?>">
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
                <p>Showing <?php echo ($T2_Start + 1); ?> to <?php echo min($T2_Start + $T2_Limit, $T2_Total_Records); ?> of <?php echo $T2_Total_Records; ?> entries</p>
            </div>
        </div>

    </div>
</main>
</div>
</div>


<!-- Re-Set -->

<script>
    function Form_Reset() {
        window.location.href = 'E_My_Q_And_A.php';
    }
</script>

<!-- Query -->

<!-- View Modal -->

<div class="modal fade" id="viewMoreQueryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewMoreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bold" id="viewMoreModalLabel">
                    Query Details
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Details Section -->
                <div class="mb-2">
                    <h6><strong>Query ID:</strong> <span id="modalID"></span></h6>
                    <h6 id="Expert_Row" style="display:none;"><strong>Expert ID:</strong> <span id="modalExpert_ID"></span></h6>
                    <h6><strong>Stream ID:</strong> <span id="modalStream_ID"></span></h6>
                    <h6><strong>Stream:</strong> <span id="modalStream_Name"></span></h6>
                    <h6><strong>Query Title:</strong> <span id="modalQuery_Title"></span></h6>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <h6><strong>Query:</strong></h6>
                    <p id="modalQuery"></p>
                </div>

                <!-- Tags -->
                <div>
                    <h6><strong>Query Status:</strong></h6>
                    <p id="modalQuery_Status" class="d-flex flex-wrap gap-2"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.view-more-query-btn').forEach(button => {
        button.addEventListener('click', function() {

            document.getElementById('modalID').textContent = this.getAttribute('data-ID');
            const Expert_ID = this.getAttribute('data-Expert_ID')
            if (Expert_ID !== null && Expert_ID !== "") {
                document.getElementById('modalExpert_ID').textContent = Expert_ID;
            }
            document.getElementById('modalStream_ID').textContent = this.getAttribute('data-Stream_ID');
            document.getElementById('modalStream_Name').textContent = this.getAttribute('data-Stream');
            document.getElementById('modalQuery_Title').textContent = this.getAttribute('data-Query_Title');
            // Assign the raw DB value to a JS variable safely
            const query = this.getAttribute('data-Query');

            // Decode HTML entities
            function decodeHtmlEntities(str) {
                const txt = document.createElement('textarea');
                txt.innerHTML = str;
                return txt.value;
            }

            // Replace literal \n (if any) with actual newlines
            const formattedQuery = decodeHtmlEntities(query).replace(/\\n/g, ' ');

            // Insert into the modal and convert newlines to <br>
            document.getElementById('modalQuery').innerHTML = formattedQuery.replace(/\n/g, '<br>');
            // document.getElementById('modalQuery').textContent = this.getAttribute('data-Query');
            // // 1. Read raw data from the attribute
            // const rawQuery = this.dataset.query;

            // // 2. Convert line breaks to visible HTML
            // const formattedQuery = rawQuery.replace(/\r?\n/g, '<br>');

            // // 3. Inject into the modal paragraph
            // document.getElementById('modalQuery').innerHTML = formattedQuery;
            document.getElementById('modalQuery_Status').textContent = this.getAttribute('data-Query_Status');

            // Conditional Expert ID
            const expertRow = document.getElementById('Expert_Row');
            const expertID = this.dataset.expert_id;

            if (expertID && expertID.trim() !== "") {
                document.getElementById('modalExpert_ID').textContent = expertID;
                expertRow.style.display = "block";
            } else {
                expertRow.style.display = "none";
            }
        });
    });
</script>


<!-- View Resume Modal -->
<div class="modal fade" id="viewQueryDocumentModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="viewQueryDocumentModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg">

            <!-- Header -->
            <div class="modal-header bg-light">
                <h1 class="modal-title fw-bold" id="viewQueryDocumentModalLabel">
                    Query Reference File
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-4 fs-5">

                <!-- SECTION -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Query Reference File</h5>
                    <div class="text-center d-flex justify-content-center">
                        <iframe id="modalDoc"
                            src=""
                            class="w-100 rounded shadow-sm"
                            style="height: 500px; display: none;"
                            frameborder="0">
                        </iframe>

                        <img id="modalDoc_Img"
                            class="img-fluid rounded shadow-sm"
                            style="max-height: 1500px; display: none;"
                            alt="Query Reference Image">
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
    document.querySelectorAll('.view-qdoc-btn').forEach(button => {
        button.addEventListener('click', function() {

            let file = this.getAttribute('data-Doc');

            if (!file) return;

            file = file.trim().replace(/^["']|["']$/g, '');

            const basePath = 'Expert_Cluster_Official_Images/Query_Doc/';
            const fullPath = basePath + file;

            const iframe = document.getElementById('modalDoc');
            const img = document.getElementById('modalDoc_Img');

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


<!-- Answer -->


<!-- View Modal -->

<div class="modal fade" id="viewMoreAnswerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewMoreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bold" id="viewMoreModalLabel">Answer Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Details Section -->
                <div class="mb-2">
                    <h6><strong>Answer ID:</strong> <span id="modalAnswer_ID"></span></h6>
                    <h6><strong>Query ID:</strong> <span id="modalQuery_ID"></span></h6>
                    <h6><strong>Expert ID:</strong> <span id="modalAExpert_ID"></span></h6>
                    <h6><strong>Stream ID:</strong> <span id="modalAStream_ID"></span></h6>
                    <h6><strong>Stream:</strong> <span id="modalAStream_Name"></span></h6>
                    <h6><strong>Answer Title:</strong> <span id="modalAnswer_Title"></span></h6>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <h6><strong>Answer:</strong></h6>
                    <p id="modalAnswer"></p>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.view-more-answer-btn').forEach(button => {
        button.addEventListener('click', function() {

            document.getElementById('modalAnswer_ID').textContent = this.getAttribute('data-Answer_ID');
            document.getElementById('modalQuery_ID').textContent = this.getAttribute('data-Query_ID');
            document.getElementById('modalAExpert_ID').textContent = this.getAttribute('data-AExpert_ID');
            document.getElementById('modalAStream_ID').textContent = this.getAttribute('data-AStream_ID');
            document.getElementById('modalAStream_Name').textContent = this.getAttribute('data-AStream');
            document.getElementById('modalAnswer_Title').textContent = this.getAttribute('data-Answer_Title');
            // Assign the raw DB value to a JS variable safely
            const Answer = this.getAttribute('data-Answer');

            // Decode HTML entities
            function decodeHtmlEntities(str) {
                const txt = document.createElement('textarea');
                txt.innerHTML = str;
                return txt.value;
            }

            const formattedAnswer = decodeHtmlEntities(Answer).replace(/\\n/g, ' ');

            document.getElementById('modalAnswer').innerHTML = formattedAnswer.replace(/\n/g, '<br>');
        });
    });
</script>


<!-- View Resume Modal -->
<div class="modal fade" id="viewAnswerDocumentModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="viewAnswerDocumentModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg">

            <!-- Header -->
            <div class="modal-header bg-light">
                <h1 class="modal-title fw-bold" id="viewAnswerDocumentModalLabel">
                    Answer Reference File
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-4 fs-5">

                <!-- SECTION -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Answer Reference File</h5>
                    <div class="text-center d-flex justify-content-center">
                        <iframe id="modalADoc"
                            src=""
                            class="w-100 rounded shadow-sm"
                            style="height: 500px; display: none;"
                            frameborder="0">
                        </iframe>

                        <img id="modalADoc_Img"
                            class="img-fluid rounded shadow-sm"
                            style="max-height: 1500px; display: none;"
                            alt="Answer Reference Image">
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
    document.querySelectorAll('.view-adoc-btn').forEach(button => {
        button.addEventListener('click', function() {

            let file = this.getAttribute('data-ADoc');

            if (!file) return;

            file = file.trim().replace(/^["']|["']$/g, '');

            const basePath = 'Expert_Cluster_Official_Images/Answer_Doc/';
            const fullPath = basePath + file;

            const iframe = document.getElementById('modalADoc');
            const img = document.getElementById('modalADoc_Img');

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Tab switching functionality
    // Tab switching functionality with session storage
    document.addEventListener('DOMContentLoaded', function() {
        const activeTab = document.getElementById('active-tab');
        const inactiveTab = document.getElementById('inactive-tab');
        const activeContent = document.getElementById('active-content');
        const inactiveContent = document.getElementById('inactive-content');

        // Check session storage for active tab
        const activeTabState = sessionStorage.getItem('activeTab') || 'active';

        // Set initial state based on session storage
        if (activeTabState === 'inactive') {
            activeContent.style.display = 'none';
            inactiveContent.style.display = 'block';
            activeTab.classList.remove('active');
            inactiveTab.classList.add('active');
        } else {
            activeContent.style.display = 'block';
            inactiveContent.style.display = 'none';
            activeTab.classList.add('active');
            inactiveTab.classList.remove('active');
        }

        activeTab.addEventListener('click', function() {
            activeContent.style.display = 'block';
            inactiveContent.style.display = 'none';
            activeTab.classList.add('active');
            inactiveTab.classList.remove('active');
            sessionStorage.setItem('activeTab', 'active');
        });

        inactiveTab.addEventListener('click', function() {
            activeContent.style.display = 'none';
            inactiveContent.style.display = 'block';
            inactiveTab.classList.add('active');
            activeTab.classList.remove('active');
            sessionStorage.setItem('activeTab', 'inactive');
        });
    });
</script>