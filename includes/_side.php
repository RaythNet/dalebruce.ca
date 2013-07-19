<?php
$Query = "SELECT * FROM ".POSTS_TABLE." WHERE forum_id!=".PAGES_FORUM_ID." AND forum_id!=".LINKS_FORUM_ID." AND forum_id!=".NEWS_FORUM_ID." AND forum_id!=".BLOG_FORUM_ID." AND post_subject LIKE 'Re:%' ORDER BY post_id DESC LIMIT 10";
$Posts = GetAll($db,$Query);
$X = 0;
?>
<div id="templatemo_sidebar">
    <div class="sidebar_box">
	<?php
        if ($user->data['is_registered']) { ?>
        <center><b><font color="#<?php echo $user->data['user_colour'];?>"><?php echo $user->data['username'];?></font></b>
        <br /><img src="<?php If ($user->data['user_avatar_type'] == 1) { ?>./forums/download/file.php?avatar=<?php } echo $user->data['user_avatar']; ?>" height="<?php echo $user->data['user_avatar_height']; ?>" width="<?php echo $user->data['user_avatar_width']; ?>" /><br/>
        <?php
                   If ($user->data['user_rank']) {
                        $Query = "SELECT * FROM ".RANKS_TABLE." WHERE rank_id={$user->data['user_rank']}";
                        $Rank = GetArray($db, $Query);
                    } Else {
                        $Query = "SELECT * FROM ".RANKS_TABLE." WHERE rank_min<={$user->data['user_posts']} AND rank_special=0 ORDER BY rank_min DESC LIMIT 1";
                        $Rank = GetArray($db, $Query);
                    }
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
                <input type="hidden" name="redirect" value="http://www.bruce-industries.com<?php echo $_SERVER['REQUEST_URI'];?>"/>
                Username: <input type="text" name="username" style="border: 1px solid #102a61; background: #000; color: #ccc;"/><br />
                Password: <input type="password" name="password" style="border: 1px solid #102a61; background: #000; color: #ccc;"/><br />
                Remember Me?: <input type="checkbox" name="autologin" style="border: 1px solid #102a61; background: #000; color: #ccc;"/><br />
                <input type="submit" name="login" value="Submit" style="border: 1px solid #102a61; background: #000; color: #ccc;"/>
            </form></center>
        <?php } ?>
    </div> 
    <div class="sidebar_box">
        <h4>Support Bruce-Industries!</h4>
<center><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="ZCV8M3JVT6V8A">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></center>
<br/><br/><h4>Affiliates</h4>
<ul class="tmo_list">
<?php
$Query = "SELECT * FROM ".TOPICS_TABLE." WHERE forum_id=".LINKS_FORUM_ID." AND topic_type=0 ORDER BY topic_id ASC";
$Links = GetAll($db, $Query);
$X = 0;
While (isset($Links[$X])) {
   $Query = "SELECT * FROM ".POSTS_TABLE." WHERE post_id={$Links[$X]['topic_first_post_id']}";
   $Array = GetArray($db,$Query);
?><li><a href="<?php Echo html_entity_decode($Array['post_text']);?>/"><?php Echo html_entity_decode($Links[$X]['topic_title']); ?></a></li>
<?php
$X++;
}
?></ul>
    </div>
<div class="sidebar_box">
    <h4>Youtubers!</h4>
    <ul class="tmo_list">
        <?php If ($Page == 'blog') { ?>
        <li><a href="./blog/">Latest Posts</a></li>
        <li><a href="./blog/archive/">Blog Archive</a></li>
        <?php } Else { ?>
        <li><a href="http://www.youtube.com/SouthlakeFilms">South Lake Films</a></li>
        <li><a href="http://www.youtube.com/Katers17">Katers17</a></li>
        <li><a href="http://www.youtube.com/SMPFilms">Cory! AKA Mr.Safety</a></li>
        <?php } ?>
    </ul>
</div>

<div class="sidebar_box">
    <h4>Recent Forum Replies</h4>
    <div class="scrollbar">
<?php
$X = 0;
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
<div class="sidebar_box">
    <h4>Recent Blog Comments</h4>
    <div class="scrollbar">
<?php
$Query = "SELECT * FROM ".POSTS_TABLE." WHERE forum_id=".BLOG_FORUM_ID." AND post_subject LIKE 'Re:%' ORDER BY post_id DESC LIMIT 10";
$Posts = GetAll($db,$Query);
$X = 0;
  If (!isset($Posts[$X])) { Echo "<i>No blog comments yet.</i>"; }
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
