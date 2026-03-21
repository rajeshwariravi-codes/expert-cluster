    <?php
    include './Admin_Dashboard.php';
    ?>
    <link rel="stylesheet" href="./Control_Panel.css">

    <main class="content p-2">
        <div class="Main-Content d-flex justify-content-center align-items-center p-2">
            <div class="Wrapper container justify-content-center">
                <div class="Header">
                    <h1 class="text-center">Expert Access Control</h1>
                    <p class="Quote text-center mt-2">
                        Manage expert permissions, roles, and system-level access with precision.
                    </p>
                </div>
                <div class="Body d-flex justify-content-center gap-5 m-5">
                    <div class="card">
                        <div class="card-content d-flex flex-column justify-content-center align-items-center">
                            <div class="card-icon" style="background: linear-gradient(135deg, #1abc9c, #16a085);">☑️</div>
                            <div class="card-title">Activate Experts</div>
                            <div class="card-body text-center">
                                <p>Grant access to new or pending experts to start contributing.</p>
                            </div>
                        </div>
                        <div class="card-footer w-100">
                            <button type="button" onclick="window.location.href = 'A_Expert_Access_Activate.php'" class="btn p-2">Activate</button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content d-flex flex-column justify-content-center align-items-center">
                            <div class="card-icon" style="background: linear-gradient(135deg, #3498db, #2980b9); font-size: 1.2rem;">❌</div>
                            <div class="card-title">Restrict Experts</div>
                            <div class="card-body text-center">
                                <p>Limit expert access to control participation and permissions.</p>
                            </div>
                        </div>
                        <div class="card-footer w-100">
                            <button type="button" onclick="window.location.href = 'A_Expert_Access_Restrict.php'" class="btn p-2">Restrict</button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content d-flex flex-column justify-content-center align-items-center">
                            <div class="card-icon" style="background: linear-gradient(135deg, #781396ff, #591b6cff);">♻️</div>
                        <div class="card-title">Reactivate Experts</div>
                        <div class="card-body text-center">
                            <p>Restore access for previously restricted experts.</p>
                        </div>
                        </div>
                        <div class="card-footer w-100">
                            <button type="button" onclick="window.location.href = 'A_Expert_Access_Reactivate.php'" class="btn p-2">Reactivate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
    </div>