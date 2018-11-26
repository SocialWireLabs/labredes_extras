<?php
/*
 * © Copyright by Laboratorio de Redes 2011—2012
 */

/*
 * Function to get admin users
 */

function labredes_extras_get_admin_users() {
    $admins = array();
    
    $batch = new ElggBatch(elgg_get_admins, array('limit' => 0));
    
    foreach($batch as $admin_user)
        $admins[$admin_user->getGUID()] = $admin_user->name;
    
    return $admins;
}

/*
 * Function to get site email
 */

function labredes_extras_get_site_email(ElggSite $site = null) {
    $site_guid = 0;
    
    if ($site != null)
        $site_guid = $site->getGUID();
    
    return elgg_get_config('siteemail', $site_guid);    
}

/* Runs the function in the system locale */
function labredes_do_in_locale($function) {
    $args = func_get_args();

    if ($args && is_array($args)) {
        /* Get locale code based on current language */
        $code = elgg_echo('labredes_extras:locale');        
        if (!isset($code)) {
            $code = 'C';
        }
        $old_locale = setlocale(LC_ALL, 0);
        setlocale(LC_ALL, $code);

        // Remove the first parameter... the function to call.
        unset($args[0]);
        $res = call_user_func_array($function, $args);

        setlocale(LC_ALL, $old_locale);

        return $res;
    }

    return false;
}
