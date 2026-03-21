<?php
include './Admin_Dashboard.php';
?>
<link rel="stylesheet" href="./Control_Panel.css">

<main class="content p-2">
    <div class="Main-Content d-flex justify-content-center align-items-center p-2">
        <div class="Wrapper container justify-content-center">
            <div class="Header">
                <h1 class="text-center">Stream Access Control</h1>
                <p class="Quote text-center mt-2">
                    Manage stream permissions, roles, and system-level access with precision and control.
                </p>
            </div>
            <div class="Body d-flex justify-content-center gap-5 m-5">

                <div class="card">
                    <div class="card-content d-flex flex-column justify-content-center align-items-center">
                        <div class="card-icon" style="background: linear-gradient(135deg, #3498db, #2980b9); font-size: 1.2rem;">❌</div>
                        <div class="card-title">Restrict Stream</div>
                        <div class="card-body text-center">
                            <p>Manage stream access by granting or denying seeker permissions.</p>
                        </div>
                    </div>
                    <div class="card-footer w-100">
                        <button type="button" onclick="window.location.href = 'A_Stream_Access_Restrict.php'" class="btn p-2">Restrict</button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content d-flex flex-column justify-content-center align-items-center">
                        <div class="card-icon" style="background: linear-gradient(135deg, #781396ff, #591b6cff);">♻️</div>
                        <div class="card-title">Reactivate Stream</div>
                        <div class="card-body text-center">
                            <p>Access has been re-granted, restoring stream permissions.</p>
                        </div>
                    </div>
                    <div class="card-footer w-100">
                        <button type="button" onclick="window.location.href = 'A_Stream_Access_Reactivate.php'" class="btn p-2">Reactivate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</div>