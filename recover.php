<?php 
include 'core/init.php'; 
logged_in_redirect();
include 'includes/overall/overallheader.php';
?>

<h1>Recover</h1>
<?php
if (isset($_GET['success']) === TRUE && empty($_GET['success']) === TRUE) {
?>
    <p>Thanks, w've emailed you. please checked your email!!</p>
    
<?php    
} else {
    $mode_allowed = array('username', 'password');
    if (isset($_GET['mode']) === TRUE && in_array($_GET['mode'], $mode_allowed) ===  TRUE) {
        if (isset($_POST['email']) === TRUE && empty($_POST['email']) === FALSE) {
            if (email_exists($_POST['email']) === TRUE) {
                recover($_GET['mode'], $_POST['email']);
                header('location: recover.php?success');
                exit();
            } else {
                echo '<p>Oops we couldn\'t find that email adress</p>';
            }

        }


    ?>

    <form action="" method="post">
        <ul>
            <li>Please enter your email adress:<br>
                <input type="text" name="email">
            </li>
            <li><input type="submit" value="Recover"></li>
        </ul>
    </form>



    <?php   
    } else {
        header('location: index.php');
        exit();

    }
}



?>

<?php include 'includes/overall/overallfooter.php'; ?>
    