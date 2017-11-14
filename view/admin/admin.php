<?php
require('/model/databaseConnect.php');

$user = $_SESSION['user'];
$userID = $user['emp_id'];

$queryUserInfo = $db->query("Select emp_id, f_name, l_name, email, status, phone_num from employee where employee.emp_id=".$userID);
$userInfoRow=$queryUserInfo->fetchAll();
        
$query = $db->query("Select all_items.item_num, entered_into_service, serial_num, make, model from all_items, user_assets where all_items.item_num = user_assets.item_num and user_assets.emp_id=".$userID);
$userRow=$query->fetchAll();

$queryAllUsers= $db->query("Select admin_emp_id, emp_id, f_name, l_name, email, status, phone_num, location_num from employee, hierarchy where employee.emp_id = hierarchy.basic_emp_id and hierarchy.admin_emp_id=".$userID);
$allUsersRow=$queryAllUsers->fetchAll();

$queryAllItems = $db->query("Select item_num, entered_into_service, serial_num, make, model, all_items.location_num from all_items, employee where all_items.location_num = employee.location_num and employee.emp_id=".$userID." order by item_num");
$allItemsRow=$queryAllItems->fetchAll();

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
<!DOCTYPE html>
<html>
	<head>
		<title>Admin View</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="styles/adminstyles.css">
		<link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="scripts/jquery.js"></script>
		<script src="scripts/adminscript.js"></script>
	</head>
	<body>
		<header>
			<nav>
				<button style="color:white;" id="adminbtn">Admin Info</button>
				<button style="color:white;" id="devicebtn">My Devices</button>
				<button style="color:white;" id="usersbtn">View Users</button>
				<button style="color:white" id="devicesbtn">View Devices</button>
			</nav>
		</header>
		<div id="admininfo" style="">
			<table style="background-color: #8CC542">
				<caption style="font-family: 'Droid Sans', sans; color: white; background-color: black; width: 15%; font-size: 20px;">My Info</caption>
				<tr> 
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Permissions</th>
                                    <th>Phone</th>
                                    <th>Profile</th>
				</tr>
				<?php foreach($userInfoRow as $userInfo) : ?>
                                <tr>
                                    <td><?php echo $userInfo['emp_id']; ?></td>
                                    <td><?php echo $userInfo['l_name'];echo ', '.$userInfo['f_name']; ?></td>
                                    <td><?php echo $userInfo['email']; ?></td>
                                    <td><?php echo $userInfo['status']; ?></td>
                                    <td><?php echo $userInfo['phone_num']; ?></td>
                                    <td><a href=".?action=viewUser&empID=<?php echo $userID ?>">View</a></td>
				</tr>
                                <?php endforeach; ?>
			</table>
		</div>
		<div id="mydevices" style="">
			<table style="background-color: #8CC542">
				<caption style="font-family: 'Droid Sans', sans; color: white; background-color: black; width: 15%; font-size: 20px;">My Devices</caption>
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
		<div id="viewusers" style="">
			<table style="background-color: #8CC542">
				<caption style="font-family: 'Droid Sans', sans; color: white; background-color: black; width: 15%; font-size: 20px;">Users</caption>
				<tr>
					<th>Employee ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Location</th>
					<th>Phone</th>
                                        <th>Profile</th>
				</tr>
				<?php foreach($allUsersRow as $value) : ?>
                                <tr>
                                    <td><?php echo $value['emp_id']; ?></td>
                                    <td><?php echo $value['l_name']; echo ', '.$value['f_name']; ?></td>
                                    <td><?php echo $value['email']; ?></td>
                                    <td><?php echo $value['status']; ?></td>
                                    <td><?php echo $value['phone_num']; ?></td>
                                    <td><a href=".?action=viewUser&empID=<?php echo $value['emp_id']; ?>">View</a></td>
				</tr>
                                <?php endforeach; ?>
			</table>
		</div>
		<div id="viewdevices" style="margin-bottom:20px">
			<table style="background-color: #8CC542">
				<caption style="font-family: 'Droid Sans', sans; color: white; background-color: black; width: 15%; font-size: 20px;">All Devices</caption>
				<tr>
                                    <th>Brand</th>
                                    <th>Model Number</th>
                                    <th>Serial Number</th>
                                    <th>Entered Into Service Date</th>
                                    <th>Inventory ID</th>
                                    <th>Replace In</th>
                                    <th>Purchase</th>
				</tr>
				<?php foreach($allItemsRow as $value) : ?>
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
                                    <td><a href="https://www.google.com/search?output=search&tbm=shop&q=<?php echo $value['make']; echo " ".$value['model']?>" target="_blank">Shop</a></td>
				</tr>
                                <?php endforeach; ?>
			</table>
		</div>
            <div id="masterListItems" style="margin-bottom:20px;margin-top:20px;"><button type="button" id="itemMasterButton" style="width:auto;color:white;font-size:20px;left:10%;">Item Master List</button></div>
            <div id="masterListUsers" style="margin-bottom:50px;"><button type="button" id="userMasterButton" style="width:auto;color:white;font-size:20px;left:10%;">User Master List</button></div>
            <footer>
                <a href=".?action=addItem">Utilities</a>
                <a href=".?action=assignItem" style="margin-left:20px;">Item Assignment</a>
                <a href=".?action=logout" style="float:right;margin-right:10px;">Logout</a>
            </footer>
            <div id="google_translate_element" style="display:none;"></div><script type="text/javascript">
                function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                }
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	</body>
</html>