$(document).ready(function(){
	$("#userbtn").click(function(){
		$("#userinfo").slideToggle();
	});
});

$(document).ready(function(){
	$("#devicebtn").click(function(){
		$("#mydevices").slideToggle();
	});
});

$(document).ready(function(){
    $("#userbtn").click(function(){
        $("#userbtn").toggleClass("colorshift");
    });
});

$(document).ready(function(){
    $("#devicebtn").click(function(){
        $("#devicebtn").toggleClass("colorshift");
    });
});

$(document).ready(function(){
	$("td button").click(function(){
		$("#tickets").slideToggle();
	});
});

$(document).ready(function(){
	$(".ticketbtn").submit(function(){
		$("#tickets").slideUp();
	});
});

$(document).ready(function() {
    $('tr.baseColor').each(function() {
        var remaining = $(this).find('td').eq(5).text();
        var days = remaining.split(" ");
        if (days[0] < 32)
        {
            if (days[0] <= 0)
            {
                $(this).toggleClass("dangerColor");
            }
            else
                $(this).toggleClass("warningColor");
        }
        
    });
});
