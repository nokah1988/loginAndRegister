
<div class="widget">
    <h2>Hello, <?php echo $user_data['first_name']; ?>!</h2>
    <div class="inner">
        <div class="profile">
            <?php
            //error_reporting(0); //delete this for uploading to webserver !!!!!!!!!!!!!!
            if (isset($_FILES['profile']) ===  TRUE) {
                if (empty($_FILES['profile']['name']) === TRUE) {
                    echo 'please choose a file';                    
                }
                else {
                    //validation extension of file
                    $allowed = array('jpg', 'jpeg', 'gif', 'png');
                    
                    $file_name = $_FILES['profile']['name'];
                    $file_extn = strtolower(end(explode('.', $file_name)));
                    $file_temp = $_FILES['profile']['tmp_name'];
                    
                    if (in_array($file_extn, $allowed) === TRUE) {
                        //uploading the file 
                        change_profile_image($session_user_id, $file_temp, $file_extn);
                        header('location: ' . $current_file);
                        exit();
                    }
                    else {
                        echo 'incorrect file type. Allowed'; 
                        echo implode(', ', $allowed);
                    }                    
                }
            }
            
            
            
            
            
            
            if (empty($user_data['profile']) === FALSE) {
                echo '<img src="', $user_data['profile'], '" alt="', $user_data['first_name'] , '\'s profile image">';               
            }           
            ?>
            <form action="" method="post" enctype="multipart/form-data"> 
                <input type="file" name="profile"> <input type="submit">
            </form>
            
            
           
        </div>
        <ul>
            <li>
                <a href="logout.php">Log out</a>
            </li>
            <li>
                <a href="<?php echo($user_data['username']); ?>">Profile</a>
            </li> 
            <li>
                <a href="changepassword.php">Change password</a>
            </li>
            <li>
            	<a href="settings.php">Settings</a>
            </li>                      
        </ul>           
    </div>
</div>