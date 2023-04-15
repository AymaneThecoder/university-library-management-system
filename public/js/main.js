


/*
-------------------------------------------------------------------
-This script contains all the code for making the website interactive|
like (the burger menu navbar, Filtering documents) and others.                          |
-------------------------------------------------------------------|
*/

$(function () {



/* Burger menu navbar show / hide */

const slidingNavbar = document.querySelector(".navbar-small-devices");
const slidingNavTogglerBtn = document.querySelector("button.slide-navbar-toggler-btn");
const slidingNavCloseBtn = document.querySelector("button.slide-navbar-close-btn");

slidingNavTogglerBtn.addEventListener("click", () => {
    slidingNavbar.classList.add("show");
})

slidingNavCloseBtn.addEventListener("click", () => {
    slidingNavbar.classList.remove("show");
})



/* Sticky navbar shadow manipulation */

$(window).scroll(function (){
    const scrolledY = window.scrollY;
    if(scrolledY > 500)
    {
        $("body > .navbar").addClass('sticky-top sticky-navbar');
    }else {
        $("body > .navbar").removeClass('sticky-top sticky-navbar');
    }
});



/* Filter articles by type(Book, periodic, article or All) */

$('.filter-documents-btn').click(function (){

    const filterBy = $(this).attr('data-filter');

    // Set the active button
    $('.filter-documents-btn.active').removeClass('active');
    $(this).addClass('active');

    // Hide by default all elements
    $('.documents .document').each(function (){
        $(this).hide();
    });

    // Show elements that match
    $('.documents .document').filter(function (){
        return $(this).attr('data-document-type') == filterBy || !filterBy;
    }).show()

})

})





