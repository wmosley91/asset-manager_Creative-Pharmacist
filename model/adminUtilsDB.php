<?php
require_once('databaseConnect.php');
require_once('/../admin/adminMethods.php');


//THESE ARE FUNCTIONS YOU CAN USE TO RETRIEVE ARRAYS OF DIFFERENT THINGS
function getLasts()
{
    global $db;
    
    $query = 'select l_name from employee';
    $statement = $db->prepare($query);
    $statement->execute();
    $lasts = $statement->fetchAll();
    $statement->closeCursor();
    return $lasts;
}

function getTypes()
{
    global $db;
    
    $query = 'SELECT * FROM category';
    $statement = $db->prepare($query);
    $statement->execute();
    $types = $statement->fetchAll();
    $statement->closeCursor();
    return $types;
    
}

function getMakes()
{
    global $db;
    
    $query = 'SELECT make FROM assets';
    $statement = $db->prepare($query);
    $statement->execute();
    $makes = $statement->fetchAll();
    $statement->closeCursor();
    return $makes;
}

function getModels()
{
    global $db;
    
    $query = 'SELECT model FROM assets';
    $statement = $db->prepare($query);
    $statement->execute();
    $models = $statement->fetchAll();
    $statement->closeCursor();
    return $models;
}

function getAdminUsers()
{
    global $db;
    
    $query = 'SELECT f_name, l_name, emp_id FROM employee WHERE status="ADMIN"';
    $statement = $db->prepare($query);
    $statement->execute();
    $adminUsers = $statement->fetchAll();
    $statement->closeCursor();
    return $adminUsers;
}

function getLocations()
{
    global $db;
    
    $query = 'SELECT location_num, address FROM location';
    $statement = $db->prepare($query);
    $statement->execute();
    $locations = $statement->fetchAll();
    $statement->closeCursor();
    return $locations;
}

function getUser($email)
{
    global $db;
    
    $query = 'SELECT f_name, l_name, emp_id FROM employee WHERE email=:email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    return $user;
}

function getUserFull($empID)
{
    global $db;
    
    $query = 'select * from employee where emp_id = :empID';
    $statement = $db->prepare($query);
    $statement->bindValue(':empID', $empID);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    return $user;
}

//ADDING, UPDATING AND DELETING AN ITEM STARTS HERE
function addItem($type, $make, $model, $serialNumber, $date, $life, $cost, $vendor, $location_num)
{
    global $db;
    $assigned = "u";
    $query = 'INSERT INTO all_items (entered_into_service, serial_num, type, make, model, location_num, cost, assigned, vendor)'
            . ' VALUES (:entered_into_service, :serial_num, :type, :make, :model, :location_num, :cost, :assigned, :vendor)';
    $statement = $db->prepare($query);
    $statement->bindValue(':entered_into_service', $date);
    $statement->bindValue(':serial_num', $serialNumber);
    $statement->bindValue(':type', $type);
    $statement->bindValue(':make', $make);
    $statement->bindValue(':model', $model);
    $statement->bindValue(':location_num', $location_num);
    $statement->bindValue(':cost', $cost);
    $statement->bindValue(':assigned', $assigned);
    $statement->bindValue(':vendor', $vendor);
    $success = $statement->execute();
    $statement->closeCursor();
    if($success)
    {
        //Checks to see if the enter type already exists in the database
        $typeAlreadyExists = checkIfFieldValueExists("type", $type);
        if($typeAlreadyExists)
        {
            $makeAlreadyExists = checkIfFieldValueExists("make", $make);
            if($makeAlreadyExists)
            {
                $modelAlreadyExists = checkIfFieldValueExists("model", $model);
                if(!$modelAlreadyExists)
                {
                    addAsset($type, $make, $model, $vendor, $life);
                }
            }
            else
            {
                addAsset($type, $make, $model, $vendor, $life);
            }
        }

        //If type does not exist it will be entered into the category table
        if($typeAlreadyExists == false)
        {
            addCategory($type);
            addAsset($type, $make, $model, $vendor, $life);
        }
        return $success;
    }
    else
    {
        return $success;
    }
    
}

function getItem($item_num)
{
    global $db;
            
    $query = 'SELECT * FROM all_items WHERE item_num = :item_num';
    $statement = $db->prepare($query);
    $statement->bindValue(':item_num', $item_num);
    $statement->execute();
    $item = $statement->fetch();
    $statement->closeCursor();
    return $item;
}


function updateItem($type, $make, $model, $serialNumber, $date, $cost, $vendor, $itemNum, $life_cycle)
{
    global $db;
    $query = 'UPDATE all_items 
                     SET entered_into_service = :date, serial_num = :serialNumber, type = :type, make = :make, model = :model, cost = :cost, vendor = :vendor WHERE item_Num = :itemNum';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':date', $date);
    $statement->bindValue(':serialNumber', $serialNumber);
    $statement->bindValue(':type', $type);
    $statement->bindValue(':make', $make);
    $statement->bindValue(':model', $model);
    $statement->bindValue(':cost', $cost);
    $statement->bindValue(':vendor', $vendor);
    $statement->bindValue(':itemNum', $itemNum);
    $success = $statement->execute();
    $statement->closeCursor();
    
    updateAsset($type, $make, $model, $life_cycle);
    return $success;
}

function updateAsset($type, $make, $model, $life_cycle)
{
    global $db;
    $query = 'UPDATE assets SET life_cycle = :life_cycle WHERE type = :type AND make = :make AND model = :model';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':type', $type);
    $statement->bindValue(':make', $make);
    $statement->bindValue(':model', $model);
    $statement->bindValue(':life_cycle', $life_cycle);
    $success = $statement->execute();
    $statement->closeCursor();
}

function deleteItem($itemNum)
{
    global $db;
    $query = 'DELETE FROM all_items WHERE item_Num = :itemNum';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':itemNum', $itemNum);
    $statement->execute();
    $statement->closeCursor();
    
    $checkItemDeleted = getItem($itemNum); 
    
    if(!$checkItemDeleted)
    {
        $success = true;
    }
    else
    {
        $success = false;
    }
    
    return $success;
}

function addAsset($type, $make, $model, $vendor, $life)
{
    global $db;

    $query = 'INSERT INTO assets (type, make, model, life_cycle)'
            . 'VALUES (:type, :make, :model, :life)';
    $statement = $db->prepare($query);
    $statement->bindValue(':type', $type);
    $statement->bindValue(':make', $make);
    $statement->bindValue(':model', $model);
    $statement->bindValue(':life', $life);
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}

function addCategory($type)
{
    global $db;

    $query = 'INSERT INTO category VALUES (:type)';
    $statement = $db->prepare($query);
    $statement->bindValue(':type', $type);
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}

//ADDING, UPDATING AND DELETING A USER STARTS HERE

function addUser($addLName, $addFName, $addEmail, $addAddress, $addPhone, $assignAdmin, $assignLocation, $password)
{
    global $db;
    $status = 'BASIC';
    
    $query = 'INSERT INTO employee (f_name, l_name, email, password, status, phone_num, address, location_num, assigned)'
            . 'VALUES (:addFName, :addLName, :addEmail, :password, :status, :addPhone, :addAddress, :assignLocation, :assignAdmin)';
    $statement = $db->prepare($query);
    $statement->bindValue(':addFName', $addFName);
    $statement->bindValue(':addLName', $addLName);
    $statement->bindValue(':addEmail', $addEmail);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':status', $status);
    $statement->bindValue(':addPhone', $addPhone);
    $statement->bindValue(':addAddress', $addAddress);
    $statement->bindValue(':assignLocation', $assignLocation);
    $statement->bindValue(':assignAdmin', $assignAdmin);
    $success = $statement->execute();
    $statement->closeCursor();
    
    $user = getUser($addEmail);
    $employeeID = $user['emp_id'];
    
    addHierarchy($employeeID, $assignAdmin);
    
    
    return $success;
}

function updateUser($originalEmail, $selectLName, $selectFName, $selectEmail, $selectAddress, $selectPhone, $selectAdmin, $selectLocation)
{
    global $db;
    
    $query = 'UPDATE employee SET f_name=:selectFName, l_name=:selectLName, email=:selectEmail, address=:selectAddress, phone_num=:selectPhone, location_num=:selectLocation'
            . ' WHERE email=:originalEmail';
            
    $statement = $db->prepare($query);
    $statement->bindValue(':selectFName', $selectFName);
    $statement->bindValue(':selectLName', $selectLName);
    $statement->bindValue(':selectEmail', $selectEmail);
    $statement->bindValue(':selectAddress', $selectAddress);
    $statement->bindValue(':selectPhone', $selectPhone);
    $statement->bindValue(':selectLocation', $selectLocation);
    $statement->bindValue(':originalEmail', $originalEmail);
    $success = $statement->execute();
    $statement->closeCursor();
    
    $user = getUser($originalEmail);
    $employeeID = $user['emp_id'];
    
    updateHierarchy($employeeID, $selectAdmin);
    return $success;
}

function addHierarchy($employeeID, $selectAdmin)
{
    global $db;
    
    $query = 'INSERT INTO hierarchy (admin_emp_id, basic_emp_id) VALUES (:selectAdmin, :employeeID)';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':employeeID', $employeeID);
    $statement->bindValue(':selectAdmin', $selectAdmin);
    $success = $statement->execute();
    $statement->closeCursor();
}

function updateHierarchy($employeeID, $selectAdmin)
{
    global $db;
    
    $query = 'UPDATE hierarchy SET admin_emp_id=:selectAdmin WHERE basic_emp_id=:employeeID';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':employeeID', $employeeID);
    $statement->bindValue(':selectAdmin', $selectAdmin);
    $success = $statement->execute();
    $statement->closeCursor();
}

function deleteUser($email, $selectAdmin)
{
    global $db;
    
    $employee = getUser($email);
    $employeeID = $employee['emp_id'];
    deleteHierarchy($employeeID);
    
    $query = 'DELETE FROM employee WHERE email = :email';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $statement->closeCursor();
    
    $checkUserBeenDeleted = getUser($email);
    
    if(!$checkUserBeenDeleted)
    {
        $success = true;
    }
    else
    {
        $success = false;
    }
    
    return $success;
}

function deleteHierarchy($basic_emp_id)
{
    global $db;
    $query = 'DELETE FROM hierarchy WHERE basic_emp_id = :basic_emp_id';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':basic_emp_id', $basic_emp_id);
    $success = $statement->execute();
    $statement->closeCursor();
}

?>