<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
<?php
$Query = "SELECT * FROM ".USERS_TABLE." WHERE user_type!=2 AND user_type!=1";
$Members = mysqli_num_rows(Query($db,$Query));
$Query = "SELECT * FROM ".TOPICS_TABLE." WHERE forum_id!=".PAGES_FORUM_ID." AND forum_id!=".LINKS_FORUM_ID." AND forum_id!=".BLOG_FORUM_ID;
$Topics = mysqli_num_rows(Query($db,$Query));
$Query = "SELECT * FROM ".POSTS_TABLE." WHERE forum_id!=".PAGES_FORUM_ID." AND forum_id!=".LINKS_FORUM_ID." AND forum_id!=".BLOG_FORUM_ID;
$PostCount = mysqli_num_rows(Query($db,$Query));
?>
            <div class="footer_col_w300">
            <h4>Statistics</h4>
            <ul class="tmo_list">
                <li><b>Members:</b> <?php echo $Members; ?></li>
                <li><b>Topics:</b> <?php echo $Topics; ?></li>
                <li><b>Replies:</b> <?php echo $PostCount-$Topics; ?></li>
                <li><b>Unique Visitors:</b> <img src="./includes/_counter.php"/>
            </ul>     
        </div>
 
<div class="footer_col_w300">
            <h4>Users Online</h4>
            <?php
            $TimeSpan = time()-1320;
            $Query = "SELECT * FROM ".SESSIONS_TABLE." WHERE session_time>=$TimeSpan";
            $Active = mysqli_num_rows(Query($db,$Query));
            $Sessions = GetAll($db, $Query);
            $X = 0;
            $Guests = 0;
            $Bots = 0;
            $Users = 0;
            While (isset($Sessions[$X])) {
                If ($Sessions[$X]['session_user_id'] == 1) {
                    $Guests++;
                } Else {
                    $Query = "SELECT * FROM ".USERS_TABLE." WHERE user_id={$Sessions[$X]['session_user_id']}";
                    $User = GetArray($db, $Query);
                    If ($User['user_type'] == 2) { $Bots++; }
                    Else { $Users++; }
                }
                $X++;
            }
            ?>
            There are <b><?php echo $Active; ?></b> users online in the last 22 Minutes (<?php Echo $Guests." Guests, {$Users} Users and {$Bots} bots";?>):<br/>
            Users:
            <?php
            $X = 0;
            While (isset($Sessions[$X])) {
                If ($Sessions[$X]['session_user_id'] == 1) {
                    $Guests++;
                } Else {
                    $Query = "SELECT * FROM ".USERS_TABLE." WHERE user_id={$Sessions[$X]['session_user_id']}";
                    $User = GetArray($db, $Query);
                    If ($X == $Active-1) { Echo " <b><font color=\"#{$User['user_colour']}\">{$User['username']}</font></b>"; }
                    Else { Echo " <b><font color=\"#{$User['user_colour']}\">{$User['username']}</font></b>,"; }
                }
                $X++;
            }
            ?>
            <br/><br/>Legend:
            <?php
            $Query = "SELECT * FROM ".GROUPS_TABLE." WHERE group_legend=1";
            $Groups = GetAll($db,$Query);
            $Active = mysqli_num_rows(Query($db,$Query));
            $X = 0;
            While (isset($Groups[$X])) {
                If ($X == $Active-1) { Echo " <b><font color=\"#{$Groups[$X]['group_colour']}\">{$Groups[$X]['group_name']}</font></b>"; }
                Else { Echo " <b><font color=\"#{$Groups[$X]['group_colour']}\">{$Groups[$X]['group_name']}</font></b>,"; }
                $X++;
            }
            ?>
        </div>
        <div class="footer_col_w300 last">
            <h4>About Us</h4>
            <p>A Non-Profit Organization bent on faster than light space travel and 0 emissions!</p>
            <p>Copyright &copy; 2013 <a href="./">DaleBruce.Ca</a> <br /> Designed by <a href="http://www.templatemo.com" target="_blank">Free CSS Templates</a><br />Coding by <a href="http://www.raythnet.org/" target="_blank">Rayth</a></p>        
        </div>
            <div class="cleaner"></div>
        </div>
</div>
</body>
</html>