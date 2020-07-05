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
		div.gallery img {
			width: 100%;
			height: 9em;
			object-fit: scale-down;
		}

		div.desc {
			padding: 0.5em;
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
		<h1>RAW Cow</h1>
		<hr>

		<?php

		// FUNCTIONS ---
		function extract_preview_jpeg($work_dir, $prev_dir)
		{
			shell_exec('exiftool -b -PreviewImage -w ' . $prev_dir . '%f.JPG -r ' . $work_dir);
		}
		function is_dir_empty($dir)
		{
			if (!is_readable($dir)) return NULL;
			return (count(scandir($dir)) == 3);
		}
		function auto_level($prev_dir)
		{
			$files = glob($prev_dir . '*.JPG');
			foreach ($files as $file) {
				shell_exec('mogrify -auto-level ' . $prev_dir . basename($file));
			}
		}
		// --- FUNCTIONS

		if (is_dir_empty($work_dir)) {
			echo '<img src="wtf-cow.jpg" alt="WTF Cow" width="600"><br>';
			exit("No RAW files. WTF?");
		}

		if (!file_exists($prev_dir)) {
			shell_exec('mkdir -p ' . $prev_dir);
			extract_preview_jpeg($work_dir, $prev_dir);
			if ($enable_auto_level) {
				auto_level($prev_dir);
			}
		}

		define('IMAGEPATH', $prev_dir);
		foreach (glob(IMAGEPATH . '*.JPG') as $filename) {
			echo '<div class="responsive">';
			echo '<div class="gallery">';
			echo '<a target="_blank" href="' . $filename . '" data-featherlight="image">';
			echo '<img src="' . $filename . '" alt="' . $filename . '">';
			echo '</a>';
			echo '<div class="desc">' . basename($filename). "</div>";
			echo '</div>';
			echo '</div>';
		}
		echo "<form action='process.php' method='post'>";
		echo "<select name='img'>";
		$files = glob("JPG/*");
			foreach ($files as $file) {
				$img = basename($file);
				echo "<option value='$img'>$img</option>";
			}
			echo "</select>";
		echo "<select style='margin-left:0.5em;' name='lut'>";
		$files = glob($lut_dir."*");
			foreach ($files as $file) {
				$lut_name = basename($file);
				$lut = basename($file, ".png");
				echo "<option value='$lut_name'>$lut</option>";
			}
			echo "</select>";
			echo "<input class='btn' style='margin-left:0.5em;' type='submit' value='Process' name='submit'>";
			echo "</form>";
		?>
		<div class="clearfix"></div>
		<hr>
		<form method='POST' action=''>
			<input display: inline!important; class="btn primary" type="submit" name="refresh" value="Refresh">
		</form>
		<?php
		if (isset($_POST["refresh"])) {
			shell_exec('rm -rf ' . $prev_dir);
			shell_exec('mkdir -p ' . $prev_dir);
			extract_preview_jpeg($work_dir, $prev_dir);
			if ($enable_auto_level) {
				auto_level($prev_dir);
			}
			echo '<meta http-equiv="refresh" content="0">';
		}
		?>
	</div>
</body>

</html>