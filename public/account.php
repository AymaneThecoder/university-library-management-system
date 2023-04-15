<?php

    session_start();

    require_once '../app/includes/logic/user.php';
    require_once '../app/includes/data/major.php';
    require_once '../app/includes/logic/helpers.php';

    // Redirect the user to login page if he's not authenticated
    $user_id = $_SESSION['user_id'] ?? null;

    if(!isset($user_id) && !isset($_POST['saveChanges']))
    {
        redirect('login', []);

    } elseif(!isset($user_id) && isset($_POST['saveChanges'])) {

        //The user tries to modify account info when he loggedout
        //Send an error
        redirect('login', ['msg_status' => 'error', 'msg' => 'Votre compte n\'a pas été modifé']);
    }
    

    $user = getUserByIDOrEmail($user_id);

    $error = '';

    if(isset($_POST['saveChanges']))
    {
        unset($_POST['saveChanges']);
      $error = modifyUserAccountInfo($_POST);
    }


    // Header

    require_once '../app/includes/partials/header.php';

?>
<link rel="stylesheet" href="http://localhost/management-of-library/public/css/account.css?v=2">
</head>


<body class="light-gray">

   <!-- Navbar -->

   <?php
   require_once '../app/includes/partials/navbar-layouts/user_loggedin_navbar.php';
   ?>


    <section class="container-lg mt-5 mb-5 pb-3 pt-3">
      <form action="" class="form" method="post">
        <h4 class="border-bottom border-1 border-dark px-5 py-2 m-auto mb-5" style="width: fit-content;">Mon compte</h4>
        <p class="text-center mb-4">Vous trouvez ici tous vos informations, Vous pouvez les changer.</p>
        <p class="text-center text-danger"><?= $error ?></p>
        <div class="form-container m-auto">

            <div class="row mb-3 align-items-center">
                <div class="col-12 col-sm-3">
                    <label for=""><strong>Nom complet</strong></label>
                </div>
                <div class="col-12 col-sm-9">
                    <input class="form-control" value="<?= $_POST['full_name'] ?? $user['fullName'] ?>" type="text" name="full_name" id="">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-12 col-sm-3">
                    <label for=""><strong>Email</strong></label>
                </div>
                <div class="col-12 col-sm-9">
                    <input class="form-control" value="<?= $_POST['email'] ?? $user['email'] ?>" type="text" name="email" id="">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-12 col-sm-3">
                    <label for=""><strong>Filiere</strong></label>
                </div>
                <div class="col-12 col-sm-9">
                <select class="form-select" name="major" id="">

                <?php
                $majors = getMajors();
                foreach($majors as $major):
                ?>

                <option value="<?= $major['id'] ?>" <?= $major['id'] == ($_POST['major'] ?? $user['majorId']) ? 'selected' : '' ?> > <?= $major['name'] ?> </option>

                <?php
                endforeach;
                ?>

                </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-12 col-sm-3">
                    <label for=""><strong>Mot de passe(Nouveau)</strong></label>
                </div>
                <div class="col-12 col-sm-9">
                    <input class="form-control" value="" type="password" name="password" id="">
                </div>
            </div>

            <div class="row mb-4 align-items-center">
                <div class="col-12 col-sm-3">
                    <label for=""><strong>Repeter mot de passe</strong></label>
                </div>
                <div class="col-12 col-sm-9">
                    <input class="form-control" value="" type="password" name="confirm_password" id="">
                </div>
            </div>

            <input class="btn btn-primary" type="submit" name="saveChanges" value="Sauvgarder">
            <input class="btn btn-secondary" type="reset" value="Reinitialiser">
        </div>
      </form>
    </section>

<!-- Footer -->

<?php
  require_once  '../app/includes/partials/footer.php';
?>

<script src="./js/ajax/borrow.js?v=6"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="http://localhost/management-of-library/app/js/main.js?v=3"></script>
</body>
</html>