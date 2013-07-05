<?php
$Query = "SELECT * FROM ".POSTS_TABLE." WHERE forum_id!=".PAGES_FORUM_ID." AND forum_id!=".LINKS_FORUM_ID." AND forum_id!=".NEWS_FORUM_ID." AND forum_id!=".BLOG_FORUM_ID." ORDER BY post_id DESC LIMIT 10";
$Posts = GetAll($db,$Query);
$X = 0;
?>
<div id="templatemo_sidebar">
    <div class="sidebar_box">
	<?php
        if ($user->data['is_registered']) { ?>
        <center><b><font color="#<?php echo $user->data['user_colour'];?>"><?php echo $user->data['username'];?></font></b>
        <br /><img src="./forums/download/file.php?avatar=<?php echo $user->data['user_avatar']; ?>" height="<?php echo $user->data['user_avatar_height']; ?>" width="<?php echo $user->data['user_avatar_width']; ?>" /><br/>
        <?php
        $Query = "SELECT * FROM ".RANKS_TABLE." WHERE rank_id={$user->data['user_rank']}";
        $Rank = GetArray($db, $Query);
        ?>
        <br /><?php Echo $Rank['rank_title']; ?><br/><img src="./forums/images/ranks/<?php echo $Rank['rank_image']; ?>"/><br/>
        <br />[<a href="<?php Echo append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=logout', true, $user->session_id);?>">Log out</a>] [<a href="./forums/faq.php">FAQ</a>] [<a href="./forums/memberlist.php">Members</a>] [<a href="./forums/search.php">Search</a>]
        <br />[<a href="./forums/ucp.php">User Control Panel</a>] [<a href=<?php If ($user->data['user_new_privmsg'] == 1) { Echo "\"./forums/ucp.php?i=pm&folder=inbox\"><b>{$user->data['user_unread_privmsg']} new message</b>"; } Elseif ($user->data['user_new_privmsg'] > 1) { Echo "\"./forums/ucp.php?i=pm&folder=inbox\"><b>{$user->data['user_unread_privmsg']} new messages</b>"; } Else { Echo "\"./forums/ucp.php?i=pm&folder=inbox\">0 new messages"; } ?></a>] 
        </center>
        <?php }
        Else { ?> 
        <center>You are not logged in.
            <br/>[<a href="./forums/faq.php">FAQ</a>] [<a href="./forums/memberlist.php">Members</a>] [<a href="./forums/search.php">Search</a>] [<a href="./forums/ucp.php?mode=register">Register</a>]
            <br/>
            <form action="./forums/ucp.php?mode=login" method="POST">
                <input type="hidden" name="redirect" value="http://www.dalebruce.ca<?php echo $_SERVER['REQUEST_URI'];?>"/>
                Username: <input type="text" name="username" style="border: 1px solid #102a61; background: #000; color: #ccc;"/><br />
                Password: <input type="password" name="password" style="border: 1px solid #102a61; background: #000; color: #ccc;"/><br />
                Remember Me?: <input type="checkbox" name="autologin" style="border: 1px solid #102a61; background: #000; color: #ccc;"/><br />
                <input type="submit" name="login" value="Submit" style="border: 1px solid #102a61; background: #000; color: #ccc;"/>
            </form></center>
        <?php } ?>
    </div>  
<div class="sidebar_box">
    <h4>Categories</h4>
    <ul class="tmo_list">
        <li><a href="http://www.youtube.com/SouthlakeFilms">South Lake Films</a></li>
        <li><a href="http://www.dalebruce.ca/forums/viewforum.php?f=30">Star Trek RP</a></li>
        <li><a href="./">Stop</a></li>
        <li><a href="./">Being</a></li>
        <li><a href="./">Latin</a></li>
        <li><a href="./">Sentences!!</a></li>
    </ul>
</div>

<div class="sidebar_box">
    <h4>Recent Forum Posts</h4>
    <div class="scrollbar">
<?php
  While (isset($Posts[$X])) {
    $Query = "SELECT * FROM ".USERS_TABLE." WHERE user_id={$Posts[$X]['poster_id']}";
    $User = GetArray($db,$Query);
    ?>
    <div class="recent_comment_box">
    <a href="./forums/viewtopic.php?p=<?php Echo $Posts[$X]['post_id'];?>" target="_blank"><?php Echo $Posts[$X]['post_subject'];?></a> by <a href="./forums/memberlist.php?mode=viewprofile&u=<?php Echo $User['user_id'];?>" target="_blank"><b><font color="<?php Echo $User['user_colour']; ?>"><?php Echo $User['username']; ?></font></b></a>
    <p><?php
    $post_text = BBCode($Posts[$X]['post_text'],$Posts[$X]['bbcode_uid']);
    Echo nl2br(substr($post_text,0,125));
    if (strlen($post_text) > 125) { Echo "..."; }
    ?></p></div>
    <?php
    $X++;
  }
?></div>
</div>
</div>
    <div class="cleaner"></div>