<?php
include './Admin_Dashboard.php';
?>
<link rel="stylesheet" href="./A_Select_Panel.css">

<main class="content p-2">
    <div class="Main-Content d-flex justify-content-center align-items-center p-2">
        <div class="Wrapper container justify-content-center">
            <div class="Header">
                <h1 class="text-center">Core Records</h1>
                <p class="Quote text-center mt-2">
                    Centralize and manage expert, seeker, and stream records with structured oversight and system-level clarity.
                </p>
            </div>
            <div class="Body d-flex justify-content-center gap-5 m-5">
                <button type="button" onclick="window.location.href = 'A_Experts_Records.php'" class="btn p-2 shadow">Experts</button>

                <button type="button" onclick="window.location.href = 'A_Seekers_Records.php'" class="btn p-2 shadow">Seekers</button>

                <button type="button" onclick="window.location.href = 'A_Streams_Records.php'" class="btn p-2 shadow">Streams</button>
            </div>
        </div>
    </div>
</main>
</div>
</div>