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
<script src="./includes/js/jquery.nivo.slider.js" type="text/javascript"></script>
<script type="text/javascript">
$(window).load(function() {
	$('#slider').nivoSlider({
		effect:'random',
		slices:15,
		animSpeed:600,
		pauseTime:5000,
		startSlide:0, //Set starting Slide (0 index)
		directionNav:false, 
		directionNavHide:false, //Only show on hover
		controlNav:false, //1,2,3...
		controlNavThumbs:false, //Use thumbnails for Control Nav
		pauseOnHover:true, //Stop animation while hovering
		manualAdvance:false, //Force manual transitions
		captionOpacity:0.7, //Universal caption opacity
		beforeChange: function(){},
		afterChange: function(){},
		slideshowEnd: function(){} //Triggers after all slides have been shown
	});
});
</script>
</head>
<body>

<div id="templatemo_header_wrapper">
	<div id="templatemo_header">
    
    	<div id="site_title">
            <a href="./"></a>
        </div> <!-- end of site_title -->
        
        
