<?php 
include 'core/init.php'; 
protect_page();
admin_protect();
include 'includes/overall/overallheader.php';
?>

<h1>Email all users</h1>

<?php
if (isset($_GET['success']) === TRUE && empty($_GET['success']) === TRUE) {
?>

<p>Email has been sent</p>

<?php    
} else {
    
    if (empty($_POST) === FALSE) {
        if (empty($_POST['subject']) === TRUE) {
            $errors[] = "Subject is required";        
        }
        if (empty($_POST['body']) === TRUE) {
            $errors[] = "body is required";   
        }
        if (empty($errors) === FALSE) {
            echo output_errors($errors);        
        }
            else {
            // send email
            mail_users($_POST['subject'], $_POST['body']);           
            
            header('location: mail.php?success');
            exit();
        }    
    }
    
    ?>

    <form action="" method="post">
        <ul>
            <li>
                Subject*:<br>
                <input type="text" name="subject">
            </li>
            <li>
                Body*:<br>
                <textarea name="body"></textarea>
            </li>
            <li>
                <input type="submit" value="send">
            </li>
        </ul>
    </form>
<?php 
}
include 'includes/overall/overallfooter.php'; ?>
    