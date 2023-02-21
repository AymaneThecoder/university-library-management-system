/* Borrowing a document */

const borrowBtn = document.getElementById("borrowBtn");

borrowBtn.addEventListener("click", () => {

    // Get the details for creating the borrow (userID, documentID)
    const dataToSend = getBorrowDataToSend();
    ajaxRequest('../borrow.php', "POST", dataToSend, displayBorrowResponse);

})


function getBorrowDataToSend(){
    const hiddenInputs = document.querySelectorAll("input[type='hidden']");
    const dataToSend = {};
    hiddenInputs.forEach(inpt => {
        const inputName = inpt.getAttribute("name");
        const inputValue = inpt.getAttribute("value");
        dataToSend[inputName] = inputValue;
    })
    return dataToSend;
}

// Send an AJAX request to the 'borrow.php' to create a new borrow

function ajaxRequest(to, method, data = null, $callback){
    const jsonData = JSON.stringify(data);
    const xmlh = new XMLHttpRequest();
    xmlh.open(method, to, true);
    xmlh.onload = () => {
        if(xmlh.status == 200)
        {
            const response = JSON.parse(xmlh.response);
            $callback(response);
        }
        else
        {
            console.warn("Request didn't send");
        }
    }
    xmlh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlh.send(`data=${jsonData}`);
}

// Display the response from the server 
function displayBorrowResponse(response){
    const borrowMessageEle = document.querySelector("#borrowModal .modal-body .borrow-message");
    const elementsToAppend = [];
    const messageParag = document.createElement("p");
    borrowMessageEle.innerHTML = '';
    if(response.borrowCode)
    {
        messageParag.innerText = 'Emprunte effectue avec success votre CODE d\'emprunte est: ';
        messageParag.classList.add("mb-3")
        const borrowCodeSpan = document.createElement("span");
        borrowCodeSpan.classList.add("text-primary");
        borrowCodeSpan.innerText = response.borrowCode;
        messageParag.append(borrowCodeSpan);
        const borrowTipMessage = document.createElement("p");
        borrowTipMessage.classList.add("text-start", "borrow-tip");
        borrowTipMessage.innerText = 'NOTE: Vous devez sauvgarder votre code d\'emprunte';
        elementsToAppend.push(messageParag, borrowTipMessage);
    } else {
        messageParag.innerText = response.borrowError;
        messageParag.classList.add("text-danger");
        elementsToAppend.push(messageParag);
    }
    elementsToAppend.forEach(ele => {
        borrowMessageEle.append(ele);
    })
}
