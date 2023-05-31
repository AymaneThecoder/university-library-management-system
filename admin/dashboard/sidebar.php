<!-- Sidebar -->

<div class="sidebar" id="mySidebar">
<div class="side-header">
    <img src="./assets/images/logo.png" width="120" height="120" alt="Swiss Collection"> 
    <h5 style="margin-top:10px;">Bonjour <?= $_SESSION['name'] ?> </h5>
</div>

<hr style="border:1px solid; background-color:#8a7b6d; border-color:#3B3131;">
    <a class="tab-link" href="./index.php"><i class="fa fa-home"></i> Dashboard</a>
    <a class="tab-link" href="#Adherents" onclick="showUsers()" ><i class="fa fa-users"></i> adhérents</a>
    <a class="tab-link" href="#documents" onclick="showDocuments()"><i class="fa fa-book"></i> Documents</a>
    <a class="tab-link" href="#doc_types" onclick="showDocTypes()" ><i class="fa fa-th-large"></i> Types</a>   
    <a class="tab-link" href="#categories" onclick="showDocCategories()" ><i class="fa fa-th"></i> Categories</a>
    <a class="tab-link" href="#empruntes" onclick="showBorrows()"><i class="fa fa-list"></i> Empruntes</a>
    <a class="tab-link" href="#avertissements" onclick="showReturnDocAlerts()"><i class="fa fa-exclamation"></i> Avertissements</a>
  
  <!---->
</div>
<script>
  function showEmprunts(){  
    $.ajax({
      url: "./adminView/viewEmprunts.php",
      method: "post",
      data: {record:1},
      success: function(data){
        $('.allContent-section').html(data);
      }
    });
  }
  function showRetenus(){  
    $.ajax({
      url: "./adminView/viewEmprunts.php",
      method: "post",
      data: {record:1},
      success: function(data){
        $('.allContent-section').html(data);
      }
    });
  }
  function confirmEmprunts(id) {  
  $.ajax({
    url: "./controller/confirmBorrow.php",
    method: "post",
    data: { borrow_code: id },
    success: function(data) {
      $('.allContent-section').html(data);
      showEmprunts();
    }
  });
}

  function confirmRetenus(id){   
  $.ajax({
    url: "./controller/confirmRetenu.php",
    method: "post",
    data: { borrow_code: id }, // Pass the id as the value for the "borrow_code" parameter
    success: function(data) {
      $('.allContent-section').html(data);
      showRetenus();
    }
  });
}
function showHistorique(){  
    $.ajax({
      url: "./adminView/viewHistorique.php",
      method: "post",
      data: {record:1},
      success: function(data){
        $('.allContent-section').html(data);
      }
    });
  }
</script>



