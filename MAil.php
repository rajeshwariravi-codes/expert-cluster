


Fatal error: Uncaught Error: Call to undefined function sendeliteemail() in C:\xampp\htdocs\Expert_Cluster_Nova\A_Learner_Sent_Elite_Queries.php:268 Stack trace: #0 {main} thrown in C:\xampp\htdocs\Expert_Cluster_Nova\A_Learner_Sent_Elite_Queries.php on line 268     <?php
  session_start();
  $Seeker_ID = $_SESSION["Seeker_ID"];
  $E_ID = $_SESSION["E_ID"];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Eduseeks_Dashboard</title>
    <link rel="stylesheet" href="Learner_Dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  </head>
  <body>
    <input type="checkbox" id="check">
    <label for="check">
      <i class="fas fa-bars" id="btn"></i>
      <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
    <header>
      <?php
        $Server_Name = "localhost";
        $User_Name = "root";
        $Password = "";
        $Database_Name = "Expert_Cluster_Nova";
        $Connection = mysqli_connect( $Server_Name, $User_Name, $Password, $Database_Name );
        if( $Connection ){
         $SQL_Query = "SELECT * FROM Eduseeks WHERE Seeker_ID = '$Seeker_ID';";
         $SQL = mysqli_query( $Connection, $SQL_Query );
         while( $Row = mysqli_fetch_row( $SQL )){
           print ("
            <img src='Expert_Cluster_Official_Images/Eduseeks_Images/$Row[10]' alt=''>
            <p>Welcome</p>
            <p>$Row[2]</p><p>$Row[3]</p>
          ");
         }
        }
      ?>
    </header>
    <ul>
     <li><a href="Learner_Profile.php"><i class="fas fa-user-circle"></i> Profile</a></li>
     <li><a href="Edustreams.php"><i class="fa-solid fa-pager"></i>Edustreams</a></li>
     <li class="dropdown">
      <a href="#"><i class="fas fa-question-circle"></i> Query Center</a>
      <ul class="dropdown-menu">
      <li><a href="Learner_Subject_Catalogue.php"><i class="fas fa-book"></i> Subjects</a></li>
      <li><a href="Learner_Sent_Queries.php"><i class="fas fa-paper-plane"></i> Sent Queries</a></li>
      <li><a href="Learner_Sent_Elite_Queries.php"><i class="fas fa-user-graduate"></i> Ask Expert</a></li>
      <li><a href="Learner_My_Queries.php"><i class="fas fa-list-alt"></i> My Queries</a></li>
      <li><a href="Learner_Inbox_Answer.php"><i class="fas fa-inbox"></i> Inbox Answers</a></li>
      </ul>
     </li>
     <li class="dropdown">
      <a href="#"><i class="fas fa-star-half-alt"></i> Answer Review Center</a>
      <ul class="dropdown-menu">
      <li><a href="Learner_FB_AnswerX.php"><i class="fas fa-thumbs-up"></i> Feedback</a></li>
      <li><a href="Learner_RP_AnswerX.php"><i class="fas fa-flag"></i> Reports</a></li>
      <li><a href="Learner_FB_AnswerX_View.php"><i class="fas fa-clipboard-list"></i> AnswerX Feedback</a></li>
      <li><a href="Learner_RP_AnswerX_View.php"><i class="fas fa-clipboard-check"></i> AnswerX Reports</a></li>
      </ul>
     </li>
     <li><a href="Learner_Q&A_Hub.php"><i class="fas fa-comments"></i> Q&A Hub</a></li>
     <li class="dropdown">
      <a href="#"><i class="fas fa-globe"></i> Web Feedback</a>
      <ul class="dropdown-menu">
        <li><a href="Learner_Feedback.php"><i class="fas fa-comment-dots"></i> Feedback</a></li>
        <li><a href="Learner_Report.php"><i class="fas fa-bug"></i> Reports</a></li>
        </ul>
     </li>
     <li><a href="">	<i class="fas fa-user-friends"></i> Chatbox</a></li>
    </ul>
   </div>
   <section>
   <style>
    @import url('https://fonts.googleapis.com/css2?family=Big+Shoulders+Stencil:opsz,wght@10..72,100..900&family=Bytesized&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Tektur:wght@400..900&display=swap');
 * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
 }   
 body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: url(Expert_Cluster_Images/Query.jpg) fixed;
    background-size: 1550px 1150px;
    background-position: center;
    background-repeat: no-repeat;
 }
 .wrapper {
    width: 1000px;
    height: auto;
    background: rgba(166, 102, 196, 0.52);
    border-radius: 20px;
    color: whitesmoke;
    backdrop-filter: blur(2px);
    box-shadow: 0 2px 10px whitesmoke;
    opacity: 1;
    padding: 12px;
 }
 .wrapper h1 {
  font-family: "Big Shoulders Stencil", sans-serif;
  font-size: 40px;
  font-weight: bold;
  font-style: normal;
    color: whitesmoke;
    text-align: center;
 }
 .wrapper h4 {
    font-family: "Playfair Display", serif;
  font-optical-sizing: auto;
  font-weight: bold;
  font-style: italic;
    color: whitesmoke;
    text-align: center;
    background: ;
 }
 .wrapper .input-box {
    position: relative;
    width: 100%;
    height: 50px;
    background: transparent;
    margin: 30px 0;
 }
.input-box .Label {
    font-family: "Big Shoulders Stencil", sans-serif;
    font-size: 22px;
    font-style: normal;
    font-weight: bold;
    color: whitesmoke;
 }
 .Radio {
    width: 100%;
    height: 100%;
    font-family: "Tektur", sans-serif;
    font-size: 15px;
    font-weight: normal;
    font-style: normal;
    font-variation-settings:
    "wdth" 100;
    background: transparent;
    border: 2px solid rgba(255, 255, 255, .2);
    border-radius: 40px;
    font-size: 16px;
    color: whitesmoke;
    padding: 12px;
    /* padding: 20px 45px 20px 20px; */
 }
 .input-box input {
    width: 100%;
    height: 100%;
    background: transparent;
    border: 2px solid rgba(255, 255, 255, .2);
    border-radius: 40px;
    padding: 20px 45px 20px 20px;
    color: white;
 }
 .input-box .Input {
    font-family: "Tektur", sans-serif;
    font-size: 15px;
    font-weight: normal;
    font-style: normal;
    font-variation-settings:
    "wdth" 100;
 }
 .input-box input::placeholder {
    color: whitesmoke;
    /* top: 50%;
    transform: translateY(-50%); */
    font-size: 15px;
 }
.input-box span {
    position: absolute;
    top: 75%;
    right: 20px;
    font-size: 20px;
    color:whitesmoke;
 }
 input:hover {
    border: 2px solid whitesmoke;
    box-shadow: 0 0 15px whitesmoke;
 }
.btn {
    width: 100%;
    height: 45px;
    background-color: rgba(155, 100, 181, 0.515);
    border: none;
    outline: none;
    border-radius: 35px;
    box-shadow: 0 2px 10px whitesmoke;
    opacity: 1;
    cursor: pointer;
    font-size: 16px;
    color: whitesmoke;
    font-weight: 600;
    transition: background 0.3s ease;
}

.btn:hover {
    box-shadow: 0 4px 8px rgb(155, 100, 181);
    opacity: 1;
    background-color: rgb(155, 100, 181);
}
</style>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

    $Server_Name = "localhost";
    $User_Name = "root";
    $Password = "";
    $Database_Name = "Expert_Cluster_Nova";
    $Connection = new mysqli($Server_Name, $User_Name, $Password, $Database_Name);
    if ( $Connection ) {
        $SQL_Seek_Query = "SELECT * FROM Eduseeks WHERE Seeker_ID = '$Seeker_ID';";
        $SQL_Seek = mysqli_query($Connection, $SQL_Seek_Query);
        while ( $Seek_Row = mysqli_fetch_row($SQL_Seek)) {
            $Seeker_Type = $Seek_Row[17];
            $Seeker_ID = $Seek_Row[0];
            $S_First_Name = $Seek_Row[2];
            $S_Last_Name = $Seek_Row[3];
            $Seeker_E_Mail = $Seek_Row[8];
        }
        $SQL_Elite_Query = "SELECT * FROM Eduelite WHERE Elite_ID = '$E_ID';";
        $SQL_Elite = mysqli_query($Connection, $SQL_Elite_Query);
        while ( $Elite_Row = mysqli_fetch_row($SQL_Elite)) {
            $First_Name = $Elite_Row[2];
            $Last_Name = $Elite_Row[3];
            $Elite_E_Mail = $Elite_Row[8];
            $Elite_Eduquest = $Elite_Row[22];
        }
        $SQL_Stream_Query = "SELECT * FROM Edustreams WHERE Subject = '$Elite_Eduquest';";
        $SQL_Stream = mysqli_query($Connection, $SQL_Stream_Query);
        while ( $Stream_Row = mysqli_fetch_row($SQL_Stream)) {
            $Subject_Type = $Stream_Row[2];
            $Subject_ID = $Stream_Row[3];
            $Subject = $Stream_Row[4];
        }
    }
    if ( $Connection ) {
        if (isset($_POST["Ask_Now"])) {
            $Seeker_Type = $_POST["Seeker_Type"];
            $Seeker_ID = $_POST["Seeker_ID"];
            $Seeker_Name = $_POST["Seeker_Name"];
            $Seeker_E_Mail = $_POST["Seeker_E_Mail"];
            $Elite_ID = $_POST["Elite_ID"];
            $Elite_Name = $_POST["Elite_Name"];
            $Elite_E_Mail = $_POST["Elite_E_Mail"];
            $Subject_ID = $_POST["Subject_ID"];
            $Subject_Type = $_POST["Subject_Type"];
            $Subject = $_POST["Subject"];
            $Query = $_POST["Query"];
            $Ref_Query_Document = $_FILES["Ref_Query_Document"]["name"];
            $Tmp_Ref_Query_Document = $_FILES["Ref_Query_Document"]["tmp_name"];
            $Input_Ref_Query_Document = "./Expert_Cluster_Official_Images/Elite_QueryX_Images/" .$Ref_Query_Document;
            move_uploaded_file($Tmp_Ref_Query_Document, $Input_Ref_Query_Document);
            $Query_ID = "ELQUERY".rand(100000,999999); 
            $SQL_Insert_Query = "INSERT INTO `Elite_QueryX`(`Query_ID`, `Seeker_Type`, `Seeker_ID`, `Seeker_Name`, `Seeker_E_Mail`, `Elite_ID`, `Elite_Name`, `Elite_E_Mail`, `Subject_Id`, `Subject_Type`, `Subject`, `Query`, `Ref_Query_Document`, `Query_Status`) VALUES ('$Query_ID','$Seeker_Type','$Seeker_ID','$Seeker_Name','$Seeker_E_Mail','$Elite_ID','$Elite_Name','$Elite_E_Mail','$Subject_ID','$Subject_Type','$Subject','$Query','$Ref_Query_Document','Awaiting Replay');";
            $SQL_Insert = mysqli_query($Connection, $SQL_Insert_Query);
                sendeliteemail($Elite_Name, $Elite_E_Mail, $Query_ID, $Seeker_Name, $Subject);
                sendseekermail($Seeker_Name, $Seeker_E_Mail, $Elite_Name, $Query_ID, $Subject);
            print "
                <script>
                    alert ('Query Raised Successfully...!');
                </script>
            ";
        }
        function sendeliteemail($Elite_Name, $Elite_E_Mail, $Query_ID, $Seeker_Name, $Subject)
{
    
    
        $Name = htmlentities($Elite_Name);

        $Email = htmlentities($Elite_E_Mail);  
        
        $mailsender = "Expert Cluster";

        $mailsubject = "You've Received a New Query from an Eduseeker on Expert Cluster Nova!";

        $message = "
        
        Dear $Elite_Name ,<br><br>

                  We hope you're doing well!<br>

                    You have just received a new query from an Eduseeker on <strong>Expert Cluster Nova</strong>, who has specifically chosen you to address their concern.<br>

                    <b>Query Details:</b><br>
                    - Query ID: $Query_ID<br>
                    - Eduseeker Name: $Seeker_Name<br>
                    - Topic: $Subject<br>

                    Please log in to your dashboard to review and respond to the query.<br>

                    Your expertise is valuable to our learners, and we appreciate your dedication to providing quality responses.<br>

            Best regards,<br>  
              <b>Expert Cluster Team</b><br>  
              <a href='mailto:expertcluster.moon@gmail.com'>expertcluster.moon@gmail.com</a>

";

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'expertcluster.moon@gmail.com';
                $mail->Password = 'rtdt dumq ovfd mhie';
                $mail->Port = 465;
                $mail->SMTPSecure = 'ssl';
                $mail->isHTML(true);
                $mail->setFrom($Email, $mailsender);
                $mail->addAddress($Email);
                $mail->Subject = $mailsubject;
                $mail->Body = $message;
                $mail->send();
            
                
            }

            function sendseekermail($Seeker_Name, $Seeker_E_Mail, $Elite_Name, $Query_ID, $Subject)
{
    
    
        $Name = htmlentities($Seeker_Name);
        $Email = htmlentities($Seeker_E_Mail);  
        
        $mailsender = "Expert Cluster";

        $mailsubject = "Your Query Has Been Successfully Sent to $Elite_Name";

        $message = "
        
        Dear $Seeker_Name,<br><br>

            Thank you for submitting your query on <strong>Expert Cluster Moon</strong>!<br>

            Your query has been successfully sent to <strong>$Elite_Name</strong>, the expert you selected. You will receive a notification once the expert responds.<br>

            <b>Query Summary:</b>
            - Query ID: $Query_ID<br>
            - Topic: $Subject<br>
            - Submitted To: $Elite_Name<br>

            You can track the status of your query anytime via your dashboard.<br>

            We appreciate your trust in our platform. Stay curious, keep learning!<br>

             Best regards,<br>  
              <b>Expert Cluster Team</b><br>  
              <a href='mailto:expertcluster.moon@gmail.com'>expertcluster.moon@gmail.com</a>

                ";

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'expertcluster.moon@gmail.com';
                $mail->Password = 'rtdt dumq ovfd mhie';
                $mail->Port = 465;
                $mail->SMTPSecure = 'ssl';
                $mail->isHTML(true);
                $mail->setFrom($Email, $mailsender);
                $mail->addAddress($Email);
                $mail->Subject = $mailsubject;
                $mail->Body = $message;
                $mail->send();
            
                
            }

    }
?>
<div class="wrapper">
        <form action="" method="post" enctype="multipart/form-data">
            <h1>BrainStrome Form</h1>
            <h4>Submit your questions and unlock knowledge with Expertise - where curiosity meets expert answers...!</h4>
            <input class='form-control Input' type='hidden' name='Seeker_Type' id='Seeker_Type' placeholder='Seeker Type' value='<?= $Seeker_Type ?>' required>
            <div class="form-group input-box">
                <label for="Seeker_ID" class="Label">Seeker ID</label>
                <br><br>
                <input class='form-control Input' type='text' name='Seeker_ID' id='Seeker_ID' placeholder='Seeker ID' value='<?= $Seeker_ID ?>' required>
            </div>
            <br>
            <div class="form-group input-box">
                <label for="Seeker_Name" class="Label">Seeker Name</label>
                <br><br>
                <input class='form-control Input' type='text' name='Seeker_Name' id='Seeker_Name' placeholder='Seeker Name' value='<?= $S_First_Name ?> <?= $S_Last_Name ?>' required>
            </div>
            <input class='form-control Input' type='hidden' name='Seeker_E_Mail' id='Seeker_E_Mail' placeholder='Seeker E-Mail' value='<?= $Seeker_E_Mail ?>' required>
            <br>
            <div class="form-group input-box">
                <label for="Elite_ID" class="Label">Elite ID</label>
                <br><br>
                <input class='form-control Input' type='text' name='Elite_ID' id='Elite_ID' placeholder='Elite ID' value='<?= $E_ID ?>' required>
            </div>
            <br>
            <div class="form-group input-box">
                <label for="Elite_Name" class="Label">Elite Name</label>
                <br><br>
                <input class='form-control Input' type='text' name='Elite_Name' id='Elite_Name' placeholder='Elite Name' value='<?= $First_Name ?> <?= $Last_Name ?>' required>
            </div>
            <input class='form-control Input' type='hidden' name='Elite_E_Mail' id='Elite_E_Mail' placeholder='Elite E-Mail' value='<?= $Elite_E_Mail ?>' required>
            <input class='form-control Input' type='hidden' name='Subject_ID' id='Subject_ID' placeholder='Subject ID' value='<?= $Subject_ID ?>' required>
            <input class='form-control Input' type='hidden' name='Subject_Type' id='Subject_Type' placeholder='Subject Type' value='<?= $Subject_Type ?>' required>
            <br>
            <div class="form-group input-box">
                <label for="Subject" class="Label">Subject</label>
                <br><br>
                <input class='form-control Input' type='text' name='Subject' id='Subject' placeholder='Subject' value='<?= $Subject ?>' required>
            </div> 
            <br>
            <div class="form-group input-box">
                <label for="Query" class="Label">Query</label>
                <br><br>
                <input class="form-control Input" type="text" name="Query" id="Query" placeholder="Query" required>
            </div>
            <br>
            <div class="form-group input-box">
                <label for="Ref_Query_Document" class="Label">Reference Query Document</label>
                <br><br>
                <input class="form-control Input" type="file" name="Ref_Query_Document" id="Ref_Query_Document" placeholder="Ref Query Document">
            </div>
            <br><br><br>
            <button type="submit" name="Ask_Now" class="btn">Ask Now</button>
        </form>
    </div>
   </section>
  </body>
</html>