<?php
session_start();
require_once '../app/includes/data/document.php';

$docId = htmlspecialchars($_GET['doc_id']);
$document = getDocumentByID($docId);

// Header

require_once '../app/includes/partials/header.php';
?>
<link rel="stylesheet" href="http://localhost/management-of-library/public/css/document_preview.css?v=2">
</head>


<body>

   <!-- Navbar -->

   <?php
   require_once isset($_SESSION['user_id']) ?  '../app/includes/partials/navbar-layouts/user_loggedin_navbar.php' : '../app/includes/partials/navbar-layouts/user_loggedout_navbar.php';
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
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="cover">
                        <img src="../public/assets/uploads/book_covers/<?= $document['coverImgPath'] ?>" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="wrapper">
                        <div class="description-container">
                            <h4>Resume</h4>
                            <p class="description"><?= $document['summary'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="details">
                     <p class="author"><span style="font-weight: bold;">Auteur: </span><?= $document['author'] ?></p>
                     <p class="page_count"><span style="font-weight: bold;">Nombre de page: </span><?= $document['pageCount'] ?></p>
                     <p class="doc_type"><span style="font-weight: bold;">Type de document: </span><?= $document['docType'] ?></p>
                     <input type="hidden" value="<?= $document['id'] ?>" name="docID">
                    </div>
                </div>
            </div>
        </div>
     </div>
    </section>

<!-- Footer -->

<?php
  require_once  '../app/includes/partials/footer.php';
?>

<script src="./js/ajax/borrow.js?v=8"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="http://localhost/management-of-library/app/js/main.js?v=3"></script>
</body>
</html>
