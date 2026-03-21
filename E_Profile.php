<?php
include './Expert_Dashboard.php';
include './Database.php';
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Aboreto&family=Big+Shoulders+Stencil:opsz,wght@10..72,100..900&family=Cinzel:wght@400..900&family=Cormorant+Upright:wght@300;400;500;600;700&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Pacifico&family=Radley:ital@0;1&family=Text+Me+One&family=Zilla+Slab+Highlight:wght@400;700&display=swap');

    .Main-Content {
        /* height: calc(100vh - 8rem); */
        height: 100vh;
        overflow: hidden;
        margin: 20px;
    }

    .Wrapper {
        width: 100%;
        max-width: 900px;
        border-radius: 40px;
        overflow: hidden;
        padding: 20px 0px;
        border-radius: 15px;
        background-color: rgba(188, 58, 214, 0.3);
        color: #350a3ec5;
        border: none;
        box-shadow: 0 10px 30px rgba(73, 11, 89, 0.15);
        cursor: pointer;
    }

    .Header h1 {
        font-family: "Cinzel";
        color: #ffffff;
        font-size: clamp(1.8rem, 2.2vw, 2rem);
    }

    .main-right {
        background-color: rgba(242, 232, 244, 0.4);
        border-radius: 5px;
    }

    .main-left .rounded {
        border: #f4c7f5 solid 5px;
    }

    .main-left .Expert-Name,
    .main-left .Expert-Designation {
        color: #ffffff;
        font-family: "Radley";
    }

    label {
        color: #ffffff;
    }

    .Right input,
    .Left input {
        background: transparent;
        border: 1px #ffffff solid;
        border-radius: 5px;
        color: #ffffff;
        font-family: "Radley";
        font-size: clamp(1rem, 1.3vw, 1.1rem);
        font-weight: 100;
    }

    input:focus {
        background: transparent !important;
        border: 2px solid #ffffff;
        color: #ffffff !important;
    }

    .input-group-text {
        border: 2px #ffffff solid;
        color: rgba(32, 3, 40, 0.9);
    }

    .required-label::after {
        content: " *";
        color: #ffffff;
    }

    .btn {
        width: 100%;
        min-height: 60px;
        background: linear-gradient(135deg, #9120e7 0%, #a747f1 100%);
        color: #ffffffb5;
        font-family: "Josefin Sans";
        font-size: clamp(1rem, 1.6vw, 1.4rem);
        border-radius: 0.5rem;
        transition:
            transform 0.35s cubic-bezier(0.4, 0, 0.2, 1),
            box-shadow 0.35s ease;
    }

    .btn:hover,
    .btn:active {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(190, 30, 225, 0.35);
        color: #ffffff;
    }

    @media (max-width: 992px) {
        .Body {
            flex-wrap: wrap;
        }
    }
</style>
<?php
if ($Connection) {
    $Select_Query = "SELECT * FROM `Expert` WHERE `Expert_ID` = ?";
    $Select_Query_SQL = $Connection->prepare($Select_Query);
    $Select_Query_SQL->bind_param("s", $Expert_ID);
    $Select_Query_SQL->execute();
    $Result = $Select_Query_SQL->get_result();
    if ($Row = $Result->fetch_assoc()) {
        $Expert_Name = $Row['First_Name'] . " " . $Row['Last_Name'];
        $Expert_Pic = $Row['Profile_Pic'];
        $Expert_Phone_No = $Row['Phone_Number'];
        $Expert_City = $Row['City'];
        $Expert_Country = $Row['Country'];
        $Expert_Qualification = $Row['Qualification'];
        $Expert_Expert_In = $Row['Expert_In'];
        $Expert_Designation = $Row['Designation'];
        $Expert_Organization_Name = $Row['Organization_Name'];
        $Expert_Years_of_Experience = $Row['Years_of_Experience'];
    }
}
?>
<main class="content p-2">
    <div class="Main-Content d-flex justify-content-center align-items-center p-2">
        <div class="Wrapper container justify-content-center">
            <div class="Header">
                <h1 class="text-start my-5 px-5">My Profile</h1>
            </div>
            <div class="Body d-flex flex-column justify-content-center gap-5 m-5">
                <div class="main-left">
                    <img class="rounded d-block mx-auto" style="width: 30%;" src="./Expert_Cluster_Official_Images/Expert_Profile_Pic/<?= $Expert_Pic ?>" alt="<?= $Expert_Name ?>">

                    <h3 class="Expert-Name text-center mt-2 mb-1"><?= $Expert_Name ?></h3>
                    <h5 class="Expert-Designation text-center mb-2"><?= $Expert_Designation ?></h5>
                </div>
                <div class="Content d-flex justify-content-center">
                    <div class="main-right d-flex flex-md-row flex-column p-3">
                        <div class="Right p-3">
                            <div class="section mb-3">
                                <label for="name" class="form-label required-label px-1 fw-bold">Name:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" class="form-control text-start px-4" name="name" id="name" value="<?= $Expert_Name ?>" readonly>
                                </div>
                            </div>
                            <div class="section mb-3">
                                <label for="Phone_No" class="form-label required-label px-1 fw-bold">Phone Number:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" class="form-control text-start px-4" name="Phone_No" id="Phone_No" value="<?= $Expert_Phone_No ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="Left p-3">
                            <div class="section mb-3">
                                <label for="Address" class="form-label required-label px-1 fw-bold">Address:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                                    <input type="text" class="form-control text-start px-4" name="Address" id="Address" value="<?= $Expert_City ?>,<?= $Expert_Country ?>" readonly>
                                </div>
                            </div>
                            <div class="section mb-3">
                                <label for="Qualification" class="form-label required-label px-1 fw-bold">Qualification:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user-graduate"></i></span>
                                    <input type="text" class="form-control text-start px-4" name="Qualification" id="Qualification" value="<?= $Expert_Qualification ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</div>