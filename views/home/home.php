<?php
require_once '../../BusinessLogic/Common/functions.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
   
    <link rel="stylesheet" href="../../styles/bulma.min.css">
    <link rel="stylesheet" href="../../styles/app.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script type="text/javascript" src="../../scripts/sweetalert2.min.js"></script>
    <script type="text/javascript" src="../../scripts/jquery.min.js"></script>
    <script type="text/javascript" src="../../scripts/views/app/home.js"></script>
    <link rel="stylesheet" href="../../styles/sweetalert2.min.css"> 
  </head>

    <body>  
        
        <?php include_once '../Shared/header.php';?>
          
        <section class="section">
            <div class="container">
                <div class="intro">
                <!-- <div class="animated-bar"></div> -->
                <div class="slide slide-a">
                    <div class="slide-content">
                        <h2 class="slide-a-child">Let's Start</h1>
                      
                       

                        <img src="..\..\resources\images\settings.png" class="slide-a-child">
                       <?php

                        if(((int)$_SESSION['user_role'] == ADMIN) || ((int)$_SESSION['user_role'] == FULL_ACCESS)){
                        echo '
                            <a href="../Members/add-members-view.php"> 
                            <img src="..\..\resources\images\add-users.png" class="slide-a-child">
                            </a>
                            ';
                        }

                        if(((int)$_SESSION['user_role'] == ADMIN) || ((int)$_SESSION['user_role'] == FULL_ACCESS) || ((int)$_SESSION['user_role'] == QUICK_ACCESS)){
                            echo '
                                <a href="../Messaging/quick-message-view.php"> 
                                <img src="..\..\resources\images\sendMessage.png" class="slide-a-child">
                                </a>
                                ';
                        }



                       if((int)$_SESSION['user_role'] == ADMIN){
                        echo '
                                <a href="../Admin/admin-home.php"> 
                                <img src="..\..\resources\images\administrative-tools.png" class="slide-a-child">
                                </a>
                            ';
                       }
                       ?>
                    </div>
                </div>

                <!-- <div class="slide slide-b">
                    <div class="slide-content">
                        <h2 class="slide-b-child">what I do</h2>
                        <p class="slide-b-child">I design modern, clean and creative websites</p>
                        <p class="slide-b-child">And make them alive on the internet</p>
                    </div>
                </div>

                <div class="slide slide-c">
                    <div class="slide-content">
                        <h2 class="slide-c-child">What I use</h2>
                        <ul>
                            <li class="slide-c-child"><p>Adobe Photoshop</p></li>
                            <li class="slide-c-child"><p>HTML5</p></li>
                            <li class="slide-c-child"><p>CSS3</p></li>
                            <li class="slide-c-child"><p>Javascript</p></li>
                        </ul>
                    </div>
                </div>

                <div class="slide slide-d">
                    <div class="slide-content">
                        <h2 class="slide-d-child">Let's Start</h2>
                        <img src="..\..\resources\images\add-users.png" class="slide-d-child replay">
                        <img src="..\..\resources\images\settings.png" class="slide-d-child replay">
                    </div>
                </div> -->

                </div>
            </div>
        </section>
        <?php include_once '../Shared/footer.php';?>
    </body>
</html>







