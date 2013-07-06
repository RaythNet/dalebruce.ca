<?php
//Work out what part of the blog we want
If (isset($_GET['2'])) { $Action = $_GET['2']; } Else { $Action = 'reel'; }

//View a certain post, or return to the reel if no post id is found.
If ($Action == 'view') {
    If (isset($_GET['3'])) { $PostID = clean($db,$_GET['3']); } else { $Action = 'reel'; }
    
    //Check if a comment has been posted before loading up the post and comments.
    If (isset($PostID)) {
        $Query = "SELECT * FROM ".POSTS_TABLE." WHERE topic_id={$PostID} ORDER BY post_id ASC LIMIT 1";
        $Post = GetArray($db,$Query);
        If (isset($_POST['comment_submit'])) {
            $text = clean($db,$_POST['comment']);
            $poll = $uid = $bitfield = $options = ''; // will be modified by generate_text_for_storage
            $allow_bbcode = $allow_urls = $allow_smilies = 0;
            $subject = "Re: {$Post['post_subject']}";
            $data = array(
                 // General Posting Settings
                'forum_id'            => BLOG_FORUM_ID,    // The forum ID in which the post will be placed. (int)
                'topic_id'            => $PostID,    // Post a new topic or in an existing one? Set to 0 to create a new one, if not, specify your topic ID here instead.
                'icon_id'            => 0,    // The Icon ID in which the post will be displayed with on the viewforum, set to false for icon_id. (int)

                // Defining Post Options
                'enable_bbcode'    => 0,    // Enable BBcode in this post. (bool)
                'enable_smilies'    => 0,    // Enabe smilies in this post. (bool)
                'enable_urls'        => 0,    // Enable self-parsing URL links in this post. (bool)
                'enable_sig'        => 0,    // Enable the signature of the poster to be displayed in the post. (bool)

                // Message Body
                'message'            => $text,        // Your text you wish to have submitted. It should pass through generate_text_for_storage() before this. (string)
                'message_md5'    => md5($text),// The md5 hash of your message

                // Values from generate_text_for_storage()
                'bbcode_bitfield'    => $bitfield,    // Value created from the generate_text_for_storage() function.
                'bbcode_uid'        => $uid,        // Value created from the generate_text_for_storage() function.

                // Other Options
                'post_edit_locked'    => 0,        // Disallow post editing? 1 = Yes, 0 = No
                'topic_title'        => $subject,    // Subject/Title of the topic. (string)

                // Email Notification Settings
                'notify_set'        => 0,        // (bool)
                'notify'            => 0,        // (bool)
                'post_time'         => 0,        // Set a specific time, use 0 to let submit_post() take care of getting the proper time (int)
                'forum_name'        => '',        // For identifying the name of the forum in a notification email. (string)

                // Indexing
                'enable_indexing'    => 0,        // Allow indexing the post? (bool)

                // 3.0.6
                'force_approved_state'    => 1, // Allow the post to be submitted without going into unapproved queue
                'post_time' => time(),
                'poster_id' => $_SERVER['REMOTE_ADDRE']
             );
             $Query = "INSERT INTO ".POSTS_TABLE
                     ." (`topic_id`,`forum_id`,`poster_id`,`icon_id`,`poster_ip`,`post_time`,`post_approved`,`post_reported`,`enable_bbcode`,`enable_smilies`"
                     .",`enable_magic_url`,`enable_sig`,`post_subject`,`post_text`,`post_checksum`) VALUES "
                     ."({$PostID},{$data['forum_id']},{$user->data['user_id']},0,'{$data['poster_ip']}',{$data['post_time']},0,0,0,0,"
                     ."0,0,'{$subject}','{$data['message']}','{$data['message_md5']}');";
             $Result = Query($db,$Query);
        }
        $Query = "SELECT * FROM ".POSTS_TABLE." WHERE topic_id={$PostID} ORDER BY post_id ASC";
        $Posts = GetAll($db,$Query);
        $X = 0;
        //Display original Post
?>
<div class="post_box">
    <?php
    $User = GetArray($db, "SELECT * FROM ".USERS_TABLE." WHERE user_id={$Posts[$X]['poster_id']}");
    If (getAvatar($db, $User['username']) != Null) {
         ?><a href="./forums/memberlist.php?mode=viewprofile&u=<?php echo $User['user_id'];?>" target="_blank"><img src="./forums/download/file.php?avatar=<?php Echo getAvatar($db, $User['username']);?>" alt="Avatar"/></a><?php
    }
    ?>
<div class="post_box_right">
<h2><?php Echo $Posts[$X]['post_subject']; ?></h2>
<div class="post_meta">
    <strong>Date: </strong><?php Echo date('D jS F Y',$Posts[$X]['post_time'])."@".date('G:i',$Posts[$X]['post_time']); ?> | 
    <strong>Author: </strong><?php Echo "<a href=\"./forums/memberlist.php?mode=viewprofile&u={$User['user_id']}\" target=\"_blank\"><b><font color=\"#{$User['user_colour']}\">{$User['username']}</font></b></a>"; ?>
</div>
<p><?php 
$post_text = BBCode($Posts[$X]['post_text'],$Posts[$X]['bbcode_uid']);
echo nl2br($post_text);
?></p>
<div class="cleaner"></div>
</div>
    </div><div class="cleaner"></div>    
<?php
//Now display all the comments
$X = 1;
?><br />
    <h3>Comments</h3>
    <?php
    If (!isset($Posts[$X])) { Echo "<i>There are no comments yet."; If ($user->data['is_registered']) { Echo "Be the first and comment using the form below."; } Echo "</i>"; }
    Else {
        ?><div id="comment_section" class="newsscrollbar"><ol class="comments first_level">
        <?php
        While (isset($Posts[$X])) { 
            $User = GetArray($db, "SELECT * FROM ".USERS_TABLE." WHERE user_id={$Posts[$X]['poster_id']}"); ?>
            <li>
            <div class="comment_box commentbox1">
            <?php If (getAvatar($db, $User['username']) != Null) {
                $Avatar = getAvatar($db, $User['username']); ?>
                <div class="gravatar">
                <a href="./forums/memberlist.php&mode=viewprofile&u=<?php echo $User['user_id']; ?>" target="_blank"><img src="./forums/download/file.php?avatar= <?php echo $Avatar; ?>" width="50" height="50"></a>
                </div>
            <?php }
            ?><div class="comment_text">
                 <div class="comment_author"><b><font color="#<?php echo $User['user_colour'];?>"><?php echo $User['username']; ?></font></b>
                    <span class="date"><?php echo date('D jS F Y',$Posts[$X]['post_time']); ?></span>
                    <span class="time"><?php echo date('G:i',$Posts[$X]['post_time']); ?></span>
                 </div>
                <p>
                    <?php
                    Echo nl2br($Posts[$X]['post_text']);
                    ?>
                </p>
            </div>
                <div class="cleaner"></div>
        </div></li>
    <?php
    $X++;
        }
        ?>
            </ol></div>
    <?php
    }
    
    //Now we display the comment form IF the user is logged in
    if ($user->data['is_registered']) {
        ?>
    <div id="comment_form">
        <h3>Leave a comment</h3>
        <form action="./blog/view/<?php echo $PostID;?>/" method="POST">
            <div class="form_row"><label>Name: </label> <b><font color="#<?php echo $user->data['user_colour'];?>"><?php echo $user->data['username'];?></font></b></div>
            <div class="form_row">
                <label>Comment: </label>
                <textarea  name="comment" rows="" cols="225" class="input_field"></textarea>
            </div>
            <center><input type="submit" name="comment_submit" value="Submit" class="submit_btn" /></center>
        </form>
    </div>
    <?php
    }
    }
}

//Display the reel of blog posts (Last 5 posts)
If ($Action == 'reel') {
    $Query = "SELECT * FROM ".TOPICS_TABLE." WHERE forum_id=".BLOG_FORUM_ID." ORDER BY topic_id DESC LIMIT 5";
    $BlogTopics = GetAll($db,$Query);
    $X = 0;
    While (isset($BlogTopics[$X])) {
        $Query = "SELECT * FROM ".POSTS_TABLE." WHERE topic_id={$BlogTopics[$X]['topic_id']} ORDER BY post_id ASC";
        $Post = GetAll($db,$Query);
        $Result = Query($db, $Query);
        $TotalReplies = mysqli_num_rows($Result)-1;
        ?>
<div class="post_box">
    <?php
    If (getAvatar($db, $BlogTopics[$X]['topic_first_poster_name']) != Null) {
        $User = GetArray($db, "SELECT * FROM ".USERS_TABLE." WHERE username='{$BlogTopics[$X]['topic_first_poster_name']}'");
         ?><a href="./forums/memberlist.php?mode=viewprofile&u=<?php echo $User['user_id'];?>" target="_blank"><img src="./forums/download/file.php?avatar=<?php Echo getAvatar($db, $BlogTopics[$X]['topic_first_poster_name']);?>" alt="Avatar"/></a><?php
    }
    ?>
<div class="post_box_right">
<h2><?php Echo $BlogTopics[$X]['topic_title']; ?></h2>
<div class="post_meta">
    <strong>Date: </strong><?php Echo date('D jS F Y',$Post[0]['post_time']); ?> | 
    <strong>Author: </strong><?php Echo "<a href=\"./forums/memberlist.php&mode=viewprofile&u={$User['user_id']}\" target=\"_blank\"><b><font color=\"#{$BlogTopics[$X]['topic_first_poster_colour']}\">{$BlogTopics[$X]['topic_first_poster_name']}</font></b></a>"; ?>
</div>
<p><?php 
$post_text = BBCode($Post[0]['post_text'],$Post[0]['bbcode_uid']);
echo substr(nl2br($post_text),0,750);
If (strlen(nl2br($post_text)) > 750) { echo "..."; }
?></p>
<div class="cleaner"></div>
<a href="./blog/view/<?php Echo $BlogTopics[$X]['topic_id']; ?>" class="more float_r"> <?php Echo $TotalReplies;?> Comment(s). Read more.</a>
</div>
    </div><div class="cleaner"></div>
</div>
<?php
    $X++;
    }
}

//Display the blog archive.
If ($Action == 'archive') {
    $Query = "SELECT * FROM ".TOPICS_TABLE." WHERE forum_id=".BLOG_FORUM_ID." ORDER BY topic_id DESC";
    $BlogTopics = GetAll($db, $Query); $X = 0;
?>
<table width="100%" class="tableborder" style="border: 1px solid #0000FF;">
    <tr><td width="50%"><b>Post Title</b></td><td width="25%"><b>Author</b></td><td width="25%"><b>Date</b></td></tr>
    <tr><td colspan="3"><hr color="#0000FF"/></td></tr>
    <?php
    While (isset($BlogTopics[$X])) {
        Echo "<tr><td>{$BlogTopics[$X]['topic_title']}</td><td><b><font color=\"#{$BlogTopics[$X]['topic_first_poster_colour']}\">{$BlogTopics[$X]['topic_first_poster_name']}</font></b></td><td>".date('D jS F Y',$BlogTopics[$X]['topic_time'])."</td></tr>";
        $X++;
    }
    ?>
</table>
<?php
}
?>
