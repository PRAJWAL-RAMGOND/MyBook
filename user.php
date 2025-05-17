<div id="friends">
    <?php
        require_once("classes/Image.php"); // only included once, no duplicate class error
        $image_class = new Image();

        $image = "images/user_male.jpg"; 
        if (isset($FRIEND_ROW['gender']) && strtolower($FRIEND_ROW['gender']) === "female") {
            $image = "images/user_female.jpg";
        }
        if (file_exists($FRIEND_ROW['profile_image'])) {
            $image = $image_class->get_thumb_profile($FRIEND_ROW['profile_image']);
        } 
    ?>  

    <a href="profile.php?id=<?php echo $FRIEND_ROW['userid']; ?>">
        <img id="friends_img" src="<?php echo $image ?>"><br>
        <?php echo $FRIEND_ROW['first_name'] . " " . $FRIEND_ROW['last_name'] ?>
    </a>
</div>
