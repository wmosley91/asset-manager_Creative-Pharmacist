<?php
require('/model/databaseConnect.php');

if (!isset($empID)){$empID = null;}
if (!isset($user)) {$user = null;}

$queryLocation = $db->query("select description from location where location_num =".$user['location_num']);
$location = $queryLocation->fetch();

$queryItems = $db->query("select type, make, model, serial_num, item_num from all_items where item_num in (select item_num from user_assets where emp_id =".$empID.")");
$items = $queryItems->fetchAll();

?>
<html>
    <head>
		<title>View User</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="styles/viewUserStyles.css">
		<link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="scripts/jquery.js"></script>
		<script src="scripts/viewUserScripts.js"></script>
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.js"></script>
        </head>
        <body>
            <div id='leftHalf'>
                <div id="userInfoDiv" class='divs'>
                    <h3 style='margin-top:0;'>User Information</h3>
                    <p class='ps'><b>Name:</b> <?php echo $user['f_name'] ?>&nbsp;<?php echo $user['l_name'] ?></p><br/>
                    <p class='ps'><b>Employee ID:</b> <?php echo $empID ?></p><br/>
                    <p class='ps'><b>Email:</b> <?php echo $user['email'] ?></p><br/>
                    <p class='ps'><b>Phone:</b> <?php echo $user['phone_num'] ?></p><br/>
                    <p class='ps'><b>Address:</b> <?php echo $user['address'] ?></p><br/>
                    <p class='ps'><b>Location:</b> <?php echo $location['description'] ?></p><br/>
                </div>
                <div id="userItemsDiv" class='divs'>
                    <h3 style='margin-top:0;'>User's Assigned Items</h3>
                    <table>
                        <tr>
                            <th style='text-align:center'>Type</th>
                            <th style='text-align:center'>Make</th>
                            <th style='text-align:center'>Model</th>
                            <th style='text-align:center'>Item Info</th>
                        </tr>
                        <?php foreach($items as $item) : ?>
                            <tr>
                                <td><?php echo $item['type']; ?></td>
                                <td><?php echo $item['make']; ?></td>
                                <td><?php echo $item['model']; ?></td>
                                <td><button type='button' class='viewButton' value='<?php echo $item['item_num']?>'>View</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
            <div id='rightHalf'>
                <div id ='itemInfoDiv' class='divs'>
                    <h3 style='margin-top:0;'>Item Information</h3>
                    <p class='ps'>
                        <label for="item">
                        <span>Item Number: </span>
                        </label>
                        <span id='item'></span>
                    </p>
                    <p class='ps'>
                        <label for="serial">
                        <span>Serial Number: </span>
                        </label>
                        <span id='serial'></span>
                    </p>
                    <p class='ps'>
                        <label for="date">
                        <span>Date Purchased: </span>
                        </label>
                        <span id='date'></span>
                    </p>
                    <p class='ps'>
                        <label for="cost">
                        <span>Cost: </span>
                        </label>
                        <span id='cost'></span>
                    </p>
                    <p class='ps'>
                        <label for="vendor">
                        <span>Vendor: </span>
                        </label>
                        <span id='vendor'></span>
                    </p>
                    <p class='ps'>
                        <label for="location">
                        <span>Location: </span>
                        </label>
                        <span id='location'></span>
                    </p>
                    <p class='ps'>
                        <label for="photo">
                        <span>Photo: </span>
                        </label>
                        <span id='photo'></span>
                    </p>
                </div>
            </div>
            <footer>
                <a href=".?action=home">Admin Landing</a>
                <a href=".?action=logout" style="float:right;margin-right: 10px;">Logout</a>
            </footer>
            <div id="google_translate_element" style="display:none;"></div><script type="text/javascript">
                function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                }
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        </body>
</html>
