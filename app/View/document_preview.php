<?php

 require_once '../controller/document_preview.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://localhost/management-of-library/app/css/document_preview.css?v=1">
    <link rel="stylesheet" href="http://localhost/management-of-library/app/css/customProperties.css">
    <link rel="stylesheet" href="http://localhost/management-of-library/app/css/booksExplorePageStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
        <!-- Navbar start -->

        <nav class="navbar navbar-expand sticky-top bg-white">
            <div class="container py-2 px-3 px-sm-0">
                       <!-- LOGO -->
                   <a class="navbar-brand" href="booksExploreView.html">
                       <h2>jaliss</h2>
                   </a>
                   <ul class="navbar-nav navbar-center column-gap-5">
                       <li class="nav-item">
                           <a href="#" class="nav-link active">Tous</a>
                       </li>
                       <li class="nav-item">
                           <a href="#" class="nav-link">Articles</a>
                       </li>
                       <li class="nav-item">
                           <a href="#" class="nav-link">Livres</a>
                       </li>
                       <li class="nav-item">
                           <a href="#" class="nav-link">Periodiques</a>
                       </li>
                   </ul>
                   <ul class="navbar-nav navbar-right align-items-center column-gap-2">
                       <li class="nav-item">
                            <a class="signup-btn btn btn-lg  btn-outline-secondary">Creer votre compte</a>
                       </li>
                       <li class="nav-item">
                            <a class="signin-btn btn btn-lg btn-primary">Se connecter</a>
                       </li>
                   </ul>
                   <!--Navbar right Dropdown for smaller devices -->
                   <div class="login-dropdown dropdown d-none">
                       <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
                           <i class="fa fa-user"></i>
                       </button>
                       <div class="dropdown-menu dropdown-menu-end">
                           <li class="dropdown-item">
                               <a class="signup-btn-dropdown btn btn-outline-secondary w-100">Creer votre compte</a>
                           </li>
                           <li class="dropdown-item">
                               <a class="signin-btn-dropdown btn btn-primary w-100">Se connecter</a>
                           </li>
                       </div>
                   </div>
               <!-- navbar small toggler button -->
               <button class="slide-navbar-toggler-btn d-none btn">
                   <i class="fa fa-bars"></i>
               </button>
            </div>
            <!-- Navbar for tablet and mobile devices -->
            <div class="navbar-small-devices">
               <button class="slide-navbar-close-btn btn">
                   <i class="fa fa-close"></i>
               </button>
               <div class="navbar-action-btns mb-5 d-flex p-2 column-gap-1">
                   <a href="#" class="signup-tbn btn btn-secondary w-50">Creer votre compte</a>
                   <a href="#" class="signin-btn btn btn-primary w-50 d-flex justify-content-center align-items-center">Se connecter</a>
               </div>
               <ul class="navbar-nav d-flex flex-column">
                   <li><a class="nav-link active" href="#">Tous</a></li>
                   <li><a class="nav-link" href="#">Articles</a></li>
                   <li><a class="nav-link" href="#">Livres</a></li>
                   <li><a class="nav-link" href="#">Periodiques</a></li>
               </ul>
                <!-- LOGO -->
                <a class="navbar-brand" href="booksExploreView.html">
                   <h2>jaliss</h2>
               </a>
            </div>
           </nav>
       
           <!--Navbar end  -->
    
    <!-- Document preview section start -->

    <section class="document-preview">
     <div class="container">
        <div class="document-container">
            <div class="wrapper d-flex justify-content-between align-items-start mb-5">
                <h2 class="doc_title w-75 mb-5"><?= $document['title'] ?></h2>
                <button class="btn btn-lg btn-primary borrow-btn">Emprunter</button>
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
                    </div>
                </div>
            </div>
        </div>
     </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="http://localhost/management-of-library/app/js/main.js?v=1"></script>
</body>
</html>