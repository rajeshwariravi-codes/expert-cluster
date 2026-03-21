<?php
include "./Database.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expert Cluster | Stream Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="./Expert_Cluster_Images/Expert Cluster.jpg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Css File -->
    <link rel="stylesheet" href="./Register_Form.css">
</head>

<body>
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
                                <input class="form-control-file" type="file" name="Stream_Image" id="Stream_Image" accept="'jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'" placeholder="Enter The Stream Image" required>
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

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

    if ($Connection) {
        function sent_Expert_Mail($Expert_Name, $Expert_E_Mail, $Stream_ID, $CLE_Stream_Category, $CLE_Stream_Type, $CLE_Stream)
        {

            $Name  = htmlentities($Expert_Name);
            $Email = htmlentities($Expert_E_Mail);

            $mailsubject = "New Stream Launched on Expert Cluster";
            $mailsender  = "Expert Cluster";

            $message = '
                <html>
                <head>
                    <style>
                        @import url(\'https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap\');

                        body {
                            background-color: #f4f6fb;
                            padding: 20px;
                        }

                        .container {
                            max-width: 600px;
                            margin: auto;
                            background-color: #ffffff;
                            padding: 25px;
                            border-radius: 14px;
                            box-shadow: 0 8px 22px rgba(0,0,0,0.08);
                        }

                        .header {
                            font-family: \'Cinzel\', serif;
                            font-size: 22px;
                            font-weight: 600;
                            color: #4f46e5;
                            margin-bottom: 18px;
                        }

                        .highlight-box {
                            background-color: #eef2ff;
                            border-radius: 12px;
                            padding: 20px;
                            margin: 22px 0;
                        }

                        .label {
                            font-weight: 600;
                            color: #555;
                        }

                        .value {
                            font-size: 16px;
                            color: #111;
                            margin-bottom: 12px;
                        }

                        .note {
                            font-size: 14px;
                            color: #555;
                            margin-top: 18px;
                        }

                        .footer {
                            margin-top: 32px;
                            font-size: 13px;
                            color: #777;
                        }

                        a {
                            color: #4f46e5;
                            text-decoration: none;
                        }
                    </style>
                </head>

                <body style=\'font-family:\'Josefin Sans\', Arial, sans-serif; font-size:15px; color:#333; line-height:1.7;\'>
                    <div class=\'container\'>
                        <div class=\'header\'>
                            New Learning Stream Alert 🚀
                        </div>

                        <p>
                            Hello <strong>' . htmlspecialchars($Name) . '</strong>,
                        </p>

                        <p>
                            We are excited to inform you that a <strong>new stream has been successfully created</strong> on the <strong>Expert Cluster</strong> platform.
                            This stream is now live and available for expert engagement.
                        </p>

                        <div class=\'highlight-box\'>
                            <div class=\'value\'>
                                <span class=\'label\'>Stream ID:</span><br>
                                <strong>' . htmlspecialchars($Stream_ID) . '</strong>
                            </div>

                            <div class=\'value\'>
                                <span class=\'label\'>Category:</span><br>
                                ' . htmlspecialchars($CLE_Stream_Category) . '
                            </div>

                            <div class=\'value\'>
                                <span class=\'label\'>Stream Type:</span><br>
                                ' . htmlspecialchars($CLE_Stream_Type) . '
                            </div>

                            <div class=\'value\'>
                                <span class=\'label\'>Stream Name:</span><br>
                                <strong>' . htmlspecialchars($CLE_Stream) . '</strong>
                            </div>
                        </div>

                        <p class=\'note\'>
                            You may now start contributing, reviewing queries, and engaging with learners under this stream.
                            Your expertise helps shape meaningful learning experiences.
                        </p>

                        <div class=\'footer\'>
                            With appreciation,<br>
                            <strong>Expert Cluster Team</strong><br>
                            <a href=\'mailto:expertcluster.moon@gmail.com\'>expertcluster.moon@gmail.com</a>
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

        function sent_Seeker_Mail($Seeker_Name, $Seeker_E_Mail, $Stream_ID, $CLE_Stream_Category, $CLE_Stream_Type, $CLE_Stream)
        {
            $Name  = htmlentities($Seeker_Name);
            $Email = htmlentities($Seeker_E_Mail);

            $mailsubject = 'New Learning Stream Is Live on Expert Cluster';
            $mailsender  = 'Expert Cluster';

            $message = '
                <html>
                <head>
                    <!-- Use link instead of import for better email client support -->
                    <link href=\'https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap\' rel=\'stylesheet\'>

                    <style>
                        body, .container, .highlight-box, .label, .value, .note, .footer, a {
                            font-family: \'Josefin Sans\', sans-serif !important;
                        }

                        body {
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
                            border-radius: 14px;
                            box-shadow: 0 8px 22px rgba(0,0,0,0.08);
                        }

                        .header {
                            font-family: \'Cinzel\', serif !important;
                            font-size: 22px;
                            font-weight: 600;
                            color: #4f46e5;
                            margin-bottom: 18px;
                        }

                        .highlight-box {
                            background-color: #eef2ff;
                            border-radius: 12px;
                            padding: 20px;
                            margin: 22px 0;
                        }

                        .label {
                            font-weight: 600;
                            color: #555;
                        }

                        .value {
                            font-size: 16px;
                            color: #111;
                            margin-bottom: 12px;
                        }

                        .note {
                            font-size: 14px;
                            color: #555;
                            margin-top: 18px;
                        }

                        .footer {
                            margin-top: 32px;
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
                    <div class=\'container\'>
                        <div class=\'header\'>
                            A New Learning Stream Awaits You ✨
                        </div>

                        <p>
                            Hello <strong>' . htmlspecialchars($Name) . '</strong>,
                        </p>

                        <p>
                            We’re excited to let you know that a <strong>new learning stream</strong> has just gone live on the
                            <strong>Expert Cluster</strong> platform — designed to help you explore, ask, and grow with expert guidance.
                        </p>
                        <div class=\'highlight-box\'>
                            <div class=\'value\'>
                                <span class=\'label\'>Stream ID:</span><br>
                                <strong>' . htmlspecialchars($Stream_ID) . '</strong>
                            </div>
                            <div class=\'value\'>
                                <span class=\'label\'>Stream Category:</span><br>
                                ' . htmlspecialchars($CLE_Stream_Category) . '
                            </div>

                            <div class=\'value\'>
                                <span class=\'label\'>Stream Type:</span><br>
                                ' . htmlspecialchars($CLE_Stream_Type) . '
                            </div>

                            <div class=\'value\'>
                                <span class=\'label\'>Stream Name:</span><br>
                                <strong>' . htmlspecialchars($CLE_Stream) . '</strong>
                            </div>
                        </div>

                        <p class=\'note\'>
                            You can now explore this stream, raise your questions, and connect with experts who are ready to guide you.
                            Learning here is driven by curiosity — and you’re right on time.
                        </p>

                        <div class=\'footer\'>
                            Happy learning,<br>
                            <strong>Expert Cluster Team</strong><br>
                            <a href=\'mailto:expertcluster.moon@gmail.com\'>expertcluster.moon@gmail.com</a>
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
                    $CLE_Stream_Category = html_entity_decode($Stream_Category);
                    $CLE_Stream_Type = html_entity_decode($Cleared['Stream_Type']);
                    $CLE_Stream = html_entity_decode($Cleared['Stream']);

                    $Access_Gate = "Grant";
                    $Expert_Select_Query = "SELECT First_Name, Last_Name, E_Mail FROM `Expert` WHERE `Access_Gate` = ?";
                    $Expert_Select_Query_SQL = $Connection->prepare($Expert_Select_Query);
                    $Expert_Select_Query_SQL->bind_param("s", $Access_Gate);
                    $Expert_Select_Query_SQL->execute();
                    $Expert_Result = $Expert_Select_Query_SQL->get_result();

                    while ($Expert_Row = $Expert_Result->fetch_assoc()) {
                        $Expert_Name = $Expert_Row['First_Name'] . " " . $Expert_Row['Last_Name'];
                        $Expert_E_Mail = $Expert_Row['E_Mail'];
                        sent_Expert_Mail($Expert_Name, $Expert_E_Mail, $Stream_ID, $CLE_Stream_Category, $CLE_Stream_Type, $CLE_Stream);
                    }

                    $Seeker_Select_Query = "SELECT First_Name, Last_Name, E_Mail FROM `Seeker` WHERE `Access_Gate` = ?";
                    $Seeker_Select_Query_SQL = $Connection->prepare($Seeker_Select_Query);
                    $Seeker_Select_Query_SQL->bind_param("s", $Access_Gate);
                    $Seeker_Select_Query_SQL->execute();
                    $Seeker_Result = $Seeker_Select_Query_SQL->get_result();

                    while ($Seeker_Row = $Seeker_Result->fetch_assoc()) {
                        $Seeker_Name = $Seeker_Row['First_Name'] . " " . $Seeker_Row['Last_Name'];
                        $Seeker_E_Mail = $Seeker_Row['E_Mail'];
                        sent_Seeker_Mail($Seeker_Name, $Seeker_E_Mail, $Stream_ID, $CLE_Stream_Category, $CLE_Stream_Type, $CLE_Stream);
                    }
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
</body>

</html>