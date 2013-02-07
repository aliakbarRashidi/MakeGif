<p>Video is required, other parameters are optional and will override the default behavior of converting the entire video, original size, at 10fps. Source video is deleted after processing. Takes time after uploading to process, so be patient.</p>
<form action="" method="post" enctype="multipart/form-data">
	<ul>
		<li><label>Source video:</label><input type="file" name="movie" /></li>
		<li><label>Output size (px):</label><input type="text" name="width" value=""/> x <input type="text" name="height" value=""/></li>
		<li><label>Framerate (fps):</label><input type="text" name="framerate"/></li>
		<li><label>Start (seconds):</label><input type="text" name="start"/></li>
		<li><label>Duration (seconds):</label><input type="text" name="duration" /></li>
		<!--li><label>Gif delay (seconds/100):</label><input type="text" name="delay"/></li-->
		<li><input type="submit" value="Make Gif" /></li>
	</ul>
</form>