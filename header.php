<?php
    // Default corner image
    $corner_image = "images/user_male.jpg";

    if (isset($USER)) {
        // Check if user has a valid profile image path and the file exists
        if (!empty($USER['profile_image']) && file_exists($USER['profile_image'])) {
            $image_class = new Image();
            $corner_image = $image_class->get_thumb_profile($USER['profile_image']); // Generate and use thumbnail
        } else {
            // Fallback based on gender
            if ($USER['gender'] == "Female") {
                $corner_image = "images/user_female.jpg";
            }
        }
    }
?>


<div id="blue_bar">
    <form method="get" action="search.php">
        <div style="width: 800px; margin: auto; font-size: 30px;">
        <a style="color: white; text-decoration: none;" href="index.php">MyBook</a> 

    
        
            &nbsp &nbsp <input type="text" id="search_box" name='find' placeholder="Search....">
        
        

        <a href="profile.php">
            <img src="<?php echo htmlspecialchars($corner_image); ?>" style="width:50px; float: right; border-radius: 50%;">
        </a>

        <a href="logout.php">
            <span style="font-size:11px; float: right; margin:10px; color:white;">Logout</span>
        </a>

    </div>
    </form>
</div>
