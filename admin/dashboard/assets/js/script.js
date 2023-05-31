

$(function (){
  
  // Initialize datatable
  console.log($('#addDocTypeModal'));
  if($('.datatable').length > 0)
  {
    $('.datatable').DataTable();
  }

  // Toggle sidebar

  $('.toggle-sidebar-btn').click(function (){
    const state = $(this).attr('data-is-sidebar-open');

    state == 'false' ? openSidebar() : closeSidebar();
  })

})

function openSidebar() {
  console.log('Open')
  document.querySelector('button.toggle-sidebar-btn').dataset.isSidebarOpen = 'true';
  document.querySelector('button.toggle-sidebar-btn i').classList.add('fa-angle-double-left');
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = document.querySelector(".main-navbar").style.marginLeft = "250px";  
}

function closeSidebar() {
  document.querySelector('button.toggle-sidebar-btn').dataset.isSidebarOpen = 'false';
  document.querySelector('button.toggle-sidebar-btn i').classList.remove('fa-angle-double-left');
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft = document.querySelector(".main-navbar").style.marginLeft = "0";  
  console.log('Close')
}