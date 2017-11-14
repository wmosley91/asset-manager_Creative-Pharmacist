<?php
//This file provides methods that will be utilized throughout the ADMIN Side of the application
require_once('/../model/adminUtilsDB.php');

function checkIfFieldValueExists($field, $value)
{
    
    $exists = false;
    
    switch($field)
    {
        case 'type':
            $types = getTypes();
            foreach($types as $existingType)
            {
                if($value == $existingType['type'])
                {
                    $exists = true;
                    return $exists;
                    break;
                }
                else
                {
                    $exists = false;
                }
            }
            return $exists;
        break;
        
        case 'make':
            $makes = getMakes();
            foreach($makes as $existingMake)
            {
                if($value == $existingMake['make'])
                {
                    $exists = true;
                    return $exists;
                    break;
                }
                else
                {
                    $exists = false;
                }
            }
            return $exists;
        break;
        
        case 'model':
            $models = getModels();
            foreach($models as $existingModel)
            {
                if($value == $existingModel['model'])
                {
                    $exists = true;
                    return $exists;
                    break;
                }
                else
                {
                    $exists = false;
                }
            }
            return $exists;
        break;
    }
    
}

?>

