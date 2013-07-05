<div id="homepage_slider">
     <div id="slider">
                    <a href="#"><img src="./includes/images/slideshow/08.jpg" width="580" height="300" alt="Image 7" title="Gliese667C" /></a>
                    <a href="#"><img src="./includes/images/slideshow/01.jpg" width="580" height="300" alt="Image 1" title="Windmills - East Point" /></a>
      </div>
</div>
<?php
$Query = "SELECT * FROM ".TOPICS_TABLE." WHERE forum_id=".NEWS_FORUM_ID." ORDER BY topic_id DESC LIMIT 5";
$NewsTopics = GetAll($db,$Query);
$X = 0;
?><?php
While (isset($NewsTopics[$X])) {
    $Query = "SELECT * FROM ".POSTS_TABLE." WHERE topic_id={$NewsTopics[$X]['topic_id']} ORDER BY post_id ASC";
    $Post = GetAll($db,$Query);
    $Result = Query($db, $Query);
    $TotalReplies = mysqli_num_rows($Result)-1;
?>
<div class="post_box">
    <?php
    If (getAvatar($db, $NewsTopics[$X]['topic_first_poster_name']) != Null) {
        $User = GetArray($db, "SELECT * FROM ".USERS_TABLE." WHERE username='{$NewsTopics[$X]['topic_first_poster_name']}'");
         ?><a href="./forums/memberlist.php?mode=viewprofile&u=<?php echo $User['user_id'];?>" target="_blank"><img src="forums/download/file.php?avatar=<?php Echo getAvatar($db, $NewsTopics[$X]['topic_first_poster_name']);?>" alt="Avatar"/></a><?php
    }
    ?>
    <div class="post_box_right">
<h2><?php Echo $NewsTopics[$X]['topic_title']; ?></h2>
<div class="post_meta">
    <strong>Date: </strong><?php Echo date('D jS F Y',$Post[0]['post_time']); ?> | 
    <strong>Author: </strong><?php Echo "<a href=\"./forums/memberlist.php&mode=viewprofile&u={$User['user_id']}\" target=\"_blank\"><b><font color=\"#{$NewsTopics[$X]['topic_first_poster_colour']}\">{$NewsTopics[$X]['topic_first_poster_name']}</font></b></a>"; ?>
</div>
<p><?php 
$post_text = BBCode($Post[0]['post_text'],$Post[0]['bbcode_uid']);
echo substr(nl2br($post_text),0,750);
If (strlen(nl2br($post_text)) > 750) { echo "..."; }
?></p>
<div class="cleaner"></div>
<a href="./forums/viewtopic.php?t=<?php Echo $NewsTopics[$X]['topic_id']; ?>" class="more float_r" target="_blank"> <?php Echo $TotalReplies;?> Comment(s). Read more.</a>
</div>
    </div><div class="cleaner"></div>
<?php
$X++;
}
?>
<div class="cleaner"></div>
