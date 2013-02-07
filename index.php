<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);

include 'upload.php';

class validation {
	public function check_video($object) {
		$mime = $object->file['mime'];
		
		if (substr_count($mime, "video/")==0) {
			$object->set_error('You must upload a video!');
		}
	}
}

$body="";

$lines = file('headers.txt');
$header = $lines[array_rand($lines)];

function posted($p) {
	return (isset($_POST[$p]) && strlen($_POST[$p])>0 && (string)(int)$_POST[$p] == $_POST[$p]);
}

function destroy_dir($dir) {
	if (!is_dir($dir) || is_link($dir)) return unlink($dir);
	foreach (scandir($dir) as $file) {
		if ($file == '.' || $file == '..') continue;
		if (!destroy_dir($dir . DIRECTORY_SEPARATOR . $file)) {
			chmod($dir . DIRECTORY_SEPARATOR . $file, 0777);
			if (!destroy_dir($dir . DIRECTORY_SEPARATOR . $file)) return false;
		};
	}
	return rmdir($dir);
}

if (!empty($_FILES['movie'])) {
	$upload = Upload::factory('input');
	$upload->file($_FILES['movie']);
	$validation = new validation;
	$upload->callbacks($validation, array('check_video'));
	
	$results = $upload->upload();
	//$body = "<pre>".print_r($results, true)."</pre>";
	
	if(empty($results["errors"])) {
		$workingdir = "working/".$results["filename"];
		
		if(is_dir($workingdir))
			destroy_dir($workingdir);
		
		if(mkdir($workingdir)) {
			$ffmpeg = "ffmpeg ";
			
			$framerate = 10;
			if( posted("framerate") ) {
				$framerate = intval($_POST["framerate"]);
			}
			$ffmpeg .= "-r ".$framerate." ";
			
			$ffmpeg .= "-i ".$results["full_path"]." ";
			
			
			if( posted("start") ) {
				$ffmpeg .= "-ss ".$_POST["start"]." ";
			}
			
			if( posted("duration") ) {
				$ffmpeg .= "-t ".$_POST["duration"]." ";
			}
			
			if( posted("width") && posted("height") ) {
				$ffmpeg .= "-s ".$_POST["width"]."x".$_POST["height"]." ";
			}
			
			$ffmpeg .= $workingdir."/frame%08d.gif";
			
			$gifsicle = "gifsicle --loop --optimize --delay ";
			if( posted("delay") ) {
				$gifsicle .= $_POST["delay"]." ";
			} else {
				$delay = intval(100/$framerate);
				$gifsicle .= $delay." ";
			}
			$gifsicle .= $workingdir."/frame*.gif > output/".$results["filename"].".gif";
			
			//$body .= $ffmpeg."<br/>".$gifsicle;
			shell_exec($ffmpeg);
			shell_exec($gifsicle);
			
			//CLean up
			destroy_dir($workingdir);
			unlink($results["full_path"]);
			
			$body = file_get_contents("success.tpl");
			$body .= "<img src='output/".$results["filename"].".gif'/>";
		}
	} else {
		foreach($results["errors"] as $err) {
			$body .= "<p><strong>Error:</strong>".$err."</p>";
		}
	}
} else {
	$body = file_get_contents("form.tpl");
}

echo str_ireplace(
	array(
		"{Body}",
		"{Header}"
	),
	array(
		$body,
		$header
	),
	file_get_contents("main.tpl")
);

?>
