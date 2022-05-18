let searching = document.querySelector('#search');
//declare an anonymous function
let decodeHTML = function (html) {
    //Creating an element
    let txt = document.createElement('textarea');
    txt.innerHTML = html;
    //Get value from txt
    return txt.value;
}

if(searching) {
    let div = document.querySelector('#resultProposal');
    searching.addEventListener('keyup', ()=>{
        if (searching.value !== '') {
            const xhr = new XMLHttpRequest();
            //Format of data sent
            xhr.responseType = 'json';

            //Retrieves message content
            const searchContent = {
                content : searching.value
            };
            //AJAX request initialization
            xhr.open('post', '/api/search.php');
            //Event management
            xhr.onload = function() {

                if (xhr.status === 404) {
                    alert("Une erreur s'est produite");
                    return;
                } else if (xhr.status === 400) {
                    alert('Un paramètre est manquant');
                    return;
                }
                //Returns the empty search div if the response is 400
                div.innerHTML = "";
                //Request success, data pending
                const response = xhr.response;
                response.forEach(value=> {
                    //Creating a link that leads to an article
                    let title = document.createElement('a');
                    title.href = "/index.php?c=home&a=view-article&id=" + value.id;
                    //Decode HTML special characters
                    title.innerText = decodeHTML(value.title);
                    //Embeds the search proposal in the div
                    div.appendChild(title)
                });
            }
            //send the request
            xhr.send(JSON.stringify(searchContent));
        }
    });
}