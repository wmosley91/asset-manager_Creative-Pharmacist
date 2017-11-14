$(document).ready(function() {
    $('#rightHalf').hide();
    $('.viewButton').bind('click', getItemInfo);
});


function getItemInfo() {
    $('.viewButton').css("background-color", "black");
    $(this).css('background-color', '#8CC542');
    var item_num = $(this).val();
    
    $.getJSON('model/ajaxDB.php?field=getItemInfo&item=' + item_num, function(result) {
        $('#item').text(result[0].item_num);
        $('#serial').text(result[0].serial_num);
        $('#cost').text('$'+result[0].cost);
        $('#vendor').text(result[0].vendor);
        var ptime = result[0].entered_into_service.split(/[- :]/);
            ptime.splice(3);
            $('#date').text(ptime.join("-"));
        $.getJSON('model/ajaxDB.php?field=getLocationDescription&num=' + result[0].location_num, function(result) {
            $('#location').text(result.description);
        });
        $('#photo').find('img').remove();
        $.getJSON('model/ajaxDB.php?field=getImage&type=' + result[0].type + '&make=' + result[0].make + '&model=' + result[0].model, function(result) {
            
            if (result.image === null)
                {
                    console.log("fied");
                    $('#photo').append('<img src="images/null.png" class="resized">');
                }
            
            else
            {
                $('#photo').append('<img src="images/'+result.image+'.png" class="resized">');
            }
        });
    });
    $('#rightHalf').show();
}

