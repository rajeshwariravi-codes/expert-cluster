<?php
include "./Database.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expert Cluster | Sign In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="./Expert_Cluster_Images/Expert Cluster.jpg">
    <link rel="stylesheet" href="./Sign_In.css">
</head>

<body>

    <!-- Prevent The Right Click -->
    <script>
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    </script>

    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

    if ($Connection) {

        function Sent_Code_Mail($V_Seeker_Name, $V_E_Mail, $Verification_Code)
        {
            $Name = htmlentities($V_Seeker_Name);
            $Email = htmlentities($V_E_Mail);

            $mailsender = "Expert Cluster";
            $mailsubject = "Your Verification Code for Expert Cluster";

            $message = '
                <html>
                <head>
                    <style>
                        @import url("https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Josefin+Sans:wght@400;600&display=swap");

                        body {
                            font-family: "Josefin Sans", "Cinzel", sans-serif;
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
                            font-size: 22px;
                            font-weight: 700;
                            color: #4f46e5;
                            margin-bottom: 20px;
                            text-align: center;
                        }

                        p {
                            font-size: 16px;
                            margin-bottom: 15px;
                        }

                        .code-box {
                            background-color: #eef2ff;
                            border-left: 4px solid #4f46e5;
                            border-radius: 10px;
                            padding: 18px;
                            text-align: center;
                            font-size: 26px;
                            font-weight: 700;
                            letter-spacing: 3px;
                            color: #4f46e5;
                            margin: 25px 0;
                        }

                        .timer {
                            font-size: 14px;
                            color: #555;
                            text-align: center;
                            margin-top: -10px;
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
                        <div class="header">Verification Required</div>

                        <p>
                            Hello ' . htmlspecialchars($Name) . ',
                        </p>

                        <p>
                            Thank you for registering on <strong>Expert Cluster</strong>.
                            To complete your verification, please use the code below.
                        </p>

                        <div class="code-box">' . htmlspecialchars($Verification_Code) . '</div>

                        <div class="timer">
                            This verification code is valid for <strong>1 minute</strong>.
                        </div>

                        <p class="note">
                            If you did not request this verification, you may safely ignore this email.
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
            $mail->Password = 'dckl jpqd kcbb jzky';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->isHTML(true);
            $mail->setFrom('expertcluster.moon@gmail.com', $mailsender);
            $mail->addAddress($Email, $Name);
            $mail->Subject = $mailsubject;
            $mail->Body = $message;
            $mail->send();
        }

        function Sent_New_Mail($First_Name, $Last_Name, $Sent_E_Mail)
        {
            $Name = htmlentities($First_Name . ' ' . $Last_Name);
            $Email = htmlentities($Sent_E_Mail);

            $mailsender  = "Expert Cluster";
            $mailsubject = "Password Updated Successfully";
            $message = '
                <html>
                <head>
                    <style>
                        @import url("https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Josefin+Sans:wght@400;600&display=swap");

                        body {
                            font-family: "Josefin Sans", "Cinzel", sans-serif;
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
                            font-size: 22px;
                            font-weight: 700;
                            color: #16a34a; /* success green */
                            margin-bottom: 20px;
                            text-align: center;
                        }

                        p {
                            font-size: 16px;
                            margin-bottom: 15px;
                        }

                        .highlight-box {
                            background-color: #ecfdf5;
                            border-left: 4px solid #16a34a;
                            border-radius: 10px;
                            padding: 20px;
                            margin: 20px 0;
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
                        <div class="header">Password Updated Successfully</div>

                        <p>
                            Hello <strong>' . htmlspecialchars($Name) . '</strong>,
                        </p>

                        <div class="highlight-box">
                            <p>
                                Your password has been successfully updated. You can now sign in securely
                                using your new credentials.
                            </p>
                        </div>

                        <p class="note">
                            If this change was not initiated by you, please contact our support team
                            immediately so we can assist you.
                        </p>

                        <p class="note">
                            You’re all set — keep learning, keep building, and keep moving forward 🚀
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
            $mail->Password = 'dckl jpqd kcbb jzky';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->isHTML(true);
            $mail->setFrom('expertcluster.moon@gmail.com', $mailsender);
            $mail->addAddress($Email, $Name);
            $mail->Subject = $mailsubject;
            $mail->Body = $message;
            $mail->send();
        }

        function Sent_Re_Code_Mail($Re_Seeker_Name, $Re_Send_E_Mail, $Verification_Code, $Verification_Code_Timer)
        {
            $Name = htmlentities($Re_Seeker_Name);
            $Email = htmlentities($Re_Send_E_Mail);

            $mailsender = "Expert Cluster";
            $mailsubject = "Your Verification Code for Expert Cluster";

            $message = '
                <html>
                <head>
                    <style>
                        @import url("https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Josefin+Sans:wght@400;600&display=swap");

                        body {
                            font-family: "Josefin Sans", "Cinzel", sans-serif;
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
                            font-size: 22px;
                            font-weight: 700;
                            color: #4f46e5;
                            margin-bottom: 20px;
                            text-align: center;
                        }

                        p {
                            font-size: 16px;
                            margin-bottom: 15px;
                        }

                        .code-box {
                            background-color: #eef2ff;
                            border-left: 4px solid #4f46e5;
                            border-radius: 10px;
                            padding: 18px;
                            text-align: center;
                            font-size: 26px;
                            font-weight: 700;
                            letter-spacing: 3px;
                            color: #4f46e5;
                            margin: 25px 0;
                        }

                        .timer {
                            font-size: 14px;
                            color: #555;
                            text-align: center;
                            margin-top: -10px;
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
                        <div class="header">Verification Code Resent</div>

                        <p>
                            Hello ' . htmlspecialchars($Name) . ',
                        </p>

                        <p>
                            We received a request to resend your verification code for
                            <strong>Expert Cluster</strong>. Please use the code below to
                            complete your verification.
                        </p>

                        <div class="code-box">' . htmlspecialchars($Verification_Code) . '</div>

                        <div class="timer">
                            This verification code is valid for <strong>1 minute</strong>.
                        </div>

                        <p class="note">
                            If you did not request this code, you may safely ignore this email.
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
            $mail->Password = 'dckl jpqd kcbb jzky';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->isHTML(true);
            $mail->setFrom('expertcluster.moon@gmail.com', $mailsender);
            $mail->addAddress($Email, $Name);
            $mail->Subject = $mailsubject;
            $mail->Body = $message;
            $mail->send();
        }

        $E_Mail_Value = "";

        if (isset($_POST['Submit'])) {
            $S_Mail_ID      = $_POST["Mail_Id"];
            $Seeker_Password = $_POST["Password"];

            $E_Mail_Error = "";
            $Password_Error = "";

            if (!empty($S_Mail_ID) && !empty($Seeker_Password)) {
                if (!preg_match('~[\w\.-]+@[\w\.-]+\.\w{2,}~', $S_Mail_ID)) {
                    $E_Mail_Error = "Please enter a valid email address.";
                    $E_Mail_Value = "";
                } elseif (!preg_match('~^(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$~', $Seeker_Password)) {
                    $Password_Error = "*Password must be at least 8 characters, include 1 uppercase letter and 1 number, and a special character (@ $ ! % * ? &).";
                    $E_Mail_Value = $S_Mail_ID;
                } else {
                    $Grant = "Grant";
                    $Re_Grant = "Re-Grant";
                    $Select_Query = "SELECT * FROM `Seeker` WHERE `E_Mail` = ? AND `Password` = ? AND ( Access_Gate = ? OR Access_Gate = ? )";
                    $Select_Query_SQL = $Connection->prepare($Select_Query);
                    $Select_Query_SQL->bind_param("ssss", $S_Mail_ID, $Seeker_Password, $Grant, $Re_Grant);
                    $Select_Query_SQL->execute();
                    $Result = $Select_Query_SQL->get_result();

                    if ($Row = $Result->fetch_assoc()) {
                        $S_Seeker_ID     = $Row['Seeker_ID'];
                        $S_S_Mail_Id    = $Row['E_Mail'];
                        $S_Password     = $Row['Password'];
                    } else {
                        echo "
                        <script>
                            alert('Verify your login details — only granted or re-granted Seekers can access this portal.');
                            window.location.href = 'Seeker_Sign_In.php';
                        </script>
                    ";
                    }
                }
            } else {
                echo "
                        <script>
                            alert('📝 Please fill in all the required fields before continuing.');
                            window.location.href = 'Seeker_Sign_In.php';
                        </script>
                    ";
            }

            if (!empty($S_S_Mail_Id) && !empty($S_Password)) {
                if ($S_S_Mail_Id == $S_Mail_ID && $S_Password == $Seeker_Password) {
                    $_SESSION['Seeker_ID'] = $S_Seeker_ID;
                    echo "
                        <script>
                            alert('Login Successfull ✨');
                            window.location.href = 'Seeker_Dashboard.php';
                        </script>
                    ";
                }
            }
        }

        // Verification Code

        function Generate_Code($Length = 6)
        {
            $Characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $ID = '';
            $Max_Index = strlen($Characters) - 1;

            for ($i = 0; $i < $Length; $i++) {
                $ID .= $Characters[random_int(0, $Max_Index)];
            }
            return $ID;
        }

        $showSecondModal = false;
        $Show_Resend = false;

        if (isset($_POST['Sent'])) {
            $V_Seeker_Name = $_POST['Seeker_Name'];
            $V_E_Mail = $_POST['E_Mail'];

            $Verification_Code = Generate_Code();
            date_default_timezone_set('Asia/Kolkata');
            $Verification_Code_Timer = date('Y-m-d H:i:s', strtotime('+1 minute'));

            $Verification_Code_Query = "UPDATE `Seeker` SET `Verification_Code` = ? , `Verification_Code_Timer` = ? WHERE E_Mail = ?";
            $Verification_Code_Query_SQL = $Connection->prepare($Verification_Code_Query);
            $Verification_Code_Query_SQL->bind_param("sss", $Verification_Code, $Verification_Code_Timer, $V_E_Mail);
            if ($Verification_Code_Query_SQL->execute()) {
                Sent_Code_Mail($V_Seeker_Name, $V_E_Mail, $Verification_Code);
                echo "
                    <script>
                        alert ('Verification Code Sent Successfully✨');
                        var myModal = new bootstrap.Modal(document.getElementById('exampleModalToggle2'));
                        myModal.show();
                    </script>
                ";
                $showSecondModal = true;
            }
        }

        // New Password

        date_default_timezone_set('Asia/Kolkata');
        $Current_Time = time();

        if (isset($_POST['New_Pass'])) {
            $Fields = [
                'E_Mail',
                'V_Code',
                'N_Password',
                'Re_N_Password'
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

            $Select_Name_Query = "SELECT * FROM `Seeker` WHERE E_Mail = ?";
            $Select_Name_Query_SQL = $Connection->prepare($Select_Name_Query);
            $Select_Name_Query_SQL->bind_param("s", $Cleared['E_Mail']);
            $Select_Name_Query_SQL->execute();
            $Result = $Select_Name_Query_SQL->get_result();

            $First_Name = '';
            $Last_Name = '';
            $Verification_Code = '';
            $Verification_Code_Timer = '';

            if ($Row = $Result->fetch_assoc()) {
                $First_Name                  = $Row['First_Name'];
                $Last_Name                   = $Row['Last_Name'];
                $Verification_Code           = $Row['Verification_Code'];
                $Verification_Code_Timer     = $Row['Verification_Code_Timer'];

                $V_E_Mail = $Cleared['E_Mail'];
                $V_Expert_Name = ucwords(trim($First_Name . ' ' . $Last_Name));

                if (empty($Verification_Code) || empty($Verification_Code_Timer)) {
                    $Show_Resend = True;
                    echo "
                    <script>
                        alert('Your verification code has expired. Please click Resend to get a new code.');
                    </script>
                    ";
                }

                if (!empty($Verification_Code_Timer) && $Current_Time > strtotime($Verification_Code_Timer)) {
                    $Null_Query = "UPDATE `Expert` SET `Verification_Code` = NULL, `Verification_Code_Timer` = NULL WHERE E_Mail = ?";
                    $Null_Query_SQL = $Connection->prepare($Null_Query);
                    $Null_Query_SQL->bind_param("s", $Cleared['E_Mail']);
                    if ($Null_Query_SQL->execute()) {
                        $Show_Resend = true;
                        $showSecondModal = true;
                        echo "
                        <script>
                            alert ('Your verification code has expired. Please click Resend to get a new code.');
                        </script>
                    ";
                    }
                } elseif ($Cleared['V_Code'] === $Verification_Code) {
                    if ($Cleared['N_Password'] === $Cleared['Re_N_Password']) {
                        $Sent_E_Mail = $Cleared['E_Mail'];
                        $Update_Query = "UPDATE `Seeker` SET Password = ?, Verification_Code = '', Verification_Code_Timer = '' WHERE E_Mail = ? AND Verification_Code = ?";
                        $Update_Query_SQL = $Connection->prepare($Update_Query);
                        $Update_Query_SQL->bind_param("sss", $Cleared['N_Password'], $Cleared['E_Mail'], $Cleared['V_Code']);
                        if ($Update_Query_SQL->execute()) {
                            Sent_New_Mail($First_Name, $Last_Name, $Sent_E_Mail);
                            echo "
                                <script>
                                    alert('Password updated successfully. You can now sign in securely ✨');
                                    window.location.href = 'Seeker_Sign_In.php';
                                </script>
                            ";
                        }
                    } else {
                        $showSecondModal = true;
                        echo "
                        <script>
                            alert ('Passwords do not match. Please re-enter and try again.');
                        </script>
                    ";
                    }
                } else {
                    $showSecondModal = True;
                    echo "
                    <script>
                        alert ('Invalid verification code. Please check and try again.');
                    </script>
                ";
                }
            }
        }

        // Re-Send

        function Generate_Re_Send_Code($Length = 6)
        {
            $Characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $ID = '';
            $Max_Index = strlen($Characters) - 1;

            for ($i = 0; $i < $Length; $i++) {
                $ID .= $Characters[random_int(0, $Max_Index)];
            }
            return $ID;
        }
        if (isset($_POST['Re_Send'])) {
            $Re_Seeker_Name = $_POST['Seeker_Name'];
            $Re_Send_E_Mail = $_POST['E_Mail'];

            $Verification_Code = Generate_Re_Send_Code();
            date_default_timezone_set('Asia/Kolkata');
            $Verification_Code_Timer = date('Y-m-d H:i:s', strtotime('+1 minute'));

            $Verification_Code_Query = "UPDATE `Seeker` SET `Verification_Code` = ? , `Verification_Code_Timer` = ? WHERE E_Mail = ?";
            $Verification_Code_Query_SQL = $Connection->prepare($Verification_Code_Query);
            $Verification_Code_Query_SQL->bind_param("sss", $Verification_Code, $Verification_Code_Timer, $Re_Send_E_Mail);
            if ($Verification_Code_Query_SQL->execute()) {
                $V_E_Mail = $Re_Send_E_Mail;
                Sent_Re_Code_Mail($Re_Seeker_Name, $Re_Send_E_Mail, $Verification_Code, $Verification_Code_Timer);
                echo "
                    <script>
                        alert ('Verification Code Sent Successfully✨');
                        var myModal = new bootstrap.Modal(document.getElementById('exampleModalToggle2'));
                        myModal.show();
                    </script>
                ";
                $showSecondModal = true;
            }
        }
    }
    ?>

    <?php if (!empty($showSecondModal)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modalEl = document.getElementById('exampleModalToggle2');
                if (modalEl) {
                    // Open the modal
                    var myModal = new bootstrap.Modal(modalEl, {
                        backdrop: 'static',
                        keyboard: false
                    });
                    myModal.show();

                    // Pre-fill the email field safely
                    var emailInput = modalEl.querySelector('#E_Mail');
                    if (emailInput) {
                        emailInput.value = "<?= addslashes($V_E_Mail ?? '') ?>";
                    }

                    // Show the resend button only if $Show_Resend is true
                    <?php if (!empty($Show_Resend)): ?>
                        var resendBtn = modalEl.querySelector('#resendBtn');
                        if (resendBtn) {
                            resendBtn.style.display = 'inline-block'; // or 'block' depending on your layout
                        }
                    <?php endif; ?>
                }
            });
        </script>
    <?php endif; ?>

    <div class="Wrapper container justify-content-center">
        <div class="w-100 w-md-auto p-3">
            <div class="Seeker-Details">
                <h3 class="Title text-center">Seeker Sign In</h3>
                <p class="Description Quote text-center">Ask questions, explore knowledge, and grow at your own pace.</p>
            </div>
            <div class="Seeker-Form d-flex justify-content-center align-items-center w-100">
                <form method="Post" class="Form-Wrapper mx-auto" novalidate>
                    <div class="Form w-100">
                        <div class="form-group md-3">
                            <label for="Mail_Id">E-Mail Id :</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-at Input-Icon"></i>
                                <input class="form-control" type="email" name="Mail_Id" id="Mail_Id" placeholder="Enter The E-Mail Id" value="<?= $E_Mail_Value ?>" data-next="Password" autofocus required autocomplete="off">
                            </div>
                        </div>
                        <?php if (!empty($E_Mail_Error)) : ?>
                            <p class="ms-2 mt-2 small text-center Error">
                                <?= $E_Mail_Error ?>
                            </p>
                        <?php endif; ?>
                        <div class="form-group md-3">
                            <label for="Password">Password :</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-eye-slash Input-Icon" id="Toggle_Eye"></i>
                                <i class="fa-solid fa-eye Input-Icon" id="" style="display: none;"></i>
                                <input class="form-control" type="password" name="Password" id="Password" placeholder="Enter The Password" required autocomplete="off">
                            </div>
                        </div>
                        <?php if (!empty($Password_Error)) : ?>
                            <p class="ms-2 mt-2 small text-center Error">
                                <?= $Password_Error ?>
                            </p>
                        <?php endif; ?>
                        <div class="row mb-2 me-2">
                            <div class="col d-flex justify-content-end">
                                <a href="" class="Forget_Password" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Forget Password?</a>
                            </div>
                        </div>
                        <div class="Button d-flex justify-content-center gap-4">
                            <button type="submit" name="Submit" class="Submit">Sign In</button>
                            <a href="./Sign_In.php"><button type="button">Back</button></a>
                        </div>
                        <div class="Already text-center mt-3">
                            <p class="small mb-0">
                                Haven’t joined yet? Sign up and start learning!
                                <a href="./Seeker_Sign_Up.php">Sign Up</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Next Field -->

    <script>
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();

                    const nextId = this.dataset.next;
                    if (nextId) {
                        const nextInput = document.getElementById(nextId);
                        if (nextInput) nextInput.focus();
                    }
                }
            });
        });
    </script>

    <!-- Password Focus -->
    <?php if (!empty($Password_Error)) : ?>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const passwordField = document.getElementById("Password");

                if (passwordField) {
                    passwordField.focus();
                }
            });
        </script>
    <?php endif; ?>

    <!-- Eye Icon -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const Password = document.getElementById('Password');
            const ToggleEye = document.getElementById('Toggle_Eye');

            ToggleEye.addEventListener("click", () => {
                if (Password.type === "password") {
                    Password.type = "text";
                    ToggleEye.classList.remove("fa-eye-slash");
                    ToggleEye.classList.add("fa-eye");
                } else {
                    Password.type = "password";
                    ToggleEye.classList.remove("fa-eye");
                    ToggleEye.classList.add("fa-eye-slash");
                }
                Password.focus();
            });
        });
    </script>

    <!-- Forgot Modal -->

    <!-- Modal To send the Verification Code -->
    <div class="modal fade" id="exampleModalToggle" data-bs-backdrop="static" data-bs-heyboard="false" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalToggleLabel">Get Verification Code</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="Seeker_Name" class="col-form-label">Full Name :</label>
                            <input type="text" class="form-control Modal_Input" name="Seeker_Name" id="Seeker_Name" placeholder="Enter Your Full Name." required autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="E_Mail" class="col-form-label">E-Mail :</label>
                            <input class="form-control Modal_Input" type="email" name="E_Mail" id="E_Mail" placeholder="Enter Your E-Mail To Send The Verification Code." required autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" name="Sent">Sent</button>
                        <button class="btn" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal To Set the new Password -->
    <div class="modal fade" id="exampleModalToggle2" data-bs-backdrop="static" data-bs-heyboard="false" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Set New Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input class="form-control Modal_Input" type="hidden" name="Seeker_Name" id="Seeker_Name" value="<?= $V_Seeker_Name ?>" required>
                        <div class="form-group mb-3">
                            <label for="E_Mail" class="col-form-label">E-Mail :</label>
                            <input class="form-control Modal_Input" type="email" name="E_Mail" id="E_Mail" value="<?= $V_E_Mail ?>" required readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="V_Code" class="col-form-label">Verification Code :</label>
                            <input class="form-control Modal_Input" type="text" name="V_Code" id="V_Code" placeholder="Enter The Verification Code." required autocomplete="off">
                        </div>
                        <div class="position-relative">
                            <input class="form-control Modal_Input" type="password" name="N_Password" id="N_Password" placeholder="Enter The New Password." required autocomplete="off">
                            <i class="fa-solid fa-eye-slash Input-Icon" id="N_Toggle_Eye"></i>
                        </div>
                        <div class="form-group mb-3">
                            <label for="Re_N_Password" class="col-form-label">Confirm Password :</label>
                            <div class="position-relative">
                                <input class="form-control Modal_Input" type="password" name="Re_N_Password" id="Re_N_Password" placeholder="Renter The New Password." required autocomplete="off">
                                <i class="fa-solid fa-eye-slash Input-Icon" id="Re_N_Toggle_Eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <div class="Div-1">
                            <?php if (!empty($Show_Resend)): ?>
                                <button class="btn" name="Re_Send" formnovalidate>Resend</button>
                            <?php endif; ?>
                        </div>
                        <div class="Div-2">
                            <button class="btn" name="New_Pass">Sign-In</button>
                            <button class="btn" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Back</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Eye Icon -->
    <script>
        // New Password
        document.addEventListener("click", function(e) {
            if (e.target.id === "N_Toggle_Eye") {
                const password = document.getElementById("N_Password");

                if (password.type === "password") {
                    password.type = "text";
                    e.target.classList.replace("fa-eye-slash", "fa-eye");
                } else {
                    password.type = "password";
                    e.target.classList.replace("fa-eye", "fa-eye-slash");
                }

                password.focus();
            }
        });

        // Confirm Password
        document.addEventListener("click", function(e) {
            if (e.target.id === "Re_N_Toggle_Eye") {
                const password = document.getElementById("Re_N_Password");

                if (password.type === "password") {
                    password.type = "text";
                    e.target.classList.replace("fa-eye-slash", "fa-eye");
                } else {
                    password.type = "password";
                    e.target.classList.replace("fa-eye", "fa-eye-slash");
                }

                password.focus();
            }
        });
    </script>

</body>

</html>