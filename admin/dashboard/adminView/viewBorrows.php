

<?php
  include_once "../../../app/config/db.php";
  $connection = getConnection();
?>

<div class="alert alert-secondary sticky-top" style="display: none;">Envoie d'avertissement en cours...</div>
<div class="d-flex justify-content-between mt-4 mb-5">
  <h4 class="">Empruntes</h4>
  <!-- Trigger the modal with a button -->
  <!-- <button type="button" class="btn btn-primary" style="height:40px" data-toggle="modal" data-target="#addBorrowModal">
    <i class="fa fa-plus"></i>
    Ajouter
  </button> -->
  </div>

    <?php
      $sql = "SELECT b.*, d.title AS doc_title, u.full_name as user_name FROM borrows b
              LEFT JOIN documents d ON b.doc_id=d.id
              LEFT JOIN users u ON b.user_id=u.id
              ORDER BY b.borrow_date desc";

      $stmt = $connection->prepare($sql);
      if($stmt)
      {
        $stmt->execute();
        $borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($borrows) > 0)
        {
        ?>
    <div class="table-responsive">
    <table id="borrowsTable" class="table datatable bg-white">
    <thead>
      <tr>
        <th class="text-center">code</th>
        <th class="text-center">Document</th>
        <th class="text-center">Adhérent</th>
        <th class="text-center">Date d'emprunte</th>
        <th class="text-center">Date de retour</th>
        <th class="text-center">Status</th>
        <th>Action</th>
      </tr>
    </thead>

    <?php
        foreach($borrows as $borrow):
      ?>

          <tr>
          <td id="borrow_code" class="align-middle" ><?php echo $borrow["borrow_code"] ?></td>
          <td id="document" class="align-middle"><?php echo $borrow["doc_title"]?></td>
          <td id="utilisateur" class="align-middle"><?php echo $borrow["user_name"]?></td>
          <td id="borrow_date" class="align-middle"><?php echo $borrow["borrow_date"]?></td>
          <td id="return_date" class="align-middle"><?php echo $borrow["return_date"]?></td>
          <td>
            <?php
              if($borrow['status'] == 'en cours')
              {
            ?>
            <div>Accepter?</div> 
            <button class="btn btn-success btn-sm"  onclick='respondBorrowRequest("accept", <?= json_encode($borrow["borrow_code"]);?>);' >Oui</button>
            <button class="btn btn-danger btn-sm"  onclick='respondBorrowRequest("reject", <?= json_encode($borrow["borrow_code"]);?>);' >Non</button>

            <?php
              } else
              {
                if($borrow['status'] == 'active')
                {
                  $badgeColor = 'success';
                } elseif(in_array($borrow['status'], ['refuse', 'non retourne'])){
                  $badgeColor = 'danger';
                } else {
                  $badgeColor = 'primary';
                }
              ?>
              <span class="badge badge-<?= $badgeColor ?>"><?= $borrow['status']; ?></span>
            <?php
              }
            ?>

          </td>
          <td class="align-middle">
            <div class="dropleft">
            <button class="btn btn-sm" data-toggle="dropdown">
              <i class="fa fa-ellipsis-h"></i>
            </button>
            <div class="dropdown-menu">
            <button class="dropdown-item" <?= !in_array($borrow['status'], ['active', 'non retourne']) ? 'disabled' : '' ?> onclick='returnDocument(<?= json_encode($borrow["borrow_code"]) ?>);''>Retourner</button>
            <button class="dropdown-item" onclick='alertUser(<?= json_encode($borrow["borrow_code"]) ?>)' >Avertir adhérent</button>
            <!-- Loader -->
            <div class="loader-wrapper position-absolute bg-dark top-0 bottom-0 start-0 end-0">
            <svg version="1.1" id="L5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                <circle fill="#fff" stroke="none" cx="6" cy="50" r="6">
                  <animateTransform
                    attributeName="transform" 
                    dur="1s" 
                    type="translate" 
                    values="0 15 ; 0 -15; 0 15" 
                    repeatCount="indefinite" 
                    begin="0.1"/>
                </circle>
                <circle fill="#fff" stroke="none" cx="30" cy="50" r="6">
                  <animateTransform 
                    attributeName="transform" 
                    dur="1s" 
                    type="translate" 
                    values="0 10 ; 0 -10; 0 10" 
                    repeatCount="indefinite" 
                    begin="0.2"/>
                </circle>
                <circle fill="#fff" stroke="none" cx="54" cy="50" r="6">
                  <animateTransform 
                    attributeName="transform" 
                    dur="1s" 
                    type="translate" 
                    values="0 5 ; 0 -5; 0 5" 
                    repeatCount="indefinite" 
                    begin="0.3"/>
                </circle>
              </svg>
            </div>
            </div>
            </div>
          </td>
        </tr>

      <?php
      endforeach;
        } else {
      ?>
          <div class="text-center text-muted pt-5">Aucune document trouvé</div>
      <?php
        }
        }
      ?>

    <?php
    
    ?>
  </table>
  </div>

  <script>
    console.log('HI')
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