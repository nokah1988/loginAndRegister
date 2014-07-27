<?php 
include 'core/init.php';
protect_page();
include('includes/overall/overallheader.php');

if (empty($_POST) === FALSE) {
	$required_fields =  array('first_name', 'email'); //dit bekijkt welke gegevens moeten gevalideerd worden
	foreach($_POST as $key=>$value) {
         if (empty($value) && in_array($key, $required_fields) ===  TRUE) {
             $errors[] = "fields with * are required";
             break 1;            
         }                
     }
	 
	 if (empty($errors) === TRUE) {
		 if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === FALSE) {
			 $errors[] = "A valid email adress is required"; 			 
		 }
		 else if(email_exists($_POST['email']) === TRUE && $user_data['email'] !== $_POST['email']) {
			 $errors[] = 'Sorry, the email \'' . $_POST['email'] . '\' is already in use.';
		 } 
		 
		 
	}	
	//print_r($errors);	 	
}


?>


<h2>Settings</h2>
<?php
if (isset($_GET['success']) === TRUE && empty($_GET['success']) === TRUE) {
    echo 'Your details has been updated successfully';
} else{

if (empty($_POST) === FALSE && empty($errors)  === TRUE){        
        
	///update user settings
	$update_data =  array(
		'first_name'    => $_POST['first_name'],
		'last_name'     => $_POST['last_name'],
		'email'     	=> $_POST['email'],
                'allow_email'   => ($_POST['allow_email'] == 'on') ? 1 : 0
                
	);
	
	//print_r($update_data);
	
	update_user($session_user_id, $update_data);
	header('location: settings.php?success');
	exit();
	
	
} else if (empty($errors) === FALSE) {
	echo output_errors($errors);	
	}
	
	


?>


<form action="" method="post">
	<ul>
    	<li>
        	Firstname*:<br>
            <input type="text" name="first_name"  value="<?php echo($user_data['first_name']); ?>">
        </li>
        <li>
        	Lastname:<br>
            <input type="text" name="last_name" value="<?php echo($user_data['last_name']); ?>">
        </li>
        <li>
        	Email*:<br>
            <input type="text" name="email" value="<?php echo($user_data['email']); ?>">
        </li>
        <li>        	
            <input type="checkbox" name="allow_email" <?php if ($user_data['allow_email'] == 1) {echo 'checked="checked"';}  ?>> Would you like receive or newsletter?
        </li>
        <li>        	
            <input type="submit" value="update">
        </li>
    </ul>

</form>




<?php
}
include('includes/overall/overallfooter.php');
?>

