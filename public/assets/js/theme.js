let switchMode = localStorage.getItem("switchMode");
const SwitchModeToggle = $('.darkMode');

// Dark mode function
const enableDarkMode = function () {
    // Add the class to the body
    $('body').addClass('dark');
    // Update switchMode in localStorage
    localStorage.setItem('switchMode', 'enable');
}

// Light mode function
const disableDarkMode = function () {
    // Remove the class from the body
    $( 'body' ).removeClass('dark');
    // Update switchMode in localStorage value
    localStorage.setItem('switchMode', null);
}

// If the user already visited and enabled switchMode
if (switchMode === 'enable') {
    enableDarkMode();
    console.log(switchMode)
}
else {
    disableDarkMode();
}

SwitchModeToggle.on('click', function() {
    // get their switchMode setting
    switchMode = localStorage.getItem('switchMode');
    // if it not current enabled, enable it
    if (switchMode !== 'enable') {
        enableDarkMode();
        // if it has been enabled, turn it off
    } else {
        disableDarkMode();
    }
});
