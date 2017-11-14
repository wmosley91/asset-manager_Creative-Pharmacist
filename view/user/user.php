<?php
require_once('/model/databaseConnect.php');

$user = $_SESSION['user'];
$userID = $user['emp_id'];

$queryUserInfo = $db->query("Select emp_id, f_name, l_name, email, status, phone_num from employee where employee.emp_id=".$userID);
$userInfoRow=$queryUserInfo->fetchAll();
        
$query = $db->query("Select all_items.item_num, entered_into_service, serial_num, make, model from all_items, user_assets where all_items.item_num = user_assets.item_num and user_assets.emp_id=".$userID);
$userRow=$query->fetchAll();

function dateDifference($date_1, $date_2, $differenceFormat = '%a')
   {
       $dateTime1 = date_create($date_1);
       $dateTime2 = date_create($date_2);
       
       $interval = date_diff($dateTime1, $dateTime2);
       
       return $interval->format($differenceFormat);
   }

function death($entered, $life)
{
   $date_1 = $entered;
   $date_2 = date('m/d/Y');
   echo (365 * $life) - dateDifference($date_1, $date_2) ." days";
}

?>
<html>
	<head>
		<title>User View</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="styles/userstyles.css">
		<link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="scripts/jquery.js"></script>
		<script src="scripts/userscript.js"></script>
	</head>
	<body>
		<header>
			<nav>
				<button style="color:white; margin-right:20px;" id="userbtn">User Info</button>
				<button style="color:white;" id="devicebtn">My Devices</button>
			</nav>
		</header>
		<div id="userinfo" style="">
			<table style="background-color: #8CC542">
				<caption style="font-family: 'Droid Sans', sans; color: white; background-color: black; width: 5%; font-size: 20px;">My Info</caption>
				<tr> 
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Permissions</th>
                                    <th>Phone</th>\	
				</tr>
				<?php foreach($userInfoRow as $userInfo) : ?>
                                <tr>
                                    <td><?php echo $userInfo['emp_id']; ?></td>
                                    <td><?php echo $userInfo['f_name']; ?> <?php echo $userInfo['l_name']; ?></td>
                                    <td><?php echo $userInfo['email']; ?></td>
                                    <td><?php echo $userInfo['status']; ?></td>
                                    <td><?php echo $userInfo['phone_num']; ?></td>
				</tr>
                                <?php endforeach; ?>
			</table>
		</div>
		<div id="mydevices" style="">
			<table style="background-color: #8CC542">
				<caption style="font-family: 'Droid Sans', sans; color: white; background-color: black; width: 7%; font-size: 20px;">My Devices</caption>
				<tr>
                                    <th>Brand</th>
                                    <th>Model Number</th>
                                    <th>Serial Number</th>
                                    <th>Entered Into Service Date</th>
                                    <th>Inventory ID</th>
                                    <th>Replace In</th>
                                </tr>
				<?php foreach($userRow as $value) : ?>
                                <tr class="baseColor">
                                    
                                    <td><?php echo $value['make']; ?></td>
                                    <td><?php echo $value['model']; ?></td>
                                    <td><?php echo $value['serial_num']; ?></td>
                                    <td><?php echo $value['entered_into_service']; ?></td>
                                    <td><?php echo $value['item_num']; ?></td>
                                    <?php 
                                    $query = $db->query('select life_cycle from assets where make = "'.$value['make'].'" and model = "'.$value['model'].'"');
                                    $expires = $query->fetch();
                                    ?>
                                    <td><?php death($value['entered_into_service'], $expires['life_cycle']); ?></td>
                                </tr>
                                <?php endforeach; ?>
			</table>
		</div>
		<div id="tickets" style="display:none">
			<form class="ticketform">
				<p class="ticketp">Ticket Submission Form</p>
				<textarea id="ticketarea" rows="4" cols="50" placeholder="Briefly describe issue" wrap="hard" required></textarea>
				<button class="ticketbtn">Submit Ticket</button>
			</form>
		</div>
		</div>
            <footer>
                <a href=".?action=logout" style="float:right;margin-right:10px;">Logout</a>
            </footer>
                <div id="google_translate_element" style="display:none;"></div><script type="text/javascript">
                function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                }
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	</body>
</html>

