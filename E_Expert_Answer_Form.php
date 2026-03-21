<?php
include "./Database.php";
include "./Expert_Dashboard.php";
$Query_ID = $_SESSION['Query_ID'];

if ($Connection) {
    $Select_Query = "SELECT * FROM `Query` WHERE Query_ID = ?";
    $Select_Query_SQL = $Connection->prepare($Select_Query);
    $Select_Query_SQL->bind_param("s", $Query_ID);
    $Select_Query_SQL->execute();
    $Result = $Select_Query_SQL->get_result();
    if ($Row = $Result->fetch_assoc()) {
        $Query_Title = $Row['Query_Title'];
        $Query = $Row['Query'];
        $Query_Doc = $Row['Query_Doc'];
    }
}
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Aboreto&family=Big+Shoulders+Stencil:opsz,wght@10..72,100..900&family=Cinzel:wght@400..900&family=Cormorant+Upright:wght@300;400;500;600;700&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Pacifico&family=Text+Me+One&family=Zilla+Slab+Highlight:wght@400;700&display=swap');

    .Wrapper {
        width: 100%;
        max-width: 1500px;
        border-radius: 40px;
        overflow: hidden;
        padding: 20px 0px;
        border-radius: 25px;
        background-color: rgba(36, 33, 36, 0.30);
        color: white;
        border: none;
        box-shadow: 0 10px 30px rgba(73, 11, 89, 0.15);
    }

    .Title {
        font-family: "Josefin Sans";
        font-size: clamp(1.5rem, 2vw, 2.5rem);
        font-weight: 400;
    }

    .Description {
        font-family: "Cormorant Upright";
        font-size: clamp(1.1rem, 1.3vw, 2rem);
        font-weight: 300;
    }

    .Quote::before {
        content: "“";
    }

    .Quote::after {
        content: "”";
    }

    .Bottom a {
        text-decoration: none;
        color: white;
        font-family: "Cinzel";
        font-size: clamp(1rem, 1.5vw, 2rem);
        font-weight: 600;
    }

    .Sub_Container {
        border: 2px solid rgba(232, 212, 237, 0.9);
        border-radius: 20px;
        /* background: rgba(72, 66, 72, 0.3); */
    }

    .Sub_Container h3 {
        font-family: "Josefin Sans";
        font-weight: 400;
    }

    /* Form Style */

    .Form-Wrapper {
        width: 100%;
        max-width: 100%;
    }

    .Form {
        padding: 20px 25px;
    }

    .form-group {
        margin-bottom: 0.8rem;
        position: relative;
    }

    .form-control,
    .form-select,
    .form-control-file {
        border: 2px solid rgba(239, 233, 238, 0.5);
        border-radius: 6px;
        padding: 10px 12px;
        font-family: "Cormorant Upright";
        font-weight: 900;
        font-size: clamp(0.8rem, 1vw, 1.3rem);
        transition: All 0.3s ease;
        background: rgba(0, 0, 0, 0.1);
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        height: 42px;
        width: 100%;
    }

    .form-control:focus,
    .form-control-file:focus {
        color: #ffffffff;
        font-size: clamp(0.8rem, 1.3vw, 1.8rem);
        font-weight: 600;
        border-color: #260523c2;
        box-shadow: 0 0 0 0.2rem rgba(12, 0, 14, 0.25);
        background: rgba(0, 0, 0, 0.1);
    }

    .form-select:focus {
        color: #ffffffff;
        font-weight: 600;
        border-color: #260523c2;
        box-shadow: 0 0 0 0.2rem rgba(12, 0, 14, 0.25);
        background: rgba(0, 0, 0, 0.1);
    }

    input[type="text"]:not(:placeholder-shown),
    input[type="phone"]:not(:placeholder-shown),
    input[type="email"]:not(:placeholder-shown),
    input[type="Password"]:not(:placeholder-shown),
    input[type="file"]:not(:placeholder-shown),
    .form-group textarea {
        color: #ffffffff;
    }

    .Radio-Value {
        font-family: "Cormorant Upright";
        font-weight: 400;
        font-size: clamp(0.8rem, 1.3vw, 1.8rem);
    }

    .form-control::placeholder,
    .form-control-file::placeholder {
        color: #d5ccdaff;
        font-size: clamp(0.8rem, 1.5vw, 1.1rem);
        opacity: 0.9;
    }

    .form-select {
        color: #ffffffff;
        font-size: clamp(0.8rem, 1.5vw, 1.1rem);
    }

    .form-select option {
        font-family: "Josefin Sans";
        background: rgba(232, 212, 237, 0.8);
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
        border: none;
        color: rgba(29, 3, 36, 0.8);
        font-weight: 500;
    }

    .form-group textarea {
        overflow-y: auto;
        scrollbar-width: none;
    }

    .form-select textarea::-webkit-scrollbar {
        display: none;
    }

    /* Optional: make file input and preview look nicer */
    .File-Group input[type="file"] {
        width: 100%;
        /* full width of column */
        border-radius: 8px;
        padding: 5px;
    }

    /* Preview image styling */
    .File-Group img {
        width: auto;
        max-width: 100%;
        border-radius: 30px;
        object-fit: cover;
    }

    label {
        font-weight: 600;
        color: #ffffffff;
        margin-bottom: 6px;
        display: block;
        font-family: "Cormorant Upright";
        font-size: clamp(1rem, 1.3vw, 1.5rem);
    }

    .Input-Icon {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        color: #d9c2e6ff;
        pointer-events: none;
    }

    .Warning {
        color: #ffffffff;
        font-family: "Text Me One";
        font-weight: 300;
        font-size: clamp(0.5rem, 1.2vw, 1rem);
    }

    .btn {
        font-family: "Cormorant Upright";
        font-weight: bolder;
        font-size: clamp(1rem, 1.5vw, 1.3rem);
        /* border: 2px solid rgba(38, 0, 37, 1); */
        background: rgba(20, 0, 38, 0.8);
        color: #ffffffff;
    }

    .Button button {
        background: linear-gradient(135deg, rgba(50, 12, 73, 0.95) 0%, rgba(35, 12, 72, 0.95) 100%) !important;
        border: none;
        border-radius: 10px;
        padding: 5px 25px;
        font-family: "Cinzel";
        font-weight: 500;
        font-size: clamp(1rem, 1.5vw, 2rem);
        color: rgba(255, 255, 255, 1);
    }

    /* Calander */

    .flatpickr-calendar {
        font-family: "Cormorant Upright";
        background: rgba(232, 212, 237, 0.8);
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
        border: none;
    }

    .flatpickr-current-month {
        font-weight: 200;
        letter-spacing: 0.3px;
        color: rgba(29, 3, 36, 0.8);
    }

    .flatpickr-weekdays {
        background: rgba(196, 26, 54, 0.3);
    }

    .flatpickr-weekday {
        color: #b8a594ff;
        font-weight: 500;
    }

    .flatpickr-day {
        color: #10011eff;
    }

    .flatpickr-day:hover {
        background: #10011eff;
        color: #ffffff;
    }

    /* Select 2 */

    .select2-container .select2-selection--multiple {
        min-height: 42px;
        background: rgba(0, 0, 0, 0.1);
        border: 2px solid rgba(239, 233, 238, 0.5);
        border-radius: 6px;
        font-family: "Cormorant Upright";
    }

    .select2-container--default .select2-selection--multiple .select2-search__field::placeholder {
        font-family: "Cormorant Upright";
        font-size: clamp(0.8rem, 1.5vw, 1.1rem);
        color: #daccccff;
        opacity: 0.7;
    }

    .select2-container .select2-selection--multiple:hover,
    .select2-container--focus .select2-selection--multiple {
        color: #d9c2e6ff;
        border-color: #260523c2;
        box-shadow: 0 0 0 0.2rem rgba(12, 0, 14, 0.25);
        background: rgba(0, 0, 0, 0.1);
    }

    .select2-selection__choice {
        background: #ffffff;
        color: rgba(0, 0, 0, 1);
        border: none;
        font-weight: 700;
    }

    .select2-container--default .select2-selection--multiple .select2-search__Field::placeholder {
        font-family: "Cormorant Upright";
        font-size: 1rem;
        font-weight: 600;
        color: #d5ccdaff;
        opacity: 0.75;
    }

    .select2-container--default .select2-dropdown {
        background: rgba(232, 212, 237, 0.9);
        border: none;
        border-radius: 8px;
    }

    .select2-container--default .select2-results__option {
        font-family: "Cormorant Upright", serif;
        font-size: 1.2rem;
        font-weight: 500;
        padding: 0.6rem 3rem;
        color: rgba(0, 0, 0, 1);
        transition: background 0.25s ease, color 0.25s ease;
    }

    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
        background: rgba(196, 26, 54, 0.5);
        color: #ffffff !important;
    }

    .select2-container--default .select2-results__options {
        max-height: 240px;
        overflow-y: auto;

        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE / Edge legacy */
    }

    /* Chrome, Edge, Safari */
    .select2-container--default .select2-results__options::-webkit-scrollbar {
        display: none;
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

    #modalQuery {
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
<main class="content p-0 p-sm-5">
    <div class="Wrapper container justify-content-center">
        <div class="w-100 w-md-auto">
            <div class="Expert-Details">
                <h3 class="Title text-center">Query Resolution Form</h3>
                <p class="Description Quote text-center">Break it down, make it click, and help the learner move forward.</p>
            </div>
            <div class="Expert-Form d-flex justify-content-center align-items-center w-100">
                <form method="Post" class="Form-Wrapper mx-auto" enctype="multipart/form-data" autocomplete="off">
                    <div class="Form w-100">
                        <div class="row">
                            <input type="hidden" name="Expert_ID" id="Expert_ID" value="<?= $Expert_ID ?>">
                            <input type="hidden" name="Query_ID" id="Query_ID" value="<?= $Query_ID ?>">
                        </div>
                        <div class="d-flex flex-column flex-sm-row justify-content-center">
                            <div class="Sub_Container p-3 m-2 w-100">
                                <div class="row">
                                    <h3 class="text-start">Query</h3>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="form-group">
                                        <label for="Query_Title">Query Title :</label>
                                        <textarea class="form-control" style="width: 100%; height: 100px;" type="text" name="Query_Title" id="Query_Title" readonly required><?= $Query_Title ?></textarea>
                                    </div>
                                </div>
                                <div class="row md-3">
                                    <div class="form-group">
                                        <label for="Query">Query :</label>
                                        <textarea class="form-control" style="width: 100%; height: 200px;" type="text" name="Query" id="Query" readonly required><?= htmlspecialchars_decode(str_replace('\\n', " ", $Query)) ?></textarea>
                                    </div>
                                </div>
                                <div class="row md-3 d-flex justify-content-end px-3">
                                    <?php
                                    echo "
                                    <button type='button' class='btn col-md-2 view-btn view-Doc-btn mb-1 fs-5' data-bs-toggle='modal' data-bs-target='#viewDocumentModal'
                                        data-Doc=' {$Query_Doc} '>
                                        File
                                    </button>
                                ";
                                    ?>
                                </div>
                            </div>
                            <div class="Sub_Container p-3 m-2 w-100">
                                <div class="row">
                                    <h3 class="text-start">Answer</h3>
                                </div>
                                <div class="row md-3">
                                    <div class="form-group col-md-12">
                                        <label for="Answer_Title">Answer Title :</label>
                                        <textarea class="form-control" style="width: 100%; height: 100px;" type="text" name="Answer_Title" id="Answer_Title" placeholder="Enter your Answer Title" autofocus autocomplete="off" data-next="Answer" required></textarea>
                                    </div>
                                </div>
                                <div class="row md-3">
                                    <div class="form-group">
                                        <label for="Answer">Answer :</label>
                                        <textarea class="form-control" style="width: 100%; height: 200px;" type="text" name="Answer" id="Answer" placeholder="Enter Your Answer..!" autocomplete="off" data-next="Answer_Doc" required></textarea>
                                    </div>
                                </div>
                                <div class="row md-3">
                                    <div class="form-group File-Group">
                                        <label for="Answer_Doc">Reference Document :</label>
                                        <input class="form-control-file" type="file" name="Answer_Doc" id="Answer_Doc" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" placeholder="Enter The Answer Document" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Button d-flex justify-content-center gap-4 mt-3">
                            <button type="submit" name="Post" class="Submit">Post Answer</button>
                            <button type="submit" name="Back" onclick="window.location.href = 'S_Streams_Query.php'">Back</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Prevent The Right Click -->
    <!-- <script>
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    </script> -->

    <!-- Next Field -->

    <script>
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === "Enter") { // move on Enter key
                    e.preventDefault(); // prevent form submit
                    const nextId = this.dataset.next; // get the next field ID
                    if (nextId) {
                        const nextInput = document.getElementById(nextId);
                        if (nextInput) nextInput.focus();
                    }
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

    <?php

    if ($Connection) {
        if (isset($_POST["Post"])) {
            $Fields = [
                'Expert_ID',
                'Query_ID',
                'Answer_Title',
                'Answer'
            ];

            $Cleared = [];

            foreach ($Fields as $Field) {
                if (isset($_POST[$Field])) {
                    if ($Field === 'Streams') {
                        // Handle multiple select as array
                        $Cleared[$Field] = array_map(function ($val) use ($Connection) {
                            // Convert all line breaks to real \n
                            $val = str_replace(["\r\n", "\r", "\\r\\n", "\\n"], "\n", $val);
                            $val = trim($val);
                            return mysqli_real_escape_string($Connection, htmlspecialchars($val, ENT_QUOTES, 'UTF-8'));
                        }, $_POST[$Field]);
                    } else {
                        $val = str_replace(["\r\n", "\r", "\\r\\n", "\\n"], "\n", $_POST[$Field]);
                        $val = trim($val);
                        $Cleared[$Field] = mysqli_real_escape_string($Connection, htmlspecialchars($val, ENT_QUOTES, 'UTF-8'));
                    }
                } else {
                    $Cleared[$Field] = ($Field === 'Streams') ? [] : '';
                }
            }

            $Files = [
                'Answer_Doc' => ['folder' => './Expert_Cluster_Official_Images/Answer_Doc/', 'types' => ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']],
            ];

            foreach ($Files as $Field => $Info) {
                if (isset($_FILES[$Field]) && $_FILES[$Field]['error'] === UPLOAD_ERR_OK) {
                    $File_Tmp = $_FILES[$Field]['tmp_name'];
                    $File_Ext = strtoLower(pathInfo($_FILES[$Field]['name'], PATHINFO_EXTENSION));

                    // Check Allowed types
                    if (in_array($File_Ext, $Info['types'])) {
                        if (!is_dir($Info['folder'])) {
                            mkdir($Info['folder'], 0755, true);
                        }
                        $newFileName = 'Answer_' . bin2hex(random_bytes(4)) . '.' . $File_Ext;
                        $destPath = $Info['folder'] . $newFileName;

                        if (move_uploaded_file($File_Tmp, $destPath)) {
                            $Cleared[$Field] = $newFileName; // store filename in DB
                        } else {
                            $Cleared[$Field] = ''; // upload failed
                        }
                    } else {
                        $Cleared[$Field] = ''; // invalid file type
                    }
                } else {
                    $Cleared[$Field] = ''; // no file uploaded
                }
            }

            // ID Generation

            function Generate_Id()
            {
                $Characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $ID = '';
                for ($i = 0; $i < 6; $i++) {
                    $ID .= $Characters[mt_rand(0, strlen($Characters) - 1)];
                }
                return "EAN" . $ID;
            }

            $Answer_ID = Generate_Id();

            $Insert_Query = "INSERT INTO `Answer` (`Answer_ID`, `Expert_ID`, `Query_ID`, `Answer_Title`, `Answer`, `Answer_Doc`)
                                VALUE (?,?,?,?,?,?)
                            ";
            $Insert_Query_SQL = $Connection->prepare($Insert_Query);

            $Insert_Query_SQL->bind_param(
                "ssssss",
                $Answer_ID,
                $Cleared['Expert_ID'],
                $Cleared['Query_ID'],
                $Cleared['Answer_Title'],
                $Cleared['Answer'],
                $Cleared['Answer_Doc']
            );

            $Query_ID = $Cleared['Query_ID'];

            if ($Insert_Query_SQL->execute()) {
                $Status = "Resolved";
                $Update_Query = "UPDATE `Query` SET `Query_Status` = ? WHERE `Query_ID` = ?";
                $Update_Query_SQL = $Connection->prepare($Update_Query);
                $Update_Query_SQL->bind_param("ss", $Status, $Query_ID);
            }

            if ($Update_Query_SQL->execute()) {
                unset($_SESSION['Query_ID']);
                echo "
                        <script>
                            alert ('Answer Submitted Successfully✨');
                        </script>
                    ";
            }
        }
    }
    ?>
</main>
</div>
</div>