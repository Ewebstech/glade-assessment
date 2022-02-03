<?php

function is_action_permitted($userRole, $localRoles){
    if(!in_array($userRole, $localRoles)){
        return false;
    } else {
        return true;
    }
}
