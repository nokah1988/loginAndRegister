<?php 
include 'core/init.php';
logged_in_redirect();
include 'includes/overall/overallheader.php';

 if (empty($_POST) === FALSE) {
     $required_fields =  array('username', 'password', 'password_again', 'first_name', 'email'); //dit bekijkt welke gegevens moeten gevalideerd worden 
     foreach($_POST as $key=>$value) {
         if (empty($value) && in_array($key, $required_fields) ===  TRUE) {
             $errors[] = "fields with * are required";
             break 1;            
         }                
     }
     if (empty($errors) === TRUE) {
         if (user_exists($_POST['username']) === TRUE) {
             $errors[] = 'Sorry, the username \'' . $_POST['username'] . '\' is already taken.';             
         }
         if (preg_match("/\\s/", $_POST['username']) == TRUE) { // dit is voor te kijken of er spaties voorkomen
             $errors[] = "your usernamen must not contain any spaces";             
         }
         
         if (strlen($_POST['password']) < 6) {
             $errors[] = "your password must be at least 6 characters long";             
         }
         if ($_POST['password'] !== $_POST['password_again']) {
              $errors[] = "your passwords doesn't match";            
         }
         if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === FALSE) {
             $errors[] = "A valid email adress is required";             
         }
         if (email_exists($_POST['email']) === TRUE) {
             $errors[] = 'Sorry, the email \'' . $_POST['email'] . '\' is already in use.';          
         }
     }
}

//print_r($errors);


?>

<h1>Register</h1>

<?php

if (isset($_GET['success']) && empty($_GET['success'])) {
    echo 'you \'ve been registered successfully!, please read you email for activating your account!!';
    
} else {   

    if (empty($_POST) === FALSE && empty($errors) === TRUE) {
        //register user
        $register_data = array(
            'username'     => $_POST['username'],
            'password'     => $_POST['password'],
            'first_name'   => $_POST['first_name'],
            'last_name'    => $_POST['last_name'],            
            'email'        => $_POST['email'],
            'email_code'   => md5($_POST['username'] + microtime())
        );
        register_user($register_data);
        //redirect user
        header('location: register.php?success');
        exit();



    }  else if (empty($errors) === FALSE) {
        //output errors
        echo output_errors($errors);    
    }



    ?>
    <form action="" method="post">
        <ul>
            <li>
                Username*:<br>
                <input type="text" name="username">
            </li>
            <li>
                Password*:<br>
                <input type="password" name="password">
            </li>
            <li>
                Password again*:<br>
                <input type="password" name="password_again">
            </li>
            <li>
                First name*:<br>
                <input type="text" name="first_name">
            </li>
            <li>
                 Last name:<br>
                <input type="text" name="last_name">
            </li>
            <li>
                Email*:<br>
                <input type="text" name="email">
            </li>
            <li>           
                <input type="submit" value="Register">
            </li>       
        </ul>    
    </form>


<?php 
}

include 'includes/overall/overallfooter.php'; ?>