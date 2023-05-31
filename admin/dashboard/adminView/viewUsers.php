
<?php
  include_once "../../../app/config/db.php";
  $connection = getConnection();
?>

<div class="">
<div class="d-flex justify-content-between mt-4 mb-5">
  <h4 class="">Adherents</h4>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-primary" style="height:40px" data-toggle="modal" data-target="#addUserModal">
    <i class="fa fa-plus"></i>
    Ajouter
  </button>
  </div>

    <?php
      $sql = "SELECT u.*, b.name as branch 
              FROM users u LEFT JOIN branches b
              ON u.branch_id = b.id
              ORDER BY u.created_at desc";

      $stmt = $connection->prepare($sql);
      if($stmt)
      {
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($users) > 0)
        {
        ?>
    <div class="table-responsive">
    <table class="table datatable bg-white">
    <thead>
      <tr>
        <th class="text-center">id</th>
        <th class="text-center">nom complet</th>
        <th class="text-center">Email</th>
        <th class="text-center">Filière</th>
        <th class="text-center">telephone</th>
        <th>Action</th>
      </tr>
    </thead>

    <?php
        foreach($users as $user):
      ?>

          <tr>
          <td id="id"><?php echo $user["id"] ?></td>
          <td id="full_name"><?php echo $user["full_name"]?></td>
          <td id="email"><?php echo $user["email"]?></td>
          <td id="branch"><?php echo $user["branch"]?></td>
          <td id="phone_number"><?php echo $user["phone_number"]?></td>
          <td>
            <button class="btn"  onclick="loadUser(event.target);" data-toggle="modal" data-target="#editUserModal">
              <i class="fa fa-pencil cursor-pointer text-success"></i>
            </button>
            <button class="btn" onclick="confirmDeleteUser(<?= $user['id'] ?>);">
              <i class="fa fa-trash text-danger"></i>
            </button>
          </td>
        </tr>

      <?php
      endforeach;
        } else {
      ?>
          <div class="text-center text-muted pt-5">Aucune adhérents trouvé</div>
      <?php
        }
        }
      ?>

    <?php
    
    ?>
  </table>
  </div>

</div>

    <!-- Add user modal -->
    <div class="modal fade" id="addUserModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Nouveau adhérent</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="addUserForm"  enctype='multipart/form-data' action="" method="POST">
            <div class="form-group">
              <label for="c_name">nom complet</label>
              <input type="text" class="form-control" name="full_name" required>
              <div class="input-error text-danger" data-input="full_name" ></div>
            </div>
            <div class="form-group">
              <label for="c_name">Email</label>
              <input type="text" class="form-control" name="email" required>
              <div class="input-error text-danger" data-input="email" ></div>
            </div>
            <?php
              if($stmt = $connection->prepare('select * from branches'))
              {
                $stmt->execute();
                $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);
              }
            ?>
            <div class="form-group">
              <label for="c_name">Filiere</label>
              <select name="branch_id" class="form-control" id="">
              <?php
              foreach($branches as $branch):
                ?>

              <option value="<?= $branch['id'] ?>"> <?= $branch['name'] ?> </option>

              <?php
              endforeach;
              ?>
              </select>
              <div class="input-error text-danger" data-input="branch" ></div>
            </div>
            <div class="form-group">
              <label for="c_name">Telephone</label>
              <input type="text" class="form-control" name="phone_number" required>
              <div class="input-error text-danger" data-input="phone_number" ></div>
            </div>
            <div class="form-group">
              <label for="c_name" class="d-flex justify-content-between align-items-center pr-2">
                Mot de passe
                <span class="togglePasswordVisibility">
                  <i class="fa fa-eye"></i>
                </span>
              </label>
              <input type="password" class="passwordShowHideInput form-control" name="password" required>
              <div class="input-error text-danger" data-input="password" ></div>
            </div>
            <div class="form-group">
            <label for="c_name" class="d-flex justify-content-between align-items-center pr-2">
                Confirmez mot de passe
                <span id="togglePasswordVisibility">
                  <i class="fa fa-eye"></i>
                </span>
              </label>
              <input type="password" class="passwordShowHideInput form-control" name="password_confirm" required>
              <div class="input-error text-danger" data-input="password_confirm" ></div>
            </div>
            <div class="form-group">
              <button type="button" onclick="addUser();" class="btn btn-secondary" style="height:40px">Ajouter</button>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">fermer</button>
        </div>
      </div>
      
    </div>
  </div>

      <!-- Edit user modal -->
    <div class="modal fade" id="editUserModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modifier adhérent</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="editUserForm"  enctype='multipart/form-data' action="" method="POST">
            <input type="hidden" name="id">
            <div class="form-group">
              <label for="c_name">nom complet</label>
              <input type="text" class="form-control" name="full_name" required>
              <div class="input-error text-danger" data-input="full_name" ></div>
            </div>
            <div class="form-group">
              <label for="c_name">Email</label>
              <input type="text" class="form-control" name="email" required>
              <div class="input-error text-danger" data-input="email" ></div>
            </div>
            <?php
              if($stmt = $connection->prepare('select * from branches'))
              {
                $stmt->execute();
                $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);
              }
            ?>
            <div class="form-group">
              <label for="c_name">Filiere</label>
              <select name="branch_id" class="form-control" id="">
              <?php
              foreach($branches as $branch):
                ?>

              <option value="<?= $branch['id'] ?>"><?= $branch['name'] ?></option>

              <?php
              endforeach;
              ?>
              </select>
              <div class="input-error text-danger" data-input="branch" ></div>
            </div>
            <div class="form-group">
              <label for="c_name">Telephone</label>
              <input type="text" class="form-control" name="phone_number" required>
              <div class="input-error text-danger" data-input="phone_number" ></div>
            </div>
            <div class="form-group">
              <label for="c_name" class="d-flex justify-content-between align-items-center pr-2">
                Nouveau mot de passe
                <span class="togglePasswordVisibility">
                  <i class="fa fa-eye"></i>
                </span>
              </label>
              <input type="password" class="passwordShowHideInput form-control" name="password" required>
              <div class="input-error text-danger" data-input="password" ></div>
            </div>
            <div class="form-group">
            <label for="c_name" class="d-flex justify-content-between align-items-center pr-2">
                Confirmez mot de passe
                <span class="togglePasswordVisibility">
                  <i class="fa fa-eye"></i>
                </span>
              </label>
              <input type="password" class="passwordShowHideInput form-control" name="password_confirm" required>
              <div class="input-error text-danger" data-input="password_confirm" ></div>
            </div>
            <div class="form-group">
              <button type="button" onclick="editUser();" class="btn btn-success" style="height:40px">Ajouter adhérent</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">fermer</button>
        </div>
      </div>
      
    </div>
  </div>

      <!-- Delete user modal -->
      <div class="modal fade" id="deleteUserModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Supprimer adhérent</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Voulez vous vraiment supprimez cet adhérent?</h6>
        </div>
        <div class="modal-footer">
          <button id="deleteUserModalBtn" type="button" onclick="deleteUser();" class="btn btn-primary" style="height:40px">Oui, supprimez</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">fermer</button>
      </div>
      </div>
      
    </div>
  </div>

  <script>

      // Password show/hide
  $('.togglePasswordVisibility').click(function (){

    const passwordInput = $(this).parents('.form-group').find('input.passwordShowHideInput')[0];

    if($(passwordInput).attr('type') == 'password')
    {
      $(this).children('i').addClass('fa-eye-slash');
      $(passwordInput).attr('type', 'text');
    } else {
      $(this).children('i').removeClass('fa-eye-slash');
      $(passwordInput).attr('type', 'password');
    }
  })

    // Initialize datatable
    if($('.datatable').length > 0)
  {
    $('.datatable').DataTable({
        order: [],
        oLanguage: {
        sLengthMenu: "Affiche _MENU_ enregistrements par page",
        sZeroRecords: "Rien n'a été trouvé - desolé",
        sInfo: "Affiche _START_ à _END_ de _TOTAL_ enregistrements",
        sInfoEmpty: "Affiche 0 à 0 de 0 enregistrements",
        sInfoFiltered: "(filtré de _MAX_ total enregistrements)",
        sSearch: 'chercher:',
        oPaginate: {
            sFirst:    "Premier",
            sLast:    "Dernier",
            sNext:    "Suivant",
            sPrevious: "Précédent"
        },
      }
    });  
  }
  </script>