<?php
session_start();

require_once '../../app/includes/logic/helpers.php';
include_once "../../app/config/db.php";

$connection = getConnection();



// Logout

if(isset($_POST['logout_btn']))
{
    session_unset();
    session_destroy();

    redirect('../login', []);
}

?>



<!DOCTYPE html>
<html>
<head>
  <title>Admin</title>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <link rel="stylesheet" href="./assets/css/style.css?v=<?= time(); ?>"></link>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  </head>
</head>
<body >
    
        <?php

            if(!isset($_SESSION['user_id']))
            {
                redirect('../login', []);
            }

            include "./adminHeader.php";
            include "./sidebar.php";

        ?>
    
    <div id="main">
    <div id="main-content" class="container position-relative allContent-section py-4">
        <div class="row">
            <div class="col-sm-3">
                <!-- Users count -->
                <div class="custom-card">
                    <div class="text-right">
                        <i class="fa fa-users  mb-2 " style="font-size: 70px;"></i>
                    </div>
                    <h1 style="color:white;">
                    <?php
                        $sql = "SELECT count(*) as total from users";
                        $stmt = $connection->prepare($sql);
                        if($stmt){
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total'];
                        }
                    ?>
                    </h1>
                    <h5 style="color:white;">Adhérents</h5>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- Documents count -->
                <div class="custom-card">
                    <div class="text-right">
                        <i class="fa fa-book  mb-2" style="font-size: 70px;"></i>
                    </div>
                    <h1 style="color:white;">
                    <?php
                        $sql = "SELECT count(*) as total from documents";
                        $stmt = $connection->prepare($sql);
                        if($stmt){
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total'];
                        }
                    ?>
                    </h1>
                    <h5 style="color:white;">
                        Documents
                    </h5>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- Documents types count -->
                <div class="custom-card">
                    <div class="text-right">
                        <i class="fa fa-th-large mb-2" style="font-size: 70px;"></i>
                    </div>
                    <h1 style="color:white;">
                    <?php
                        $sql = "SELECT count(*) as total from users";
                        $stmt = $connection->prepare($sql);
                        if($stmt){
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total'];
                        }
                    ?>
                    </h1>
                    <h5 style="color:white;">Types</h5>
                </div>
            </div>
            <div class="col-sm-3">
                <!-- Borrows count -->
                <div class="custom-card">
                    <div class="text-right">
                        <i class="fa fa-book mb-2" style="font-size: 70px;"></i>
                    </div>
                    <h1 style="color:white;">
                    <?php
                        $sql = "SELECT count(*) as total from borrows";
                        $stmt = $connection->prepare($sql);
                        if($stmt){
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total'];
                        }
                    ?>
                    </h1>
                    <h5 style="color:white;">Empruntes</h5>
                </div>
            </div>
        </div>
        
    </div>
    </div>
       
            
        <?php
            if (isset($_GET['type']) && $_GET['type'] == "success") {
                echo '<script> alert("type est ajouté")</script>';
            }else if (isset($_GET['type']) && $_GET['type'] == "error") {
                echo '<script> alert("erreur lors de lajout")</script>';
            }
        ?>


<script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
    <script type="text/javascript" src="./assets/js/Functions.js?v=<?= time(); ?>"></script>    
    <script type="text/javascript" src="./assets/js/script.js?v=<?= time(); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</body>
 
</html>