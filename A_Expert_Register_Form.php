<?php
include "./Database.php";
include "./Admin_Dashboard.php";
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
                <h3 class="Title text-center">Expert Register Form</h3>
                <p class="Description Quote text-center">Share expertise, resolve queries, and guide learners with confidence.</p>
            </div>
            <div class="Expert-Form d-flex justify-content-center align-items-center w-100">
                <form method="Post" class="Form-Wrapper mx-auto" enctype="multipart/form-data" autocomplete="off">
                    <div class="Form w-100">
                        <div class="row g-3 align-items-center">
                            <div class="form-group col-md-4">
                                <label for="First_Name">First Name :</label>
                                <input class="form-control" type="text" name="First_Name" id="First_Name" placeholder="Enter your First Name" data-next="Last_Name" autofocus required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Last_Name">Last Name :</label>
                                <input class="form-control" type="text" name="Last_Name" id="Last_Name" placeholder="Enter your Last Name" data-next="ProfilePic" required>
                            </div>
                            <div class="File-Group form-group col-md-4 d-flex flex-column">
                                <label for="ProfilePic" class="mb-2 text-start">Profile Picture :</label>
                                <input class="form-control-file" type="file" name="Profile_Pic" id="ProfilePic" accept=".jpg,.jpeg,.png,.gif" data-next="DOB" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group col-md-6">
                                <label for="DOB">Date Of Birth :</label>
                                <input class="form-control" type="text" name="DOB" id="DOB" placeholder="Enter your Date Of Birth" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Gender">Gender :</label>
                                <div class="d-flex gap-3 mt-3">
                                    <div class="d-flex Radio-Value">
                                        <input type="radio" class="me-2" name="Gender" id="Gender" value="Female" required> Female
                                    </div>
                                    <div class="d-flex Radio-Value">
                                        <input type="radio" class="me-2" name="Gender" id="Gender" value="Male" required> Male
                                    </div>
                                    <div class="d-flex Radio-Value">
                                        <input type="radio" class="me-2" name="Gender" id="Gender" value="Other" required> Other
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group col-md-6">
                                <label for="Phone_Number">Phone Number :</label>
                                <input class="form-control" type="phone" name="Phone_Number" id="Phone_Number" placeholder="Enter The Phone Number" data-next="E_Mail" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="E_Mail">E-Mail :</label>
                                <input class="form-control" type="email" name="E_Mail" id="E_Mail" placeholder="Enter The E-Mail" data-next="City" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group col-md-6">
                                <label for="City">City :</label>
                                <input class="form-control" type="text" name="City" id="City" placeholder="Enter The City" data-next="Country" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Country">Country :</label>
                                <input class="form-control" type="text" name="Country" id="Country" placeholder="Enter The Country" data-next="Qualification" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group col-md-6">
                                <label for="Qualification">Qualification :</label>
                                <input class="form-control" type="text" name="Qualification" id="Qualification" placeholder="Enter The Qualification" data-next="Expert_In" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Expert_In">Expert In :</label>
                                <input class="form-control" type="text" name="Expert_In" id="Expert_In" placeholder="Enter The Area Of Intrest" data-next="Professional_Certification" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group File-Group">
                                <label for="Professional_Certification">Certification :</label>
                                <input class="form-control-file" type="file" name="Professional_Certification" id="Professional_Certification" accept=".pdf,.doc,.docx" placeholder="Enter The Professional Certification" data-next="Designation">
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group col-md-4">
                                <label for="Designation">Designation :</label>
                                <input class="form-control" type="text" name="Designation" id="Designation" placeholder="Enter The Designation" data-next="Organization_Name" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Organization_Name">Organization Name :</label>
                                <input class="form-control" type="text" name="Organization_Name" id="Organization_Name" placeholder="Enter The Organization Name" data-next="Years_of_Experience" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Years_of_Experience">Years of Experience :</label>
                                <input class="form-control" type="text" name="Years_of_Experience" id="Years_of_Experience" placeholder="Enter The Years of Experience" data-next="Resume" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group File-Group">
                                <label for="Resume">Resume :</label>
                                <input class="form-control-file" type="file" name="Resume" id="Resume" accept=".pdf,.doc,.docx" placeholder="Enter The Resume" data-next="Streams" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <label for="Streams">Streams To Handle :</label>
                            <select class="form-control select2" name="Streams[]" id="Streams" multiple required>
                                <?php
                                if ($Connection) {
                                    $Stream_Access = "Grant";
                                    $Select_Query = "SELECT Stream FROM `Streams` WHERE Access_Gate = ? ORDER BY Stream_Category ASC";
                                    $Select_Query_SQL = $Connection->prepare($Select_Query);
                                    $Select_Query_SQL->bind_param("s", $Stream_Access);
                                    $Select_Query_SQL->execute();
                                    $Result = $Select_Query_SQL->get_result();
                                    while ($Row = $Result->fetch_assoc()) {
                                ?>
                                        <option value="<?= html_entity_decode($Row['Stream']) ?>"><?= html_entity_decode($Row['Stream']) ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row md-3">
                            <div class="form-group">
                                <label for="Expert_Tags">Expertise for Search :</label>
                                <textarea class="form-control" style="width: 100%; height: 150px;" type="text" name="Expert_Tags" id="Expert_Tags" placeholder="Enter Your Intrested Tags" required></textarea>
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

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

    if ($Connection) {
        function Sent_Mail($First_Name, $Last_Name, $E_Mail, $Expert_ID, $Password, $Streams_Text)
        {
            $Name = htmlentities($First_Name . " " . $Last_Name);
            $Email = htmlentities($E_Mail);

            $mailsender = "Expert Cluster";
            $mailsubject = "Expert Appointment Confirmation | Expert Cluster";

            $message = $message = '
                <html>
                <head>
                    <style>
                        @import url("https://fonts.googleapis.com/css2?family=Aboreto&family=Big+Shoulders+Stencil:opsz,wght@10..72,100..900&family=Cinzel:wght@400..900&family=Cormorant+Upright:wght@300;400;500;600;700&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Pacifico&family=Text+Me+One&family=Zilla+Slab+Highlight:wght@400;700&display=swap");

                        body {
                            font-family: "Aboreto", "Big Shoulders Stencil", "Cinzel", "Cormorant Upright", "Josefin Sans", "Pacifico", "Text Me One", "Zilla Slab Highlight", sans-serif;
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
                            padding: 25px;
                            border-radius: 12px;
                            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
                        }

                        .header {
                            font-family: "Cinzel", serif;
                            font-size: 22px;
                            font-weight: 600;
                            color: #4f46e5;
                            margin-bottom: 15px;
                        }

                        .highlight-box {
                            background-color: #eef2ff;
                            border-radius: 10px;
                            padding: 18px;
                            margin: 20px 0;
                        }

                        .label {
                            font-weight: 600;
                            color: #555;
                        }

                        .value {
                            font-size: 16px;
                            color: #111;
                            margin-bottom: 10px;
                        }

                        .password {
                            font-size: 20px;
                            font-weight: bold;
                            color: #4f46e5;
                            letter-spacing: 1px;
                        }

                        .note {
                            font-size: 14px;
                            color: #555;
                            margin-top: 15px;
                        }

                        .footer {
                            margin-top: 30px;
                            font-size: 13px;
                            color: #777;
                        }

                        a {
                            color: #4f46e5;
                            text-decoration: none;
                        }
                    </style>
                </head>

                <body>
                    <div class="container">
                        <div class="header">
                            Welcome to Expert Cluster, ' . $First_Name . ' ' . $Last_Name . '
                        </div>

                        <p>
                            We are pleased to inform you that your expert profile has been
                            <strong>successfully created by the Administration</strong>
                            on the <strong>Expert Cluster</strong> platform.
                        </p>

                        <div class="highlight-box">
                            <div class="value">
                                <span class="label">Expert ID:</span><br>
                                <strong>' . $Expert_ID . '</strong>
                            </div>

                            <div class="value">
                                <span class="label">Temporary Password:</span><br>
                                <span class="password">' . $Password . '</span>
                            </div>

                            <div class="value">
                                <span class="label">Assigned Streams:</span><br>
                                ' . $Streams_Text . '
                            </div>
                        </div>

                        <p class="note">
                            For security reasons, you are required to
                            <strong>change your password immediately after your first login</strong>.
                        </p>

                        <p>
                            If you believe this account was created in error or you need assistance,
                            please contact our support team.
                        </p>

                        <div class="footer">
                            Best regards,<br>
                            <strong>Expert Cluster Administration</strong><br>
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
            $mail->Password = 'xzim melz bpcv hhbw';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->isHTML(true);
            $mail->setFrom('expertcluster.moon@gmail.com', $mailsender);
            $mail->addAddress($Email, $Name);
            $mail->Subject = $mailsubject;
            $mail->Body = $message;
            $mail->send();
        }
        if (isset($_POST["Register"])) {
            $Fields = [
                'First_Name',
                'Last_Name',
                'DOB',
                'Gender',
                'Phone_Number',
                'E_Mail',
                'Password',
                'City',
                'Country',
                'Qualification',
                'Expert_In',
                'Professional_Certification',
                'Designation',
                'Organization_Name',
                'Years_of_Experience',
                'Resume',
                'Expert_Tags',
                'Streams'
            ];

            $Cleared = [];

            foreach ($Fields as $Field) {
                if (isset($_POST[$Field])) {
                    if ($Field === 'Streams') {
                        // Handle multiple select as array
                        $Cleared[$Field] = array_map(function ($val) use ($Connection) {
                            return mysqli_real_escape_string($Connection, htmlspecialchars($val, ENT_QUOTES, 'UTF-8'));
                        }, $_POST[$Field]);
                    } else {
                        $Cleared[$Field] = mysqli_real_escape_string($Connection, htmlspecialchars($_POST[$Field], ENT_QUOTES, 'UTF-8'));
                    }
                } else {
                    $Cleared[$Field] = ($Field === 'Streams') ? [] : '';
                }
            }

            $Files = [
                'Resume' => ['folder' => './Expert_Cluster_Official_Images/Expert_Resumes/', 'types' => ['pdf', 'doc', 'docx']],
                'Professional_Certification' => ['folder' => './Expert_Cluster_Official_Images/Expert_Certificates/', 'types' => ['pdf', 'doc', 'docx']],
                'Profile_Pic' => ['folder' => './Expert_Cluster_Official_Images/Expert_Profile_Pic/', 'types' => ['jpg', 'jpeg', 'png', 'gif']]
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
                        $newFileName = uniqid($Field . '_') . '.' . $File_Ext;
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
                return "AEX" . $ID;
            }

            $Expert_ID = Generate_Id();

            // Password Generation

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

            // Access Gate

            $Access_Gate = "Grant";


            // Age Calculation

            $DOB = new DateTime($Cleared['DOB']);
            $Today = new DateTime();
            $Age = $Today->diff($DOB)->y;
            $Insert_Query = "INSERT INTO `Expert` (`Expert_ID`, `First_Name`, `Last_Name`, `Date_Of_Birth`, `Age`, `Gender`, `Phone_Number`, `E_Mail`, `Password`, `Profile_Pic`, `City`, `Country`, `Qualification`, `Expert_In`, `Professional_Certification`, `Designation`, `Organization_Name`, `Years_of_Experience`, `Resume`, `Access_Gate`)
                                VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
                            ";
            $Insert_Query_SQL = $Connection->prepare($Insert_Query);

            $Insert_Query_SQL->bind_param(
                "ssssisissssssssssiss",
                $Expert_ID,
                $Cleared['First_Name'],
                $Cleared['Last_Name'],
                $Cleared['DOB'],
                $Age,
                $Cleared['Gender'],
                $Cleared['Phone_Number'],
                $Cleared['E_Mail'],
                $Password,
                $Cleared['Profile_Pic'],
                $Cleared['City'],
                $Cleared['Country'],
                $Cleared['Qualification'],
                $Cleared['Expert_In'],
                $Cleared['Professional_Certification'],
                $Cleared['Designation'],
                $Cleared['Organization_Name'],
                $Cleared['Years_of_Experience'],
                $Cleared['Resume'],
                $Access_Gate
            );

            if ($Insert_Query_SQL->execute()) {

                $Streams = array_unique(array_map('trim', $Cleared['Streams']));
                $Insert_Streams_Query = "INSERT INTO `Expert_Streams` (`Expert_ID`, `Stream_ID`, `Stream_Name`) VALUES (?, ?, ?)";
                $Insert_Streams_Query_SQL = $Connection->prepare($Insert_Streams_Query);

                $Select_Stream_ID_Query = "SELECT `Stream_ID` FROM `Streams` WHERE `Stream` = ?";
                $Select_Stream_ID_Query_SQL = $Connection->prepare($Select_Stream_ID_Query);

                foreach ($Streams as $Stream_Name) {

                    $Select_Stream_ID_Query_SQL->bind_param("s", $Stream_Name);
                    $Select_Stream_ID_Query_SQL->execute();
                    $Result = $Select_Stream_ID_Query_SQL->get_result();

                    if ($Row = $Result->fetch_assoc()) {

                        $Stream_ID = $Row['Stream_ID'];
                        $Insert_Streams_Query_SQL->bind_param("sis", $Expert_ID, $Stream_ID, $Stream_Name);
                        $Insert_Streams_Query_SQL->execute();
                    }
                }
            }
            if ($Streams_Done) {
                $Tags = array_map('trim', explode(",", $Cleared['Expert_Tags']));
                $Tags_Count = count($Tags);
                $Insert_Tags_Query = "INSERT INTO `Expert_Tags` (`Expert_ID`, `Tag_No`, `Tags_Keywords`) VALUES (?, ?, ?)";
                $Insert_Tags_Query_SQL = $Connection->prepare($Insert_Tags_Query);
                for ($i = 0; $i < $Tags_Count; $i++) {
                    $Tag_No = $i + 1;
                    $Tag_Name = $Tags[$i];
                    $Insert_Tags_Query_SQL->bind_param("sis", $Expert_ID, $Tag_No, $Tag_Name);
                    $Tags_Done = $Insert_Tags_Query_SQL->execute();
                }
                if ($Tags_Done) {
                    $First_Name = $Cleared['First_Name'];
                    $Last_Name = $Cleared['Last_Name'];
                    $E_Mail = $Cleared['E_Mail'];
                    $Streams_Text = implode(', ', $Streams);
                    Sent_Mail($First_Name, $Last_Name, $E_Mail, $Expert_ID, $Password, $Streams_Text);
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