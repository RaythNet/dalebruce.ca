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
} ?>
        </ul>
      </div>
    </div>
</div>
