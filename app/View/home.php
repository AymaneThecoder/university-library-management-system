
<?php
 require_once '../controller/home.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="http://localhost/management-of-library/app/css/booksExplorePageStyle.css?v=2">
    <link rel="stylesheet" href="http://localhost/management-of-library/app/css/customProperties.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css">
    <title>Document</title>
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

  <!-- Hero section start -->
   
  <section class="hero-section mt-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-7 mb-5 mb-md-0">
                <div class="left">
                    <h2 class="header mb-4 lh-sm">Enraichis votre connaissance avec des <span style="color: var(--secondary-color);">documents</span> rigoureux</h2>
                    <div class="search-documents-container">
                        <div class="input-group">
                            <input class="search-input form-control form-control-lg" type="text" name="" id="" placeholder="chercher par titre ou auteur">
                            <button class="search-btn btn">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="right d-flex justify-content-center align-items-center">
                    <img class="w-100" src="../assets/3529668 1WIHOUT_BG.png" alt="">
                </div>
            </div>
        </div>
    </div>
  </section>

<!-- Hero section end -->

<!-- Articles showcase section start -->

<section class="documents-showcase-section mt-5 pt-5">
    <div class="container px-5">

    <h4 class=" text-center my-5">Choisir dans <span class="doc_count text-primary"><?= $documents_count ?></span> diffrentes documents dans des domaines diverse</h4>
        <!-- Filter elements -->

        <div class="filter-btns d-flex column-gap-3 mb-5">
          <button class="filter-documents-btn active btn btn-md btn-outline-primary">Tous</button>
          <button class="filter-documents-btn btn btn-md btn-outline-primary">Livres</button>
          <button class="filter-documents-btn btn btn-md btn-outline-primary">Periodiques</button>
          <button class="filter-documents-btn btn btn-md btn-outline-primary">Articles</button>
        </div>
        <ul class="documents list-unstyled row">
        <?php
         foreach($documents as $doc):
         ?>
            <li class="document col-md-6 col-lg-4 mb-5" data-document-type=<?= $doc['doc_type'] ?>>
              <a class="text-decoration-none text-dark" href="document_preview.php?doc_id=<?= $doc['doc_id'] ?>">
               <div class="row justify-content-center">
                    <div class="col-12 cover mb-3">
                        <img src="../assets/uploads/book_covers/<?= $doc['cover_img_id'] ?>" alt="">
                    </div>
                    <div class="col-12 document-info">
                        <p class="title text-center mb-3"><?= $doc['title'] ?></p>
                        <div class="px-2 d-flex justify-content-between align-items-center">
                            <p class="author mb-0"><?= $doc['full_author_name'] ?></p>
                             <h5 class="document-type"><?= $doc['doc_type'] ?></h5>
                        </div>
                    </div>
                </div>
              </a>
            </li>
        <?php
        endforeach;
        ?>
        </ul>
    </div>
</section>

<!-- Articles section end -->

<!-- Footer -->

<footer class="footer mt-5">
        <nav class="navbar navbar-expand">
            <div class="container">
                    <a href="booksExploreView.html" class="navbar-brand">
                        <h3>
                            jaliss
                        </h3>
                    </a>
                <div class="navbar-right">
                    <div class="navbar-nav gap-2 gap-sm-4">
                       <a href="" class="navbar-link text-dark text-decoration-none">Tous</a>
                       <a href="" class="navbar-link text-dark text-decoration-none">Articles</a>
                       <a href="" class="navbar-link text-dark text-decoration-none">Livres</a>
                       <a href="" class="navbar-link text-dark text-decoration-none">Periodiques</a>
                    </div>
                </div>
            </div>
         </nav> 
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="http://localhost/management-of-library/app/js/main.js?v=1"></script>
</body>
</html>