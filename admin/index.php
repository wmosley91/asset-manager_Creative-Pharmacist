<?php  
//ADMIN INDEX FILE
require_once('/model/adminUtilsDB.php');
require_once('/admin/adminMethods.php');
//variables
$message = '';
if (!isset($action)){$action = filter_input(INPUT_POST, 'action');}

//filters the action from the request to decide how to handle it. If no action was set, redirects to the login


if ($action == NULL)
{
    $action = filter_input(INPUT_GET, 'action');
}

switch($action)
{
    case 'adminLand':
        
        include('\view\admin\admin.php');
    break;
    
    case 'addItem':
        $type = filter_input(INPUT_POST, 'addType');
        $make = filter_input(INPUT_POST, 'addMake');
        $model = filter_input(INPUT_POST, 'addModel');
        $serialNumber = filter_input(INPUT_POST, 'addSerial');
        $date = filter_input(INPUT_POST, 'addDate');
        $life = filter_input(INPUT_POST, 'addLife');
        $cost = filter_input(INPUT_POST, 'addCost');
        $vendor = filter_input(INPUT_POST, 'addVendor');
        $location = filter_input(INPUT_POST, 'addItemLocation');
        $manualOauto = isset($_POST['onoffswitch']);
        
        /*Ensures everything entered into the database is in Uppercase */
        
        $type = strtoupper($type);
        $make = strtoupper($make);
        $model = strtoupper($model);
        $serialNumber = strtoupper($serialNumber);
        $vendor = strtoupper($vendor);
        $badField = false;
        
        
        if (!isset($type)){$type = '';}
        if (!isset($make)){$make = '';}
        if (!isset($model)){$model = '';}
        if (!isset($serialNumber)){$serialNumber = '';}
        if (!isset($date)){$date = '';}
        if (!isset($life)){$life = '';}
        if (!isset($cost)){$cost = '';}
        if (!isset($vendor)){$vendor = '';}
        
        
        if($type == null && $make == null && $cost == null && $vendor == null)
        {
            $adminUsers = getAdminUsers();
            $locations = getLocations();
            $types = getTypes();
            include('\view\admin\adminUtils.php');
        }
        else
        {

            if($type == null || $type == false)
            {
                $message .= "Please enter a type.<br>";
            }
            else if($type)
            {
                $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>]/";
                $fieldLength = strlen($type);
                
                $result = preg_match($pattern, $type);
                if($result == 1)
                {
                    $message .= "Type field can only contain letters, numbers, underscores or spaces.<br>";
                    $badField = true;
                }
                if($fieldLength > 30)
                {
                    $message .= "Type field only allows 30 characters.<br>";
                    $badField = true;
                }
            }
            if($make == null || $make == false)
            {
                $message .= "Please enter a make.<br>";
            }
            else if($make)
            {
                $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>]/";
                $fieldLength = strlen($make);
                
                $result = preg_match($pattern, $make);
                if($result == 1)
                {
                    $message .= "Make field can only contain letters, numbers, underscores or spaces.<br>";
                    $badField = true;
                }
                if($fieldLength > 30)
                {
                    $message .= "Make field only allows 30 characters.<br>";
                    $badField = true;
                }
            }
            
            if($model == null || $model == false)
            {
                $message .= "Please enter a model.<br>";
            }
            else if($model)
            {
                $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>]/";
                $fieldLength = strlen($model);
                
                $result = preg_match($pattern, $model);
                if($result == 1)
                {
                    $message .= "Model field can only contain letters, numbers, underscores or spaces.<br>";
                    $badField = true;
                }
                if($fieldLength > 30)
                {
                    $message .= "Model field only allows 30 characters.<br>";
                    $badField = true;
                }
            }
            
            if($date == null || $date == false)
            {
                $message .= "Please enter a date.<br>";
            }
            if($life == null || $life == false)
            {
                $message .= "Please enter a Life Cycle amount.<br>";
            }
            else if($life)
            {
                $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>a-zA-Z]/";
                $fieldLength = strlen($life);
                
                $result = preg_match($pattern, $life);
                if($result == 1)
                {
                    $message .= "Expected Lifecycle field can only contain numbers.<br>";
                    $badField = true;
                }
                if($fieldLength > 30)
                {
                    $message .= "Expected Lifecycle field only allows 3 characters.<br>";
                    $badField = true;
                }
            }
            
            if($cost == null || $cost == false)
            {
                $message .= "Please enter a cost.<br>";
            }
            else if($cost)
            {
                $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>a-zA-Z]/";
                $fieldLength = strlen($cost);
                
                $result = preg_match($pattern, $cost);
                if($result == 1)
                {
                    $message .= "Cost field can only contain numbers.<br>";
                    $badField = true;
                }
                if($fieldLength > 30)
                {
                    $message .= "Cost field only allows 3 characters.<br>";
                    $badField = true;
                }
            }
            if($vendor == null || $vendor == false)
            {
                $message .= "Please enter a vendor.<br>";
            }
            else if($vendor)
            {
                $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>]/";
                $fieldLength = strlen($vendor);
                
                $result = preg_match($pattern, $vendor);
                if($result == 1)
                {
                    $message .= "Make field can only contain letters, numbers, underscores or spaces.<br>";
                    $badField = true;
                }
                if($fieldLength > 30)
                {
                    $message .= "Make field only allows 30 characters.<br>";
                    $badField = true;
                }
            }
            
            if($type == null || $type == false || $make == null || $make == false || $date == null || $date == false
                    || $life == null || $life == false || $cost == null || $cost == false || $vendor == null || $vendor == false || $badField)
            {
                $adminUsers = getAdminUsers();
                $locations = getLocations();
                $types = getTypes();
                include('\view\admin\adminUtils.php');
                break;
            }
            else
            {
                $success = false;
                
                if($manualOauto)
                {
                    $success = addItem($type, $make, $model, $serialNumber, $date, $life, $cost, $vendor, $location);
                }
                else //If manual was selected on switch this will check the type, make and model fields to ensure they don't already exist
                {
                    //Checks to see if the enter type already exists in the database
                    $typeAlreadyExists = checkIfFieldValueExists("type", $type);
                    
                    //If type exists now we'll check the make
                    if($typeAlreadyExists)
                    {
                        $makeAlreadyExists = checkIfFieldValueExists("make", $make);
                        
                        //If make exists now we'll check the model
                        if($makeAlreadyExists)
                        {
                            $modelAlreadyExists = checkIfFieldValueExists("model", $model);
                            
                            //If model also exists we'll prompt them to use auto mode
                            if($modelAlreadyExists)
                            {
                                $message = "The Type, Make and Model entered already exists, please complete your entry using Assisted Entry";
                                $adminUsers = getAdminUsers();
                                $locations = getLocations();
                                $types = getTypes();
                                include('\view\admin\adminUtils.php');
                                break;
                            }
                            else
                            {
                                $success = addItem($type, $make, $model, $serialNumber, $date, $life, $cost, $vendor, $location);
                            }
                        }
                        else
                        {
                            $success = addItem($type, $make, $model, $serialNumber, $date, $life, $cost, $vendor, $location);
                        }
                    }
                    else
                    {
                        $success = addItem($type, $make, $model, $serialNumber, $date, $life, $cost, $vendor, $location);
                    }
                    
                }

                
                if($success)
                {
                    $message = "Item was successfully entered into the database";
                    $type = '';
                    $make = '';
                    $model = '';
                    $serialNumber = '';
                    $adminUsers = getAdminUsers();
                    $locations = getLocations();
                    $types = getTypes();
                    include('\view\admin\adminUtils.php');
                    break;
                }
                else
                {
                    $message = "Item could not be entered at this time";
                    $adminUsers = getAdminUsers();
                    $locations = getLocations();
                    $types = getTypes();
                    include('\view\admin\adminUtils.php');
                    break;
                }
            }
        }
    break;
    
    case 'updateItem':
        $type = filter_input(INPUT_POST, 'selectType');
        $make = filter_input(INPUT_POST, 'selectMake');
        $model = filter_input(INPUT_POST, 'selectModel');
        $serialNumber = filter_input(INPUT_POST, 'selectSerial');
        $date = filter_input(INPUT_POST, 'selectDate');
        $life = filter_input(INPUT_POST, 'selectLife');
        $cost = filter_input(INPUT_POST, 'selectCost');
        $vendor = filter_input(INPUT_POST, 'selectVendor');
        $itemNum = filter_input(INPUT_POST, 'itemNum');
        
        /*Ensures everything entered into the database is in Uppercase */
        
        $type = strtoupper($type);
        $make = strtoupper($make);
        $model = strtoupper($model);
        $serialNumber = strtoupper($serialNumber);
        $vendor = strtoupper($vendor);
        $badField = false;
        
        
        if($type == null || $type == false)
        {
            $message = "Please enter a type.<br>";
        }
        else if($type)
        {
            $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>]/";
            $fieldLength = strlen($type);

            $result = preg_match($pattern, $type);
            if($result == 1)
            {
                $message .= "Type field can only contain letters, numbers, underscores or spaces.<br>";
                $badField = true;
            }
            if($fieldLength > 30)
            {
                $message .= "Type field only allows 30 characters.<br>";
                $badField = true;
            }
        }
        if($make == null || $make == false)
        {
            $message .= "Please enter a make.<br>";
        }
        else if($make)
        {
            $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>]/";
            $fieldLength = strlen($make);

            $result = preg_match($pattern, $make);
            if($result == 1)
            {
                $message .= "Make field can only contain letters, numbers, underscores or spaces.<br>";
                $badField = true;
            }
            if($fieldLength > 30)
            {
                $message .= "Make field only allows 30 characters.<br>";
                $badField = true;
            }
        }
        
        if($model == null || $model == false)
            {
                $message .= "Please enter a model.<br>";
            }
        else if($model)
        {
            $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>]/";
            $fieldLength = strlen($model);

            $result = preg_match($pattern, $model);
            if($result == 1)
            {
                $message .= "Model field can only contain letters, numbers, underscores or spaces.<br>";
                $badField = true;
            }
            if($fieldLength > 30)
            {
                $message .= "Model field only allows 30 characters.<br>";
                $badField = true;
            }
        }
        
        if($date == null || $date == false)
        {
            $message .= "Please enter a date.<br>";
        }
        if($life == null || $life == false)
        {
            $message .= "Please enter a Life Cycle amount.<br>";
        }
        else if($life)
        {
            $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>a-zA-Z]/";
            $fieldLength = strlen($life);

            $result = preg_match($pattern, $life);
            if($result == 1)
            {
                $message .= "Expected Lifecycle field can only contain numbers.<br>";
                $badField = true;
            }
            if($fieldLength > 30)
            {
                $message .= "Expected Lifecycle field only allows 3 characters.<br>";
                $badField = true;
            }
        }
        if($cost == null || $cost == false)
        {
            $message .= "Please enter a cost.<br>";
        }
        else if($cost)
        {
            $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>a-zA-Z]/";
            $fieldLength = strlen($cost);

            $result = preg_match($pattern, $cost);
            if($result == 1)
            {
                $message .= "Cost field can only contain numbers.<br>";
                $badField = true;
            }
            if($fieldLength > 30)
            {
                $message .= "Cost field only allows 3 characters.<br>";
                $badField = true;
            }
        }
        if($vendor == null || $vendor == false)
        {
            $message .= "Please enter a vendor.<br>";
        }
        else if($vendor)
        {
            $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}':;<,>]/";
            $fieldLength = strlen($vendor);

            $result = preg_match($pattern, $vendor);
            if($result == 1)
            {
                $message .= "Vendor field can only contain letters, numbers, underscores or spaces.<br>";
                $badField = true;
            }
            if($fieldLength > 30)
            {
                $message .= "Vendor field only allows 30 characters.<br>";
                $badField = true;
            }
        }

        if($type == null || $type == false || $make == null || $make == false || $date == null || $date == false
                || $life == null || $life == false || $cost == null || $cost == false || $vendor == null || $vendor == false || $badField)
        {
            $adminUsers = getAdminUsers();
            $locations = getLocations();
            $types = getTypes();
            include('\view\admin\adminUtils.php');
            break;
        }
        else
        {
            $success = updateItem($type, $make, $model, $serialNumber, $date, $cost, $vendor, $itemNum, $life);

            if($success)
            {
                $message = "Item was successfully updated in the database";
                $adminUsers = getAdminUsers();
                $locations = getLocations();
                $types = getTypes();
                include('\view\admin\adminUtils.php');
                break;
            }
            else
            {
                $message = "Item could not be updated at this time";
                $adminUsers = getAdminUsers();
                $locations = getLocations();
                $types = getTypes();
                include('\view\admin\adminUtils.php');
                break;
            }
        }
    break;
    
    case 'deleteItem':
        $itemNum = filter_input(INPUT_POST, 'itemNum');
        $success = deleteItem($itemNum);
        
        if($success)
        {
            $message = "Item was successfully deleted";
            $adminUsers = getAdminUsers();
            $locations = getLocations();
            $types = getTypes();
            include('\view\admin\adminUtils.php');
            break;
        }
        else
        {
            $message = "Item could not be deleted at this time";
            $adminUsers = getAdminUsers();
            $locations = getLocations();
            $types = getTypes();
            include('\view\admin\adminUtils.php');
            break;
        }
    break;
    
    case 'addUser':
        $addLName = filter_input(INPUT_POST, 'addLName');
        $addFName = filter_input(INPUT_POST, 'addFName');
        $addEmail = filter_input(INPUT_POST, 'addEmail');
        $addAddress = filter_input(INPUT_POST, 'addAddress');
        $addPhone = filter_input(INPUT_POST, 'addPhone');
        $addPassword = filter_input(INPUT_POST, 'addPassword');
        $confirmPassword = filter_input(INPUT_POST, 'addPasswordConfirm');
        $assignAdmin = filter_input(INPUT_POST, 'assignAdmin');
        $assignLocation = filter_input(INPUT_POST, 'assignLocation');
        
        /*Ensures everything entered into the database is in Uppercase */
        
        $addLName = strtoupper($addLName);
        $addFName = strtoupper($addFName);
        $addEmail = strtoupper($addEmail);
        $addAddress = strtoupper($addAddress);
        $badField = false;
        
        if($addLName == null || $addFName == null || $addEmail == null || $addAddress == null || $addPhone == null || $assignAdmin == null || $assignLocation == null)
            {
                $adminUsers = getAdminUsers();
                $locations = getLocations();
                $types = getTypes();
                include('\view\admin\adminUtils.php');
                break;
            }
        
        if($addLName && $addFName && $addEmail && $addAddress && $addPhone && $addPassword && $confirmPassword && $assignAdmin && $assignLocation)
        {
            $addPassword = trim($addPassword);
            $confirmPassword = trim($confirmPassword);
            
            if($addPassword === $confirmPassword)
            {
                if($addLName == null || $addLName == false)
                {
                    $message = "Please enter a last name.<br>";
                }
                else if($addLName)
                {
                    $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}:;<,>0-9]/";
                    $fieldLength = strlen($addLName);

                    $result = preg_match($pattern, $addLName);
                    if($result == 1)
                    {
                        $message .= "Last name field can only contain letters, apostrophes, underscores or spaces.<br>";
                        $badField = true;
                    }
                    if($fieldLength > 15)
                    {
                        $message .= "Last name field only allows up to 15 characters.<br>";
                        $badField = true;
                    }
                }
                if($addFName == null || $addFName == false)
                {
                    $message .= "Please enter a First Name.<br>";
                }
                else if($addFName)
                {
                    $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}:;<,>0-9]/";
                    $fieldLength = strlen($addFName);

                    $result = preg_match($pattern, $addFName);
                    if($result == 1)
                    {
                        $message .= "First name field can only contain letters, apostrophes, underscores or spaces.<br>";
                        $badField = true;
                    }
                    if($fieldLength > 15)
                    {
                        $message .= "First name field only allows up to 15 characters.<br>";
                        $badField = true;
                    }
                }

                if($addEmail == null || $addEmail == false)
                {
                    $message .= "Please enter an email.<br>";
                }
                else if($addEmail)
                {
                    $pattern = "/[`~!#$%^&*()\-\=\+\[\]\{\}:;<,>]/";
                    $fieldLength = strlen($addEmail);

                    $result = preg_match($pattern, $addEmail);
                    if($result == 1)
                    {
                        $message .= "Email field can only contain letters, apostrophes, underscores or spaces.<br>";
                        $badField = true;
                    }
                    if($fieldLength > 40)
                    {
                        $message .= "Email field only allows up to 40 characters.<br>";
                        $badField = true;
                    }
                }
                if($addAddress == null || $addAddress == false)
                {
                    $message .= "Please enter an address.<br>";
                }
                else if($addAddress)
                {
                    $pattern = "/[`~!@#$%^&*()\-\=\+\[\]\{\}:;<,>]/";
                    $fieldLength = strlen($addAddress);

                    $result = preg_match($pattern, $addAddress);
                    if($result == 1)
                    {
                        $message .= "Address field can only contain letters, apostrophes, underscores or spaces.<br>";
                        $badField = true;
                    }
                    if($fieldLength > 40)
                    {
                        $message .= "Address field only allows up to 40 characters.<br>";
                        $badField = true;
                    }
                }
                if($addPhone == null || $addPhone == false)
                {
                    $message .= "Please enter a phone number.<br>";
                }
                else if($addPhone)
                {
                    $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}\_':;<,>a-zA-Z]/";
                    $fieldLength = strlen($addPhone);

                    $result = preg_match($pattern, $addPhone);
                    if($result == 1)
                    {
                        $message .= "Phone number field can only contain numbers.<br>";
                        $badField = true;
                    }
                    if($fieldLength > 10)
                    {
                        $message .= "Phone number field only allows up to 10 characters.<br>";
                        $badField = true;
                    }
                }
                
                if($addPassword == null || $addPassword == false)
                {
                    $message .= "Please enter a password.<br>";
                }
                else if($addPassword)
                {
                    $pattern = "/[`~()\-\=\+\[\]\{\}:;<,>]/";
                    $fieldLength = strlen($addPassword);

                    $result = preg_match($pattern, $addPassword);
                    if($result == 1)
                    {
                        $message .= "Password field cannot contain the following special characters `~()-=+[]{}:;<,>.<br>";
                        $badField = true;
                    }
                    if($fieldLength > 20)
                    {
                        $message .= "Password field only allows up to 20 characters.<br>";
                        $badField = true;
                    }
                }

                if($addLName == null || $addLName == false || $addFName == null || $addFName == false || $addEmail == null || $addEmail == false
                        || $addAddress == null || $addAddress == false || $addPhone == null || $addPhone == false || $addPassword == null || $addPassword == false || $badField)
                {
                    $adminUsers = getAdminUsers();
                    $locations = getLocations();
                    $types = getTypes();
                    include('\view\admin\adminUtils.php');
                    break;
                }
                
                if(!$badField)
                {
                    $addPassword = password_hash($addPassword, PASSWORD_DEFAULT);
                    $success = addUser($addLName, $addFName, $addEmail, $addAddress, $addPhone, $assignAdmin, $assignLocation, $addPassword);

                    if($success)
                    {
                        $message = "User was successfully added to the database";

                        /*reset form*/
                        $addLName = '';
                        $addFName = '';
                        $addEmail = '';
                        $addAddress = '';
                        $addPhone = '';
                        $adminUsers = getAdminUsers();
                        $locations = getLocations();
                        $types = getTypes();
                        include('\view\admin\adminUtils.php');
                        break;
                    }
                    else
                    {
                        $message = "User could not be added at this time";
                        $adminUsers = getAdminUsers();
                        $locations = getLocations();
                        $types = getTypes();
                        include('\view\admin\adminUtils.php');
                        break;
                    }
                }
            }
            else
            {
                $message = "Passwords must matched";
                $adminUsers = getAdminUsers();
                $locations = getLocations();
                $types = getTypes();
                include('\view\admin\adminUtils.php');
                break;
            }
        }
        else
        {
            $message = 'Please check all fields and try again.';
            $adminUsers = getAdminUsers();
            $locations = getLocations();
            $types = getTypes();
            include('\view\admin\adminUtils.php');
            break;
        }

    break;
    
    case 'updateUser':
        $selectLName = filter_input(INPUT_POST, 'selectLName');
        $selectFName = filter_input(INPUT_POST, 'selectFName');
        $selectEmail = filter_input(INPUT_POST, 'selectEmail');
        $selectAddress = filter_input(INPUT_POST, 'selectAddress');
        $selectPhone = filter_input(INPUT_POST, 'selectPhone');
        $selectAdmin = filter_input(INPUT_POST, 'selectAdmin');
        $selectLocation = filter_input(INPUT_POST, 'selectLocation');
        
        /*Ensures everything entered into the database is in Uppercase */
        
        $selectLName = strtoupper($selectLName);
        $selectFName = strtoupper($selectFName);
        $selectEmail = strtoupper($selectEmail);
        $selectAddress = strtoupper($selectAddress);
        $badField = false;
        
        if($selectLName && $selectFName && $selectEmail && $selectAddress && $selectPhone && $selectAdmin && $selectLocation)
        {
            if($selectLName == null || $selectLName == false)
                {
                    $message = "Please enter a last name.<br>";
                }
                else if($selectLName)
                {
                    $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}:;<,>0-9]/";
                    $fieldLength = strlen($selectLName);

                    $result = preg_match($pattern, $selectLName);
                    if($result == 1)
                    {
                        $message .= "Last name field can only contain letters, apostrophes, underscores or spaces.<br>";
                        $badField = true;
                    }
                    if($fieldLength > 15)
                    {
                        $message .= "Last name field only allows up to 15 characters.<br>";
                        $badField = true;
                    }
                }
                if($selectFName == null || $selectFName == false)
                {
                    $message .= "Please enter a First Name.<br>";
                }
                else if($selectFName)
                {
                    $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}:;<,>0-9]/";
                    $fieldLength = strlen($selectFName);

                    $result = preg_match($pattern, $selectFName);
                    if($result == 1)
                    {
                        $message .= "First name field can only contain letters, apostrophes, underscores or spaces.<br>";
                        $badField = true;
                    }
                    if($fieldLength > 15)
                    {
                        $message .= "First name field only allows up to 15 characters.<br>";
                        $badField = true;
                    }
                }

                if($selectEmail == null || $selectEmail == false)
                {
                    $message .= "Please enter an email.<br>";
                }
                else if($selectEmail)
                {
                    $pattern = "/[`~!#$%^&*()\-\=\+\[\]\{\}:;<,>]/";
                    $fieldLength = strlen($selectEmail);

                    $result = preg_match($pattern, $selectEmail);
                    if($result == 1)
                    {
                        $message .= "Email field can only contain letters, apostrophes, underscores or spaces.<br>";
                        $badField = true;
                    }
                    if($fieldLength > 40)
                    {
                        $message .= "Email field only allows up to 40 characters.<br>";
                        $badField = true;
                    }
                }
                if($selectAddress == null || $selectAddress == false)
                {
                    $message .= "Please enter an address.<br>";
                }
                else if($selectAddress)
                {
                    $pattern = "/[`~!@#$%^&*()\-\=\+\[\]\{\}:;<,>]/";
                    $fieldLength = strlen($selectAddress);

                    $result = preg_match($pattern, $selectAddress);
                    if($result == 1)
                    {
                        $message .= "Address field can only contain letters, apostrophes, underscores or spaces.<br>";
                        $badField = true;
                    }
                    if($fieldLength > 40)
                    {
                        $message .= "Address field only allows up to 40 characters.<br>";
                        $badField = true;
                    }
                }
                if($selectPhone == null || $selectPhone == false)
                {
                    $message .= "Please enter a phone number.<br>";
                }
                else if($selectPhone)
                {
                    $pattern = "/[`~!@#$%^&*()\-\=\+\.\[\]\{\}\_':;<,>a-zA-Z]/";
                    $fieldLength = strlen($selectPhone);

                    $result = preg_match($pattern, $selectPhone);
                    if($result == 1)
                    {
                        $message .= "Phone number field can only contain numbers.<br>";
                        $badField = true;
                    }
                    if($fieldLength > 10)
                    {
                        $message .= "Phone number field only allows up to 10 characters.<br>";
                        $badField = true;
                    }
                }
            
                if($selectLName == null || $selectLName == false || $selectFName == null || $selectFName == false || $selectEmail == null || $selectEmail == false
                        || $selectAddress == null || $selectAddress == false || $selectPhone == null || $selectPhone == false || $badField)
                {
                    $adminUsers = getAdminUsers();
                    $locations = getLocations();
                    $types = getTypes();
                    include('\view\admin\adminUtils.php');
                    break;
                }
            
            if(!$badField)
            {
                $originalEmail = $selectEmail;
                $success = updateUser($originalEmail, $selectLName, $selectFName, $selectEmail, $selectAddress, $selectPhone, $selectAdmin, $selectLocation);

                if($success)
                {
                    $message = "User was successfully updated in the database";
                    /*reset form*/
                    $addLName = '';
                    $addFName = '';
                    $addEmail = '';
                    $addAddress = '';
                    $addPhone = '';
                    $adminUsers = getAdminUsers();
                    $locations = getLocations();
                    $types = getTypes();
                    include('\view\admin\adminUtils.php');
                    break;
                }
                else
                {
                    $message = "User could not be updated at this time";
                    $adminUsers = getAdminUsers();
                    $locations = getLocations();
                    $types = getTypes();
                    include('\view\admin\adminUtils.php');
                    break;
                }
            }
        }
        else
        {
            $message = "User could not be added at this time";
            $adminUsers = getAdminUsers();
            $locations = getLocations();
            $types = getTypes();
            include('\view\admin\adminUtils.php');
            break;
        }
       
    break;
    
    case 'deleteUser':
        $selectedEmail = filter_input(INPUT_POST, 'selectEmail');
        $selectAdmin = filter_input(INPUT_POST, 'selectAdmin');
        
        $success = deleteUser($selectedEmail, $selectAdmin);
        
        if($success)
            {
                $message = "User was successfully deleted from the database";
                $adminUsers = getAdminUsers();
                $locations = getLocations();
                $types = getTypes();
                include('\view\admin\adminUtils.php');
                break;
            }
            else
            {
                $message = "User could not be deleted at this time";
                $adminUsers = getAdminUsers();
                $locations = getLocations();
                $types = getTypes();
                include('\view\admin\adminUtils.php');
                break;
            }
    break;
    
    case 'assignItem':
        $adminUsers = getAdminUsers();
        $locations = getLocations();
        $types = getTypes();
        $lasts = getLasts();
        include('view/admin/itemAssignment.php');
        break;
    
    case 'viewUser':
        $empID = filter_input(INPUT_GET, 'empID');
        $user = getUserFull($empID);
        $adminUsers = getAdminUsers();
        $locations = getLocations();
        $types = getTypes();
        include('\view\admin\viewUser.php');
        break;
}   
?>