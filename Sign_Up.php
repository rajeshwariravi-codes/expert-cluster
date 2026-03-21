<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expert Cluster | Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="./Expert Cluster Images/Expert Cluster.jpg">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Aboreto&family=Big+Shoulders+Stencil:opsz,wght@10..72,100..900&family=Cinzel:wght@400..900&family=Cormorant+Upright:wght@300;400;500;600;700&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Pacifico&family=Text+Me+One&family=Zilla+Slab+Highlight:wght@400;700&display=swap');

    body {
        background-image: linear-gradient(to right,
                rgba(238, 131, 242, 0.2),
                rgba(225, 205, 230, 0.2)),
            url("Expert_Cluster_Images/Expert_Cluster_Image_1.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        color: white;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .Wrapper {
        width: 100%;
        max-width: 1000px;
        background: #eea77434;
        border-radius: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
        overflow: hidden;
        padding: 5%;
    }

    .Head {
        padding: 0 0 3% 0;
    }

    .Head h2 {
        font-family: "Aboreto";
        font-size: clamp(2.5rem, 3vw, 4rem);
        font-weight: 500;
    }

    .Head h3 {
        font-family: "Cormorant Upright";
        font-size: clamp(1.5rem, 2vw, 3rem);
        font-weight: 300;
    }

    button {
        flex: 1 1 200px;
        padding: 20px;
        background: transparent;
        border-radius: 25px;
        background-color: rgba(134, 165, 236, 0.15);
        color: white;
        border: none;
        box-shadow: 0 10px 30px rgba(73, 11, 89, 0.15);
        cursor: pointer;
        transition:
            transform 0.35s ease,
            box-shadow 0.35s ease;
        will-change: transform, box-shadow;
    }

    .Division-Section button:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 18px 45px rgba(73, 11, 89, 0.35);
    }

    .Admin-Head i,
    .Expert-Head i,
    .Seeker-Head i {
        padding: 0 0 5% 0;
        font-size: clamp(2rem, 2.5vw, 3rem);
    }

    .Title {
        font-family: "Josefin Sans";
        font-size: clamp(1.5rem, 2vw, 2.5rem);
        font-weight: 400;
    }

    .Description {
        font-family: "Cormorant Upright";
        font-size: clamp(1.3rem, 1vw, 2rem);
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
</style>

<body>
    <div class="Wrapper container">
        <div class="Head">
            <h2 class="text-center">Expert Cluster</h2>
            <h3 class="Quote text-center">A space to learn, lead, and level up.</h3>
        </div>
        <div class="Division-Section d-flex flex-wrap justify-content-center gap-4">

            <button class="w-100 w-md-auto  " onclick="window.location.href = 'Expert_Sign_Up.php'">
                <div class="Expert-Section p-3">
                    <div class="Expert-Head">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="Expert-Details">
                        <h3 class="Title">Expert Register</h3>
                        <p class="Description Quote">Share expertise, resolve queries, and guide learners with confidence.</p>
                    </div>
                </div>
            </button>

            <button class="w-100 w-md-auto" onclick="window.location.href = 'Seeker_Sign_Up.php'">
                <div class="Seeker-Section p-3">
                    <div class="Seeker-Head">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div class="Seeker-Details">
                        <h3 class="Title">Seeker Register</h3>
                        <p class="Description Quote">Ask questions, explore knowledge, and grow at your own pace.</p>
                    </div>
                </div>
            </button>
        </div>
        <div class="Bottom text-center pt-5">
            <a href="Expert_Cluster.php">Back To Home</a>
        </div>
    </div>

    <!-- Prevent The Right Click -->
    <script>
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    </script>

</body>

</html>S