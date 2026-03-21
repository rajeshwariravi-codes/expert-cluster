
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .dashboard-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .dashboard-title {
            font-size: 2.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
            font-weight: 800;
        }
        
        .dashboard-subtitle {
            color: #666;
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .category-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
        }
        
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
        }
        
        .category-card.active {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border-color: #667eea;
        }
        
        .card-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            font-size: 30px;
            color: white;
            transition: all 0.3s ease;
        }
        
        .category-card:hover .card-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }
        
        .card-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }
        
        .card-count {
            display: inline-block;
            padding: 5px 15px;
            background: #f8f9fa;
            border-radius: 20px;
            font-weight: 600;
            color: #667eea;
            font-size: 0.9rem;
        }
        
        /* Category-specific colors */
        .new-enquiry-card .card-icon { background: linear-gradient(135deg, #2ecc71, #27ae60); }
        .assigned-card .card-icon { background: linear-gradient(135deg, #3498db, #2980b9); }
        .on-process-card .card-icon { background: linear-gradient(135deg, #f39c12, #e67e22); }
        .walk-in-card .card-icon { background: linear-gradient(135deg, #9b59b6, #8e44ad); }
        .closed-card .card-icon { background: linear-gradient(135deg, #e74c3c, #c0392b); }
        .register-card .card-icon { background: linear-gradient(135deg, #1abc9c, #16a085); }
        
        /* Options Panel */
        .options-panel {
            display: none;
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.4s ease-out;
        }
        
        .options-panel.active {
            display: block;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .panel-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }
        
        .close-panel {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #999;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .close-panel:hover {
            color: #e74c3c;
        }
        
        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .option-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
            border: 2px solid transparent;
        }
        
        .option-card:hover {
            background: #667eea;
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            border-color: #667eea;
        }
        
        .option-icon {
            font-size: 2rem;
            margin-bottom: 15px;
        }
        
        .option-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .option-desc {
            font-size: 0.85rem;
            opacity: 0.8;
        }
        
        /* Category-specific option colors */
        .new-enquiry-options .option-card:hover { background: #2ecc71; border-color: #2ecc71; }
        .assigned-options .option-card:hover { background: #3498db; border-color: #3498db; }
        .on-process-options .option-card:hover { background: #f39c12; border-color: #f39c12; }
        .walk-in-options .option-card:hover { background: #9b59b6; border-color: #9b59b6; }
        .closed-options .option-card:hover { background: #e74c3c; border-color: #e74c3c; }
        .register-options .option-card:hover { background: #1abc9c; border-color: #1abc9c; }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 25px 20px;
            }
            
            .dashboard-title {
                font-size: 2rem;
            }
            
            .categories-grid {
                grid-template-columns: 1fr;
            }
            
            .options-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .dashboard-container {
                padding: 20px 15px;
            }
            
            .dashboard-title {
                font-size: 1.8rem;
            }
            
            .card-icon {
                width: 60px;
                height: 60px;
                font-size: 25px;
            }
        }
        
        /* Stats Badge */
        .stats-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #e74c3c;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Enquiry Management Dashboard</h1>
            <p class="dashboard-subtitle">
                Select a category to view and manage different types of enquiries. 
                Each category provides specific options tailored to your needs.
            </p>
        </div>
        
        <div class="categories-grid">
            <!-- New Enquiry Card -->
            <div class="category-card new-enquiry-card" onclick="showOptions('new-enquiry')">
                <div class="card-icon">📋</div>
                <h3 class="card-title">New Enquiry</h3>
                <p class="card-description">Create and manage new enquiries from various sources</p>
                <span class="card-count">4 Options</span>
                <div class="stats-badge">New</div>
            </div>
            
            <!-- Assigned Enquiry Card -->
            <div class="category-card assigned-card" onclick="showOptions('assigned')">
                <div class="card-icon">👥</div>
                <h3 class="card-title">Assigned Enquiry</h3>
                <p class="card-description">View and manage enquiries assigned to team members</p>
                <span class="card-count">4 Options</span>
            </div>
            
            <!-- On Processing Card -->
            <div class="category-card on-process-card" onclick="showOptions('on-process')">
                <div class="card-icon">⚙️</div>
                <h3 class="card-title">On Processing</h3>
                <p class="card-description">Monitor enquiries currently being processed</p>
                <span class="card-count">4 Options</span>
            </div>
            
            <!-- Walk-In Enquiry Card -->
            <div class="category-card walk-in-card" onclick="showOptions('walk-in')">
                <div class="card-icon">🚶</div>
                <h3 class="card-title">Walk-In Enquiry</h3>
                <p class="card-description">Handle walk-in customer enquiries</p>
                <span class="card-count">4 Options</span>
            </div>
            
            <!-- Closed Enquiry Card -->
            <div class="category-card closed-card" onclick="showOptions('closed')">
                <div class="card-icon">✅</div>
                <h3 class="card-title">Closed Enquiry</h3>
                <p class="card-description">Review completed and closed enquiries</p>
                <span class="card-count">2 Options</span>
            </div>
            
            <!-- Registered Card -->
            <div class="category-card register-card" onclick="showOptions('register')">
                <div class="card-icon">📝</div>
                <h3 class="card-title">Registered</h3>
                <p class="card-description">Access registration records and student data</p>
                <span class="card-count">4 Options</span>
            </div>
        </div>
        
        <!-- Options Panels -->
        <div id="new-enquiry-options" class="options-panel new-enquiry-options">
            <div class="panel-header">
                <h3 class="panel-title">New Enquiry Options</h3>
                <button class="close-panel" onclick="hideOptions()">×</button>
            </div>
            <div class="options-grid">
                <a href="./Admin_New_Enquiry_By_Admin.php" class="option-card">
                    <div class="option-icon">👨‍💼</div>
                    <div class="option-title">Admin New</div>
                    <div class="option-desc">Create new enquiry by admin</div>
                </a>
                <a href="./Admin_New_Enquiry_By_Recruiter.php" class="option-card">
                    <div class="option-icon">👩‍💼</div>
                    <div class="option-title">Recruiter New</div>
                    <div class="option-desc">New enquiry by recruiter</div>
                </a>
                <a href="./Admin_New_Job_By_Admin.php" class="option-card">
                    <div class="option-icon">💼</div>
                    <div class="option-title">Admin Job New</div>
                    <div class="option-desc">Job enquiries by admin</div>
                </a>
                <a href="./Admin_New_Job_By_Recruiter.php" class="option-card">
                    <div class="option-icon">👔</div>
                    <div class="option-title">Recruiter Job New</div>
                    <div class="option-desc">Job enquiries by recruiter</div>
                </a>
            </div>
        </div>
        
        <div id="assigned-options" class="options-panel assigned-options">
            <div class="panel-header">
                <h3 class="panel-title">Assigned Enquiry Options</h3>
                <button class="close-panel" onclick="hideOptions()">×</button>
            </div>
            <div class="options-grid">
                <a href="#" class="option-card">
                    <div class="option-icon">👨‍💼</div>
                    <div class="option-title">Admin Assigned</div>
                    <div class="option-desc">Enquiries assigned to admin</div>
                </a>
                <a href="./Admin_Existing_Assign_Enquiry.php" class="option-card">
                    <div class="option-icon">👩‍💼</div>
                    <div class="option-title">Recruiter Assigned</div>
                    <div class="option-desc">Enquiries assigned to recruiters</div>
                </a>
                <a href="#" class="option-card">
                    <div class="option-icon">💼</div>
                    <div class="option-title">Admin Job Assigned</div>
                    <div class="option-desc">Job enquiries assigned to admin</div>
                </a>
                <a href="#" class="option-card">
                    <div class="option-icon">👔</div>
                    <div class="option-title">Recruiter Job Assigned</div>
                    <div class="option-desc">Job enquiries assigned to recruiters</div>
                </a>
            </div>
        </div>
        
        <!-- Add similar option panels for other categories -->
        <div id="on-process-options" class="options-panel on-process-options">
            <div class="panel-header">
                <h3 class="panel-title">On Processing Options</h3>
                <button class="close-panel" onclick="hideOptions()">×</button>
            </div>
            <div class="options-grid">
                <a href="./Admin_On_Processing_By_Admin.php" class="option-card">
                    <div class="option-icon">👨‍💼</div>
                    <div class="option-title">Admin Processing</div>
                    <div class="option-desc">Processing by admin</div>
                </a>
                <a href="./Admin_On_Processing_By_Recruiter.php" class="option-card">
                    <div class="option-icon">👩‍💼</div>
                    <div class="option-title">Recruiter Processing</div>
                    <div class="option-desc">Processing by recruiter</div>
                </a>
                <a href="./Admin_On_Processing_Job_By_Admin.php" class="option-card">
                    <div class="option-icon">💼</div>
                    <div class="option-title">Admin Job Processing</div>
                    <div class="option-desc">Job processing by admin</div>
                </a>
                <a href="./Admin_On_Processing_Job_By_Recruiter.php" class="option-card">
                    <div class="option-icon">👔</div>
                    <div class="option-title">Recruiter Job Processing</div>
                    <div class="option-desc">Job processing by recruiter</div>
                </a>
            </div>
        </div>
        
        <div id="closed-options" class="options-panel closed-options">
            <div class="panel-header">
                <h3 class="panel-title">Closed Enquiry Options</h3>
                <button class="close-panel" onclick="hideOptions()">×</button>
            </div>
            <div class="options-grid">
                <a href="./Admin_Closed_Enquiry.php" class="option-card">
                    <div class="option-icon">📄</div>
                    <div class="option-title">Closed Enquiry</div>
                    <div class="option-desc">View closed enquiries</div>
                </a>
                <a href="./Admin_Closed_Job_Enquiry.php" class="option-card">
                    <div class="option-icon">📋</div>
                    <div class="option-title">Closed Job Enquiry</div>
                    <div class="option-desc">View closed job enquiries</div>
                </a>
            </div>
        </div>
        
        <div id="register-options" class="options-panel register-options">
            <div class="panel-header">
                <h3 class="panel-title">Registered Options</h3>
                <button class="close-panel" onclick="hideOptions()">×</button>
            </div>
            <div class="options-grid">
                <a href="./Admin_Registered_Enquiry.php" class="option-card">
                    <div class="option-icon">📊</div>
                    <div class="option-title">Current Registered</div>
                    <div class="option-desc">Current registered enquiries</div>
                </a>
                <a href="./Admin_Registered_Job_Enquiry.php" class="option-card">
                    <div class="option-icon">📈</div>
                    <div class="option-title">Previous Registered</div>
                    <div class="option-desc">Previous registered enquiries</div>
                </a>
                <a href="#" class="option-card">
                    <div class="option-icon">🌐</div>
                    <div class="option-title">Online Registration</div>
                    <div class="option-desc">Online registration portal</div>
                </a>
                <a href="#" class="option-card">
                    <div class="option-icon">🎓</div>
                    <div class="option-title">AR Intern Students</div>
                    <div class="option-desc">Intern student records</div>
                </a>
            </div>
        </div>
    </div>

    <script>
        let activeCategory = null;
        let activeCard = null;
        
        function showOptions(category) {
            // Hide all options panels
            const allPanels = document.querySelectorAll('.options-panel');
            allPanels.forEach(panel => {
                panel.classList.remove('active');
            });
            
            // Remove active class from all cards
            const allCards = document.querySelectorAll('.category-card');
            allCards.forEach(card => {
                card.classList.remove('active');
            });
            
            // If clicking the same category, close it
            if (activeCategory === category) {
                activeCategory = null;
                activeCard = null;
                return;
            }
            
            // Show the selected panel
            const selectedPanel = document.getElementById(category + '-options');
            if (selectedPanel) {
                selectedPanel.classList.add('active');
                activeCategory = category;
                
                // Add active class to clicked card
                const clickedCard = event.currentTarget;
                clickedCard.classList.add('active');
                activeCard = clickedCard;
                
                // Scroll to the panel
                selectedPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
        
        function hideOptions() {
            const allPanels = document.querySelectorAll('.options-panel');
            allPanels.forEach(panel => {
                panel.classList.remove('active');
            });
            
            const allCards = document.querySelectorAll('.category-card');
            allCards.forEach(card => {
                card.classList.remove('active');
            });
            
            activeCategory = null;
            activeCard = null;
        }
        
        // Close panel when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = event.target.closest('.dashboard-container');
            if (!isClickInside) {
                hideOptions();
            }
        });
        
        // Add keyboard navigation
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideOptions();
            }
        });
    </script>
</body>
</html>