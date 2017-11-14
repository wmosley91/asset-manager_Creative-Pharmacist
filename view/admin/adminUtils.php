<?php
if (!isset($types)){$types = null;}
if (!isset($locations)){$locations = null;}
if (!isset($adminUsers)){$adminUsers = null;}
if (!isset($message)){$message = null;}

/*For add item form*/
if (!isset($type)){$type = null;} 
if (!isset($make )){$make = null;} 
if (!isset($model )){$model = null;} 
if (!isset($serialNumber)){$serialNumber = null;} 
if (!isset($date)){$date = null;} 
if (!isset($life)){$life = null;} 
if (!isset($cost)){$cost = null;} 
if (!isset($vendor)){$vendor = null;}
if (!isset($location)){$location = null;}


/*For add user form*/
if (!isset($addLName)){$addLName = null;} 
if (!isset($addFName)){$addFName = null;} 
if (!isset($addEmail)){$addEmail = null;} 
if (!isset($addAddress)){$addAddress = null;} 
if (!isset($addPhone)){$addPhone = null;} 
if (!isset($addPassword)){$addPassword = null;} 
if (!isset($confirmPassword)){$confirmPassword = null;} 
if (!isset($assignAdmin)){$assignAdmin = null;}
if (!isset($assignLocation)){$assignLocation = null;}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Admin Utils</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="styles/adminutilsstyles.css">
		<link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="scripts/jquery.js"></script>
		<script src="scripts/adminutilsscript.js"></script>
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.js"></script>
        </head>
	<body>
		<header>
			<nav>
				<button style="color:white;" id="addItemButton">Add Item</button>
				<button style="color:white;" id="updateDeleteItemButton">Update/Delete Item</button>
				<button style="color:white;" id="addUserButton">Add User</button>
				<button style="color:white" id="updateDeleteUserButton">Update/Delete User</button>
			</nav>
		</header>
		<div class="wrapper" id="addItem">
                    
			<p class="formTitles">Add Item</p>
                        <div  class="divFields">
                            
				<form id="addItemForm" class="forms" action="." method="POST">
                                    <input type="hidden" name="action" value="addItem">
					<p class="formInstructions">Complete form to add new item to assets database</p>
                                        <p id="switchInstructions">Assisted Entry</p>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                                            <label class="onoffswitch-label" for="myonoffswitch">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
					<section>
						<p id="addTypeP">
							<label for="addType">
							<span>Type: </span>
							</label>
							<select id="addType" name="addType" class="inputs">
                                                            <option value="default">Select item type to begin</option>
                                                            <?php foreach ($types as $type):?>
                                                            <option value="<?php echo $type['type']?>">&nbsp;<?php echo $type['type']?></option>  
                                                            <?php endforeach?>
							</select>
                                                    <input type='text' style='display:none;' class="inputs" id='addTypeInactive' name='addTypeInactive'
                                                           />
						</p>
						<p>
							<label for="addMake">
							<span>Make: </span>
							</label>
							<select id="addMake" name="addMake" class="inputs">
							</select>
                                                        <input type='text' style='display:none;' class="inputs" id='addMakeInactive' name='addMakeInactive'
                                                               <?php if ($make ){?>value = "<?php echo $make ; }?>"/>
						</p>
						<p>
							<label for="addModel">
							<span>Model: </span>
							</label>
							<select id="addModel" name="addModel" class="inputs">
							</select>
                                                        <input type='text' style='display:none;' class="inputs" id='addModelInactive' name='addModelInactive'
                                                               <?php if ($model ){?>value = "<?php echo $model ; }?>"/>
						</p>
						<p>
							<label for="addSerial">
							<span>Serial Number: </span>
							</label>
							<input type="text" id="addSerial" name="addSerial" class="inputs" required
                                                               <?php if ($serialNumber ){?>value = "<?php echo $serialNumber ; }?>"/>
						</p>
						<p>
							<label for="addDate">
							<span>Date Entered: </span>
							</label>
							<input type="text" id="addDate" name="addDate" class="inputs">
						</p>
						<p>
							<label for="addLife">
							<span>Expected Lifecycle (years): </span>
							</label>
							<input type="number" id="addLife" name="addLife" class="inputs" min="1" max="20" readonly>
						</p>
						<p>
							<label for="addCost">
							<span>Cost: </span>
							</label>
							<input type="text" id="addCost" name="addCost" class="inputs" required>
						</p>
						<p>
							<label for="addVendor">
							<span>Vendor: </span>
							</label>
							<input type="text" id="addVendor" name="addVendor" class="inputs" required>
						</p>
                                                <p>
							<label for="addItemLocation">
							<span>Assign to Location: </span>
							</label>
                                                        <select id="addItemLocation" name="addItemLocation" class="inputs">
                                                            <?php foreach ($locations as $location):?>
                                                            <option value="<?php echo $location['location_num'];?>">&nbsp;<?php echo $location['location_num']." - ".$location['address'];?></option>  
                                                            <?php endforeach?>
							</select>
						</p>
						<button type="submit" id="addItemFormButton">Add Item</button>
					</section>
				</form>
			</div>
		</div>
		<div class="wrapper" id="addUser">
			<p class="formTitles">Add User</p>
			<div  class="divFields">
				<form id="addUserForm" class="forms" action="." method="POST">
                                    <input type="hidden" name="action" value="addUser">
					<p class="formInstructions">Complete form to add new user to database</p>
                                        <section>
						<h3>User information</h3>
						<p>
							<label for="addLName">
							<span>Last Name: </span>
							</label>
							<input type="text" name="addLName" id="addLName" class="inputs" required
                                                               <?php if ($addLName){?>value = "<?php echo $addLName; }?>"/>
						</p>
                                                <p>
							<label for="addFName">
							<span>First Name: </span>
							</label>
							<input type="text" name="addFName" id="addFName" class="inputs" required
                                                               <?php if ($addFName){?>value = "<?php echo $addFName; }?>"/>
						</p>
						<p>
							<label for="addAddress">
							<span>Address: </span>
							</label>
							<input type="text" name="addAddress" id="addAddress" class="inputs" required
                                                               <?php if ($addAddress){?>value = "<?php echo $addAddress; }?>"/>
						</p>
						<p>
							<label for="addPhone">
							<span>Phone: </span>
							</label>
							<input type="text" id="addPhone" name="addPhone" class="inputs" required
                                                               <?php if ($addPhone){?>value = "<?php echo $addPhone; }?>"/>
						</p>
                                                <p>
							<label for="addEmail">
							<span>Email: </span>
							</label>
							<input type="text" name="addEmail" id="addEmail" class="inputs" required
                                                               <?php if ($addEmail){?>value = "<?php echo $addEmail; }?>"/>
						</p>
                                                <p>
							<label for="addPassword">
							<span>Password: </span>
							</label>
							<input type="password" id="addPassword" name="addPassword" class="inputs" required/>
						</p>
                                                 <p>
							<label for="addPasswordConfirm">
							<span>Confirm Password: </span>
							</label>
							<input type="password" id="addPasswordConfirm" name="addPasswordConfirm" class="inputs" required/>
						</p>
						<p>
							<label for="assignAdmin">
							<span>Assign to Admin: </span>
							</label>

                                                        <select id="assignAdmin" name="assignAdmin" class="inputs">
                                                            <option value="default">Select admin to begin</option>
                                                            <?php foreach ($adminUsers as $adminUser):?>
                                                            <option value="<?php echo $adminUser['emp_id'];?>">&nbsp;<?php echo $adminUser['f_name'] . ' ' . $adminUser['l_name'];?></option>  
                                                            <?php endforeach?>
							</select>
						</p>
						<p>
							<label for="assignLocation">
							<span>Assign to Location: </span>
							</label>
                                                        
                                                        <select id="assignLocation" name="assignLocation" class="inputs">
                                                            <option value="default">Select location to begin</option>
                                                            <?php foreach ($locations as $location):?>
                                                            <option value="<?php echo $location['location_num'];?>">&nbsp;<?php echo $location['location_num']." - ".$location['address'];?></option>  
                                                            <?php endforeach?>
							</select>
						</p>
						<button type="submit" id="addUserFormButton">Add User</button>
					</section>
				</form>
			</div>
		</div>
                <div class="wrapper" id="updateDeleteItem">
			<p class="formTitles">Update/Delete Item</p>
			<div  class="divFields">
				<form id="updateDeleteItemForm" class="forms" action="." method="POST">
					<p class="formInstructions">Select item then make changes</p>                                       
					<section>
						<p>
							<label for="selectType">
							<span>Type: </span>
							</label>
							<select name="selectType" id="selectType" class="inputs">
                                                            <option value="default">Select item type to begin</option>
                                                            <?php foreach ($types as $type):?>
                                                            <option value="<?php echo $type['type']?>">&nbsp;<?php echo $type['type']?></option>  
                                                            <?php endforeach?>
                                                        </select>
                                                        <input type='text' style='display:none;' class="inputs" id='selectTypeInactive' name='selectTypeInactive'/>
						</p>
						<p>
							<label for="selectMake">
							<span>Make: </span>
							</label>
							<select name="selectMake" id="selectMake" class="inputs">
                                                        </select>
                                                        <input type='text' style='display:none;' class="inputs" id='selectMakeInactive' name='selectMakeInactive'
                                                               <?php if ($make ){?>value = "<?php echo $make ; }?>"/>
						</p>
						<p>
							<label for="selectModel">
							<span>Model: </span>
							</label>
							<select name="selectModel" id="selectModel" class="inputs">
                                                        </select>
                                                        <input type='text' style='display:none;' class="inputs" id='selectModelInactive' name='selectModelInactive'
                                                               <?php if ($model ){?>value = "<?php echo $model ; }?>"/>
						</p>
						<p>
							<label for="selectSerial">
							<span>Serial: </span>
							</label>
							<select name="selectSerial" id="selectSerial" class="inputs">
                                                        </select>
                                                        <input type="hidden" name="itemNum" id="itemNum">
                                                        <input type='text' style='display:none;' class="inputs" id='selectSerialInactive' name='selectSerialInactive'
                                                               <?php if ($serialNumber ){?>value = "<?php echo $serialNumber ; }?>"/>
						</p>
                                                <p>
							<label for="selectDate">
							<span>Date Entered: </span>
							</label>
							<input type="text" id="selectDate" name="selectDate" class="inputs" readonly>
						</p>
						<p>
							<label for="selectLife">
							<span>Expected Lifecycle (years): </span>
							</label>
							<input type="number" id="selectLife" name="selectLife" class="inputs" min="1" max="20" readonly>
						</p>
						<p>
							<label for="selectCost">
							<span>Cost: </span>
							</label>
							<input type="text" id="selectCost" name="selectCost" class="inputs" readonly>
						</p>
						<p>
							<label for="selectVendor">
							<span>Vendor: </span>
							</label>
							<input type="text" id="selectVendor" name="selectVendor" class="inputs" readonly>
						</p>
                                                 <p>
							<label for="selectItemLocation">
							<span>Assign to Location: </span>
							</label>
                                                        <select id="selectItemLocation" name="selectItemLocation" class="inputs" readonly>
                                                        </select>
						</p>
						<button type="submit" id="deleteItemButton">Delete Item</button>
					</section>
                                        <ul id="updateDeleteRadio">
                                            <li>
                                              <input type="radio" id="deleteRadio" name="itemSelector" value="delete" checked>
                                              <label for="deleteRadio">Delete</label>
                                              <div class="check"></div>
                                            </li>
                                            <li>
                                              <input type="radio" id="updateRadio" name="itemSelector" value="update">
                                              <label for="updateRadio">Update</label>
                                              <div class="check"><div class="inside"></div></div>
                                            </li>
                                        </ul>
                                        <button type="button" style="width:auto;position:absolute;left:1%;top:4%;" id="resetButton">Reset</button>
                                        <input type="hidden" name="action" value="deleteItem" id="getItemAction">
				</form>
			</div>
		</div>
                <div class="wrapper" id="updateDeleteUser" style="display:none">
			<p class="formTitles">Update/Delete User</p>
			<div  class="divFields">
				<form id="updateDeleteUserForm" class="forms" action="" method="POST">
					<p class="formInstructions">Select user then make changes</p>
                                        <section>
						<p>
							<label for="selectLName">
							<span>Last Name: </span>
							</label>
                                                        <select name="selectLName" id="selectLName" class="inputs">
                                                        </select>
							<input type="text" style='display:none;' name="selectLNameInactive" id="selectLNameInactive" class="inputs">
						</p>
                                                <p>
							<label for="selectFName">
							<span>First Name: </span>
							</label>
                                                        <select name="selectFName" id="selectFName" class="inputs">
                                                        </select>
							<input type="text" style='display:none;' name="selectFNameInactive" id="selectFNameInactive" class="inputs">
						</p>
						
						<p>
							<label for="selectEmail">
							<span>Email: </span>
							</label>
                                                        <select name="selectEmail" id="selectEmail" class="inputs">
                                                        </select>
							<input type="text" style='display:none;' name="selectEmailInactive" id="selectEmailInactive" class="inputs">
                                                        <input type="hidden" id="phpEmpId" name="phpEmpId">
						</p>
						<p>
							<label for="selectAddress">
							<span>Address: </span>
							</label>
							<input type="text" name="selectAddress" id="selectAddress" class="inputs" readonly>
						</p>
						<p>
							<label for="selectPhone">
							<span>Phone: </span>
							</label>
							<input type="text" id="selectPhone" name="selectPhone" class="inputs" readonly>
						</p>
						<p>
							<label for="selectAdmin">
							<span>Assign to Admin: </span>
							</label>
                                                        <input type="text" id="selectAdmin" name="selectAdmin" class="inputs" readonly>
                                                        <select id="selectAdminInactive" name="selectAdminInactive" class="inputs" style="display:none;">
							</select>
						</p>
						<p>
							<label for="selectLocation">
							<span>Assign to Location: </span>
							</label>
                                                        <input type="text" id="selectLocation" name="selectLocation" class="inputs" readonly>
							<select id="selectLocationInactive" name="selectLocationInactive" class="inputs" style="display:none;">
							</select>
						</p>
						<button type="submit" id="updateDeleteUserFormButton">Delete User</button>
					</section>
                                        <ul id="updateDeleteUserRadio">
                                            <li>
                                              <input type="radio" id="deleteUserRadio" name="userSelector" value="delete" checked>
                                              <label for="deleteUserRadio">Delete</label>
                                              <div class="check"></div>
                                            </li>
                                            <li>
                                              <input type="radio" id="updateUserRadio" name="userSelector" value="update">
                                              <label for="updateUserRadio">Update</label>
                                              <div class="check"><div class="inside"></div></div>
                                            </li>
                                        </ul>
                                        <button type="button" style="width:auto;position:absolute;left:1%;top:4%;" id="resetUserButton">Reset</button>
                                        <input type="hidden" name="action" value="deleteUser" id="getUserAction">
				</form>
			</div>
		</div>
            <p id="phpMessage" style="color:white;text-align:center;font-size:20px;"><?php echo $message ?></p>
            <footer>
                <a href=".?action=home">Admin Landing</a>
                <a href=".?action=assignItem" style="margin-left: 20px;">Item Assignment</a>
                <a href=".?action=logout" style="float:right;margin-right: 10px;">Logout</a>
            </footer>
            <div id="google_translate_element" style="display:none;"></div><script type="text/javascript">
                function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                }
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        </body>
</html>