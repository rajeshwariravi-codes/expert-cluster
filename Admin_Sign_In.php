<?php
include "./Database.php";
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
    if ($Connection) {
        $E_Mail = "";
        if (isset($_POST['Submit'])) {
            $E_Mail_ID      = $_POST["Mail_Id"];
            $Admin_Password = $_POST["Password"];

            $E_Mail_Error = "";
            $Password_Error = "";
            if (!empty($E_Mail_ID) && !empty($Admin_Password)) {
                if (!preg_match('~[\w\.-]+@[\w\.-]+\.\w{2,}~', $E_Mail_ID)) {
                    $E_Mail_Error = "Please enter a valid email address.";
                } elseif (!preg_match('~^(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$~', $Admin_Password)) {
                    $Password_Error = "*Password must be at least 8 characters, include 1 uppercase letter and 1 number, and a special character (@ $ ! % * ? &).";
                    $E_Mail = $E_Mail_ID;
                } else {
                    $Select_Query = "SELECT * FROM Admin WHERE Mail_Id = ? AND Password = ?";
                    $Select_Query_SQL = $Connection->prepare($Select_Query);
                    $Select_Query_SQL->bind_param("ss", $E_Mail_ID, $Admin_Password);
                    $Select_Query_SQL->execute();
                    $Result = $Select_Query_SQL->get_result();

                    if ($Row = $Result->fetch_assoc()) {
                        $A_E_Mail_Id    = $Row['Mail_Id'];
                        $A_Password     = $Row['Password'];
                    } else {
                        echo "
                        <script>
                            alert('⚠️ Credentials don’t match. Please double-check and try again.');
                        </script>
                    ";
                    }
                }
            } else {
                echo "
                        <script>
                            alert('📝 Please fill in all the required fields before continuing.');
                        </script>
                    ";
            }

            if (!empty($A_E_Mail_Id) && !empty($A_Password)) {
                if ($A_E_Mail_Id == $E_Mail_ID && $A_Password == $Admin_Password) {
                    echo "
                        <script>
                            alert('Login Successfull ✨');
                            window.location.href = 'Admin_Dashboard.php';
                        </script>
                    ";
                }
            }
        }
    }
    ?>

    <div class="Wrapper container justify-content-center">
        <div class="w-100 w-md-auto p-3">
            <div class="Admin-Details">
                <h3 class="Title text-center">Admin Sign In</h3>
                <p class="Description Quote text-center">Oversee the platform, manage users, and keep the system running smoothly.</p>
            </div>
            <div class="Admin-Form d-flex justify-content-center align-items-center w-100">
                <form method="Post" class="Form-Wrapper mx-auto" novalidate>
                    <div class="Form w-100">
                        <div class="form-group md-3">
                            <label for="Mail_Id">E-Mail Id :</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-at Input-Icon"></i>
                                <input class="form-control" type="email" name="Mail_Id" id="Mail_Id" placeholder="Enter The E-Mail Id" value="<?= $E_Mail ?>" data-next="Password" autofocus autocomplete="off" required>
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
                        <div class="Button d-flex justify-content-center gap-4">
                            <button type="submit" name="Submit" class="Submit">Sign In</button>
                            <a href="./Sign_In.php"><button type="button">Back</button></a>
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
</body>

</html>