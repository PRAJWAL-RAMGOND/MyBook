<?php

	session_start();

    include("classes/connect.php");
    include("classes/login.php");
    include("classes/user.php");
    include("classes/post.php");
    include("classes/image.php");

    $login=new Login();
    $user_data = $login->check_login($_SESSION['mybook_userid']);

   // print_r($_GET);
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
    	

    	if(isset($_FILES['file']['name']) && $_FILES['file']['name'] !="")
    	{

  	
    		if($_FILES['file']['type'] == "image/jpeg")
    		{
    			$allowed_size = (1024 * 1024) * 15;
    			if($_FILES['file']['size'] < $allowed_size)
    			{
    				//fine
    				$folder = "uploads/" . $user_data['userid'] . "/";

    				//create folder

    				if(!file_exists($folder))
    				{

    					mkdir($folder,0777,true);
    				}
    				$image = new Image();
    				$filename= $folder . $image->generate_filename(15) . ".jpg";
			    	move_uploaded_file($_FILES['file']['tmp_name'], $filename);


			    	$change = "profile";

			    		//check for mode
			    		if(isset($_GET['change']))
			    		{
			    			$change = $_GET['change'];
			    		}

			    	
			    	if($change == "cover")
				    {
				    	if(file_exists($user_data['cover_image']))
				    	{
				    		unlink($user_data['cover_image']);
				    	}
				    	$image->resize_image($filename,$filename,1500,1500);
				    }else
				    {
					    	if(file_exists($user_data['profile_image']))
					    	{
					    		unlink($user_data['profile_image']);
					    	}
				    	  	$image->resize_image($filename,$filename,1500,1500);
			        }
			    	if(file_exists($filename))
			    	{	
			    		$userid = $user_data['userid'];


			    		if($change == "cover")
			    		{
			    		  $query="update users set cover_image = '$filename' where userid = $user_data[userid] limit 1";
			    		   $_POST['is_cover_image']=1;
			    		}
			    		else
			    		{
			    			$query="update users set profile_image = '$filename' where userid = $user_data[userid] limit 1";
			    		   $_POST['is_profile_image']=1;
			    		}

			    		


			    		
			    		$DB=new Database();
			    		$DB->save($query);


                  //create a post after pfp updation
                    $post = new Post();

				        $post->create_post($userid,$_POST,$filename);

			    		header(("Location: profile.php"));
			    		die;
			    	}
    			}
    			else
	    		{
	    			echo "<div style= 'text-align:center;font-size:12px;color:white;background-color:grey;'>";
		            echo "<br>The following errors occured:<br><br>";
		            echo "File too large";
		            echo "</div>"; 
	    		}
    		}
    		else
    		{
    			echo "<div style= 'text-align:center;font-size:12px;color:white;background-color:grey;'>";
	            echo "<br>The following errors occured:<br><br>";
	            echo "please add a valid file!";
	            echo "</div>"; 
    		}
	    	
         }
         else
         {
         	echo "<div style= 'text-align:center;font-size:12px;color:white;background-color:grey;'>";
            echo "<br>The following errors occured:<br><br>";
            echo "please add a valid file!";
            echo "</div>";
         }
    }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Change Profile Image | MyBook</title>
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

	
	#post_button{

		float:right;
		background-color: #405d9b;
		border: none;
		color: white;
		padding: 4px;
		font-size: 14px;
		border-radius: 2px;
		width: 55px;
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
	<!--Top bar-->
	<br>
	<?php include("header.php"); ?>
	<!--cover area-->
	<div style="width: 800px;margin:auto;min-height: 400px;">
		
		<!--Below Cover area-->
	<div style="display: flex;">

		
		<!--Profile image updation Area-->
		<div style="min-height: 400px;flex: 2.5;padding: 20px;padding-right: 0px;">
		<form method="post" enctype="multipart/form-data">
			<div style="border: solid thin #aaa;padding: 10px;background-color: white;">
				<input type="file" name="file">
				<input id="post_button" type="submit" value="Upload">
				<br>
				<br>

				<div style="text-align: center;">
						<?php



					    		//check for mode
					    		if(isset($_GET['change']) && $_GET['change'] == "cover")
					    		{
					    			$change = "cover";
					    			echo "<img src ='$user_data[cover_image]' style='max-width:500px;' >"; 
					    		}
					    		else
					    		{
					    			echo "<img src ='$user_data[profile_image]' style='max-width:500px;' >";
					    		}

								

						?>
					
				</div>
			</div>
		</form>
			<!--posts-->
			
		</div>
	</div>
	</div>
</body>
</html>