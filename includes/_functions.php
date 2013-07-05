<?php
/* Functions.php
 * Author: Ryan Morrison AKA Rayth
 * Description: Useful functions to be used in PHP Applications.
 * Version: 1.1
 * Updates:
 *          1.1 Updated MySQL to MySQLi for PHP 5.5.0 and later.
 *              Added GetArray(). Added Start().
 *          1.0 First Edition of the File.
 */

/* Function: Start
 * Description: Connects to MySQL. Loads session variables.
 */
Function Start($Host,$Username,$Password) {
    session_start();
    $Link = mysqli_connect($Host, $Username, $Password);
    Return $Link;
}
/* Function: Clean
 * Description: Clean a string to go through a MySQL query successfully.
 *              Prevents SQL Injection
 */
Function Clean($Link,$String) { return mysqli_real_escape_string($Link,$String); }

/* Function: Query
 * Description: Query a MySQL Database.
 *              Automatically runs through the Clean() function.
 */
Function Query($Link,$Query) {
    $Result = mysqli_query($Link,$Query) or die("Error with Query: {$Query}. [".mysqli_error($Link)."]");
    Return $Result;
}

/* Function: GetArray
 * Description: Returns a 1 Dimensional array containing the result from a
 *              MySQL Query.
 */
Function GetArray($Link,$Query) {
    $Result = Query($Link,$Query);
    Return mysqli_fetch_array($Result);
}

/* Function: GetAll
 * Description: Returns a Multi Dimensional array containing all the results for
 *              a query to a MySQL database.
 */
Function GetAll($Link,$Query) {
    $Result = Query($Link,$Query);
    If (mysqli_num_rows($Result) > 0) {
        While ($Row = mysqli_fetch_array($Result)) { $X[] = $Row; }
        Return $X;
    } Else { Return Null; }
}

/* Function: nl2br2
 * Description: Use in place of nl2br. Removes the nl character completely.
 *              Makes it easier to use explode() from a text box.
 */
Function nl2br2($String) { 
    $String = str_replace(array("\r\n", "\r", "\n"), "<br />", $String); 
    Return $String; 
}

/* Function: getTitle
 * Description: Will get the title of a page that isn't created by a file.
 */
Function getTitle($Link,$Page) {
    $Page = Clean($Link,$Page);
    $Query = "SELECT * FROM ".TOPICS_TABLE." WHERE forum_id=".PAGES_FORUM_ID." AND topic_title LIKE '{$Page}%'";
    $TitleResult = GetArray($Link, $Query);
    If ($TitleResult) { $Title = explode("*",$TitleResult['topic_title']);
    Return $Title[1]; } Else { Return "404 Error"; }
}

/* Function: loadPage
 * Description: Will load a page that isn't created by a file.
 */
Function loadPage($Link,$Page) {
    $Page = Clean($Link,$Page);
    $Query = "SELECT * FROM ".TOPICS_TABLE." WHERE forum_id=".PAGES_FORUM_ID." AND topic_title LIKE '{$Page}%'";
    $PageResult = GetArray($Link, $Query);
    If ($PageResult['topic_id']) {
        $Query = "SELECT * FROM ".POSTS_TABLE." WHERE post_id={$PageResult['topic_first_post_id']}";
        $Post = GetArray($Link, $Query);
        Return $Post['post_text'];
    } Else {
        Return "<h2>Page not found.</h2><p>The page you are looking for does not exist.</p>";
    }
}
/*
 * Function: getAvatar
 * Description: Will get the avatar for user with Name of $ID in following Priority:
 *              User > Group. If none is found, default will be used.
 */
Function getAvatar($Link,$ID) {
    $Query = "SELECT * FROM ".USERS_TABLE." WHERE username='{$ID}'";
    $User = GetArray($Link,$Query);
    If ($User['user_avatar'] == "") {
        $Query = "SELECT * FROM ".GROUPS_TABLE." WHERE group_id={$User['group_id']}";
        $Group = GetArray($Link,$Query);
        If ($Group['group_avatar'] == "") { return Null; }
        Else { Return $Group['group_avatar']; }
    } Else { Return $User['user_avatar']; }
}
function BBCode($Text,$uid) {
    $bbcode = array (
        "/\[b:".$uid."\](.*?)\[\/b:".$uid."\]/is" => "<b>$1</b>",
        "/\[u:".$uid."\](.*?)\[\/u:".$uid."\]/is" => "<u>$1</u>",
        "/\[url\=(.*?):".$uid."\](.*?)\[\/url:".$uid."\]/is" => "<a href='$1'>$2</a>",
        "/\[img:".$uid."\](.*?)\[\/img:".$uid."\]/is" => "<img src='$1'>",
        "/\[s:".$uid."\](.*?)\[\/s:".$uid."\]/is" => "<s>$1</s>",
        "/\[i:".$uid."\](.*?)\[\/i:".$uid."\]/is" => "<i>$1</i>",
        "/\[color=(.*?):".$uid."\](.*?)\[\/color:".$uid."\]/is" => "<font color='$1'>$2</font>",
        "/\[size=(.*?):".$uid."\](.*?)\[\/size:".$uid."\]/is" => "<span style='font-size: $1%; line-height: normal;'>$2</span>",
        "/\[list:".$uid."\](.*?)\[\/list:".$uid."\]/is" => "<ul>$1</ul>",
        "/\[list=1:".$uid."\](.*?)\[\/list:".$uid."\]/is" => "<ol>$1</ol>",
        "/\[\*:".$uid."\]([^\[]+)/i" => "<li>$1</li>"
    );  
    $Text = nl2br($Text);
    $New = preg_replace(array_keys($bbcode), array_values($bbcode), $Text);
    Return $New;
}
?>