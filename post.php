

<div id="post"> 
    <div>
        <?php

            $image="images/user_male.jpg"; 
            if($ROW_USER['gender']=="Female")
            {
                $image="images/user_female.jpg";
            }
            if(file_exists($ROW_USER['profile_image']))
            {
                $image = $image_class->get_thumb_profile($ROW_USER['profile_image']);
            }

        ?>
        <img src="<?php echo $image ?>" style="width:75px;margin-right: 4px;border-radius: 50%;">
    </div>
                        <div style="width: 100%">
                            <div style="font-weight: bold;color: #405d9b;width :100%">
                                <?php 
                                    echo htmlspecialchars($ROW_USER['first_name'])." ".htmlspecialchars($ROW_USER['last_name']); 

                                        if($ROW['is_profile_image'])
                                        {
                                            echo "<span style = 'font-weight:normal;color:#aaa;'> updated their profile image</span>";
                                        }

                                        if($ROW['is_cover_image'])
                                        {
                                            echo "<span style = 'font-weight:normal;color:#aaa;'> updated their cover image</span>";
                                        }
                                        
                                ?>
                            </div>
                            <?php echo htmlspecialchars($ROW['post']) ?>
                            <br><br>

                            <?php 
                            if(file_exists($ROW['image']))
                            {
                                $post_image = $image_class->get_thumb_post($ROW['image']);
                              echo "<img src= '$post_image' style='width:80%;' />";
                            }

                            ?>

                            <br><br>

                            <?php

                                $likes = "";

                                $likes = ($ROW['likes'] > 0) ? "(" .$ROW['likes']. ")" : "";

                            ?>
                            <a href="like.php?type=post&id=<?php echo $ROW['postid'] ?>">Like <?php echo $likes ?></a> . <a href="">Comment</a> . 
                        <span style="color: #999;">
                            
                            <?php echo $ROW['date'] ?>

                        </span>
                        <span style="color: #999;float:right">

                            <?php
                                $post = new Post();
                                if($post->i_own_post($ROW['postid'], $_SESSION['mybook_userid']))
                                {
                                        echo "
                                        <a href='edit.php?id= $ROW[postid]'>
                                             Edit
                                        </a> . 
                                        <a href='delete.php?id= $ROW[postid]'>
                                            Delete
                                        </a> ";
                                }   


                                
                            ?>

                        </span>


                        <?php

                            $i_liked = false;

                            if(isset($_SESSION['mybook_userid']))
{
    $DB = new Database();
    $sql = "select likes from likes where type='post' && contentid = '$ROW[postid]' limit 1";
    $result = $DB->read($sql);

    if(is_array($result) && isset($result[0]['likes']))
    {
        $likes = json_decode($result[0]['likes'], true);

        if(is_array($likes))
        {
            $user_ids = array_column($likes, "userid");

            if(in_array($_SESSION['mybook_userid'], $user_ids))
            {
                $i_liked = true;
            }
        }
    }
}

                            
                            if($ROW['likes']>0)
                                {

                                    echo "<br>";
                                    echo "<a href='likes.php?type=post&id=$ROW[postid]'>";

                                    if ($ROW['likes'] == 1)
                                     {
                                        if($i_liked)
                                        {
                                            echo "<span style='float:left;'>You liked this post </span>";
                                        }else
                                        {
                                           echo "<span style='float:left;'>1 person liked this post </span>"; 
                                        }
              
                                    }
                                    else
                                    {
                                        if($i_liked)
                                        {
                                            $text = "others";
                                            if($ROW['likes'] - 1 == 1)
                                            {
                                                $text="other";
                                            }
                                            echo "<span style='float:left;'>You and " . ($ROW['likes'] -1) ." ". $text . "  person liked this post </span>";

                                        }
                                        else
                                        {
                                            echo "<span style='float:left;'>" . $ROW['likes'] . " people liked this post </span>";
                                        }
                                        

                                        
                                    }

                                    echo "</a>";
                                    
                                }

                        ?>
                        </div>
</div>   

