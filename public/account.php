<?php

session_start();

require_once '../app/includes/logic/user.php';
require_once '../app/includes/data/major.php';
require_once '../app/includes/logic/helpers.php';

// Redirect the user to login page if he's not authenticated
$user_id = $_SESSION['user_id'] ?? null;

if(!isset($user_id))
{
   redirect('login');
}

if(isset($_POST['saveChanges']))
{
    
}

$user = getUserByIDOrEmail($user_id);

// Header

require_once '../app/includes/partials/header.php';

?>
<link rel="stylesheet" href="http://localhost/management-of-library/public/css/account.css?v=6">
</head>


<body class="light-gray">

   <!-- Navbar -->

   <?php
   require_once '../app/includes/partials/navbar-layouts/user_loggedin_navbar.php';
   ?>


    <section class="container-lg mt-5 pt-3">
      <form action="" class="form" method="post">
        <h4 class="border-bottom border-1 border-dark px-5 py-2 m-auto mb-5" style="width: fit-content;">Mon compte</h4>
        <p class="text-center mb-4">Vous trouvez ici tous vos informations, Vous pouvez les changer.</p>
        <div class="form-container m-auto">
            <div class="row mb-2">
                <div class="col">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input class="form-control" value="<?= $user['email'] ?>" type="text" name="email" id="">
                    </div>
                </div>
                <div class="col">
                <div class="form-group">
                        <label for="">Nom complet</label>
                        <input class="form-control" value="<?= $user['fullName'] ?>" type="text" name="full_name" id="">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="form-group">
                        <label for="">Filiere</label>
                        <select class="form-select" name="major" id="">

                        <?php
                        $majors = getMajors();
                        foreach($majors as $major):
                         ?>

                         <option value="<?= $major['id'] ?>" <?= $major['id'] == $user['majorId'] ? 'selected' : '' ?> > <?= $major['name'] ?> </option>

                        <?php
                        endforeach;
                        ?>

                        </select>
                    </div>
                </div>
                <div class="col">
                <div class="form-group">
                        <label for="">Mot de passe</label>
                        <input class="form-control" type="password" name="full_name" id="">
                    </div>
                </div>
            </div>
            <input class="btn btn-primary" type="submit" value="Sauvgarder">
            <input class="btn btn-secondary" name="saveChanges" type="reset" value="Reinitialiser">
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