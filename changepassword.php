<?php 
include 'core/init.php';
protect_page();
 
/*$salt = "some-salt-salty-kdfjj545oidf444idfji84f8dsf4"; */
if (empty($_POST) ===  FALSE) {
    $required_fields =  array('current_password', 'password', 'password_again');
    foreach($_POST as $key=>$value) {
         if (empty($value) && in_array($key, $required_fields) ===  TRUE) {
             $errors[] = "fields with * are required";
             break 1;            
         }                
     }
     if (sha1($_POST['current_password']) === $user_data['password']) {
         if (trim($_POST['password']) !== trim($_POST['password_again'])) {
             $errors[] = "your new passwords do not match";             
         }elseif (strlen($_POST['password']) < 6) {
             $errors[] = "your password must be at least 6 characters long";            
        }
         
     }  else {
         $errors[] = "your current password is incorrect";
     }
     //print_r($errors);
         
     
    
}



include 'includes/overall/overallheader.php';
?>

<h1>Change password</h1>
<?php
if (isset($_GET['success']) === TRUE && empty($_GET['success']) === TRUE) {
    echo 'your password has been changed!';   
} else { 
    if (isset($_GET['force']) === TRUE && empty($_GET['force']) === TRUE) {
        
    ?>

<p>you must change your password now that you've requested a new password !!</p>

    <?php 
    
    }
    
    if (empty($_POST) === FALSE && empty($errors) === TRUE) {
            //change password posted the form and no errors !!
        change_password($session_user_id, $_POST['password']);
        header('location: changepassword.php?success');
            }
            
    else if (empty($errors) === FALSE) {
            //output errors
        echo output_errors($errors);    
        }
        

    ?>


    <form action="" method="post">
        <ul>
            <li>
                Current password*:<br>
                <input type="password" name="current_password">
            </li>
            <li>
                New password*:<br>
                <input type="password" name="password">
            </li>
            <li>
                New password again*:<br>
                <input type="password" name="password_again">
            </li>
            <li>
                <input type="submit" value="change password">
            </li>
        </ul>
    </form>
 


<?php 
}

include 'includes/overall/overallfooter.php'; ?>
    