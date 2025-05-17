<?php
    include("classes/autoload.php");

    // Check login
    $login = new Login();
    $user_data = $login->check_login($_SESSION['mybook_userid']);
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        if(isset($_POST['first_name']))
        {
            $settings_class = new Settings();
            $settings_class->save_settings($_POST,$_SESSION['mybook_userid']);
        }
        else
        {
            $post = new Post();
            $id = $_SESSION['mybook_userid'];
            $result=$post->create_post($id,$_POST,$_FILES);
            
            if($result == "")
            {
                header("Location: index.php");
                die;
            }
            else
            {
                echo "<div style= 'text-align:center;font-size:12px;color:white;background-color:grey;'>";
                echo "<br>The following errors occured:<br><br>";
                echo $result;
                echo "</div>";
            }
        }
            
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Profile | MyBook</title>
</head>
<style type="text/css">
	#blue_bar{
		height: 50px;
		background-color: #405d9b;
		color: #d9dfeb;
	}
	#search_box{
		width:400px;
		height: 20px;
		border-radius: 5px;
		border: none;
		padding: 4px;
		background-image: url(search.png);
		background-repeat: no-repeat;
		background-position: right;
	}
	#profile_pic{
		width: 150px;
		border-radius: 50%;
		border:solid 2px white;
	}
	#menu_buttons{
		width: 100px;
		display: inline-block;
		margin: 2px;
	}
	#friends_img{
		width: 75px;
		float: left;
		margin: 8px;
	}
	#friends_bar{
		min-height: 400px;
		margin-top: 20px;
		color: #888;
		padding: 8px;
		text-align: center;
		font-size: 20px;
		color: #405d9b;
	}
	#friends{
		clear:both;
		font-size: 12px;
		font-weight: bold;
		color: #405d9b;
	}
	textarea{
		width: 100%;
		border: none;
		font-family: tahoma;
		font-size: 14px;
		height:60px;
	}
	#post_button{
		float:right;
		background-color: #405d9b;
		border: none;
		color: white;
		padding: 4px;
		font-size: 14px;
		border-radius: 2px;
		width: 50px;
	}
	#post_bar{
		margin-top: 20px;
		background-color: white;
		padding: 10px;
	}
	#post{
		padding: 4px;
		font-size: 13px;
		display: flex;
		margin-bottom: 20px;
	}
</style>
<body style="font-family: tahoma;background-color: #d0d8e4;">
	<!-- Top bar -->
	<br>
	<?php include("header.php"); ?>

	<!-- Main Container -->
	<div style="width: 800px;margin:auto;min-height: 400px;">
		<div style="display: flex;">
			
			<!-- Sidebar / Profile -->
			<div style="min-height: 400px;flex: 1;">
				<div id="friends_bar">
					<?php 
    $image_class = new Image();

    // fallback image if no profile pic exists
    $profile_image = "images/user_male.jpg";

    if (!empty($user_data['profile_image']) && file_exists($user_data['profile_image'])) {
        $profile_image = $image_class->get_thumb_profile($user_data['profile_image']);
    }
?>
<img src="<?php echo $profile_image ?>" id="profile_pic"><br>

					<a href="profile.php" style="text-decoration: none;"> 
					<?php echo $user_data['first_name'] . " ". $user_data['last_name'] ?>
					</a>
				</div>
			</div>

			<!-- Posts Area -->
			<div style="min-height: 400px;flex: 2.5;padding: 20px;padding-right: 0px;">
				
				<!-- Post Box -->
				<div style="border: solid thin #aaa;padding: 10px;background-color: white;">
					 <form method="post" enctype="multipart/form-data">
					 	<textarea name="post" placeholder="What's on your mind?"></textarea>
					 	<input type="file" name="file">
					 	<input id="post_button" type="submit" value="Post">
					 	<br>
					 </form>
				</div>

				<!-- Posts Feed -->
				<div id="post_bar">
					<?php
						$DB = new Database();
						$image_class = new Image();
						$user_class = new User();
						$posts = false;

						// Get users the current user is following
						$followers = $user_class->get_following($_SESSION['mybook_userid'], "user");

						if (is_array($followers) && count($followers) > 0) {
							// Extract user IDs of people followed
							$follower_ids = array_column($followers, "userid");

							// Convert to comma-separated string for SQL (NO extra quotes!)
							$follower_ids_str = implode(",", $follower_ids);

							// Fetch posts from those users
							$sql = "SELECT * FROM posts WHERE userid IN ($follower_ids_str) ORDER BY id DESC LIMIT 50";
							$posts = $DB->read($sql);
						}

						// Display posts if available
						if ($posts) {
							foreach ($posts as $ROW) {
								$ROW_USER = $user_class->get_user($ROW['userid']);
								include("post.php");
							}
						} else {
							// If no posts found
							echo "<div style='color:#888; text-align:center; padding:20px;'>No posts to show yet. Start following people to see their posts 🚀</div>";
						}
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
