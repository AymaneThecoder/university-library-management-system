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
   
    <section class="search-result main pt-5">
        <div class="container">
            
       

            <!-- Articles showcase section start -->

            <section class="documents-showcase-section mt-5">

                <!-- Search bar -->

                <div class="row align-items-center">
                    <div class="col">
                        <div class="search-form-container ms-auto w-50">
                            <form action="<?= $_SERVER['REQUEST_URI'] ?>" class="">
                                <div class="d-flex custom-input-group">
                                    <select name="doc_type" id="" class="form-select rounded-left" style="width: 120px;">
                                        <option value="">Tous</option>
                                        <option value="article" <?= @$_GET['doc_type'] == 'article' ? 'selected' : '' ?>>Articles</option>
                                        <option value="livre" <?= @$_GET['doc_type'] == 'livre' ? 'selected' : '' ?>>Livres</option>
                                        <option value="periodique" <?= @$_GET['doc_type'] == 'periodique' ? 'selected' : '' ?>>Periodiques</option>
                                    </select>
                                    <input class="form-control" type="text" name="search_query" id="" value="<?= @$_GET['search_query'] ?>" placeholder="Titre ou auteur">
                                    <button class="search-btn btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php
                    if($q):
                    ?>
                    <h6 class="resul-query mt-5" >Resultat pour: <span style="color: green;"><?= $q ?></span></h6>
                    <?php
                    endif;
                    ?>

                </div>

                <!-- Documents list -->

                    <ul class="documents list-unstyled row mt-5 pt-5">

                    <?php
                    if(count($documents) > 0)
                    {
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

                    }else{    
                    ?>

                    <h5>Ooops! Aucune resultat à été trouvé</h5>

                    <?php
                    }
                    ?>

                    </ul>


                    <!-- Pagination -->

                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li  class="page-item"><a class="page-link <?= $currentPage == 1 ? 'disabled' : '' ?>" href="?search_query=<?= $q ?>&page=<?= $currentPage - 1 ?>">Precedent</a></li>
                            <?php

                            for($i = 1; $i <= $nbrPages; $i++):
                            ?>
                            <li class="page-item <?= $currentPage == $i ? 'active' : '' ?>"><a class="page-link" href="?search_query=<?= $q ?>&page=<?= $i ?>"><?= $i ?></a></li>
                            <?php
                            endfor;
                            ?>

                            <li class="page-item"><a class="page-link <?= $currentPage == $nbrPages ? 'disabled' : '' ?>" href="#">Suivant</a></li>
                        </ul>
                    </nav>


            </section>
        </div>
    </section>

<!-- Footer -->

<?php
  require_once  '../app/includes/partials/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="./js/main.js?v=5"></script>
</body>
</html>