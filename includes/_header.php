<?php
If (isset($_GET['1'])) { $Page = $_GET['1']; } Else { $Page = 'home'; }
if (file_exists("./includes/pages/_{$Page}.php")) { $Title = ucfirst($Page); }
Else { $Title = getTitle($db,$Page); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://www.bruce-industries.com/"></base>
<title>Bruce-Industries :: <?php Echo $Title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css" media="all">
@import "./includes/style.css";
</style>
<link rel="stylesheet" href="./includes/nivo-slider.css" type="text/css" media="screen" />
<script src="./includes/js/jquery.min.js" type="text/javascript"></script>
</head>
<body>

<div id="templatemo_header_wrapper">
	<div id="templatemo_header">
    
    	<div id="site_title">
            <a href="./"></a>
        </div> <!-- end of site_title -->
        
        
