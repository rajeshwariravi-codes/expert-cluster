<?php
include "./Database.php";
include "./Admin_Dashboard.php"
?>

<link rel="stylesheet" href="A_Forms.css">

<!-- jQuery (must come first for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<main class="content p-5">
    <div class="Wrapper container justify-content-center">
        <div class="w-100 w-md-auto p-3">
            <div class="Expert-Details">
                <h3 class="Title text-center">Stream Form</h3>
                <p class="Description Quote text-center">Ask smarter. Learn deeper. Grow faster.</p>
            </div>
            <div class="Expert-Form d-flex justify-content-center align-items-center w-100">
                <form method="Post" class="Form-Wrapper mx-auto" enctype="multipart/form-data" autocomplete="off" novalidate>
                    <div class="Form w-100">
                        <div class="row g-3">
                            <div class="form-group col-md-6">
                                <label for="Stream_Category">Stream Category :</label>
                                <select class="form-select" name="Stream_Category" id="Stream_Category" required autofocus>
                                    <option value="" selected disabled>--Select The Stream Category--</option>
                                    <option value="Academic & Knowledge Streams">Academic & Knowledge Streams</option>
                                    <option value="Career & Professional Skills">Career & Professional Skills</option>
                                    <option value="Lifestyle, Growth & Social Impact">Lifestyle, Growth & Social Impact</option>
                                    <option value="Technology & Creative Fields">Technology & Creative Fields</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Stream_Type">Stream Type :</label>
                                <input class="form-control" type="text" name="Stream_Type" id="Stream_Type" placeholder="Enter The Stream Type" data-next="Stream" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group">
                                <label for="Stream">Stream :</label>
                                <input class="form-control" type="text" name="Stream" id="Stream" placeholder="Enter The Stream" data-next="Stream_Description" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group">
                                <label for="Stream_Description">Stream Description :</label>
                                <textarea class="form-control" type="text" style="width: 100%; height: 150px;" name="Stream_Description" id="Stream_Description" placeholder="Enter The Stream Description" required></textarea>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group File-Group">
                                <label for="Stream_Image">Stream Image :</label>
                                <input class="form-control-file" type="file" name="Stream_Image" id="Stream_Image" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx" placeholder="Enter The Stream Image" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group">
                                <label for="Tag_Keywords">Tag Keywords for Search :</label>
                                <textarea class="form-control" style="width: 100%; height: 150px;" type="text" name="Tag_Keywords" id="Tag_Keywords" placeholder="Enter Your Intrested Tags" required></textarea>
                            </div>
                            <p class="Warning ms-2">
                                Choose the subjects or skills that students can use to discover you in their searches.
                                (Type multiple tags separated by commas, e.g., HTML, CSS, JavaScript)
                            </p>
                        </div>
                        <div class="Button d-flex justify-content-center gap-4 mt-3">
                            <button type="submit" name="Register" class="Submit">Register</button>
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

    <?php
    if ($Connection) {
        if (isset($_POST["Register"])) {
            $Fields = [
                'Stream_Category',
                'Stream_Type',
                'Stream',
                'Stream_Description',
                'Phone_Number',
                'E_Mail',
                'Password',
                'Stream_Description',
                'Tag_Keywords'
            ];

            $Cleared = [];

            foreach ($Fields as $Field) {
                if (isset($_POST[$Field])) {

                    $Cleared[$Field] = htmlspecialchars($_POST[$Field], ENT_QUOTES, 'UTF-8');
                    $Cleared[$Field] = mysqli_real_escape_string($Connection, $Cleared[$Field]);
                } else {
                    $Cleared[$Field] = '';
                }
            }

            $Files = [
                'Stream_Image' => ['folder' => './Expert_Cluster_Official_Images/Streams/', 'types' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']],
            ];

            foreach ($Files as $Field => $Info) {
                if (isset($_FILES[$Field]) && $_FILES[$Field]['error'] === UPLOAD_ERR_OK) {
                    $File_Tmp = $_FILES[$Field]['tmp_name'];
                    $File_Ext = strtolower(pathInfo($_FILES[$Field]['name'], PATHINFO_EXTENSION));

                    // Check allowed types
                    if (in_array($File_Ext, $Info['types'])) {
                        if (!is_dir($Info['folder'])) {
                            mkdir($Info['folder'], 0755, true);
                        }
                        $newFileName = 'SI_' . bin2hex(random_bytes(4)) . '.' . $File_Ext;
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

            $Stream_Category = $Cleared['Stream_Category'];
            function Generate_ID($Stream_Category)
            {
                $C_Words = explode(" ", $Stream_Category);
                $C_Words_FL = "";
                foreach ($C_Words as $C_Word) {
                    $C_Words_FL .= strtoupper(substr($C_Word, 0, 1));
                }
                $hash = strtoupper(bin2hex(random_bytes(3))); // 6-char secure hash
                return $C_Words_FL . $hash;
            }

            $Stream_ID = Generate_ID($Stream_Category);

            $Insert_Query = "INSERT INTO `Streams` (`Stream_ID`,`Stream_Category`, `Stream_Type`, `Stream`, `Stream_Description`, `Stream_Image`) VALUES ( ?, ?, ?, ?, ?, ?)
                            ";
            $Insert_Query_SQL = $Connection->prepare($Insert_Query);

            $Insert_Query_SQL->bind_param(
                "ssssss",
                $Stream_ID,
                $Stream_Category,
                $Cleared['Stream_Type'],
                $Cleared['Stream'],
                $Cleared['Stream_Description'],
                $Cleared['Stream_Image']
            );

            if ($Insert_Query_SQL->execute()) {

                $Tags = array_map('trim', explode(",", $Cleared['Tag_Keywords']));
                $Tags_Count = count($Tags);
                $Insert_Tags_Query = "INSERT INTO `Stream_Tags` (`Stream_ID`, `Tag_No`, `Tag_Keywords`) VALUES (?, ?, ?)";
                $Insert_Tags_Query_SQL = $Connection->prepare($Insert_Tags_Query);
                for ($i = 0; $i < $Tags_Count; $i++) {
                    $Tag_No = $i + 1;
                    $Tag_Name = $Tags[$i];
                    $Insert_Tags_Query_SQL->bind_param("sis", $Stream_ID, $Tag_No, $Tag_Name);
                    $Tags_Done = $Insert_Tags_Query_SQL->execute();
                }
                if ($Tags_Done) {
                    echo "
                        <script>
                            alert ('Login Successfully Done✨');
                        </script>
                    ";
                }
            }
        }
    }
    ?>
</main>
</div>
</div>