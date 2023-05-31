<h2>Historique</h2>
<?php
include_once "../dataBaseCon/dbconnect.php";

$sql = "SELECT nom_complet, titre, borrow_date, return_date FROM adherent a, document d , historique h WHERE h.id_adh = a.id_adh AND h.id_doc = d.id_doc";
$result = $conn->query($sql);
?>

<table class="table">
  <thead>
    <tr>
      <th class="text-center">nom de l'adherent</th>
      <th class="text-center">nom du document</th>
      <th class="text-center">date d'emprunt</th>
      <th class="text-center">date du retour</th>
    </tr>
  </thead>
  <tbody>
  <?php if ($result->num_rows > 0): ?>
  <?php while ($row = $result->fetch_assoc()): ?>
  <tr>
    <td><?php echo $row["nom_complet"]?></td>
    <td><?php echo $row["titre"]?></td>
    <td><?php echo $row["borrow_date"]?></td>      
    <td><?php echo $row["return_date"]?></td> 
  </tr>
</tbody>
  <?php endwhile; ?>
  <?php endif; ?>
</table>