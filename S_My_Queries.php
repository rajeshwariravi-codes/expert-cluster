<?php
include './Database.php';
include './Seeker_Dashboard.php';
?>

<link rel="stylesheet" href="./Table.css">

<main class="content">
    <div class="Wrapper">
        <div class="Nav-Bar container-fluid d-flex flex-wrap justify-content-center align-items-center gap-3 mb-4 p-3">
            <button onclick="window.location.href = 'S_Query_&_Answer_Control.php'" class="btn">Back</button>
            <button id="active-tab" class="btn active">Stream Based Queries</button>
            <button id="inactive-tab" class="btn">Expert Based Queries</button>
        </div>
        <div id="active-content" class="content-section fade-in">

            <?php
            if ($Connection) {

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
                $T1_Query_Status    = $_POST['T1_Query_Status'] ?? '';
                $T1_Query_Title     = $_POST['T1_Query_Title'] ?? '';

                $T1_Search = !empty($T1_Query_Status) || !empty($T1_Query_Title) || !empty($T1_Stream);

                $T1_Params = [];
                $T1_D_Type = "";

                $T1_Where = " WHERE Q.Query_ID LIKE ? AND Q.Seeker_ID = ? ";
                $T1_Params[] = "%" . "SQU" . "%";
                $T1_Params[] = $Seeker_ID;
                $T1_D_Type = "ss";

                if ($T1_Search || isset($_POST['T1_Search'])) {
                    if (!empty($T1_Stream)) {
                        $T1_Where .= " AND Q.Stream_ID = ? ";
                        $T1_Params[] = htmlspecialchars($T1_Stream, ENT_QUOTES); // convert & → &amp;
                        $T1_D_Type .= "s";
                    }

                    if (!empty($T1_Query_Status)) {
                        $T1_Where .= " AND Q.Query_Status LIKE ? ";
                        $T1_Params[] = "%" . htmlspecialchars($T1_Query_Status) . "%";
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

                $T1_Select_Query = "SELECT Q.Query_ID, Q.Query_Reg_Time, Q.Seeker_ID, Q.Stream_ID, Q.Query_Title, Q.Query, Q.Query_Doc, Q.Query_Status, S.Stream_Category, S.Stream_Type, S.Stream AS Stream_Name FROM `Query` Q LEFT JOIN Streams S ON S.Stream_ID = REPLACE(Q.Stream_ID, '&amp;', '&') $T1_Where ";

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
                <h1 class="text-center py-4">Queries By Streams</h1>
            </div>
            <div class="Search mb-3">
                <form action="" method="post" novalidate class="container py-3">
                    <!-- <input type="hidden" name="Page" value="<?php echo $T1_Page; ?>"> -->
                    <div class="row d-flex justify-content-center">
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
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="T1_Query_Status" class="form-label ms-2">Query Status :</label>
                            <div class="form-group">
                                <select class="form-select" name="T1_Query_Status" id="T1_Query_Status">
                                    <option value="">--Select The Query Status--</option>
                                    <option value="Pending" <?= ($T1_Query_Status === 'Pending') ? "Selected" : "" ?>>Pending</option>
                                    <option value="Resolved" <?= ($T1_Query_Status === 'Resolved') ? "Selected" : "" ?>>Resolved</option>
                                </select>
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
                                <th scope="col">Query Title</th>
                                <th scope="col">Reference</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($T1_Result->num_rows > 0) {
                                $T1_Serial_No = $T1_Start + 1;
                                while ($T1_Row = $T1_Result->fetch_assoc()) {
                                    $T1_Reg_Date = date("d-m-Y", strtotime($T1_Row['Query_Reg_Time']));
                                    $T1_Query_Title = html_entity_decode($T1_Row['Query_Title'], ENT_QUOTES, 'UTF-8');
                                    // $T1_Query = htmlspecialchars($T1_Row['Query'], ENT_QUOTES, 'UTF-8');
                                    echo "<tr class = 'text-center'>";
                                    echo "<td scope='row'> {$T1_Serial_No} </td>";
                                    echo "<td scope='row'> {$T1_Reg_Date} </td>";
                                    echo "<td scope='row'> {$T1_Row["Stream_Name"]} </td>";
                                    echo "<td scope='row'> {$T1_Query_Title} </td>";
                                    echo "<td scope='row'>
                                            <div class='d-flex justify-content-center align-items-center gap-2 flex-nowrap'>
                                                <button type='button' class='btn view-btn view-more-stream-btn mb-1'
                                                    data-bs-toggle='modal'
                                                    data-bs-target='#viewMoreStreamModal'
                                                    data-ID='{$T1_Row['Query_ID']}'
                                                    data-Stream_ID='{$T1_Row['Stream_ID']}'
                                                    data-Stream='{$T1_Row['Stream_Name']}'
                                                    data-Query_Title='{$T1_Query_Title}'
                                                    data-Query='{$T1_Row['Query']}'
                                                    data-Query_Status='{$T1_Row['Query_Status']}'>
                                                    <i class='fa-solid fa-eye'></i>
                                                </button>
                                                <button type='button' class='btn view-btn view-Doc-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewDocumentModal'
                                                    data-Doc='" . $T1_Row['Query_Doc'] . "'>
                                                    <i class='fa-solid fa-file'></i>
                                                </button>
                                            </div>
                                        </td>";
                                    echo "</tr>";
                                    $T1_Serial_No++;
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-muted'>No records available at the moment.</td></tr>";
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
                                    <input type="hidden" name="T1_Query_Status" value="<?php echo $T1_Query_Status; ?>">
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
                                    <input type="hidden" name="T1_Query_Status" value="<?php echo $T1_Query_Status; ?>">
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
                                    <input type="hidden" name="T1_Query_Status" value="<?php echo $T1_Query_Status; ?>">
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
                $T2_Query_Status       = $_POST['T2_Query_Status'] ?? '';
                $T2_Query_Title        = $_POST['T2_Query_Title'] ?? '';

                $T2_Search = !empty($T2_Stream) || !empty($T2_Query_Status) || !empty($T2_Query_Title);

                $T2_Params = [];
                $T2_D_Type = "";

                $T2_Where = " WHERE Q.Query_ID LIKE ? AND Q.Seeker_ID = ? ";
                $T2_Params[] = "%" . "EQU" . "%";
                $T2_Params[] = $Seeker_ID;
                $T2_D_Type = "ss";

                if ($T2_Search || isset($_POST['T2_Search'])) {
                    if (!empty($T2_Stream)) {
                        $T2_Where .= " AND Q.Stream_ID LIKE ? ";
                        $T2_Params[] = "%" . htmlspecialchars($T2_Stream) . "%";
                        $T2_D_Type .= "s";
                    }

                    if (!empty($T2_Query_Status)) {
                        $T2_Where .= " AND Q.Query_Status LIKE ? ";
                        $T2_Params[] = "%" . htmlspecialchars($T2_Query_Status) . "%";
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

                $T2_Select_Query = "SELECT Q.Query_ID, Q.Query_Reg_Time, Q.Seeker_ID, Q.Expert_ID, Q.Stream_ID, Q.Query_Title, Q.Query, Q.Query_Doc, Q.Query_Status, S.Stream_Category, S.Stream_Type, S.Stream AS Stream_Name FROM `Query` Q LEFT JOIN Streams S ON S.Stream_ID = REPLACE(Q.Stream_ID, '&amp;', '&') $T2_Where ";

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
                <h1 class="text-center py-4">Queries By Experts</h1>
            </div>
            <div class="Search mb-3">
                <form action="" method="post" novalidate class="container py-3">
                    <!-- <input type="hidden" name="Page" value="<?php echo $T2_Page; ?>"> -->
                    <div class="row d-flex justify-content-center">
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
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="T2_Query_Status" class="form-label ms-2">Query Status :</label>
                            <div class="form-group">
                                <select class="form-select" name="T2_Query_Status" id="T2_Query_Status">
                                    <option value="">--Select The Query Status--</option>
                                    <option value="Pending" <?= ($T2_Query_Status === 'Pending') ? "Selected" : "" ?>>Pending</option>
                                    <option value="Resolved" <?= ($T2_Query_Status === 'Resolved') ? "Selected" : "" ?>>Resolved</option>
                                </select>
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
                                <th scope="col">Expert ID </th>
                                <th scope="col">Stream </th>
                                <th scope="col">Query Title</th>
                                <th scope="col">Reference</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($T2_Result->num_rows > 0) {
                                $T2_Serial_No = $T2_Start + 1;
                                while ($T2_Row = $T2_Result->fetch_assoc()) {
                                    $T2_Reg_Date = date("d-m-Y", strtotime($T2_Row['Query_Reg_Time']));
                                    $T2_Query_Title = html_entity_decode($T2_Row['Query_Title'], ENT_QUOTES, 'UTF-8');
                                    // $T2_Query = htmlspecialchars($T2_Row['Query'], ENT_QUOTES, 'UTF-8');
                                    echo "<tr class = 'text-center'>";
                                    echo "<td scope='row'> {$T2_Serial_No} </td>";
                                    echo "<td scope='row'> {$T2_Reg_Date} </td>";
                                    echo "<td scope='row'> {$T2_Row["Expert_ID"]} </td>";
                                    echo "<td scope='row'> {$T2_Row["Stream_Name"]} </td>";
                                    echo "<td scope='row'> {$T2_Query_Title} </td>";
                                    echo "<td scope='row'>
                                            <div class='d-flex justify-content-center align-items-center gap-2 flex-nowrap'>
                                                <button type='button' class='btn view-btn view-more-stream-btn mb-1' data-bs-toggle='modal' data-bs-target='#viewMoreStreamModal'
                                                    data-ID='{$T2_Row['Query_ID']}'
                                                    data-Expert_ID='{$T2_Row['Expert_ID']}'
                                                    data-Stream_ID='{$T2_Row['Stream_ID']}'
                                                    data-Stream='{$T2_Row['Stream_Name']}'
                                                    data-Query_Title='{$T2_Query_Title}'
                                                    data-Query='{$T2_Row['Query']}'
                                                    data-Query_Status='{$T2_Row['Query_Status']}'>
                                                    <i class='fa-solid fa-eye'></i>
                                                </button>
                                                <button type='button' class='btn view-btn view-Doc-btn mb-1 fs-6' data-bs-toggle='modal' data-bs-target='#viewDocumentModal'
                                                    data-Doc='" . $T2_Row['Query_Doc'] . "'>
                                                    <i class='fa-solid fa-file'></i>
                                                </button>
                                            </div>
                                        </td>";
                                    echo "</tr>";
                                    $T2_Serial_No++;
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center text-muted'>No records available at the moment.</td></tr>";
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
                                    <input type="hidden" name="T2_Query_Status" value="<?php echo $T2_Query_Status; ?>">
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
                                    <input type="hidden" name="T2_Query_Status" value="<?php echo $T2_Query_Status; ?>">
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
                                    <input type="hidden" name="T2_Query_Status" value="<?php echo $T2_Query_Status; ?>">
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
        window.location.href = 'S_My_Queries.php';
    }
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
    document.querySelectorAll('.view-more-stream-btn').forEach(button => {
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
<div class="modal fade" id="viewDocumentModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="viewDocumentModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg">

            <!-- Header -->
            <div class="modal-header bg-light">
                <h1 class="modal-title fw-bold" id="viewDocumentModalLabel">
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
    document.querySelectorAll('.view-Doc-btn').forEach(button => {
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