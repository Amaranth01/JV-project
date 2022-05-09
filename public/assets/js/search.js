let searching = document.querySelector('#search');
let decodeHTML = function (html) {
    let txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
}

if(searching) {
    let div = document.querySelector('#resultProposal');
    searching.addEventListener('keyup', ()=>{
        if (searching.value !== '') {
            const xhr = new XMLHttpRequest();
            xhr.responseType = 'json';

            //Retrieves message content
            const searchContent = {
                content : searching.value
            };

            xhr.open('post', '/api/search.php');

            xhr.onload = function() {

                if (xhr.status === 404) {
                    alert("Une erreur s'est produite");
                    return;
                } else if (xhr.status === 400) {
                    alert('Un paramètre est manquant');
                    return;
                }

                div.innerHTML = "";

                const response = xhr.response;
                response.forEach(value=> {
                    let title = document.createElement('a');
                    title.href = "/index.php?c=home&a=view-article&id=" + value.id;

                    title.innerText = decodeHTML(value.title);
                    div.appendChild(title)
                });
            }

            xhr.send(JSON.stringify(searchContent));
        }
    });
}