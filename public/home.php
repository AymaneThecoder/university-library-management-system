
<?php
session_start();
require_once '../app/includes/data/document.php';

// Show just 9 documents in home page

$sql = 'SELECT d.*, t.name as type FROM documents d
        LEFT JOIN doc_types t ON d.type_id=t.id
        LIMIT ?,?';
$documents = customDocumentQuery($sql, [0, 9]);


// Header

require_once '../app/includes/partials/header.php';
?>
<link rel="stylesheet" href="http://localhost/management-of-library/public/css/home.css?v=6">
</head>


<body>

    <!-- Navbar -->

    <?php
   require_once isset($_SESSION['user_id']) ?  '../app/includes/partials/navbar-layouts/user_loggedin_navbar.php' : '../app/includes/partials/navbar-layouts/user_loggedout_navbar.php';
   ?>


  <!-- Hero section start -->
   
  <section class="hero-section mt-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-7 mb-5 mb-md-0">
                <div class="left">
                    <h2 class="header mb-4 lh-sm">Enraichis votre connaissance avec des <span style="color: var(--secondary-color);">documents</span> rigoureux</h2>
                    <div class="search-documents-container fixed">
                        <form action="http://localhost/management-of-library/public/search.php" method="get">
                            <div class="input-group">
                                <input class="search-input form-control form-control-lg" type="text" name="search_query" id="" placeholder="chercher par titre ou auteur">
                                <button class="search-btn btn">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="right d-flex justify-content-center align-items-center">
                    <img class="w-100" src="./assets/3529668 1WIHOUT_BG.png" alt="">
                </div>
            </div>
        </div>
    </div>
  </section>

<!-- Hero section end -->

<!-- Documents showcase section start -->

<section class="documents-showcase-section mt-5 pt-5">
    <div class="container px-5">

    <h4 class=" text-center my-5 pb-3 text-capitalize">Choisir dans <span class="doc_count text-primary"><?= count($documents) ?></span> diffrentes documents dans des domaines diverse</h4>
        
    <!-- Documents -->

        <ul class="documents list-unstyled row">

        <?php

         foreach($documents as $doc):
         ?>
            <li class="document col-md-6 col-lg-4 mb-5" data-document-type=<?= $doc['type'] ?>>
              <a class="text-decoration-none text-dark" href="document.php?doc_id=<?= $doc['id'] ?>">
               <div class="row justify-content-center">
                    <div class="col-12 cover mb-3">
                        <img src="http://localhost/management-of-library/admin/dashboard/assets/images/uploads/doc_images/<?= $doc['doc_img'] ?>" alt="">
                    </div>
                    <div class="col-12 document-info">
                        <p class="title text-center mb-3"><?= $doc['title'] ?></p>
                        <div class="px-2 d-flex justify-content-between align-items-center">
                            <p class="author mb-0"><?= $doc['author'] ?></p>
                             <h5 class="document-type"><?= $doc['type'] ?></h5>
                        </div>
                    </div>
                </div>
              </a>
            </li>

        <?php
        endforeach;
        ?>

        </ul>

        <div class="text-center mt-5 mb-4 pb-5">
            <a href="search.php" class="btn btn-link py-2 px-3 border border-1 border-primary">Voir toutes les documents</a>
        </div>

    </div>
</section>

<!-- Articles section end -->


<!-- Footer -->

<?php
  require_once  '../app/includes/partials/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="./js/main.js?v=1"></script>
</body>
</html>