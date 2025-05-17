<div id="post"> 
    <div>
        <?php
            // ✅ Include and instantiate $image_class if not already done
            if (!isset($image_class)) {
                include_once("classes/Image.php");
                $image_class = new Image();
            }

            // ✅ Default profile image logic
            $image = "images/user_male.jpg"; 
            if ($ROW_USER['gender'] == "Female") {
                $image = "images/user_female.jpg";
            }

            // ✅ If a custom profile image exists, use its thumbnail
            if (file_exists($ROW_USER['profile_image'])) {
                $image = $image_class->get_thumb_profile($ROW_USER['profile_image']);
            }
        ?>
        <img src="<?php echo $image ?>" style="width:75px;margin-right: 4px;border-radius: 50%;" alt="User Profile Picture">
    </div>

    <div style="width: 100%">
        <div style="font-weight: bold;color: #405d9b;width: 100%">
            <?php 
                // ✅ Display full name safely
                echo htmlspecialchars($ROW_USER['first_name']) . " " . htmlspecialchars($ROW_USER['last_name']); 

                // ✅ Optional activity status
                if ($ROW['is_profile_image']) {
                    echo "<span style='font-weight:normal;color:#aaa;'> updated their profile image</span>";
                }

                if ($ROW['is_cover_image']) {
                    echo "<span style='font-weight:normal;color:#aaa;'> updated their cover image</span>";
                }
            ?>
        </div>

        <?php 
            // ✅ Output post text safely (only if it's not empty)
            if (!empty($ROW['post'])) {
                echo htmlspecialchars($ROW['post']) . "<br><br>";
            }

            // ✅ If post image exists, show its thumbnail
            if (file_exists($ROW['image'])) {
                $post_image = $image_class->get_thumb_post($ROW['image']);
                echo "<img src='$post_image' style='width:80%;' alt='Post Image' />";
            }
        ?>
    </div>
</div>
