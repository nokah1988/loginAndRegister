<?php
include 'core/init.php';
include 'includes/overall/overallheader.php';
include_once 'core/functions/users.php';
?>

<h1>Join Our Newsletter System</h1>

<?php
    if (!isset($_POST['subscribe']))
        {
            $email = strip_tags($_POST['email']);

        if ($email){
            if (strstr($email, "@") && strstr($email, "."))
                {
                    mysql_query("INSERT INTO `newsletter` VALUES('', '$email', '1')");                    
                    echo 'You have been successfully added to our newsletter system'; 
                }
            else
                echo 'You need to submit a valid email address';
            }
        }
?>

<form action="" method="post">
    <ul>
        <li>Email*:<br> <input type="text" name="email"></li>
        <li> <input type="submit" value="Subscribe"></li>
    </ul>
</form>

<?php include 'includes/overall/overallfooter.php'; ?>