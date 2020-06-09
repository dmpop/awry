<?php
error_reporting(E_ERROR);
include('config.php');
?>

<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
	<title>RAW Cow</title>
	<link rel="icon" href="cow.png">
	<link rel="stylesheet" href="css/lit.css">
	<link href="css/featherlight.min.css" type="text/css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Nunito" rel="stylesheet"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	 img.cow {
	     border-radius: 50%;
	     display: block;
	     margin-left: auto;
	     margin-right: auto;
	     margin-bottom: 1.5em;
	 }
	 
	 div.gallery {
	     border: 1px solid #ccc;
	 }
	 
	 div.gallery:hover {
	     border: 1px solid #777;
	 }
	 
	 div.gallery img {
	     width: 100%;
	     height: auto;
	 }
	 div.desc {
	     padding: 5px;
	     text-align: center;
	 }
	 
	 * {
	     box-sizing: border-box;
	 }

	 .responsive {
	     padding: 0 6px;
	     float: left;
	     width: 24.99999%;
	 }

	 @media only screen and (max-width: 800px) {
	     .responsive {
		 width: 49.99999%;
		 margin: 6px 0;
	     }
	 }

	 @media only screen and (max-width: 500px) {
	     .responsive {
		 width: 100%;
	     }
	 }

	 .clearfix:after {
	     content: "";
	     display: table;
	     clear: both;
	 }
	</style>
    </head>
    <body>
	<script src="js/jquery.min.js"></script>
	<script src="js/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
	<div class="c">
	    <img class="cow" src="cow.png" alt="RAW Cow" width="100">
	    <hr>

	    <?php
	    // FUNCTIONS ---
	    function extract_preview_jpeg($work_dir, $prev_dir, $file_ext) {
		shell_exec('exiftool -b -PreviewImage -w .JPG -ext '.$file_ext.' -r '.$work_dir);
		$files = glob($work_dir.'*.JPG');
		foreach($files as $file)
		{
		    rename($file, $prev_dir.basename($file));
		}
	    } 
	    function is_dir_empty($dir) {
		if (!is_readable($dir)) return NULL; 
		return (count(scandir($dir)) == 3);
	    }
	    function copy_exif($work_dir, $file_ext, $prev_dir) {
		$files = glob($work_dir.'*.'.$file_ext);
		foreach($files as $file)
		{
		    shell_exec('exiftool -overwrite_original -TagsFromFile '.$work_dir.pathinfo($file, PATHINFO_FILENAME).'.'.$file_ext.' '.$prev_dir.pathinfo($file, PATHINFO_FILENAME).'.JPG');
		    $exposuretime = shell_exec('exiftool -ExposureTime '.$prev_dir.pathinfo($file, PATHINFO_FILENAME).'.JPG | cut -d":" -f2');
		    $aperture = shell_exec('exiftool -Aperture '.$prev_dir.pathinfo($file, PATHINFO_FILENAME).'.JPG | cut -d":" -f2');
		    $iso = shell_exec('exiftool -Iso '.$prev_dir.pathinfo($file, PATHINFO_FILENAME).'.JPG | cut -d":" -f2');
		    shell_exec('convert '.$prev_dir.pathinfo($file, PATHINFO_FILENAME).'.JPG -gravity SouthWest -annotate 0x0 -pointsize 15 -fill White -annotate 0 "Aperture: '.$aperture.'Exposure: '.$exposuretime.'ISO: '.$iso.'" '.$prev_dir.pathinfo($file, PATHINFO_FILENAME).'.JPG');
		}
	    }
	    // --- FUNCTIONS
	    
	    if (is_dir_empty($work_dir))
	    {
		echo '<img src="wtf-cow.jpg" alt="WTF Cow" width="600"><br>';
		exit("No RAW files. WTF?");
	    }
	    
	    if (!file_exists($prev_dir))
	    {
		shell_exec('mkdir -p '.$prev_dir);
		extract_preview_jpeg($work_dir, $prev_dir, $file_ext);
		if ($enable_exif) {
		    copy_exif($work_dir, $file_ext, $prev_dir);
		}
	    }

	    define('IMAGEPATH', $prev_dir);
	    foreach(glob(IMAGEPATH.'*') as $filename){
		echo '<div class="responsive">';
		echo '<div class="gallery">';
		echo '<a target="_blank" href="'.$filename.'" data-featherlight="image">';
		echo '<img src="'.$filename.'" alt="'.$filename.'" width="600">';
		echo '</a>';
		echo '<div class="desc">'.basename($filename).'</div>';
		echo '</div>';
		echo '</div>';
	    }
	    ?>
	    <div class="clearfix"></div>
	    <hr>
	    <form method='POST' action=''>
		<input display: inline!important; class="btn primary"  type="submit" name="refresh" value="Refresh">
		That's <a href="https://gitlab.com/dmpop/raw-cow"> RAW Cow</a> for you!
	    </form>
	    <?php
	    if(isset($_POST["refresh"])) {
		shell_exec('rm -rf '.$prev_dir);
		shell_exec('mkdir -p '.$prev_dir);
		extract_preview_jpeg($work_dir, $prev_dir, $file_ext);
		if ($enable_exif) {
		    copy_exif($work_dir, $file_ext, $prev_dir);
		}
		echo '<meta http-equiv="refresh" content="0">';
	    }
	    ?>
	</div>
    </body>
</html>
