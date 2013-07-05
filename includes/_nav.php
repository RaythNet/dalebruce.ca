<div id="templatemo_menu">
        <ul>
          <li><a href="./">Home</a></li>
          <li><a href="./forums/" target="_blank">Forums</a></li>
          <li><a href="./blog/">Blog</a></li>
<?php
$Query = "SELECT * FROM ".TOPICS_TABLE." WHERE forum_id=".PAGES_FORUM_ID." AND topic_type=0 ORDER BY topic_id ASC";
$Pages = GetAll($db, $Query);
$X = 0;
While (isset($Pages[$X])) {
    $Title = explode("*",$Pages[$X]['topic_title']);
?><li><a href="./<?php Echo html_entity_decode($Title[0]);?>/"><?php Echo html_entity_decode($Title[1]); ?></a></li>
<?php
$X++;
}
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
?>
        </ul>
      </div>
    </div>
</div>
