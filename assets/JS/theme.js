let theme = document.getElementById('theme');

theme.addEventListener('click',  function (){
    let element = document.body;
    element.classList.toggle("dark-mode");
});