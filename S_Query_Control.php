<?php
include './Seeker_Dashboard.php';
?>
<!-- <style>
    .guide-wrapper {
        position: fixed;
        bottom: 325px;
        left: -100;
        animation: guideWalkIn 2.5s ease-out forwards;
    }
</style> -->
<link rel="stylesheet" href="./S_Select_Panel.css">

<main class="content p-2">
    <script>
        const mascot = document.getElementById('guideMascot');

        setTimeout(() => {
            mascot.setAttribute('src', './animations/guide-idle.json');
        }, 2600);
    </script>

    <div class="Main-Content d-flex justify-content-center align-items-center p-2">
        <div class="Wrapper container justify-content-center">
            <div class="Header">
                <h1 class="text-center">Raise a Query</h1>
                <p class="Quote text-center mt-2 p-3">
                    Initiate queries by connecting with navigating streams or experts—structured, focused, and built for clarity.
                </p>
            </div>

            <!-- Lottie Script -->
            <!-- <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script> -->
            <!-- Guide Mascot -->
            <!-- <div class="guide-wrapper">
                <lottie-player
                    id="guideMascot"
                    src="./Man on Rocket.json"
                    background="transparent"
                    speed="1"
                    style="width: 150px; height: 150px;"
                    autoplay>
                </lottie-player>
            </div> -->
            <div class="Body d-flex justify-content-center gap-5 m-5">

                <button type="button" onclick="window.location.href = 'S_Streams_Query.php'" class="btn p-2 shadow">Streams</button>

                <button type="button" onclick="window.location.href = 'S_Experts_Query.php'" class="btn p-2 shadow">Experts</button>
            </div>
        </div>
    </div>
</main>
</div>
</div>