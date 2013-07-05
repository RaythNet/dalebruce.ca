<?php
//Showing howto commit
If (isset($_GET['2'])) { $Action = $_GET['2']; } Else { $Action = 'reel'; }
If ($Action == 'view') {
    If (isset($_GET['3'])) { $PostID = clean($_GET['3']); } else { $Action = 'reel'; }
    If (isset($PostID)) {
        If ($isset($_POST['comment_submit'])) {

        }
    }
}
If ($Action == 'reel') {
    $Query = "SELECT * FROM ".TOPICS_TABLE." WHERE forum_id=".BLOG_FORUM_ID." ORDER BY topic_id DESC LIMIT 5";
    $BlogTopics = GetAll($db,$Query);
    $X = 0;
    While (isset($NewsTopics[$X])) {
        $Query = "SELECT * FROM ".POSTS_TABLE." WHERE topic_id={$BlogTopics[$X]['topic_id']} ORDER BY post_id ASC";
        $Post = GetAll($db,$Query);
        $Result = Query($db, $Query);
        $TotalReplies = mysqli_num_rows($Result)-1;
    }
}
If ($Action == 'archive') {
    
}
?>
