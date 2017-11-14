// ajax requests to populate insert drop downs /////////////////////////////////
$(document).ready(function() {
    $('#addType').bind('change', populateMake);
    $('#addMake').bind('change', populateModel);
    $('#addModel').bind('change', function() {
       $("#addModel option[value='default']").remove();
   });
   $('#addModel').bind('change', populateLife);
   hideButtons();
});

function populateType() {
    $('#selectType').find('option').remove();
    $('#selectModel').find('option').remove();
    $('#selectMake').find('option').remove();
    $('#selectLife').val("");
    $('#selectDate').val("");
    $('#selectCost').val("");
    $('#selectVendor').val("");
    $('#phpSerial').val("");
    $('#selectSerial').find('option').remove();
    $.getJSON("model/ajaxDB.php?field=default", function(result) {
        $('#selectType').append($('<option>', {
            value: "default",
            text: "Select an item to begin"
        }));
        for (var i = 0; i < result.length; i++)
        {
            $('#selectType').append($('<option>', {
                value: result[i].type,
                text: result[i].type
            }));
        }
    });
}

function populateMake() {
    $('#addMake').find('option').remove();
    $('#addModel').find('option').remove();
    $('#addLife').val("");
    $("#addType option[value='default']").remove();
    $('#addMake').append($('<option>', {
        value: "default",
        text: "Select one"
    }));
    var type = $("#addType").val();
    $.getJSON("model/ajaxDB.php?field=addType&type=" + type, function(result) {
        for (var i = 0; i < result.length; i++)
        {
            $('#addMake').append($('<option>', {
                value: result[i].make,
                text: result[i].make
            }));
        }
    });
}

function populateModel() {
    $('#addModel').find('option').remove();
    $("#addMake option[value='default']").remove();
    $('#addLife').val("");
    $('#addModel').append($('<option>', {
        value: "default",
        text: "Select one"
    }));
    var make = $("#addMake").val();
    var type = $("#addType").val();
    $.getJSON("model/ajaxDB.php?field=addMake&make=" + make + "&type=" + type, function(result) {
        for (var i = 0; i < result.length; i++)
        {
            $('#addModel').append($('<option>', {
                value: result[i].model,
                text: result[i].model
            }));
        }
    });
}

function populateLife() {
    function genSerial()
    {
        var random = Math.floor((Math.random()*2541715)+1);
        $('#addSerial').val('autogen' + random);
        var serial = $('#addSerial').val();
        $.getJSON("model/ajaxDB.php?field=checkSerials&serial=" + serial, function(result) {
            if (result)
            {
                genSerial();
            }
        });
    }
    var model = $('#addModel').val();
    if (model !== null)
    {
        $.getJSON("model/ajaxDB.php?field=addLife&model=" + model, function(result) {
            $('#addLife').val(result[0].life_cycle);
        });
    }
    genSerial();
    
    $('#addSerial').focus().select();
}

// ajax requests to populate update/delete drop downs /////////////////////////
$(document).ready(function() {
    $('#selectType').bind('change', selectMake);
    $('#selectType').bind('change', hideButtons);
    $('#selectMake').bind('change', selectModel);
    $('#selectMake').bind('change', hideButtons);
    $('#selectModel').bind('change', selectLife);
    $('#selectModel').bind('change', hideButtons);
    $('#selectModel').bind('change', selectSerial);
    $('#selectSerial').bind('change', function() {
        $('#selectSerial option[value="default"').remove();
    });
    $('#selectSerial').bind('change', selectDateCostVendor);
    $('#selectSerial').bind('change', showButtons);
    $('#selectSerial').bind('change', selectItemNum);
    $('input[type="radio"][name="itemSelector"]').bind('change', updateDelete);
});

function selectMake() {
    $('#selectMake').find('option').remove();
    $('#selectModel').find('option').remove();
    $('#selectLife').val("");
    $('#selectDate').val("");
    $('#selectCost').val("");
    $('#selectVendor').val("");
    $('#phpSerial').val("");
    $('#selectSerial').find('option').remove();
    $("#selectType option[value='default']").remove();
    $('#selectMake').append($('<option>', {
        value: "default",
        text: "Select one"
    }));
    var type = $("#selectType").val();
    $.getJSON("model/ajaxDB.php?field=addType&type=" + type, function(result) {
        for (var i = 0; i < result.length; i++)
        {
            $('#selectMake').append($('<option>', {
                value: result[i].make,
                text: result[i].make
            }));
        }
    });
}

function selectModel() {
    $('#selectModel').find('option').remove();
    $("#selectMake option[value='default']").remove();
    $('#selectLife').val("");
    $('#selectDate').val("");
    $('#selectCost').val("");
    $('#selectVendor').val("");
    $('#phpSerial').val("");
    $('#selectSerial').find('option').remove();
    $('#selectModel').append($('<option>', {
        value: "default",
        text: "Select one"
    }));
    var make = $("#selectMake").val();
    var type = $("#selectType").val();
    $.getJSON("model/ajaxDB.php?field=addMake&make=" + make + "&type=" + type, function(result) {
        for (var i = 0; i < result.length; i++)
        {
            $('#selectModel').append($('<option>', {
                value: result[i].model,
                text: result[i].model
            }));
        }
    });
}

function selectLife() {
    var model = $('#selectModel').val();
    if (model !== null)
    {
        $.getJSON("model/ajaxDB.php?field=addLife&model=" + model, function(result) {
            $('#selectLife').val(result[0].life_cycle);
        });
    }
}

function selectSerial() {
    $('#selectSerial').find('option').remove();
    $("#selectMake option[value='default']").remove();
    $('#selectDate').val("");
    $('#selectCost').val("");
    $('#selectVendor').val("");
    $('#phpSerial').val("");
    $('#selectSerial').append($('<option>', {
        value: "default",
        text: "Select one"
    }));
    var model = $("#selectModel").val();
    $.getJSON("model/ajaxDB.php?field=addSerial&model=" + model, function(result) {
        for (var i = 0; i < result.length; i++)
        {
            $('#selectSerial').append($('<option>', {
                value: result[i].serial_num,
                text: result[i].serial_num
            }));
        }
    });
}

function selectDateCostVendor() {
    
    var serial = $('#selectSerial').val();
    if (serial !== null)
    {
        $.getJSON("model/ajaxDB.php?field=addDateCostVendor&serial=" + serial, function(result) {
            $('#selectCost').val(result[0].cost);
            $('#selectVendor').val(result[0].vendor);
            var ptime = result[0].entered_into_service.split(/[- :]/);
            ptime.splice(3);
            $('#selectDate').val(ptime.join("-"));
            $('#selectItemLocation').append($('<option>', {
                value: result[0].location_num,
                text: result[0].location_num + " - " + result[0].address
            }));
        });
    }
}

function selectItemNum() {
    var serial = $('#selectSerial').val();
    if (serial !== null)
    {
        $.getJSON("model/ajaxDB.php?field=addItemNum&serial=" + serial, function(result) {
            $('#itemNum').val(result[0].item_num);
        });
    }
}

function showButtons() {
    $('#deleteItemButton').show();
    $('#updateDeleteRadio').show();
}

function hideButtons() {
    $('#deleteItemButton').hide();
    $('#updateDeleteRadio').hide();
}

function updateDelete() {
    var action = $('#getItemAction').val();
    if (action === "deleteItem")
    {
        $('#getItemAction').val("updateItem");
    }
    if (action === "updateItem")
    {
        $('#getItemAction').val("deleteItem");
    }
    
    var temp = $('#selectType');
    $('#selectTypeInactive').val($('#selectType').val());
    $('#selectTypeInactive').attr('name', 'selectType');
    $('#selectTypeInactive').prop('required', true);
    $('#selectTypeInactive').attr('id', 'selectType');
    temp.attr('name', 'selectTypeInactive');
    temp.prop('required', false);
    temp.attr('id', 'selectTypeInactive');
    $('#selectTypeInactive').hide();
    $('#selectType').show();
    
    temp = $('#selectMake');
    $('#selectMakeInactive').val($('#selectMake').val());
    $('#selectMakeInactive').attr('name', 'selectMake');
    $('#selectMakeInactive').prop('required', true);
    $('#selectMakeInactive').attr('id', 'selectMake');
    temp.attr('name', 'selectMakeInactive');
    temp.prop('required', false);
    temp.attr('id', 'selectMakeInactive');
    $('#selectMakeInactive').hide();
    $('#selectMake').show();
    
    temp = $('#selectModel');
    $('#selectModelInactive').val($('#selectModel').val());
    $('#selectModelInactive').attr('name', 'selectModel');
    $('#selectModelInactive').prop('required', true);
    $('#selectModelInactive').attr('id', 'selectModel');
    temp.attr('name', 'selectModelInactive');
    temp.prop('required', false);
    temp.attr('id', 'selectModelInactive');
    $('#selectModelInactive').hide();
    $('#selectModel').show();
    
    temp = $('#selectSerial');
    $('#selectSerialInactive').val($('#selectSerial').val());
    $('#selectSerialInactive').attr('name', 'selectSerial');
    $('#selectSerialInactive').prop('required', true);
    $('#selectSerialInactive').attr('id', 'selectSerial');
    temp.attr('name', 'selectSerialInactive');
    temp.prop('required', false);
    temp.attr('id', 'selectSerialInactive');
    $('#selectSerialInactive').hide();
    $('#selectSerial').show();
    
    var readOnly = $('#selectDate').prop('readonly');
    $('#selectDate').prop('readonly', !readOnly);
    $('#selectLife').prop('readonly', !readOnly);
    $('#selectCost').prop('readonly', !readOnly);
    $('#selectVendor').prop('readonly', !readOnly);
    $('#selectItemLocation').prop('readonly', !readOnly);
    
    var buttonText = $('#deleteItemButton').text();
    if (buttonText === "Delete Item")
    {
        $('#deleteItemButton').text("Update Item");
    }
    if (buttonText === "Update Item")
    {
        $('#deleteItemButton').text("Delete Item");
    }
    
    $('#selectItemLocation').find('option').remove();
    $.getJSON('model/ajaxDB.php?field=addLocation', function(result) {
         for (var i = 0; i < result.length; i++)
        {
            $('#selectItemLocation').append($('<option>', {
                value: result[i].location_num,
                text: result[i].location_num + " - " + result[i].address
            }));
        }
     });
}

// populate date //////////////////////////////////////////////////////////////
var now = new Date();
var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);
var today = now.getFullYear()+"-"+(month)+"-"+(day);
$(document).ready(function() {
    $('#addDate').val(today);
});

// animation controls
$(document).ready(function(){
    $("#addUser").hide();
    $("#updateDeleteItem").hide();
    $("#updateDeleteUser").hide();
    $("#addUserButton").click(function(){
            $("#addItem").hide();
            $("#updateDeleteItem").hide();
            $("#updateDeleteUser").hide();
            $("#addUser").show();
            $('#addEmail').val("");
            $('#addPassword').val("");
	});
    $("#addItemButton").click(function(){
            $("#addUser").hide();
            $("#updateDeleteItem").hide();
            $("#updateDeleteUser").hide();
            $("#addItem").show();
	});
    $("#updateDeleteItemButton").click(function() {
            $("#addItem").hide();
            $("#addUser").hide();
            $("#updateDeleteUser").hide();
            $("#updateDeleteItem").show();
    });
    $('#updateDeleteUserButton').click(function() {
            $("#addItem").hide();
            $("#addUser").hide();
            $("#updateDeleteItem").hide();
            $("#updateDeleteUser").show();
    });
    setTimeout(function() {
        $('#phpMessage').remove();
    }, 4000);
});

// auto manual switch /////////////////////////////////////////////////////////
$(document).ready(function() {
    $("#myonoffswitch").bind('change', autoManual);
    $('#resetButton').bind('click', softReset);
});

function autoManual() {
    var temp = $('#addType');
    $('#addTypeInactive').attr('name', 'addType');
    $('#addTypeInactive').prop('required', true);
    $('#addTypeInactive').attr('id', 'addType');
    temp.attr('name', 'addTypeInactive');
    temp.prop('required', false);
    temp.attr('id', 'addTypeInactive');
    $('#addTypeInactive').hide();
    $('#addType').show();
    
    temp = $('#addMake');
    $('#addMakeInactive').attr('name', 'addMake');
    $('#addMakeInactive').prop('required', true);
    $('#addMakeInactive').attr('id', 'addMake');
    temp.attr('name', 'addMakeInactive');
    temp.prop('required', false);
    temp.attr('id', 'addMakeInactive');
    $('#addMakeInactive').hide();
    $('#addMake').show();
    
    temp = $('#addModel');
    $('#addModelInactive').attr('name', 'addModel');
    $('#addModelInactive').prop('required', true);
    $('#addModelInactive').attr('id', 'addModel');
    temp.attr('name', 'addModelInactive');
    temp.prop('required', false);
    temp.attr('id', 'addModelInactive');
    $('#addModelInactive').hide();
    $('#addModel').show();
    
    var readOnly = $('#addLife').prop('readonly');
    $('#addLife').prop('readonly', !readOnly);
    $('#addLife').val("");
    
    if ($('#addModel').val() !== (""))
    {
        populateLife();
    }
 }
 
 function softReset() {
     
     var radioVal = $('input[name=itemSelector]:checked').val();
     if (radioVal === "update")
     {
         $('#deleteRadio').prop('checked', true);
         updateDelete();
     }
     hideButtons();
     populateType();
 }
 
 // update/delete user ajax requests ///////////////////////////////////////////
 
 $(document).ready(function() {
     selectLName();
     hideUserButtons();
     $('#selectLName').bind('change', selectFName);
     $('#selectFName').bind('change', selectEmail);
     $('#selectEmail').bind('change', selectUserInfo);
     $('#selectLName').bind('change', hideUserButtons);
     $('#selectFName').bind('change', hideUserButtons);
     $('#selectEmail').bind('change', showUserButtons);
 });
 
 function selectLName() {
    $('#selectLName').find('option').remove();
    $('#selectFName').find('option').remove();
    $('#selectEmail').find('option').remove();
    $('#selectAddress').val("");
    $('#selectPhone').val("");
    $('#selectAdmin').val("");
    $('#selectLocation').val("");
    
    $.getJSON("model/ajaxDB.php?field=addLastName", function(result) {
        $('#selectLName').append($('<option>', {
            value: "default",
            text: "Select an item to begin"
        }));
        for (var i = 0; i < result.length; i++)
        {
            $('#selectLName').append($('<option>', {
                value: result[i].l_name,
                text: result[i].l_name
            }));
        }
    });
 }
 
 function selectFName() {
    $('#selectLName option[value="default"').remove();
    $('#selectFName').find('option').remove();
    $('#selectEmail').find('option').remove();
    $('#selectAddress').val("");
    $('#selectPhone').val("");
    $('#selectAdmin').val("");
    $('#selectLocation').val("");
    
    var lName = $('#selectLName').val();
     $.getJSON("model/ajaxDB.php?field=addFirstName&lName=" + lName, function(result) {
         $('#selectFName').append($('<option>', {
            value: "default",
            text: "Select an item to begin"
        }));
        for (var i = 0; i < result.length; i++)
        {
            $('#selectFName').append($('<option>', {
                value: result[i].f_name,
                text: result[i].f_name
            }));
        }
     });
 }
 
 function selectEmail() {
    $('#selectFName option[value="default"').remove();
    $('#selectEmail').find('option').remove();
    $('#selectAddress').val("");
    $('#selectPhone').val("");
    $('#selectAdmin').val("");
    $('#selectLocation').val("");
    
    var lName = $('#selectLName').val();
    var fName = $('#selectFName').val();
     $.getJSON("model/ajaxDB.php?field=addEmail&lName=" + lName + "&fName=" + fName, function(result) {
         $('#selectEmail').append($('<option>', {
            value: "default",
            text: "Select an item to begin"
        }));
        for (var i = 0; i < result.length; i++)
        {
            $('#selectEmail').append($('<option>', {
                value: result[i].email,
                text: result[i].email
            }));
        }
     });
 }
 
 function selectUserInfo() {
    $('#selectAddress').val("");
    $('#selectPhone').val("");
    $('#selectAdmin').val("");
    $('#selectLocation').val("");
    
    var email = $('#selectEmail').val();
     $.getJSON("model/ajaxDB.php?field=addUserInfo&email=" + email, function(result) {
        $('#phpEmpId').val(result[0].emp_id);
        $('#selectAddress').val(result[0].address);
        $('#selectPhone').val(result[0].phone_num);
        $('#selectAdmin').val(result[0].admin_emp_id);
        $('#selectLocation').val(result[0].location_num);
        $('#selectLocation').text(result[0].location_num + " - " + result[0].address);
     });
 }
 
 // update/delete user animations //////////////////////////////////////////////
 $(document).ready(function() {
     $('#updateDeleteUserRadio').bind('change', updateDeleteUser);
     $('#resetUserButton').bind('click', softUserReset);
 }) ;

function updateDeleteUser() {
    var action = $('#getUserAction').val();
    if (action === "deleteUser")
    {
        $('#getUserAction').val("updateUser");
    }
    if (action === "updateUser")
    {
        $('#getUserAction').val("deleteUser");
    }
    
    var temp = $('#selectLName');
    $('#selectLNameInactive').val($('#selectLName').val());
    $('#selectLNameInactive').attr('name', 'selectLName');
    $('#selectLNameInactive').prop('required', true);
    $('#selectLNameInactive').attr('id', 'selectLName');
    temp.attr('name', 'selectLNameInactive');
    temp.prop('required', false);
    temp.attr('id', 'selectLNameInactive');
    $('#selectLNameInactive').hide();
    $('#selectLName').show();
    
    temp = $('#selectFName');
    $('#selectFNameInactive').val($('#selectFName').val());
    $('#selectFNameInactive').attr('name', 'selectFName');
    $('#selectFNameInactive').prop('required', true);
    $('#selectFNameInactive').attr('id', 'selectFName');
    temp.attr('name', 'selectFNameInactive');
    temp.prop('required', false);
    temp.attr('id', 'selectFNameInactive');
    $('#selectFNameInactive').hide();
    $('#selectFName').show();
    
    temp = $('#selectEmail');
    $('#selectEmailInactive').val($('#selectEmail').val());
    $('#selectEmailInactive').attr('name', 'selectEmail');
    $('#selectEmailInactive').prop('required', true);
    $('#selectEmailInactive').attr('id', 'selectEmail');
    temp.attr('name', 'selectEmailInactive');
    temp.prop('required', false);
    temp.attr('id', 'selectEmailInactive');
    $('#selectEmailInactive').hide();
    $('#selectEmail').show();
    
    setLocationAdmin();
    
    var readOnly = $('#selectAddress').prop('readonly');
    $('#selectAddress').prop('readonly', !readOnly);
    $('#selectPhone').prop('readonly', !readOnly);
    
    var buttonText = $('#updateDeleteUserFormButton').text();
    if (buttonText === "Delete User")
    {
        $('#updateDeleteUserFormButton').text("Update User");
    }
    if (buttonText === "Update User")
    {
        $('#updateDeleteUserFormButton').text("Delete User");
    }
 }
 
 function setLocationAdmin() {
     $('#selectAdmin').find('option').remove();
     $('#selectAdminInactive').find('option').remove();
     $('#selectLocation').find('option').remove();
     $('#selectLocationInactive').find('option').remove();
     
     var temp = $('#selectAdmin');
     $('#selectAdminInactive').attr('name', 'selectAdmin');
     $('#selectAdminInactive').prop('required', true);
     $('#selectAdminInactive').attr('id', 'selectAdmin');
     temp.attr('name', 'selectAdminInactive');
     temp.prop('required', false);
     temp.attr('id', 'selectAdminInactive');
     $('#selectAdminInactive').hide();
     $('#selectAdmin').show();
     
     var temp = $('#selectLocation');
     $('#selectLocationInactive').attr('name', 'selectLocation');
     $('#selectLocationInactive').prop('required', true);
     $('#selectLocationInactive').attr('id', 'selectLocation');
     temp.attr('name', 'selectLocationInactive');
     temp.prop('required', false);
     temp.attr('id', 'selectLocationInactive');
     $('#selectLocationInactive').hide();
     $('#selectLocation').show();
     
     
     $.getJSON('model/ajaxDB.php?field=addAdmin', function(result) {
         for (var i = 0; i < result.length; i++)
        {
            $('#selectAdmin').append($('<option>', {
                value: result[i].emp_id,
                text: result[i].emp_id
            }));
        }
     });
     $.getJSON('model/ajaxDB.php?field=addLocation', function(result) {
         for (var i = 0; i < result.length; i++)
        {
            $('#selectLocation').append($('<option>', {
                value: result[i].location_num,
                text: result[i].location_num + " - " + result[i].address
            }));
        }
     });
 }
 
 function showUserButtons() {
    $('#updateDeleteUserFormButton').show();
    $('#updateDeleteUserRadio').show();
}

function hideUserButtons() {
    $('#updateDeleteUserFormButton').hide();
    $('#updateDeleteUserRadio').hide();
}

 function softUserReset() {
     
     var radioVal = $('input[name=userSelector]:checked').val();
     if (radioVal === "update")
     {
         $('#deleteUserRadio').prop('checked', true);
         updateDeleteUser();
     }
     hideUserButtons();
     selectLName();
 }
 
// create cookies /////////////////////////////////////////////////////////////
 $(document).ready(function() {
     checkCookie();
     createCookieListener();
 });
 
 function createCookieListener() {
    $('#addUserFormButton').bind('click', createAddUserCookie);
    $('#addItemFormButton').bind('click', createAddItemCookie);
    $('#deleteItemButton').bind('click', createUpdateItemCookie);
    $('#updateDeleteUserFormButton').bind('click', createUpdateUserCookie);
 }
 
function createAddItemCookie() {
    document.cookie = "location=addItem";
} 

function createAddUserCookie() {
     document.cookie = "location=addUser";
 }
 
function createUpdateItemCookie() {
    document.cookie = "location=updateItem";
}

function createUpdateUserCookie() {
    document.cookie = "location=updateUser";
}
 
 function checkCookie() {
     var location = getCookie("location");
     if (location === null)
         location = "addItem";
     if (location === "addUser")
     {
        $("#addItem").hide();
        $("#updateDeleteItem").hide();
        $("#updateDeleteUser").hide();
        $("#addUser").show();
     }
     else if (location === "addItem")
     {
        $("#addUser").hide();
        $("#updateDeleteItem").hide();
        $("#updateDeleteUser").hide();
        $("#addItem").show();
     }
     else if (location === "updateUser")
     {
        $("#addUser").hide();
        $("#updateDeleteItem").hide();
        $("#updateDeleteUser").show();
        $("#addItem").hide();
     }
     else if (location === "updateItem")
     {
        $("#addUser").hide();
        $("#updateDeleteItem").show();
        $("#updateDeleteUser").hide();
        $("#addItem").hide();
     }
     document.cookie = "location=";
 }
 
 function getCookie(cname)
{
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}