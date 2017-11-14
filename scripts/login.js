$(document).ready(function(){
    $("#forgotten").hide();
});    
    
$(document).ready(function(){
	$("#forgot").click(function(){
            $("#loginForm").hide();
            $("#forgotten").show();
	});
});

$(document).ready(function(){
	$("#remember").click(function(){
            $("#forgotten").hide();
            $("#loginForm").show();
	});
});

$(document).ready(function(){
    $("#rememberMe").on("click", function() {
        $("#rememberMe").css({ fill: "#ff0000" });
    });
});