<?php

$salt = "some-salt-salty-kdfjj545oidf444idfji84f8dsf4";

function change_profile_image($user_id, $file_temp, $file_extn) {
    $file_path = 'images/profile/' . substr(sha1($salt . time()), 0, 10) . '.' . $file_extn; //making the random image name for user
    move_uploaded_file($file_temp, $file_path);
    mysql_query("UPDATE `users`SET `profile` = '" . mysql_real_escape_string($file_path) . "' WHERE `user_id` = " . (int)$user_id);
}

function mail_users($subject, $body) {
    $query = mysql_query("SELECT `email`, `first_name` FROM `users` WHERE `allow_email` = 1");
    while ($row = mysql_fetch_assoc($query) !== FALSE) {       
        
        email($row['email'], $subject, "hello " . $row['first_name'] . ",\n\n" . $body);        
    }
}

function has_access($user_id, $type) {
    $user_id = (int)$user_id;
    $type    = (int)$type;
    
    
    return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_id` = $user_id AND `type` = $type"), 0) == 1) ? TRUE : FALSE;   
}


function recover($mode, $email) {
    $mode       = sanitize($mode);
    $email      = sanitize($email);
    
    $user_data = user_data(user_id_from_email($email), 'user_id', 'first_name', 'username');
    
    if ($mode == 'username') {
        //recover username
        email($email, 'your username', "hello " . $user_data['first_name'] . ", \n\n your username is: " . $user_data['username'] . "\n\n -vandenhoven nokah");
        
    } else if ($mode == 'password') {
        //recover password
        $generated_password = substr(sha1($salt . rand(999, 999999)), 0, 8);
        change_password($user_data['user_id'], $generated_password);
        
        update_user($user_data['user_id'], array('password_recover' => '1'));
        
        email($email, 'your password recovery', "hello " . $user_data['first_name'] . ", \n\n your new password is: " . $generated_password . "\n\n -vandenhoven nokah");
        
        
        
    }   
}

function update_user($user_id, $update_data) {	
	$update =  array();
    array_walk($update_data, 'array_sanitize');
	
	foreach ($update_data as $field=>$data) {
		$update[] = '`' . $field . '` = \'' . $data . '\'';
	}
	
	mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $user_id") or die(mysql_error());
    
    
}




function activate($email, $email_code) {
    $email         = mysql_real_escape_string($email);
    $email_code    = mysql_real_escape_string($email_code);
    
    if (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `email_code` = '$email_code' AND `active` = 0"), 0) == 1) {
        //query  to updat user active status
        mysql_query("UPDATE `users` SET `active` = 1 WHERE `email` = '$email'");        
    }  else {
        return FALSE;       
    }    
}

function change_password($user_id, $password) {
    $user_id = (int)$user_id;
    $password = sha1($salt . $password);
    
    mysql_query("UPDATE `users` SET `password` = '$password', `password_recover` = 0 WHERE `user_id` = $user_id");    
}

function register_user($register_data) {
    array_walk($register_data, 'array_sanitize');
    $register_data['password'] = sha1($salt .($register_data['password']));
    
    $fields = '`' . implode('`, `', array_keys($register_data)) . '`';
    //echo $data;
    $data  =  '\'' . implode('\', \'', $register_data) . '\'';    
    
    mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
    email($register_data['email'], 'activate your account', "hello " . $register_data['first_name'] . ",\n\n You need to activate your account, so use the link below: \n\n
        
        http://diskstation/loginandregister/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] ."\n\n\n\n\n
            
        -vandenhoven nokah
        

        
            
        
        

        ");
    
}



function user_count() {
    //$query = "SELECT COUNT(`user_id`) FROM `users` WHERE `active` = 1";
    return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `active` = 1"), 0);
    
}

function user_data($user_id) {
    $data =  array();
    $user_id = (int)$user_id;
    
    $func_num_args = func_num_args();
    $func_get_args = func_get_args();
    
    if ($func_get_args > 1) {
        unset($func_get_args[0]);
        
        $fields = '`' . implode('`, `', $func_get_args) . '`';        
        $data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id"));
        
        return $data;        
    }
    
}

function logged_in() {
    return (isset($_SESSION['user_id'])) ?  TRUE : FALSE;    
}

function email_exists($email) {
    $email = sanitize($email);
    $query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'");
    return(mysql_result($query, 0) == 1) ?  TRUE : FALSE;    
}


function user_exists($username) {
    $username = sanitize($username);
    $query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'");
    return(mysql_result($query, 0) == 1) ?  TRUE : FALSE;    
}

function user_active($username) {
    $username = sanitize($username);
    $query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'  AND `ACTIVE` = 1");
    return(mysql_result($query, 0) == 1) ?  TRUE : FALSE;    
}

function user_id_from_username($username) {
    $username = sanitize($username);
    //$query = mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'");
    return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'"), 0, 'user_id');    
}

function user_id_from_email($email) {
    $email = sanitize($email);
    //$query = mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'");
    return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `email` = '$email'"), 0, 'user_id');    
}

function login($username, $password) 
{
    $user_id = user_id_from_username($username);    
    $username = sanitize($username);
    $password = sha1($salt . $password);   
    //$query = "SELECT COUNT(`user_id`) FROM `users`  WHERE `username` = '$username' AND `password` = '$password'";
    return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users`  WHERE `username` = '$username' AND `password` = '$password'"), 0) == 1) ? $user_id : FALSE;   
}


// function select countries
function select_country() {
    
}

?>
