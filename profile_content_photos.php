<div style="min-height: 400px;width: 100%;background-color: white;text-align: center;">
	<div style="padding: 20px;">
		<?php

				$DB = new Database();
				$sql = "SELECT image, postid FROM posts WHERE has_image = 1 AND userid = " . (int)$user_data['userid'] . " ORDER BY postid DESC";

				$images = $DB->read($sql);
				$image_class = new Image();
				 if(is_array($images))
				 {
				 	foreach ($images as $image_row ) {
				 		echo "<img src='". $image_class->get_thumb_post($image_row['image']) . "' style='width:150px;margin:10px;' />";
				 	}
				 	
				 }
				 else
				 {
				 	echo "No image was found";
				 }


		?>
	</div>
</div>