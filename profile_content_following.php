<div style="min-height: 400px;width: 100%;background-color: white;text-align: center;">
	<div style="padding: 20px;">
		<?php
			$image_class = new Image();
			$post_class = new Post();
			$user_class = new User();

			$following = $user_class->get_following($user_data['userid'], "user");

			if (is_array($following) && count($following) > 0) 
			{
				foreach ($following as $follower) 
				{
					if (isset($follower['userid'])) 
					{
						$FRIEND_ROW = $user_class->get_user($follower['userid']);

						if (is_array($FRIEND_ROW)) 
						{
							include("user.php");
						}
					}
				}
			} 
			else 
			{
				echo "Zero Following";
			}
		?>
	</div>
</div>
