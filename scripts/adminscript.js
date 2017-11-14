$(document).ready(function(){
	$("#adminbtn").click(function(){
		$("#admininfo").slideToggle();
	});
});

$(document).ready(function(){
	$("#devicebtn").click(function(){
		$("#mydevices").slideToggle();
	});
});

$(document).ready(function(){
	$("#usersbtn").click(function(){
		$("#viewusers").slideToggle();
	});
});

$(document).ready(function(){
	$("#devicesbtn").click(function(){
		$("#viewdevices").slideToggle();
	});
});

$(document).ready(function(){
    $("#adminbtn").click(function(){
        $("#adminbtn").toggleClass("colorShift");
    });
});

$(document).ready(function(){
    $("#devicebtn").click(function(){
        $("#devicebtn").toggleClass("colorShift");
    });
});

$(document).ready(function(){
    $("#devicesbtn").click(function(){
        $("#devicesbtn").toggleClass("colorShift");
    });
});

$(document).ready(function(){
    $("#usersbtn").click(function(){
        $("#usersbtn").toggleClass("colorShift");
    });
});

$(document).ready(function(){
	$(".tktbtn").click(function(){
		$("#tickets").slideToggle();
	});
});

$(document).ready(function(){
	$(".ticketbtn").submit(function(){
		$("#tickets").slideUp();
	});
});

$(document).ready(function(){
	$("#filterAssetsButton").click(function(){
		$("#searchAssets").slideToggle();
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

var masterItem = false;
var masterUser = false;
$(document).ready(function() {
    $("#itemMasterButton").click(function() {
        if (masterItem === false)
        {
            $("#itemMasterButton").css("background-color", "#8CC542");
            $.getJSON("model/ajaxDB.php?field=masterItems", function(result) {
                $("#masterListItems").append('<table id="masterItemTable"><tr style="background-color:#8CC542;color:white;"><th>Brand</th><th>Model</th><th>Serial Number</th><th>Entered Into Service Date</th><th>Inventory ID</th><th>Assigned</th></tr>');
                for (var i = 0; i < result.length; i++)
                {
                    $("#masterItemTable").append('<tr><td>'+result[i].make+'</td><td>'+result[i].model+'</td><td>'+result[i].serial_num+'</td><td>'+result[i].entered_into_service+'</td><td>'+result[i].item_num+'</td><td>'+result[i].assigned+'</td></tr>');
                }
                $("#masterListItems").append('</table>');
            });
            masterItem = true;
        }
        else if (masterItem === true)
        {
            $("#itemMasterButton").css("background-color", "black");
            $("#masterListItems").find('table').remove();
            masterItem = false;
        }
    });
    $("#userMasterButton").click(function() {
        if (masterUser === false)
        {
            $("#userMasterButton").css("background-color", "#8CC542");
            $.getJSON("model/ajaxDB.php?field=masterUsers", function(result) {
                console.log(result);
                 $("#masterListUsers").append('<table id="masterUserTable"><tr style="background-color:#8CC542;color:white;"><th>Employee ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Permissions</th></tr>');
                for (var i = 0; i < result.length; i++)
                {
                    $("#masterUserTable").append('<tr><td>'+result[i].emp_id+'</td><td>'+result[i].l_name+', '+result[i].f_name+'</td><td>'+result[i].email+'</td><td>'+result[i].phone_num+'</td><td>'+result[i].status+'</td></tr>');
                }
                $("#masterListUsers").append('</table>');
            });
            masterUser = true;
        }
        else if (masterUser === true)
        {
            $("#userMasterButton").css("background-color", "black");
            $("#masterListUsers").find('table').remove();
            masterUser = false;
        }
    });
});
