<?php
include "./Database.php";
include "./Seeker_Dashboard.php";
$Stream_ID = $_SESSION['Stream_ID'];

if ($Connection) {
    $Select_Query = "SELECT * FROM `Streams` WHERE Stream_ID = ?";
    $Select_Query_SQL = $Connection->prepare($Select_Query);
    $Select_Query_SQL->bind_param("s", $Stream_ID);
    $Select_Query_SQL->execute();
    $Result = $Select_Query_SQL->get_result();
    if ($Row = $Result->fetch_assoc()) {
        $Stream_Category = $Row['Stream_Category'];
        $Stream_Type = $Row['Stream_Type'];
        $Stream = $Row['Stream'];
    }
}
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Aboreto&family=Big+Shoulders+Stencil:opsz,wght@10..72,100..900&family=Cinzel:wght@400..900&family=Cormorant+Upright:wght@300;400;500;600;700&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Pacifico&family=Text+Me+One&family=Zilla+Slab+Highlight:wght@400;700&display=swap');

    .Wrapper {
        width: 100%;
        max-width: 900px;
        border-radius: 40px;
        overflow: hidden;
        padding: 20px 0px;
        border-radius: 25px;
        background-color: rgba(239, 219, 239, 0.1);
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

    .Button button {
        background: linear-gradient(180deg, #310a49 0%, #4b173d 100%) !important;
        border: none;
        border-radius: 10px;
        padding: 5px 25px;
        font-family: "Cormorant Upright";
        font-weight: bolder;
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
</style>
<!-- jQuery (must come first for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<main class="content p-0 p-sm-5">
    <div class="Wrapper container justify-content-center">
        <div class="w-100 w-md-auto p-3">
            <div class="Expert-Details">
                <h3 class="Title text-center">Query Request Form</h3>
                <p class="Description Quote text-center">Ask meaningful questions, gain clear insights, and learn with confidence.</p>
            </div>
            <div class="Expert-Form d-flex justify-content-center align-items-center w-100">
                <form method="Post" class="Form-Wrapper mx-auto" enctype="multipart/form-data" autocomplete="off">
                    <div class="Form w-100">
                        <div class="row g-3 align-items-center">
                            <div class="row">
                                <input type="hidden" name="Seeker_ID" id="Seeker_ID" value="<?= $Seeker_ID ?>">
                                <input type="hidden" name="Stream_ID" id="Stream_ID" value="<?= $Stream_ID ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Stream_Category">Stream Category :</label>
                                <input class="form-control" type="text" name="Stream_Category" id="Stream_Category" value="<?= $Stream_Category ?>" readonly required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Stream_Type">Stream Type :</label>
                                <input class="form-control" type="text" name="Stream_Type" id="Stream_Type" value="<?= $Stream_Type ?>" readonly required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Stream_Category">Stream :</label>
                                <input class="form-control" type="text" name="Stream" id="Stream" value="<?= $Stream ?>" readonly required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group col-md-12">
                                <label for="Query_Title">Query Title :</label>
                                <textarea class="form-control" style="width: 100%; height: 100px;" type="text" name="Query_Title" id="Query_Title" placeholder="Enter your Query Title" autofocus autocomplete="off" data-next="Query" required></textarea>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group">
                                <label for="Query">Query :</label>
                                <textarea class="form-control" style="width: 100%; height: 200px;" type="text" name="Query" id="Query" placeholder="Enter Your Query..!" autocomplete="off" data-next="Query_Doc" required></textarea>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group File-Group">
                                <label for="Query_Doc">Reference Document :</label>
                                <input class="form-control-file" type="file" name="Query_Doc" id="Query_Doc" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" placeholder="Enter The Query Document" required>
                            </div>
                        </div>
                        <div class="Button d-flex justify-content-center gap-4 mt-3">
                            <button type="submit" name="Ask" class="Submit">Post Query</button>
                            <button type="submit" name="Back" onclick="window.location.href = 'S_Streams_Query.php'">Back</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Prevent The Right Click -->
    <script>
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    </script>

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

    <!-- Calander -->

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            flatpickr("#DOB", {
                dateFormat: "Y-m-d", // DB-friendly, backend-safe
                AllowInput: true, // Manual typing enabled
                maxDate: "today", // No future birthdays (compliance check ✔)
                yearSelectorType: "dropdown", // Faster year navigation
                monthSelectorType: "static",
                disableMobile: true // Force flatpickr UI on mobile
            });

        });
    </script>

    <!-- Select 2 -->

    <script>
        $('.select2').select2({
            placeholder: "Select The Streams To Handle",
            AllowClear: true
        });
    </script>

    <?php

    if ($Connection) {

        if (isset($_POST["Ask"])) {
            $Fields = [
                'Seeker_ID',
                'Stream_ID',
                'Query_Title',
                'Query'
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
                'Query_Doc' => ['folder' => './Expert_Cluster_Official_Images/Query_Doc/', 'types' => ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']],
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
                        $newFileName = 'Query_' . bin2hex(random_bytes(4)) . '.' . $File_Ext;
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
                return "SQU" . $ID;
            }

            $Query_ID = Generate_Id();

            $Insert_Query = "INSERT INTO `Query` (`Query_ID`, `Seeker_ID`, `Stream_ID`, `Query_Title`, `Query`, `Query_Doc`)
                                VALUE (?,?,?,?,?,?)
                            ";
            $Insert_Query_SQL = $Connection->prepare($Insert_Query);

            $Insert_Query_SQL->bind_param(
                "ssssss",
                $Query_ID,
                $Cleared['Seeker_ID'],
                $Cleared['Stream_ID'],
                $Cleared['Query_Title'],
                $Cleared['Query'],
                $Cleared['Query_Doc']
            );

            if ($Insert_Query_SQL->execute()) {
                // Sent_Mail($First_Name, $Last_Name, $E_Mail, $Expert_ID, $Password, $Streams_Text);
                unset($_SESSION['Stream_ID']);
                echo "
                        <script>
                            alert ('Query Submitted Successfully✨');
                        </script>
                    ";
            }
        }
    }
    ?>
</main>
</div>
</div>