

$('#borrowBtn').click(function (){
  $.ajax({
    type: 'post',
    url: 'http://localhost/management-of-library/app/includes/logic/ajax/borrow.php',
    data: {
        data: {
            docID: $("input[type='hidden'][name='docID']").val(),
            userID: $("input[type='hidden'][name='userID']").val()
        }
    }
  }).then(function (data){
    data = JSON.parse(data);
   if(data.borrowError)
   {
     $('#borrowModal .modal-body').html(`<h5 class='text-center text-danger'>${data.borrowError}</h5>`);
   } else {
    $('#borrowModal .modal-body').html(`
    <div class="text-center">
    <h5 class='text-success'>Emprunte effectueé avec succés</h5>
    <a download href="${data.receiptFileUrl}">Telecharger le recu</a>
    </div>`)
   }
  })
})