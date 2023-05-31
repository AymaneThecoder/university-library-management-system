
<?php
  include_once "../../../app/config/db.php";
  $connection = getConnection();
?>

<div>
<div class="d-flex justify-content-between mt-4 mb-5">
  <h4 class="">Documents</h4>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-primary" style="height:40px" data-toggle="modal" data-target="#addDocumentModal">
    <i class="fa fa-plus"></i>
    Ajouter
  </button>
  </div>

    <?php
      $sql = "SELECT doc.*, t.name as doc_type, c.name as category FROM documents doc
              LEFT JOIN doc_types t ON doc.type_id=t.id
              LEFT JOIN doc_categories c ON doc.category_id=c.id
              ORDER BY doc.created_at desc";

      $stmt = $connection->prepare($sql);
      if($stmt)
      {
        $stmt->execute();
        $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($documents) > 0)
        {
        ?>
    <div class="table-responsive">
    <table class="table datatable bg-white">
    <thead>
      <tr>
        <th class="text-center">id</th>
        <th class="text-center">Titre</th>
        <th class="text-center">Description</th>
        <th class="text-center">Type</th>
        <th class="text-center">Categorie</th>
        <th class="text-center">Auteur</th>
        <th class="text-center">Pages</th>
        <th class="text-center">Stock</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>

    <?php
        foreach($documents as $document):
      ?>

          <tr>
          <input type="hidden" value="<?= $document['doc_img'] ?>" name="doc_img">
          <td id="id" ><?php echo $document["id"] ?></td>
          <td id="title"><?php echo $document["title"]?></td>
          <td id="doc_desc"><?php echo $document["doc_desc"]?></td>
          <td id="type"><?php echo $document["doc_type"]?></td>
          <td id="category"><?php echo $document["category"]?></td>
          <td id="author"><?php echo $document["author"]?></td>
          <td id="page_count"><?php echo $document["page_count"]?></td>
          <td id="copies_left"><?php echo $document["copies_left"]?></td>
          <td>
            <button class="btn"  onclick="viewDocument(event.target);" data-toggle="modal" data-target="#viewDocumentModal">
              <i class="fa fa-eye cursor-pointer text-primary"></i>
            </button>
            <button class="btn"  onclick="loadDocument(event.target);" data-toggle="modal" data-target="#editDocumentModal">
              <i class="fa fa-pencil cursor-pointer text-success"></i>
            </button>
            <button class="btn" onclick="confirmDeleteDocument(<?= $document['id'] ?>);">
              <i class="fa fa-trash text-danger"></i>
            </button>
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

  <!-- Add document Modal -->
  <div class="modal fade" id="addDocumentModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Nouveau document</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="addDocumentForm"  enctype='multipart/form-data' method="POST">
            <div class="form-group">
              <label for="name">Titre</label>
              <input type="text"  name="title" class="form-control" id="titre" required>
              <div class="input-error text-danger" data-input="title"></div>
            </div>
            <div class="form-group">
              <label for="name">Auteur</label>
              <input type="text"  name="author" class="form-control" id="author" required>
              <div class="input-error text-danger" data-input="author"></div>
            </div>
            <div class="form-group">
              <label for="name">Description</label>
              <textarea type="text"  name="doc_desc" class="form-control" id="titre"></textarea>
              <div class="input-error text-danger" data-input="doc_desc"></div>
            </div>
            <div class="row">
              <div class="col">
                  <div class="form-group">
                  <label for="name">Pages</label>
                  <input type="number"  name="page_count" class="form-control" id="titre" required>
                  <div class="input-error text-danger" data-input="page_count"></div>
                </div>
              </div>
              <div class="col">
                  <div class="form-group">
                  <label for="name">Copies</label>
                  <input type="number"  name="copies_left" class="form-control" id="titre" required>
                  <div class="input-error text-danger" data-input="copies_left"></div>
                </div>
              </div>
            </div>
            <div class="row">

            <?php

              if($stmt = $connection->prepare('SELECT * FROM doc_categories'))
              {
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
              }

              if($stmt = $connection->prepare('SELECT * FROM doc_types'))
              {
                $stmt->execute();
                $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
              }

            ?>

              <div class="col">
                <div class="form-group">
                  <label for="">Categorie</label>
                  <select name="category_id" id="" class="form-control">
                  <option value="">Choisir categorie</option>
                  <?php
                  foreach($categories as $ctgr):
                  ?>

                  <option value="<?= $ctgr['id'] ?>"><?= $ctgr['name'] ?></option>

                  <?php
                  endforeach;
                  ?>

                  </select>
                </div>
              </div>
              <div class="col">
              <div class="form-group">
                  <label for="">Type</label>
                  <select name="type_id" id="" class="form-control">
                  <option value="">Choisir type</option>
                  <?php
                  foreach($types as $type):
                  ?>

                  <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>

                  <?php
                  endforeach;
                  ?>

                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
                <label for="file">Image</label>
                <input class="form-control" name="doc_img" type="file" class="form-control-file">
                <div class="input-error text-danger" data-input="doc_img"></div>
            </div>
            <div class="form-group">
              <button type="button" onclick="addDocument();" class="btn btn-secondary"  style="height:40px">Ajouter</button>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Fermer</button>
        </div>
      </div>
      
    </div>
  </div>

    <!-- Edit document Modal -->
    <div class="modal fade" id="editDocumentModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modifier document</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="editDocumentForm"  enctype='multipart/form-data' method="POST">
            <input type="hidden" name="id">
            <div class="form-group">
              <label for="name">Titre</label>
              <input type="text"  name="title" class="form-control" id="titre" required>
              <div class="input-error text-danger" data-input="title"></div>
            </div>
            <div class="form-group">
              <label for="name">Auteur</label>
              <input type="text"  name="author" class="form-control" id="author" required>
              <div class="input-error text-danger" data-input="author"></div>
            </div>
            <div class="form-group">
              <label for="name">Description</label>
              <textarea type="text"  name="doc_desc" class="form-control" id="titre"></textarea>
              <div class="input-error text-danger" data-input="doc_desc"></div>
            </div>
            <div class="row">
              <div class="col">
                  <div class="form-group">
                  <label for="name">Pages</label>
                  <input type="number"  name="page_count" class="form-control" id="titre" required>
                  <div class="input-error text-danger" data-input="page_count"></div>
                </div>
              </div>
              <div class="col">
                  <div class="form-group">
                  <label for="name">Copies</label>
                  <input type="number"  name="copies_left" class="form-control" id="titre" required>
                  <div class="input-error text-danger" data-input="copies_left"></div>
                </div>
              </div>
            </div>
            <div class="row">

            <?php

              if($stmt = $connection->prepare('SELECT * FROM doc_categories'))
              {
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
              }

              if($stmt = $connection->prepare('SELECT * FROM doc_types'))
              {
                $stmt->execute();
                $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
              }

            ?>

              <div class="col">
                <div class="form-group">
                  <label for="">Categorie</label>
                  <select name="category_id" id="" class="form-control">
                  <option value="">Choisir categorie</option>
                  <?php
                  foreach($categories as $ctgr):
                  ?>

                  <option value="<?= $ctgr['id'] ?>"><?= $ctgr['name'] ?></option>

                  <?php
                  endforeach;
                  ?>

                  </select>
                </div>
              </div>
              <div class="col">
              <div class="form-group">
                  <label for="">Type</label>
                  <select name="type_id" id="" class="form-control">
                  <option value="">Choisir type</option>
                  <?php
                  foreach($types as $type):
                  ?>

                  <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>

                  <?php
                  endforeach;
                  ?>

                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
                <label for="file">Image</label>
                <input class="form-control" name="doc_img" type="file" class="form-control-file">
                <div class="input-error text-danger" data-input="doc_img"></div>
            </div>
            <div class="form-group">
              <button type="button" onclick="editDocument();" class="btn btn-success"  style="height:40px">Sauvgarder</button>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Fermer</button>
        </div>
      </div>
      
    </div>
  </div>

      <!-- View document Modal -->
      <div class="modal fade" id="viewDocumentModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Voire document</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="text-center doc-image-container mb-3">
            <img src="" alt="" class="doc-image rounded">
          </div>
            <div class="row">
              <div class="col text-right">
                <div id="title">
                  <strong>Titre:</strong>
                </div>
                <div>
                  <strong>Description:</strong>
                </div>
                <div>
                  <strong>Auteur:</strong>
                </div>
                <div>
                  <strong>Nombre de page:</strong>
                </div>
                <div>
                  <strong>Nombre de copies:</strong>
                </div>
                <div>
                  <strong>Type:</strong>
                </div>
                <div>
                  <strong>Categorie:</strong>
                </div>
              </div>
              <div class="col">
                <div class="title">
                </div>
                <div class="doc_desc">
                </div>
                <div class="author">
                </div>
                <div class="page_count">
                </div>
                <div class="copies_left">
                </div>
                <div class="type">
                </div>
                <div class="category">
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Fermer</button>
        </div>
      </div>
      
    </div>
  </div>

  
      <!-- Delete document modal -->
      <div class="modal fade" id="deleteDocumentModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Supprimer document</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Voulez vous vraiment supprimez cette document?</h6>
        </div>
        <div class="modal-footer">
          <button id="deleteDocumentModalBtn" type="button" onclick="deleteDocument();" class="btn btn-primary" style="height:40px">Oui, supprimez</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">fermer</button>
      </div>
      </div>
      
    </div>
  </div>
  
</div>

<script>

  // Inialize Delete document modal HTML content
  deleteDocModalHtml = $('#deleteDocumentModal').html();

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
   