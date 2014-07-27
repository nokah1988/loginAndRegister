<?php
include 'core/init.php';
logged_in_redirect();
include 'includes/overall/overallheader.php';

if (isset($_GET['success']) === TRUE && empty($_GET['success']) === true) {
?>

<h2>thanks, you have activating your account ...</h2>
<p>you'r free to log in </p>

<?php
    
    
}else if (isset($_GET['email'], $_GET['email_code']) === TRUE) {
    
    $email          = trim($_GET['email']);
    $email_code     = trim($_GET['email_code']);
    
    if (email_exists($email) === FALSE) {
        $errors[] = "oops, somethin went wrong, and we couldn't find that email adress";        
    } else if (activate($email, $email_code) === FALSE) {
        $errors[] = "we had problems activating your account, please check your emails for activate your account";
        
        }
    if (empty($errors) === FALSE) {
    ?>

        <h2>Oops...</h2>       

   <?php
        echo output_errors($errors); 
        
    } else {
        header('location: activate.php?success');
        exit();
        } 
}
      else {
        header('location: index.php');
    }

        
    
    

include 'includes/overall/overallfooter.php'; 
?>