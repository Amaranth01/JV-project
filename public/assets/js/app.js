//Dismiss messages
setTimeout(() => {
    document.querySelectorAll('.message').forEach(error => error.remove());
}, 6000);

//show responsive menu
let menu = document.querySelector('.burger');
let element = document.querySelector('.displayLink');
let a = 0;

menu.addEventListener('click', function () {
    if(a === 0) {
        element.style.display = 'block';
        a++
    } else if(a === 1  ){
        element.style.display = 'none';
        a--
    }
});