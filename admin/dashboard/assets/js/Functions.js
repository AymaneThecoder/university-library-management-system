


  /* Global variables */

// Delete document modal HTML content
let deleteDocModalHtml = '';



/* users */

function showUsers(){
    $.ajax({
        url:"./adminView/viewUsers.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function addUser(){

    $('.input-error').text('');

    $.ajax({
        url:"./controller/users/addUserController.php",
        method:"post",
        data: new FormData($('#addUserForm')[0]),
        success:function(data){
            console.log(data);

            if(data['status'] == 'error')
            {
                // Form errrors
                $formErrors = data['errors'];

                if(Object.keys($formErrors).length > 0)
                {
                    for(const key in $formErrors)
                    {
                        $(`#addUserForm .input-error[data-input=${key}`).text($formErrors[key][0]);
                    }
                }
            } else {
                
                // Close modal
                $('#addUserModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showUsers();
            }

        },
        error: function (error){
            console.log(error);
        },
        dataType: 'json',
        processData: false,
        contentType: false
    });
}

// Load user used to pre-populate edit user form
function loadUser(target){
        
    const userRow = $(target).parents('tr')[0];

    $(userRow).find('td').each(function (){
        const inputName = $(this).attr('id');
        const inputValue = $(this).text();

        // Handle user branch pre-populate select
        if(inputName == 'branch')
        {
   
            $('form#editUserForm select[name=branch_id] option').each(function (){
                if($(this).text() == inputValue)
                {
                    $(this).attr('selected', 'selected');
                } else {
                    $(this).removeAttr('selected');
                }
            });

            return;
        }


        $(`#editUserForm input[name=${inputName}]`).val(inputValue);
    })
}

function editUser(){
    $.ajax({
        url:"./controller/users/editUserController.php",
        method:"post",
        data: new FormData($('#editUserForm')[0]),
        success:function(data){

            if(data['status'] == 'error')
            {
                // Form errrors
                $formErrors = data['errors'];

                if(Object.keys($formErrors).length > 0)
                {
                    for(const key in $formErrors)
                    {
                        $(`#editUserForm .input-error[data-input=${key}`).text($formErrors[key][0]);
                    }
                }
            } else {

                // Close modal
                $('#editUserModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showUsers();
            }

        },
        error: function (error){
            console.log(error);
        },
        dataType: 'json',
        processData: false,
        contentType: false
    });
}

function confirmDeleteUser(userId){

    $('#deleteUserModalBtn').attr('onclick', `deleteUser(${userId})`)

    // SHow confirmation modal
    $('#deleteUserModal').modal('show');
}

function deleteUser(userId){

    $.ajax({
        url:"./controller/users/deleteUserController.php",
        method:"post",
        data: {
            'userId': userId
        },
        success:function(data){

            if(data['status'] == 'error')
            {
                
            } else {

                // Close modal
                $('#deleteUserModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showUsers();
            }

        },
        error: function (error){
            console.log(error);
        }
    });
}

/* Documents */

function showDocuments(){  
    $.ajax({
        url:"./adminView/viewDocuments.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function addDocument(){
    
    $('.input-error').text('');

    const data = new FormData($('#addDocumentForm')[0]);
    data.append('doc_img', $('#addDocumentForm input[name=doc_img]')[0].files[0]);

    $.ajax({
        url:"./controller/documents/addDocumentController.php",
        method:"post",
        data: data,
        success:function(data){

            if(data['status'] == 'error')
            {
                // Form errrors
                $formErrors = data['errors'];

                if(Object.keys($formErrors).length > 0)
                {
                    for(const key in $formErrors)
                    {
                        $(`#addDocumentForm .input-error[data-input=${key}`).text($formErrors[key][0]);
                    }
                }
            } else {

                // Close modal
                $('#addDocumentModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showDocuments();
            }

        },
        error: function (error){
            console.log(error);
        },
        dataType: 'json',
        processData: false,
        contentType: false
    });   
}

// Load document used to pre-populate edit document form
function loadDocument(target){
        
    const docRow = $(target).parents('tr')[0];

    $(docRow).find('td').each(function (){
        const inputName = $(this).attr('id');
        const inputValue = $(this).text();

        // Handle document type pre-populate select
        if(inputName == 'type')
        {
   
            $('form#editDocumentForm select[name=type_id] option').each(function (){
                if($(this).text() == inputValue)
                {
                    $(this).attr('selected', 'selected');
                } else {
                    $(this).removeAttr('selected');
                }
            });

            return;
        }

        // Handle document category pre-populate select
        if(inputName == 'category')
        {
   
            $('form#editDocumentForm select[name=category_id] option').each(function (){
                if($(this).text() == inputValue)
                {
                    $(this).attr('selected', 'selected');
                } else {
                    $(this).removeAttr('selected');
                }
            });

            return;
        }


        $(`#editDocumentForm input[name=${inputName}], textarea[name=${inputName}]`).val(inputValue);
    })
}

function viewDocument(target){
        
    const docRow = $(target).parents('tr')[0];

    // Show image
    const image = $(docRow).find('input[name=doc_img]').val();

    if(image)
    {
        $(`#viewDocumentModal img.doc-image`).attr('src', 'http://localhost/management-of-library/admin/dashboard/assets/images/uploads/doc_images/' + image);
    } else {
        $(`#viewDocumentModal img.doc-image`).remove();
        $('#viewDocumentModal .doc-image-container').append(`
            <div class="text-center text-sm text-danger p-4">
            Aucune image
            </div>
        `)
    }
    

    $(docRow).find('td').each(function (){
        const inputName = $(this).attr('id');
        const inputValue = $(this).text();

        $(`#viewDocumentModal .${inputName}`).text(inputValue);
    })
}

function editDocument(){
    
    $('.input-error').text('');

    const data = new FormData($('#editDocumentForm')[0]);
    data.append('doc_img', $('#editDocumentForm input[name=doc_img]')[0].files[0]);

    $.ajax({
        url:"./controller/documents/editDocumentController.php",
        method:"post",
        data: data,
        success:function(data){

            if(data['status'] == 'error')
            {
                // Form errrors
                $formErrors = data['errors'];

                if(Object.keys($formErrors).length > 0)
                {
                    for(const key in $formErrors)
                    {
                        $(`#editDocumentForm .input-error[data-input=${key}`).text($formErrors[key][0]);
                    }
                }
            } else {

                // Close modal
                $('#editDocumentModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showDocuments();
            }

        },
        error: function (error){
            console.log(error);
        },
        dataType: 'json',
        processData: false,
        contentType: false
    });   
}

function confirmDeleteDocument(docId){

    // Reset modal state
    $('#deleteDocumentModal').html(deleteDocModalHtml);    

    $('#deleteDocumentModalBtn').attr('onclick', `deleteDocument(${docId})`)

    // SHow confirmation modal
    $('#deleteDocumentModal').modal('show');
}

function deleteDocument(docId){

    $.ajax({
        url:"./controller/documents/deleteDocumentController.php",
        method:"post",
        data: {
            'docId': docId
        },
        success:function(data){

            if(data['status'] == 'error')
            {
                // The document cannot be deleted
                // Because it has active borrows

                if(data['errors']['canDelete'] == false)
                {
                    // Show error deleting document modal
                    $('#deleteDocumentModal .modal-body').html(`
                        <p class="text-center text-danger">
                        Desolé! ne peut pas supprimer le document, car elle a des empruntes actives
                        </p>
                    `)
                    $('#deleteDocumentModalBtn').remove();
                }
            } else {

                // Close modal
                $('#deleteDocumentModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showDocuments();
            }

        },
        dataType: 'json',
        error: function (error){
            console.log(error);
        }
    });
}

function returnDocument(borrowCode){
    $.ajax({
        url:"./controller/documents/returnDocumentController.php",
        method:"post",
        data: {
            borrowCode: borrowCode
        },
        success:function(data){
            if(data['status'] == 'error')
            {
                
            } else {
                showBorrows();
            }
        }
    });
}

/* Borrows */

function showBorrows(){  
    $.ajax({
        url:"./adminView/viewBorrows.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

// Respond to borrow request by accept/reject
function respondBorrowRequest(action, borrowCode){  

    $.ajax({
        url:"./controller/borrows/respondBorrowRequestController.php",
        method:"post",
        data:{
            borrowCode: borrowCode,
            action: action
        },
        success:function(data){
           if(data['status'] == 'error')
           {

           } else {
            showBorrows();
           }
        },
        error: function(error){

        }
    });
}

// Alert user on document return

function alertUser(borrowCode){

    // Show loader
    $('.alert')
    .attr('class', 'alert alert-secondary')
    .text('Envoie d\'avertissement en cours...')
    .show();

    // Disable table action button
    $('#borrowsTable button[data-toggle=dropdown]').attr('disabled', 'disabled');

    $.ajax({
        url:"./controller/borrows/alertUserController.php",
        method:"post",
        data:{
            borrowCode: borrowCode
        },
        success:function(data){

            $('#borrowsTable button[data-toggle=dropdown]').removeAttr('disabled');
            
           if(data['status'] == 'error')
           {
                $('.alert')
                .attr('class', 'alert alert-danger')
                .text('Erreur lors d\'envoie d\'avertissement')
                .fadeOut(5000)
           } else {
            $('.alert')
            .attr('class', 'alert alert-success')
            .text('Avertissment envoyé avec succès')
            .fadeOut(5000)
           }
        },
        error: function(error){

            $('#borrowsTable button[data-toggle=dropdown]').removeAttr('disabled');

            $('.alert')
            .addClass('alert-danger')
            .text('Erreur lors d\'envoie d\'avertissement')
            .fadeOut(5000)
        }
    });
}

/* Borrows alerts */

function showReturnDocAlerts(){  
    $.ajax({
        url:"./adminView/viewReturnDocAlerts.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

/* documents types */

function showDocTypes(){  
    $.ajax({
        url:"./adminView/viewTypes.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function addType(){
    $.ajax({
        url:"./controller/doc_types/addTypeController.php",
        method:"post",
        data: new FormData($('#addDocTypeForm')[0]),
        success:function(data){

            if(data['status'] == 'error')
            {
                // Form errrors
                $formErrors = data['errors'];

                if(Object.keys($formErrors).length > 0)
                {
                    for(const key in $formErrors)
                    {
                        $(`#addDocTypeForm .input-error[data-input=${key}`).text($formErrors[key]);
                    }
                }
            } else {
                
                // Close modal
                $('#addDocTypeModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showDocTypes();
            }

        },
        error: function (error){
            console.log(error);
        },
        dataType: 'json',
        processData: false,
        contentType: false
    });
}

// Load type used to pre-populate edit document type form
function loadDocType(target){
        
    const docTypeRow = $(target).parents('tr')[0];

    $(docTypeRow).find('td').each(function (){
        const inputName = $(this).attr('id');
        const inputValue = $(this).text();

        $(`#editDocTypeForm input[name=${inputName}]`).val(inputValue);
    })
}

function editType(){
    $.ajax({
        url:"./controller/doc_types/editTypeController.php",
        method:"post",
        data: new FormData($('#editDocTypeForm')[0]),
        success:function(data){

            if(data['status'] == 'error')
            {
                // Form errrors
                $formErrors = data['errors'];

                if(Object.keys($formErrors).length > 0)
                {
                    for(const key in $formErrors)
                    {
                        $(`#editDocTypeForm .input-error[data-input=${key}`).text($formErrors[key]);
                    }
                }
            } else {

                // Close modal
                $('#editDocTypeModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showDocTypes();
            }

        },
        error: function (error){
            console.log(error);
        },
        dataType: 'json',
        processData: false,
        contentType: false
    });
}

function confirmDeleteDocType(typeId){

    $('#deleteDocTypeModalBtn').attr('onclick', `deleteDocType(${typeId})`)

    // SHow confirmation modal
    $('#deleteDocTypeModal').modal('show');
}

function deleteDocType(typeId){

    $.ajax({
        url:"./controller/doc_types/deleteTypeController.php",
        method:"post",
        data: {
            'typeId': typeId
        },
        success:function(data){

            if(data['status'] == 'error')
            {
                
            } else {

                // Close modal
                $('#deleteDocTypeModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showDocTypes();
            }

        },
        error: function (error){
            console.log(error);
        }
    });
}


/* documents categories */

function showDocCategories(){  
    $.ajax({
        url:"./adminView/viewCategories.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function addCategorie(){
    $.ajax({
        url:"./controller/doc_categories/addCategorieController.php",
        method:"post",
        data: new FormData($('#addDocCategorieForm')[0]),
        success:function(data){

            if(data['status'] == 'error')
            {
                // Form errrors
                $formErrors = data['errors'];

                if(Object.keys($formErrors).length > 0)
                {
                    for(const key in $formErrors)
                    {
                        $(`#addDocCategorieForm .input-error[data-input=${key}`).text($formErrors[key]);
                    }
                }
            } else {
                
                // Close modal
                $('#addDocCategorieModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showDocCategories();
            }

        },
        error: function (error){
            console.log(error);
        },
        dataType: 'json',
        processData: false,
        contentType: false
    });
}

// Load categorie used to pre-populate edit document categorie form
function loadDocCategorie(target){
        
    const docCategorieRow = $(target).parents('tr')[0];

    $(docCategorieRow).find('td').each(function (){
        const inputName = $(this).attr('id');
        const inputValue = $(this).text();

        $(`#editDocCategorieForm input[name=${inputName}]`).val(inputValue);
    })
}

function editCategorie(){
    $.ajax({
        url:"./controller/doc_categories/editCategorieController.php",
        method:"post",
        data: new FormData($('#editDocCategorieForm')[0]),
        success:function(data){

            if(data['status'] == 'error')
            {
                // Form errrors
                $formErrors = data['errors'];

                if(Object.keys($formErrors).length > 0)
                {
                    for(const key in $formErrors)
                    {
                        $(`#editDocCategorieForm .input-error[data-input=${key}`).text($formErrors[key]);
                    }
                }
            } else {

                // Close modal
                $('#editDocCategorieModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showDocCategories();
            }

        },
        error: function (error){
            console.log(error);
        },
        dataType: 'json',
        processData: false,
        contentType: false
    });
}

function confirmDeleteDocCategorie(ctgrId){

    $('#deleteDocCategorieModalBtn').attr('onclick', `deleteDocCategorie(${ctgrId})`)

    // SHow confirmation modal
    $('#deleteDocCategorieModal').modal('show');
}

function deleteDocCategorie(ctgrId){
    
    $.ajax({
        url:"./controller/doc_categories/deleteCategorieController.php",
        method:"post",
        data: {
            'ctgrId': ctgrId
        },
        success:function(data){

            if(data['status'] == 'error')
            {
                
            } else {

                // Close modal
                $('#deleteDocCategorieModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                showDocCategories();
            }

        },
        error: function (error){
            console.log(error);
        }
    });
}

function showRetenus(){  
    $.ajax({
        url:"./adminView/viewRetenus.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}
function typeDelete(id){
    $.ajax({
        url:"./controller/typeDeleteController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('type Successfully deleted');
            $('form').trigger('reset');
            showTypes();
        }
    });
}

function addExamplaires(){
    var titre=$('#titre').val();
    var auteur=$('#auteur').val();
    var descript=$('#descript').val();
    var qte=$('#qte').val();
    var nom_type=$('#nom_type').val();
    var upload=$('#upload').val();
    var file=$('#file')[0].files[0];

    var fd = new FormData();
    fd.append('titre', titre);
    fd.append('auteur', auteur);
    fd.append('descript', descript);
    fd.append('qte', qte);
    fd.append('nom_type', nom_type);
    fd.append('file', file);
    fd.append('upload', upload);
    $.ajax({
        url:"./controller/addExamplaireController.php",
        method:"post",
        data:fd,
        processData: false,
        contentType: false,
        success: function(data){
            alert('Document Added successfully.');
            $('form').trigger('reset');
            showExamplaires();
        }
    });
}
function examplaireDelete(id){
    $.ajax({
        url:"./controller/deleteExamplaireController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Document Successfully deleted');
            $('form').trigger('reset');
            showExamplaires();
        }
    });
}
function examplaireEditForm(id){
    $.ajax({
        url:"./adminView/editExamplaireForm.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}
function updateExamplaires(){
    var id_doc = $('#id_doc').val();
    var titre = $('#titre').val();
    var auteur = $('#auteur').val();
    var descript = $('#descript').val();
    var nom_type = $('#nom_type').val();
    var qte = $('#qte').val();
    var existingImage = $('#existingImage').val();
    var newImage = $('#newImage')[0].files[0];
    var fd = new FormData();
    fd.append('id_doc', id_doc);
    fd.append('titre', titre);
    fd.append('auteur', auteur);
    fd.append('descript', descript);
    fd.append('nom_type', nom_type);
    fd.append('qte', qte);
    fd.append('existingImage', existingImage);
    fd.append('newImage', newImage);
   
    $.ajax({
      url:'./controller/updateExamplaireController.php',
      method:'post',
      data:fd,
      processData: false,
      contentType: false,
      success: function(data){
        alert('Document infos Update Success.');
        $('form').trigger('reset');
        showExamplaires();
      }
    });
}
