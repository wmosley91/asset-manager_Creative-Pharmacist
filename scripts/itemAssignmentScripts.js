$(document).ready(function() {
   $('#filterType').bind('change', populateMake);
   $('#filterMake').bind('change', populateModel);
   $('#filterModel').bind('change', populateSerials);
   $('#filterLast').bind('change', populateFirst);
   $('#filterFirst').bind('change', populateEmail);
   $('#filterEmail').bind('change', populateUserSerials);
   $('#removeButton').bind('click', removeSerial);
   $('#addButton').bind('click', addSerial);
   $('#resetFieldsButton').bind('click', reset);
   $('#commitButton').bind('click', commit);
   hideButtons();
});

function populateMake() {
    hideButtons();
    showButtons();
    $('#removedSerials').find('option').remove();
    $('#addedSerials').find('option').remove();
    $('#filterMake').find('option').remove();
    $('#filterModel').find('option').remove();
    $('#getSerials').find('option').remove();
    $("#filterType option[value='default']").remove();
    $('#filterMake').append($('<option>', {
        value: "default",
        text: "Select one"
    }));
    var type = $("#filterType").val();
    $.getJSON("model/ajaxDB.php?field=addTypeIA&type=" + type, function(result) {
        for (var i = 0; i < result.length; i++)
        {
            $('#filterMake').append($('<option>', {
                value: result[i].make,
                text: result[i].make
            }));
        }
    });
}

function populateModel() {
    hideButtons();
    showButtons();
    $('#removedSerials').find('option').remove();
    $('#addedSerials').find('option').remove();
    $('#filterModel').find('option').remove();
    $('#getSerials').find('option').remove();
    $("#filterMake option[value='default']").remove();
    $('#filterModel').append($('<option>', {
        value: "default",
        text: "Select one"
    }));
    var make = $("#filterMake").val();
    $.getJSON("model/ajaxDB.php?field=addMakeIA&make=" + make, function(result) {
        for (var i = 0; i < result.length; i++)
        {
            $('#filterModel').append($('<option>', {
                value: result[i].model,
                text: result[i].model
            }));
        }
    });
}

function populateSerials() {
    hideButtons();
    showButtons();
    $('#removedSerials').find('option').remove();
    $('#addedSerials').find('option').remove();
    $('#getSerials').find('option').remove();
    $("#filterModel option[value='default']").remove();
    var model = $("#filterModel").val();
    $.getJSON("model/ajaxDB.php?field=addSerialU&model=" + model, function(result) {
        for (var i = 0; i < result.length; i++)
        {
            $('#getSerials').append($('<option>', {
                value: result[i].serial_num,
                text: result[i].serial_num
            }));
        }
    });
}

 function populateFirst() {
    hideButtons();
    showButtons();
    $('#removedSerials').find('option').remove();
    $('#addedSerials').find('option').remove();
    $('#filterLast option[value="default"').remove();
    $('#filterFirst').find('option').remove();
    $('#filterEmail').find('option').remove();
    $('#userSerials').find('option').remove();
    var last = $('#filterLast').val();
     $.getJSON("model/ajaxDB.php?field=addFirstNameU&lName=" + last, function(result) {
         $('#filterFirst').append($('<option>', {
            value: "default",
            text: "Select one"
        }));
        for (var i = 0; i < result.length; i++)
        {
            $('#filterFirst').append($('<option>', {
                value: result[i].f_name,
                text: result[i].f_name
            }));
        }
     });
 }
 
  function populateEmail() {
    hideButtons();
    showButtons();
    $('#removedSerials').find('option').remove();
    $('#addedSerials').find('option').remove();
    $('#filterFirst option[value="default"').remove();
    $('#filterEmail').find('option').remove();
    $('#userSerials').find('option').remove();
    var last = $('#filterLast').val();
    var first = $('#filterFirst').val();
     $.getJSON("model/ajaxDB.php?field=addEmailU&lName=" + last + "&fName=" + first, function(result) {
         $('#filterEmail').append($('<option>', {
            value: "default",
            text: "Select one"
        }));
        for (var i = 0; i < result.length; i++)
        {
            $('#filterEmail').append($('<option>', {
                value: result[i].email,
                text: result[i].email
            }));
        }
     });
 }
 
function populateUserSerials() {
    hideButtons();
    showButtons();
    $('#userSerials').find('option').remove();
    $('#removedSerials').find('option').remove();
    $('#addedSerials').find('option').remove();
    $("#filterEmail option[value='default']").remove();
    var email = $("#filterEmail").val();
    $.getJSON("model/ajaxDB.php?field=addUserItems&email=" + email, function(result) {
        for (var i = 0; i < result.length; i++)
        {
            $('#userSerials').append($('<option>', {
                value: result[i].serial_num,
                text: result[i].serial_num + ' - ' + result[i].make + ' ' + result[i].model
            }));
        }
    });
}

function removeSerial() {
    var serial = $('#userSerials').val();
    if (serial !== null)
    {
        $('#userSerials').find('option[value='+serial+']').remove();
        $('#removedSerials').append($('<option>', {
            value: serial,
            text: serial
        }));
    }
}

function addSerial() {
    var serial = $('#getSerials').val();
    if (serial !== null)
    {
        $('#getSerials').find('option[value='+serial+']').remove();
        $('#addedSerials').append($('<option>', {
            value: serial,
            text: serial
        }));
    }
}

function commit() {
    var empID;
    var xnums = [];
    var ynums = [];
    
    var email = $('#filterEmail').val();
    
    $.ajax({
        url: "model/ajaxDB.php?field=getEmpId&email=" + email,
        async: false,
        dataType: 'json',
        success: function(result) {
            empID = result[0].emp_id;
        }
    });
            
    var x = document.getElementById('addedSerials').options;
    if (x.length !== 0)
    {
        for (var i = 0; i < x.length; i++)
        {
            $.ajax({
                url: "model/ajaxDB.php?field=addItemNum&serial=" + x[i].value,
                async: false,
                dataType: 'json',
                success: function(result) {
                    xnums.push(result[0].item_num);
                }
            });
        }
    }
    
    var y = document.getElementById('removedSerials').options;
    if (y.length !== 0)
    {
        for (var i = 0; i < y.length; i++)
        {
            $.ajax({
                url: "model/ajaxDB.php?field=addItemNum&serial=" + y[i].value,
                async: false,
                dataType: 'json',
                success: function(result) {
                    ynums.push(result[0].item_num);
                }
            });
        }
    }
    
    for (var i = 0; i < xnums.length; i++)
    {
        $.ajax({
                url: "model/ajaxDB.php?field=assignItem&empID=" + empID + "&item_num=" + xnums[i],
                async: false,
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                }
            });
    }
    
    for (var i = 0; i < ynums.length; i++)
    {
        $.ajax({
                url: "model/ajaxDB.php?field=removeItem&item_num=" + ynums[i],
                async: false,
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                }
            });
    }
    populateUserSerials();
    populateSerials();
}

function reset() {
    location.reload();
}

function hideButtons() {
    $('#addButton').hide();
    $('#removeButton').hide();
    $('#commitButton').hide();
}

function showButtons() {
    var x = $('#filterEmail').val();
    var y = $('#filterModel').val();
    if (x !== null)
    {
        $('#removeButton').show();
        $('#commitButton').show();
        
        if (y !== null)
        {
            $('#addButton').show();
        }
    }
}