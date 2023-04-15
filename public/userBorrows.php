<?php

    session_start();

    require_once '../app/includes/logic/user.php';
    require_once '../app/includes/logic/helpers.php';

    // Redirect the user to login page if he's not authenticated
    $user_id = $_SESSION['user_id'] ?? null;

    if(!isset($user_id))
    {
        redirect('login', ['name' => 'ayoub', 'age' => 56]);
    }

    // Header

    require_once '../app/includes/partials/header.php';
?>
<link rel="stylesheet" href="http://localhost/management-of-library/public/css/user_borrows.css?v=2">
</head>
<body class="light-gray">

 <!-- Navbar -->

    <?php
        require_once '../app/includes/partials/navbar-layouts/user_loggedin_navbar.php';
     ?>


    <!-- Main -->

     <div class="container mt-5 pt-3 main">
        <h4 class="border-bottom border-1 border-dark px-5 py-2 m-auto mb-5" style="width: fit-content;">Mes empruntes</h4>


        <?php
            $borrows = getUserBorrows($user_id);
        ?>

        <p class="text-center">Vous avez effectue <strong><?= count($borrows) ?></strong> emprunte<?= count($borrows) > 1 ? 's' : '' ?> jus'qua ce moment là</p>
        <div class="table-container container px-5">

        <!-- Borrows table -->

        <?php
        if(count($borrows) > 0):
        ?>

        <table class="docs table bg-white px-4">

        <!-- Table head -->
            <thead>
                <th>Code</th>
                <th>Titre du document</th>
                <th>Date d'emprunte</th>
                <th>Date de retour</th>
                <th>Action</th>
            </thead>

        <!-- Table body -->

            <tbody>

            <?php
            foreach($borrows as $borrow):
            ?>
                <tr>
                    <td><?= $borrow['code'] ?></td>
                    <td class="doc-title"><?= $borrow['docTitle'] ?></td>
                    <td><?= $borrow['borrowDate'] ?></td>
                    <td><?= $borrow['returnDate'] ?></td>
                    <td>
                        <a download href="<?= $borrow['receiptFileUrl'] ?>" class="btn btn-sm btn-primary">
                            <i class="fa fa-print" style="font-size: 1.1rem !important;"></i>
                        </a>
                    </td>
                </tr>

                <?php
                endforeach;
                ?>
            </tbody>
        </table>

        <?php
        endif;
        ?>
                </div>
            </div>
    


    <!-- Footer -->

<?php
  require_once  '../app/includes/partials/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="http://localhost/management-of-library/app/js/main.js?v=3"></script>
</body>
</html>