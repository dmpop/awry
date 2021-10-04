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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		img {
			border-radius: 1em;
			max-width: 100%;
			align-self: center;
		}
	</style>
</head>

<body>
	<div class="card text-center">
		<h1 style="margin-top: 0em;">RAW Cow</h1>
		<hr style="margin-bottom:3em;">
		<?php
		if (isset($_POST["process"])) {
			$lut = $_POST['lut'];
			$img = $_POST['img'];
			if (!file_exists($result_dir)) {
				mkdir($result_dir, 0777, true);
			}
			$imagick = new \Imagick($prev_dir . $img);
			$imagickPalette = new \Imagick(realpath($lut_dir . $lut));
			$imagick->haldClutImage($imagickPalette);
			$imagick->writeImage($result_dir . $img);
			echo '<a download="' . $result_dir . $img . '" href="' . $result_dir . $img . '" title="Click to download the file"><img alt="Click to download the file" src="' . $result_dir . $img . '"></a>';
		}
		?>
		<div>
			<button style="margin-top: 1.5em;" onclick="location.href='index.php'">Back</button>
		</div>
		<p><?php echo $footer; ?></p>
	</div>
</body>

</html>