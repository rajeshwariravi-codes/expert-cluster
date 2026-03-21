<?php
include "./Database.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta Charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expert Cluster | Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="./Expert_Cluster_Images/Expert Cluster.jpg">
    <!-- Css File -->
    <link rel="stylesheet" href="./Sign_Up.css">
</head>

<body>

    <?php

    if ($Connection) {
        function Generate_Id()
        {
            $Characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $ID = '';
            for ($i = 0; $i < 6; $i++) {
                $ID .= $Characters[mt_rand(0, strlen($Characters) - 1)];
            }
            return "SE" . $ID;
        }
        $E_Mail_Value = "";
        if (isset($_POST['Submit'])) {
            $S_Mail_ID       = $_POST["Mail_Id"];
            $Seeker_Password = $_POST["Password"];
            $Seeker_ID       = Generate_Id();

            $S_Mail_Error = "";
            $Password_Error = "";

            $E_Mail = [];

            $Select_Query = "SELECT E_Mail FROM Seeker";
            $Select_Query_SQL = $Connection->prepare($Select_Query);
            $Select_Query_SQL->execute();
            $Result = $Select_Query_SQL->get_result();
            while ($Row = $Result->fetch_assoc()) {
                $E_Mail[] = $Row['E_Mail'];
            }

            $Old_E_Mail = "";

            if (!empty($S_Mail_ID) && !empty($Seeker_Password)) {
                if (!preg_match('~[\w\.-]+@[\w\.-]+\.\w{2,}~', $S_Mail_ID)) {
                    $S_Mail_Error = "Please enter a valid email address.";
                    $E_Mail_Value = "";
                } elseif (!preg_match('~^(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$~', $Seeker_Password)) {
                    $Password_Error = "*Password must be at least 8 characters, include 1 uppercase letter and 1 number, and a special character (@ $ ! % * ? &).";
                    $E_Mail_Value = $S_Mail_ID;
                } elseif (in_array($S_Mail_ID, $E_Mail)) {
                    $Old_E_Mail = "Looks like this email is already i use. Try registering with another one.";
                    $E_Mail_Value = $S_Mail_ID;
                } else {
                    $Insert_Query = "INSERT INTO `Seeker`(`Seeker_ID`, `E_Mail`, `Password`) VALUES (?, ?, ?)";
                    $Insert_Query_SQL = $Connection->prepare($Insert_Query);
                    $Insert_Query_SQL->bind_param("sss", $Seeker_ID, $S_Mail_ID, $Seeker_Password);
                    $Insert_Query_SQL->execute();
                    $_SESSION['E_Mail_ID'] = $S_Mail_ID;
                    $_SESSION['Seeker_ID'] = $Seeker_ID;

                    echo "
                        <script>
                            alert ('📄Please Enter The Register Form.');
                            window.location.href = './Seeker_Register_Form.php';
                        </script>
                    ";
                }
            } else {
                echo "
                <script>
                alert('📝 Please fill in all the required fields before continuing.');
                </script>
                ";
                $E_Mail_Value = $S_Mail_ID;
            }
        }
    }
    ?>

    <div class="Wrapper container justify-content-center">
        <div class="w-100 w-md-auto p-3">
            <div class="Seeker-Details">
                <h3 class="Title text-center">Seeker Sign Up</h3>
                <p class="Description Quote text-center">A space to learn, lead, and level up.</p>
            </div>
            <div class="Seeker-Form d-flex justify-content-center align-items-center w-100">
                <form method="Post" class="Form-Wrapper mx-auto" novalidate>
                    <div class="Form w-100">
                        <div class="form-group md-3">
                            <label for="Mail_Id">E-Mail Id :</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-at Input-Icon"></i>
                                <input class="form-control" type="email" name="Mail_Id" id="Mail_Id" placeholder="Enter The E-Mail Id" value="<?= $E_Mail_Value; ?>" required data-next="Password" autofocus autocomplete="off">
                            </div>
                        </div>
                        <?php if (!empty($S_Mail_Error)) : ?>
                            <p class="text-center ms-2 mt-2 small Error">
                                <?= $S_Mail_Error; ?>
                            </p>
                        <?php endif; ?>
                        <?php if (!empty($Old_E_Mail)) : ?>
                            <p class="ms-2 mt-2 small text-center Error">
                                <?= $Old_E_Mail ?>
                            </p>
                        <?php endif; ?>
                        <div class="form-group md-3">
                            <label for="Password">Password :</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-eye-slash Input-Icon" id="Toggle_Eye"></i>
                                <i class="fa-solid fa-eye Input-Icon" id="" style="display: none;"></i>
                                <input class="form-control" type="password" name="Password" id="Password" placeholder="Enter The Password" required>
                            </div>
                        </div>
                        <?php if (!empty($Password_Error)) : ?>
                            <p class="text-center ms-2 mt-2 small Error">
                                <?= $Password_Error ?>
                            </p>
                        <?php endif; ?>
                        <div class="Button d-flex justify-content-center gap-4 mt-4">
                            <button type="submit" name="Submit" class="Submit">Sign Up</button>
                            <a href="./Sign_Up.php"><button type="button">Back</button></a>
                        </div>
                        <div class="Already text-center mt-2">
                            <p class="small mb-0">
                                Have an account? Log in here.
                                <a href="./Seeker_Sign_In.php">Sign In</a>
                            </p>
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
                if (e.key == "Enter") {
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
</body>

</html>