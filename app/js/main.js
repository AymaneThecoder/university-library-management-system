


/*
-------------------------------------------------------------------
-This file contains all the code for making the website interactive|
like (the burger menu navbar, Filtering documents) and others.                          |
-------------------------------------------------------------------|
*/

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

const navbar = document.querySelector("body > .navbar");

window.addEventListener("scroll", () => {
    if(window.scrollY > 0)
    {
        navbar.classList.add("sticky-navbar");
    }
    else
    {
        navbar.classList.remove("sticky-navbar");
    }
})


/* Filter articles by type(Book, periodic, article or All) */

const filterBtns = document.querySelectorAll(".documents-showcase-section .filter-btns button.filter-documents-btn");
const documentsContainer = document.querySelector(".documents-showcase-section .documents");
const documentsList = document.querySelectorAll(".documents-showcase-section .documents .document");

filterBtns.forEach(btn => {
    btn.addEventListener("click", e => {
        if(e.target.classList.contains("active"))
        {
            return false;
        }

        const filter = e.target.innerText.toLowerCase();
        filterdocuments(filter);
        updateFilterBtns(filter);
    })
})

// Function for filtering the documents
// It accepts a filterText which is in this case the document type


function filterdocuments(filterText){
    
    // Removing the last 's'
    filterText = filterText != 'tous' ? filterText.substring(0, filterText.length - 1) : filterText;
    
    // Clear the documentsContainer
    documentsContainer.innerHTML = '';
    const documentsFrag = document.createDocumentFragment();

    for(let i = 0; i < documentsList.length; i++)
    {
      const documentType = documentsList[i].dataset.documentType;
      if(documentType == filterText || filterText == 'tous')
      {
        documentsFrag.appendChild(documentsList[i]);
      }
    }

    documentsContainer.appendChild(documentsFrag)
    
}

function updateFilterBtns(filterText){
  filterBtns.forEach(btn => {
    btn.innerText.toLowerCase() == filterText ? btn.classList.add("active") : btn.classList.remove("active");
  })
}
