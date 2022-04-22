//Change theme on click
$(".darkMode").click(function(){
    if ($("body").hasClass("dark")){
        $("body").removeClass("dark");
    }
    else{
        $("body").addClass("dark");
    }
});