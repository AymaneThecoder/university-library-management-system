

<?php
  include_once "../../../app/config/db.php";
  $connection = getConnection();
?>

<div class="d-flex justify-content-between mt-4 mb-5">
  <h4 class="">Avertissements</h4>

  </div>

    <?php
      $sql = "SELECT al.*, d.title AS doc_title, u.full_name as user_name FROM return_doc_alert al
              INNER JOIN borrows b ON al.borrow_code=b.borrow_code
              INNER JOIN users u ON b.user_id=u.id
              INNER JOIN documents d ON b.doc_id=d.id
              ORDER BY al.alert_date DESC;
            ";

      $stmt = $connection->prepare($sql);
      if($stmt)
      {
        $stmt->execute();
        $alerts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($alerts) > 0)
        {
        ?>
    <div class="table-responsive">
    <table id="alertsTable" class="table datatable bg-white">
    <thead>
      <tr>
        <th class="text-center">code d'emprunte</th>
        <th class="text-center">Document</th>
        <th class="text-center">Adhérent</th>
        <th class="text-center">Date d'avertissement</th>
      </tr>
    </thead>

    <?php
        foreach($alerts as $alert):
      ?>

          <tr>
          <td id="borrow_code" class="align-middle" ><?php echo $alert["borrow_code"] ?></td>
          <td id="document" class="align-middle"><?php echo $alert["doc_title"]?></td>
          <td id="adherent" class="align-middle"><?php echo $alert["user_name"]?></td>
          <td id="alert_date" class="align-middle"><?php echo $alert["alert_date"]?></td>
        </tr>

        <?php
      endforeach;
        } else {
      ?>
          <div class="text-center text-muted pt-5">Aucune avertissement trouvé</div>
      <?php
        }
        }
      ?>

      </table>
      </div>



  <script>

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