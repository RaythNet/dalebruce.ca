<?php
ini_set('display_errors', 'On');
error_reporting(-1);
define('IN_PHPBB', true);
$phpbb_root_path = './forums/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'functions_content.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup(); 
require_once './includes/_functions.php';
require_once './includes/_config.php';
$db = Start($dbhost,$dbuser,$dbpasswd);
$Query = "SELECT * FROM user_tracking WHERE ip_address='{$_SERVER['REMOTE_ADDR']}'"; Echo "<!-- {$_SERVER['REMOTE_ADDR']} -->";
mysqli_select_db($db, $dbname) or die("Unable to select database.");
If (mysqli_num_rows(Query($db,$Query)) < 1) {
    $Query = "INSERT INTO user_tracking (`ip_address`) VALUES ('{$_SERVER['REMOTE_ADDR']}');";
    Query($db,$Query);
}
require_once './includes/_header.php';
require_once './includes/_nav.php';
?>
<div id="templatemo_main_wrapper">
	<div id="templatemo_main">
    
            <div id="templatemo_content"> 
<?php
if (file_exists("./includes/pages/_{$Page}.php")) { include("./includes/pages/_{$Page}.php"); }
Else { Echo html_entity_decode(loadPage($db,$Page)); }
?></div>
<?php
require_once './includes/_side.php';
?>
                </div>
</div><?php
require_once './includes/_footer.php';
?>
