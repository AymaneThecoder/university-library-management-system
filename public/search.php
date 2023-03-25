<?php
session_start();
require_once '../app/includes/logic/document.php';

$dataReturned = search();

foreach($dataReturned as $key => $value)
{
    $$key = $value;
}

// Header

require_once '../app/includes/partials/header.php';
?>

<link rel="stylesheet" href="http://localhost/management-of-library/public/css/search.css?v=8">
</head>
<body>

   <!-- Navbar -->

    <?php
   require_once isset($_SESSION['user_id']) ?  '../app/includes/partials/navbar-layouts/user_loggedin_navbar.php' : '../app/includes/partials/navbar-layouts/user_loggedout_navbar.php';
   ?>

    <!-- Search results section -->

    <section class="search-result">
        <div class="container">
            <h5 class="resul-query mt-5" >Resultat pour: <span style="color: green;"><?= $q ?></span></h5>

            <!-- Articles showcase section start -->

            <section class="documents-showcase-section mt-5">

                <div class="row align-items-center">
                    <div class="col">

                            <!-- Filter elements -->

                            <div class="filter-btns d-flex column-gap-3">
                                <button class="filter-documents-btn active btn btn-md btn-outline-primary">Tous</button>
                                <button class="filter-documents-btn btn btn-md btn-outline-primary">Livres</button>
                                <button class="filter-documents-btn btn btn-md btn-outline-primary">Periodiques</button>
                                <button class="filter-documents-btn btn btn-md btn-outline-primary">Articles</button>
                            </div>
                    </div>
                    <div class="col">
                        <div class="search-form-container">
                            <form action="" class="">
                                <div class="input-group w-75  ms-auto">
                                    <input class="form-control" type="text" name="search-query" id="">
                                    <button class="search-btn btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                     </div>

                    <ul class="documents list-unstyled row mt-5 pt-5">
                    <?php
                    foreach($documents as $doc):
                    ?>
                        <li class="document col-md-6 col-lg-4 mb-5" data-document-type=<?= $doc['docType'] ?>>
                        <a class="text-decoration-none text-dark" href="document.php?doc_id=<?= $doc['id'] ?>">
                        <div class="row justify-content-center">
                                <div class="col-12 cover mb-3">
                                    <img src="../public/assets/uploads/book_covers/<?= $doc['coverImgPath'] ?>" alt="">
                                </div>
                                <div class="col-12 document-info">
                                    <p class="title text-center mb-3"><?= $doc['title'] ?></p>
                                    <div class="px-2 d-flex justify-content-between align-items-center">
                                        <p class="author mb-0"><?= $doc['author'] ?></p>
                                        <h5 class="document-type"><?= $doc['docType'] ?></h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </li>
                    <?php
                    endforeach;
                    ?>
                    </ul>
            </section>
        </div>
    </section>

<!-- Footer -->

<?php
  require_once  '../app/includes/partials/footer.php';
?>

<script src="../js/borrow.js?v=3"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="http://localhost/management-of-library/app/js/main.js?v=1"></script>
</body>
</html>