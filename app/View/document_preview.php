<?php
 session_start();
 require_once '../controller/document_preview.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://localhost/management-of-library/app/css/document_preview.css?v=4">
    <link rel="stylesheet" href="http://localhost/management-of-library/app/css/customProperties.css">
    <link rel="stylesheet" href="http://localhost/management-of-library/app/css/navbar.css?v=5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>

   <!-- Navbar -->

   <?php
   require_once isset($_SESSION['user_id']) ?  './navbar-layouts/user_loggedin_navbar.php' : './navbar-layouts/user_loggedout_navbar.php';
   ?>

    <!-- Document preview section start -->

    <section class="document-preview">
     <div class="container">
        <div class="document-container">
            <div class="wrapper d-flex justify-content-between align-items-start mb-5">
                <h2 class="doc_title w-75 mb-5"><?= $document['title'] ?></h2>
                <button id="borrowBtn" class="btn btn-lg btn-primary borrow-btn" data-bs-toggle="modal" data-bs-target="#borrowModal">Emprunter</button>
                <div id="borrowModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                               <p class="borrow-doc-title p-0 m-0">Emprunter: <strong><?= $document['title'] ?></strong></p>
                            </div>
                            <div class="modal-body">
                                <h5 class="text-center borrow-message"></h5>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" data-bs-dismiss="modal">D'accord</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="cover">
                        <img src="../assets/uploads/book_covers/<?= $document['cover_img_id'] ?>" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="wrapper">
                        <div class="description-container">
                            <h4>Resume</h4>
                            <p class="description"><?= $document['doc_desc'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="details">
                     <p class="author"><span style="font-weight: bold;">Auteur: </span><?= $document['full_author_name'] ?></p>
                     <p class="page_count"><span style="font-weight: bold;">Nombre de page: </span><?= $document['page_count'] ?></p>
                     <p class="doc_type"><span style="font-weight: bold;">Type de document: </span><?= $document['doc_type'] ?></p>
                     <input type="hidden" value="<?= $document['doc_id'] ?>" name="docID">
                     <input type="hidden" value="1" name="userID">
                    </div>
                </div>
            </div>
        </div>
     </div>
    </section>
<script src="../js/borrow.js?v=3"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="http://localhost/management-of-library/app/js/main.js?v=1"></script>
</body>
</html>