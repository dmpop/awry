<?php
error_reporting(E_ERROR);
include('config.php');
?>
<html lang="en" data-theme="<?php echo $theme ?>">
<!-- Author: Dmitri Popov, dmpop@linux.com
         License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->

<head>
	<meta charset="utf-8">
	<title>RAW Cow</title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="css/classless.css">
	<link rel="stylesheet" href="css/themes.css">
	<link href="css/featherlight.min.css" type="text/css" rel="stylesheet" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		div.gallery img {
			width: 100%;
			height: 9em;
			object-fit: scale-down;
		}

		div.desc {
			padding: 0.1em;
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
	<div class="card">
		<h1 class="text-center" style="margin-top: 0em;">RAW Cow</h1>
		<form class="text-center" style="margin-top: 1em;" method='POST' action=''>
			<button type="submit" name="refresh">Refresh</button>
		</form>
		<div class="text-center">
			<?php
			echo "<form style='margin-top: .5em;' action='process.php' method='POST'>";
			echo "<select name='img'>";
			$files = glob("$jpg_dir/*");
			foreach ($files as $file) {
				$img = basename($file);
				echo "<option value='$img'>$img</option>";
			}
			echo "</select>";
			echo "<select style='margin-left:0.5em;' name='lut'>";
			$files = glob($lut_dir . "*");
			foreach ($files as $file) {
				$lut_name = basename($file);
				$lut = basename($file, ".png");
				echo "<option value='$lut_name'>$lut</option>";
			}
			echo "</select>";
			echo '<button type="submit" name="process">Process</button>';
			echo "</form>";
			?>
		</div>
		<hr>

		<?php

		// FUNCTIONS ---
		function extract_preview_jpeg($raw_dir, $jpg_dir)
		{
			shell_exec('exiftool -b -PreviewImage -w ' . $jpg_dir . '%f.JPG -r ' . $raw_dir);
		}
		function is_dir_empty($dir)
		{
			if (!is_readable($dir)) return NULL;
			return (count(scandir($dir)) == 3);
		}
		function auto_level($jpg_dir)
		{
			$files = glob($jpg_dir . "*.JPG");
			foreach ($files as $file) {
				shell_exec('mogrify -auto-level ' . $jpg_dir . basename($file));
			}
		}
		// --- FUNCTIONS

		if (is_dir_empty($raw_dir)) {
			echo '<img src="wtf-cow.jpg" alt="WTF Cow" width="600"><br>';
			exit("No RAW files. WTF?");
		}

		if (!file_exists($jpg_dir)) {
			shell_exec('mkdir -p ' . $jpg_dir);
			extract_preview_jpeg($raw_dir, $jpg_dir);
			if ($enable_auto_level) {
				auto_level($jpg_dir);
			}
		}

		define('IMAGEPATH', $jpg_dir);
		foreach (glob(IMAGEPATH . "*.JPG") as $filename) {
			echo '<div class="responsive">';
			echo '<div class="gallery">';
			echo '<a target="_blank" href="' . $filename . '" data-featherlight="image">';
			echo '<img src="' . $filename . '" alt="' . $filename . '">';
			echo '</a>';
			echo '<div class="desc">' . basename($filename) . "</div>";
			echo '</div>';
			echo '</div>';
		}

		if (isset($_POST["refresh"])) {
			shell_exec('rm -rf ' . $jpg_dir);
			shell_exec('mkdir -p ' . $jpg_dir);
			extract_preview_jpeg($raw_dir, $jpg_dir);
			if ($enable_auto_level) {
				auto_level($jpg_dir);
			}
			echo '<meta http-equiv="refresh" content="0">';
		}
		?>
		<div class="clearfix"></div>
		<hr>
		<div class="text-center"><?php echo $footer; ?></div>
	</div>
</body>

</html>