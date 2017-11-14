<?php
if (!isset($types)){$types = null;}
if (!isset($lasts)){$lasts = null;}

$typeQuery = $db->query('select distinct type from all_items where type in (select type from all_items where assigned = "u")');
$typess = $typeQuery->fetchAll();
?>
<html>
    <head>            
        <title>Item Assignment</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="styles/itemAssignmentStyles.css">
        <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
        <script src="scripts/jquery.js"></script>
        <script src="scripts/itemAssignmentScripts.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.js"></script>
    </head>
    <div class="wrapper">
        <div class="filterDiv spacingLeft" id="filterItems">
            <h2>Filter Items</h2>
            <p>Select type, make, model</p>
            <p class="fieldP">
            <span>Select Type:</span>
            <select id="filterType" name="filterType">
                <option value="default">Select type to begin</option>
                <?php foreach ($typess as $type):?>
                <option value="<?php echo $type['type']?>">&nbsp;<?php echo $type['type']?></option>  
                <?php endforeach?>
            </select><br/>
            </p>
            <p class="fieldP">
                <span>Select Make:</span>
                <select id="filterMake" name="filterMake">
                </select><br/>
            </p>
            <p class="fieldP">
                <span>Select Model:</span>
                <select id="filterModel" name="filterModel">
                </select>
            </p>
            <p class="bottomP">&nbsp;</p>
        </div>
        <div class="filterDiv spacingRight" id="filterUsers">
            <h2>Select User</h2>
            <p>Search by last name, first name, email</p>
            <p class="fieldP">
                <span>Select Last Name:</span>
                <select id="filterLast" name="filterLast">
                    <option value="default">Select last name to begin</option>
                    <?php foreach ($lasts as $last):?>
                    <option value="<?php echo $last['l_name']?>">&nbsp;<?php echo $last['l_name']?></option>  
                    <?php endforeach?>
                </select>
            </p>
            <p class="fieldP">
                <span>Select First Name:</span>
                <select id="filterFirst" name="filterFirst">
                </select><br/>
            </p>
            <p class="fieldP">
                <span>Select Email:</span>
                <select id="filterEmail" name="filterEmail">
                </select>
            </p>
            <p class="bottomP">&nbsp;</p>
        </div>
        <div class="clearFloat" style="clear:both;"></div>
    </div>
    <div class="wrapper">
        <div id="availableSerialsDiv" class="filterDiv spacingLeft">
            <h2>Available Items Pool</h2>
            <p class="padlessP">Serial numbers of available items</p>
            <select size="10" style="width:100%;" class="selectBgs" id="getSerials">
            </select>
            <p class="padlessP">&nbsp;</p>
        </div>
        <div id="buttonsDiv" class="buttonDiv">
            <button type="button" style="left:50%;" class="buttons" id="addButton">Add</button><br/>
            <button type="button" class="buttons" id="removeButton">Remove</button><br/>
            <button type="button" class="buttons" id="resetFieldsButton">Reset</button><br/>
            <button type="button" class="buttons" id="commitButton">Commit</button>
        </div>
        <div id="userSerialsDiv" class="filterDiv">
            <h2>User's Item Pool</h2>
            <p class="padlessP">Serial numbers of user's items</p>
            <select size="10" style="width:100%;" class="selectBgs" id="userSerials">
            </select>
            <p class="padlessP">&nbsp;</p>
        </div>
        <div class="clearFloat" style="clear:both"></div>
    </div>
    <div id="removedSerialsDiv" class="filterDiv spacingLeft">
        <h2>Removed Items Pool</h2>
        <p class="padlessP">Serial numbers of removed items</p>
        <select size="5" style="width:100%;" class="selectBgs" id="removedSerials">
        </select>
        <p class="padlessP">&nbsp;</p>
    </div>
    <div id="addedSerialsDiv" class="filterDiv spacingRight">
        <h2>Added Items Pool</h2>
        <p class="padlessP">Serial numbers of added items</p>
        <select size="5" style="width:100%;" class="selectBgs" id="addedSerials">
        </select>
        <p class="padlessP">&nbsp;</p>
    </div>
    <div class="clearFloat" style="clear:both;margin-bottom:100px;"></div>
    <footer>
        <a href=".?action=home">Admin Landing</a>
        <a href=".?action=addItem" style="margin-left:20px;">Utilities</a>
        <a href=".?action=logout" style="float:right;margin-right:10px;">Logout</a>
    </footer>
    <div id="google_translate_element" style="display:none;"></div><script type="text/javascript">
                function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                }
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</html>

