<?php
require_once('databaseConnect.php');

if (!isset($field)){$field = filter_input(INPUT_POST, 'field');}

if ($field == NULL)
{
    $field = filter_input(INPUT_GET, 'field');
}

switch($field)
{
    case 'addType':
        global $db;
        $type = filter_input(INPUT_GET, 'type');
        
        $query = 'SELECT DISTINCT make FROM assets WHERE type = :type';
        $statement = $db->prepare($query);
        $statement->bindValue(':type', $type);
        $statement->execute();
        $makes = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($makes);
        break;
    
    case 'addMake':
        global $db;
        $make = filter_input(INPUT_GET, 'make');
        $type = filter_input(INPUT_GET, 'type');
        
        $query = 'SELECT model FROM assets WHERE type = :type AND make = :make';
        $statement = $db->prepare($query);
        $statement->bindValue(':make', $make);
        $statement->bindValue(':type', $type);
        $statement->execute();
        $models = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($models);
        break;
    
    case 'addLife':
        global $db;
        $model = filter_input(INPUT_GET, 'model');
        
        $query = 'SELECT life_cycle FROM assets WHERE model = :model';
        $statement = $db->prepare($query);
        $statement->bindValue(':model', $model);
        $statement->execute();
        $life = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($life);
        break;
    
    case 'addSerial':
        global $db;
        $model = filter_input(INPUT_GET, 'model');
        
        $query = 'SELECT serial_num FROM all_items WHERE model = :model';
        $statement = $db->prepare($query);
        $statement->bindValue(':model', $model);
        $statement->execute();
        $serial = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($serial);
        break;
    
    case 'addSerialU':
        global $db;
        $model = filter_input(INPUT_GET, 'model');
        
        $query = 'SELECT serial_num FROM all_items WHERE model = :model and assigned = "u"';
        $statement = $db->prepare($query);
        $statement->bindValue(':model', $model);
        $statement->execute();
        $serials = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($serials);
        break;
    
    case 'addDateCostVendor':
        global $db;
        $serial = filter_input(INPUT_GET, 'serial');
        
        $query = 'SELECT entered_into_service, cost, vendor, location.location_num, address, description FROM all_items, location WHERE serial_num = :serial AND location.location_num = all_items.location_num';
        $statement = $db->prepare($query);
        $statement->bindValue(':serial', $serial);
        $statement->execute();
        $dateCostVendor = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($dateCostVendor);
        break;
    
    case 'addItemNum':
        global $db;
        $serial = filter_input(INPUT_GET, 'serial');
        
        $query = 'SELECT item_num FROM all_items WHERE serial_num = :serial';
        $statement = $db->prepare($query);
        $statement->bindValue(':serial', $serial);
        $statement->execute();
        $itemNum = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($itemNum);
        break;
    
    case 'default':
        global $db;
        
        $query = 'SELECT DISTINCT type FROM assets';
        $statement = $db->prepare($query);
        $statement->execute();
        $types = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($types);
        break;
    
    case 'addLastName':
        global $db;
        
        $query = 'SELECT l_name FROM employee WHERE status = "BASIC"';
        $statement = $db->prepare($query);
        $statement->execute();
        $lNames = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($lNames);
        break;
    
    case 'addFirstName':
        global $db;
        $lName = filter_input(INPUT_GET, 'lName');
        
        $query = 'SELECT f_name FROM employee WHERE status = "BASIC" AND l_name = :lname';
        $statement = $db->prepare($query);
        $statement->bindValue(':lname', $lName);
        $statement->execute();
        $fNames = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($fNames);
        break;
    
    case 'addFirstNameU':
        global $db;
        $lName = filter_input(INPUT_GET, 'lName');
        
        $query = 'SELECT f_name FROM employee WHERE l_name = :lname';
        $statement = $db->prepare($query);
        $statement->bindValue(':lname', $lName);
        $statement->execute();
        $fNames = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($fNames);
        break;
    
    case 'addEmail':
        global $db;
        $lName = filter_input(INPUT_GET, 'lName');
        $fName = filter_input(INPUT_GET, 'fName');
        
        $query = 'SELECT email FROM employee WHERE status = "BASIC" AND l_name = :lname AND f_name = :fname';
        $statement = $db->prepare($query);
        $statement->bindValue(':fname', $fName);
        $statement->bindValue(':lname', $lName);
        $statement->execute();
        $emails = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($emails);
        break;
    
    case 'addEmailU':
        global $db;
        $lName = filter_input(INPUT_GET, 'lName');
        $fName = filter_input(INPUT_GET, 'fName');
        
        $query = 'SELECT email FROM employee WHERE l_name = :lname AND f_name = :fname';
        $statement = $db->prepare($query);
        $statement->bindValue(':fname', $fName);
        $statement->bindValue(':lname', $lName);
        $statement->execute();
        $emails = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($emails);
        break;
    
    case 'addUserInfo':
        global $db;
        $email = filter_input(INPUT_GET, 'email');
        
        $query = 'SELECT address, phone_num, location_num, emp_id, admin_emp_id FROM employee, hierarchy WHERE email = :email AND employee.emp_id = hierarchy.basic_emp_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $info = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($info);
        break;
    
    case 'addAdmin':
        global $db;
        
        $query = 'SELECT emp_id FROM employee WHERE status = "ADMIN"';
        $statement = $db->prepare($query);
        $statement->execute();
        $admins = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($admins);
        break;
    
    case 'addLocation':
        global $db;
        
        $query = 'SELECT location_num, address, description FROM location';
        $statement = $db->prepare($query);
        $statement->execute();
        $locations = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($locations);
        break;
    
    case 'addUserItems':
        global $db;
        $email = filter_input(INPUT_GET, 'email');
        
        $query = 'select serial_num, make, model from all_items where item_num in (select item_num from user_assets where emp_id in (select emp_id from employee where email = :email))';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $userItems = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($userItems);
        break;
    
    case 'getEmpId':
        global $db;
        $email = filter_input(INPUT_GET, 'email');
        
        $query = 'select emp_id from employee where email = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $empID = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($empID);
        break;
    
    case 'assignItem':
        global $db;
        $empID = filter_input(INPUT_GET, 'empID');
        $item_num = filter_input(INPUT_GET, 'item_num');
        
        $query = 'insert into user_assets values(:empID, :item_num)';
        $statement = $db->prepare($query);
        $statement->bindValue(':empID', $empID);
        $statement->bindValue(':item_num', $item_num);
        $success = $statement->execute();
        if ($success)
        {
            $message = 'success';
        }
        else
        {
            $message = 'failed';
        }
        $statement->closeCursor();
        echo json_encode($message);
        break;
        
        case 'removeItem':
        global $db;
        $item_num = filter_input(INPUT_GET, 'item_num');
        
        $query = 'delete from user_assets where item_num = :item_num';
        $statement = $db->prepare($query);
        $statement->bindValue(':item_num', $item_num);
        $success = $statement->execute();
        if ($success)
        {
            $message = 'success';
        }
        else
        {
            $message = 'failed';
        }
        $statement->closeCursor();
        echo json_encode($message);
        break;
        
    case 'getItemInfo':
        global $db;
        $item = filter_input(INPUT_GET, 'item');
        
        $query = 'select * from all_items where item_num = :item';
        $statement = $db->prepare($query);
        $statement->bindValue(':item', $item);
        $statement->execute();
        $info = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($info);
        break;
    
    case 'getLocationDescription':
        global $db;
        $num = filter_input(INPUT_GET, 'num');
        
        $query = 'select description from location where location_num = :num';
        $statement = $db->prepare($query);
        $statement->bindValue(':num', $num);
        $statement->execute();
        $description = $statement->fetch();
        $statement->closeCursor();
        echo json_encode($description);
        break;
    
    case 'getImage':
        global $db;
        $type = filter_input(INPUT_GET, 'type');
        $make = filter_input(INPUT_GET, 'make');
        $model = filter_input(INPUT_GET, 'model');
        
        $query = 'select image from assets where type = :type and make = :make and model = :model';
        $statement = $db->prepare($query);
        $statement->bindValue(':type', $type);
        $statement->bindValue(':make', $make);
        $statement->bindValue(':model', $model);
        $statement->execute();
        $image = $statement->fetch();
        $statement->closeCursor();
        echo json_encode($image);
        break;
    
    case 'masterItems':
        global $db;
        
        $query = 'select * from all_items order by item_num';
        $statement = $db->prepare($query);
        $statement->execute();
        $items = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($items);
        break;
    
    case 'masterUsers':
        global $db;
        
        $query = 'select * from employee order by l_name';
        $statement = $db->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($users);
        break;
    
    case 'checkSerials':
        global $db;
        $serial = filter_input(INPUT_GET, "serial");
        
        $query = 'select serial_num from all_items where serial_num = :serial';
        $statement = $db->prepare($query);
        $statement->bindValue(":serial", $serial);
        $statement->execute();
        $serials = $statement->fetch();
        $statement->closeCursor();
        echo json_encode($serials);
        break;
    
    case 'addTypeIA':
        global $db;
        $type = filter_input(INPUT_GET, 'type');
        
        $query = "select distinct make from all_items where type = :type and make in (select make from all_items where assigned = 'u')";
        $statement = $db->prepare($query);
        $statement->bindValue(':type', $type);
        $statement->execute();
        $makes = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($makes);
        break;
    
    case 'addMakeIA':
        global $db;
        $make = filter_input(INPUT_GET, 'make');
        
        $query = 'SELECT distinct model FROM all_items WHERE make = :make and model in (select model from all_items where assigned = "u")';
        $statement = $db->prepare($query);
        $statement->bindValue(':make', $make);
        $statement->execute();
        $models = $statement->fetchAll();
        $statement->closeCursor();
        echo json_encode($models);
        break;
}

?>

