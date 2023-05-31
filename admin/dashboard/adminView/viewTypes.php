
<?php
  include_once "../../../app/config/db.php";
  $connection = getConnection();
?>

<div >
  <div class="d-flex justify-content-between mt-4 mb-5">
  <h4 class="">Types de documents</h4>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-primary" style="height:40px" data-toggle="modal" data-target="#addDocTypeModal">
    <i class="fa fa-plus"></i>
    Ajouter
  </button>
  </div>
    <?php
      $sql = "SELECT *
              FROM doc_types
              ORDER BY created_at desc";

      $stmt = $connection->prepare($sql);
      if($stmt)
      {
        $stmt->execute();
        $doc_types = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($doc_types) > 0)
        {
        ?>
    <div class="table-responsive">
    <table class="table datatable bg-white">
    <thead>
      <tr>
        <th class="text-center">id</th>
        <th class="text-center">nom</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>

    <?php
        foreach($doc_types as $type):
      ?>

          <tr>
          <td id="id"><?php echo $type["id"] ?></td>
          <td id="name"><?php echo $type["name"]?></td>
          <td>
              <button class="btn text-success" onclick="loadDocType(event.target);" data-toggle="modal" data-target="#editDocTypeModal">
                <i class="fa fa-pencil"></i>
              </button>
              <button class="btn text-danger" onclick="confirmDeleteDocType(<?= $type['id'] ?>);">
                <i class="fa fa-trash"></i>
              </button>
          </td>
        </tr>

      <?php
      endforeach;
        } else {
      ?>
          <div class="text-center text-muted pt-5">Aucune type de document trouvé</div>
      <?php
        }
        }
      ?>

    <?php
    
    ?>
  </table>
  </div>

  <!-- Add document type modal -->
  <div class="modal fade" id="addDocTypeModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Nouveau type</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="addDocTypeForm"  enctype='multipart/form-data' action="" method="POST">
            <div class="form-group">
              <label for="c_name">nom du type</label>
              <input type="text" class="form-control" name="name" required>
              <div class="input-error text-danger" data-input="name" ></div>
            </div>
            <div class="form-group">
              <button type="button" onclick="addType();" class="btn btn-secondary" style="height:40px">Ajouter Type</button>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">fermer</button>
        </div>
      </div>
      
    </div>
  </div>

    <!-- Edit document type modal -->
    <div class="modal fade" id="editDocTypeModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modifier type</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="editDocTypeForm"  enctype='multipart/form-data' action="" method="POST">
            <input type="hidden" name="id">
            <div class="form-group">
              <label for="c_name">nom du type</label>
              <input type="text" class="form-control" name="name" required>
              <div class="input-error text-danger" data-input="name" ></div>
            </div>
            <div class="form-group">
              <button type="button" onclick="editType();" class="btn btn-success" style="height:40px">Sauvgarder</button>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">fermer</button>
        </div>
      </div>
      
    </div>
  </div>

      <!-- Delete document type modal -->
    <div class="modal fade" id="deleteDocTypeModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Supprimer type</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Voulez vous vraiment supprimez ce type?</h6>
        </div>
        <div class="modal-footer">
          <button id="deleteDocTypeModalBtn" type="button" onclick="deleteDocType();" class="btn btn-primary" style="height:40px">Oui, supprimez</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">fermer</button>
      </div>
      </div>
      
    </div>
  </div>

  
</div>

<script>
  $(function (){
  
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

})
</script>