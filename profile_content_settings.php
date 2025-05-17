<div style="min-height: 400px;width: 100%;background-color: white;text-align: center;">
	<div style="padding: 20px;max-width: 450px; display: inline-block;">
		<form method="post" enctype="multipart/form-data">
			<?php
				$settings_class = new Settings();
				$settings = $settings_class->get_settings($_SESSION['mybook_userid']);

				if(is_array($settings))
				{
					echo "<input type='text' id='textbox' name='first_name' value='".htmlspecialchars($settings['first_name'], ENT_QUOTES)."' placeholder='First name' />";
					echo "<input type='text' id='textbox' name='last_name' value='".htmlspecialchars($settings['last_name'], ENT_QUOTES)."' placeholder='Last name' />";

					echo "<select id='textbox' name='gender' style='height:35px;'>";
					echo "<option value='Male'".($settings['gender'] == 'Male' ? ' selected' : '').">Male</option>";
					echo "<option value='Female'".($settings['gender'] == 'Female' ? ' selected' : '').">Female</option>";
					echo "</select>";

					echo "<input type='text' id='textbox' name='email' placeholder='Email' value='".htmlspecialchars($settings['email'], ENT_QUOTES)."' />";
					
					echo "<input type='password' id='textbox' name='password' value='".htmlspecialchars($settings['password'], ENT_QUOTES)."' />";
					echo "<input type='password' id='textbox' name='password2' value='".htmlspecialchars($settings['password'], ENT_QUOTES)."' />";
					
					echo "<br>About me:<br>";
					echo "<textarea id='textbox' style='height:200px;' name='about'>".htmlspecialchars($settings['about'], ENT_QUOTES)."</textarea>";

					echo '<input id="post_button" type="submit" value="Save">';
				}
			?>
		</form>
	</div>
</div>
