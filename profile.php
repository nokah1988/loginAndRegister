<?php 
include 'core/init.php'; 
include 'includes/overall/overallheader.php';

if (isset($_GET['username']) === TRUE && empty($_GET['username']) === FALSE) {
    $username       = $_GET['username'];
    
    if (user_exists($username) ===  TRUE) {   
    $user_id        = user_id_from_username($username);  
    
    $profile_data   = user_data($user_id, 'first_name', 'last_name', "email");
   ?>
    
    <h1><?php echo $profile_data['first_name']; ?>'s profile</h1>    
        <p>Email: <?php echo $profile_data['email']; ?></p>
        



    <?php    
    } else {
        echo 'sorry that username doesn\'t exists';       
    }   
    
} else {
    header('location: index.php');
    exit();
}

include 'includes/overall/overallfooter.php'; 
?>
    