<?php

include 'core/init.php';
logged_in_redirect();

if (empty($_POST) === FALSE) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (empty($username) === TRUE || empty($password) === TRUE) {
        $errors[] = 'you need to enter username and password';        
    } 
    else if (user_exists($username) === FALSE) {
        $errors[] = "we couldn't find that username. Have you registered?";       
    }
    else if (user_active($username) === FALSE){
        $errors[] = "you haven't activating your account";       
    } else {
            if (strlen($password) > 32) {
                $errors[] = "password to long";           
            }   

            $login = login($username, $password);
            if ($login === FALSE) {
                $errors[] = "that username/password combination is incorrect";            
            }
            else {          

                //set the user sesion
                $_SESSION['user_id'] = $login;

                // redirect user to home
                header("location: index.php");
                exit();            
            }        
        }
    //print_r($errors); 
        
} else {
    $errors[] = 'no data recieved';
    
}



include 'includes/overall/overallheader.php';
if (empty($errors) === FALSE) {
?>

<h2> We tried to log you in, but...</h2>
<?php
echo output_errors($errors);


}
include 'includes/overall/overallfooter.php';
?>
