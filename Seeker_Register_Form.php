<?php
include "./Database.php";
session_start();
$Seeker_ID = $_SESSION['Seeker_ID'];
$E_Mail_ID = $_SESSION['E_Mail_ID'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expert Cluster | Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="./Expert_Cluster_Images/Expert Cluster.jpg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Css File -->
    <link rel="stylesheet" href="./Register_Form.css">
</head>

<!-- jQuery (must come first for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<body>
    <div class="Wrapper container justify-content-center">
        <div class="w-100 w-md-auto p-3">
            <div class="Seeker-Details">
                <h3 class="Title text-center">Seeker Register Form</h3>
                <p class="Description Quote text-center">A space to learn, lead, and level up.</p>
            </div>
            <div class="Seeker-Form d-flex justify-content-center align-items-center w-100">
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
                            <div class="File-Group form-group col-md-4 d-flex flex-column align-items-center">
                                <label for="ProfilePic" class="mb-2">Profile Picture :</label>
                                <input class="form-control-file" type="file" name="Profile_Pic" id="ProfilePic" accept=".jpg,.jpeg,.png,.gif" data-next="DOB" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group col-md-6">
                                <label for="DOB">Date Of Birth :</label>
                                <input class="form-control" type="text" name="DOB" id="DOB" placeholder="Enter your Date Of Birth" data-next="Phone_Number" required>
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
                                <input class="form-control" type="phone" name="Phone_Number" id="Phone_Number" placeholder="Enter The Phone Number" data-next="City" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="E_Mail">E-Mail :</label>
                                <input class="form-control" type="email" name="E_Mail" id="E_Mail" placeholder="Enter The E-Mail" value="<?php echo $E_Mail_ID; ?>" required readonly>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group col-md-6">
                                <label for="City">City :</label>
                                <input class="form-control" type="text" name="City" id="City" placeholder="Enter The City" data-next="Country" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Country">Country :</label>
                                <input class="form-control" type="text" name="Country" id="Country" placeholder="Enter The Country" data-next="Seeker_Type" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group col-md-6">
                                <label for="Seeker_Type">Qualification :</label>
                                <select class="form-select" name="Seeker_Type" id="Seeker_Type" required>
                                    <option value="" selected disabled>--Select Your Type--</option>
                                    <option value="School Student">School Student</option>
                                    <option value="College Student">College Student</option>
                                    <option value="Working Professional">Working Professional</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Skill">Skills In :</label>
                                <input class="form-control" type="text" name="Skill" id="Skill" placeholder="Enter The Area Of Intrest" data-next="Certification" required>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="form-group File-Group">
                                <label for="Certification">Certification :</label>
                                <input class="form-control-file" type="file" name="Certification" id="Certification" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" placeholder="Upload Professional Certification">
                            </div>
                        </div>
                        <div class="row md-3" id="Resume_Block" style="display: none;">
                            <div class="form-group File-Group">
                                <label for="Resume">Resume :</label>
                                <input class="form-control-file" type="file" name="Resume" id="Resume" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" placeholder="Upload Resume">
                            </div>
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
    <!-- <script>
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    </script> -->

    <!-- Resume View -->

    <script>
        const Seeker_Type = document.getElementById('Seeker_Type');
        const Resume_Block = document.getElementById('Resume_Block');

        Seeker_Type.addEventListener('change', function() {
            const Value = this.value;
            if ((Value == "College Student") || (Value == "Working Professional")) {
                Resume_Block.style.display = "block";
            } else {
                Resume_Block.style.display = "none";
            }
        });
    </script>

    <!-- Calander -->

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            flatpickr("#DOB", {
                dateFormat: "Y-m-d", // DB-friendly, backend-safe
                allowInput: true, // Manual typing enabled
                maxDate: "today", // No future birthdays (compliance check ✔)
                yearSelectorType: "dropdown", // Faster year navigation
                disableMobile: true // Force flatpickr UI on mobile
            });

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

    <script>

    </script>

    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

    if ($Connection) {

        function Sent_Mail($Seeker_Name, $Seeker_ID, $E_Mail_ID)
        {
            $Name = htmlentities($Seeker_Name);
            $Email = htmlentities($E_Mail_ID);
            $mailsubject = "Your Expert Cluster Access Granted";
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
                            color: #10b981; /* success green */
                            margin-bottom: 20px;
                            text-align: center;
                        }

                        p {
                            font-size: 16px;
                            margin-bottom: 15px;
                        }

                        .highlight-box {
                            background-color: #ecfdf5;
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
                        <div class="header">
                            Hello ' . $Seeker_Name . ',
                        </div>

                        <p>
                            Welcome to <strong>Expert Cluster</strong> 🎉  
                            Your seeker account has been <strong>successfully registered</strong>.  
                            You’re now officially part of a learning-first ecosystem built for clarity, growth, and real answers.
                        </p>

                        <div class="highlight-box">
                            <div class="value">
                                <span class="label">Seeker ID:</span><br>
                                <strong> ' . $Seeker_ID . '</strong>
                            </div>
                        </div>

                        <p class="note">
                            You can now log in, explore expert streams, raise queries, and receive guidance from verified experts across multiple domains.  
                            Ask smart. Learn fast. Level up continuously.
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
                'Seeker_Type',
                'Skill'
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
                'Resume' => [
                    'folder' => './Expert_Cluster_Official_Images/Seeker_Resumes/',
                    'types'  => ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']
                ],
                'Certification' => [
                    'folder' => './Expert_Cluster_Official_Images/Seeker_Certificates/',
                    'types'  => ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']
                ],

                'Profile_Pic' => [
                    'folder' => './Expert_Cluster_Official_Images/Seeker_Profile_Pic/',
                    'types' => ['jpg', 'jpeg', 'png', 'gif']
                ]
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

            // Age Calculation

            $DOB = new DateTime($Cleared['DOB']);
            $Today = new DateTime();
            $Age = $Today->diff($DOB)->y;

            $Update_Query = "UPDATE `Seeker` SET First_Name = ?, Last_Name = ?, Date_Of_Birth = ?, Age = ?, Gender = ?, Phone_Number = ?, Profile_Pic = ?, City = ?, Country = ?,  Seeker_Type = ?, Skill = ?, Certification = ?, Resume = ?
                                WHERE Seeker_ID = ? AND E_Mail = ?
                            ";
            $Update_Query_SQL = $Connection->prepare($Update_Query);

            $Update_Query_SQL->bind_param(
                "sssisisssssssss",
                $Cleared['First_Name'],
                $Cleared['Last_Name'],
                $Cleared['DOB'],
                $Age,
                $Cleared['Gender'],
                $Cleared['Phone_Number'],
                $Cleared['Profile_Pic'],
                $Cleared['City'],
                $Cleared['Country'],
                $Cleared['Seeker_Type'],
                $Cleared['Skill'],
                $Cleared['Certification'],
                $Cleared['Resume'],
                $Seeker_ID,
                $E_Mail_ID
            );

            if ($Update_Query_SQL->execute()) {
                $Seeker_Name = $Cleared['First_Name'] . $Cleared['Last_Name'];
                sent_Mail($Seeker_Name, $Seeker_ID, $E_Mail_ID);
                echo "
                    <script>
                        alert ('Login Successfully Done✨');
                    </script>
                ";
            }
        }
    }
    ?>
</body>

</html>