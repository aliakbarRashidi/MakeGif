About
================================
This is small PHP frontend to the FFMpeg and Gifsicle command line utilities. It supports uploading a single video file and immediately converting it to a GIF. Optional paramaters to control frame rate, video length, and size are available. The script attempts to generate optimized GIFs that support a full 256 color palette.

Dependencies
================================
* http://www.ffmpeg.org/
* http://www.lcdf.org/gifsicle/

This script relies on the command line binaries ```ffmpeg``` and ```gifsicle```. It shouldn't be difficult finding an FFMpeg package on your distribution repositories or from their website. Gifsicle is likewise easily obtainable from it's website.

TODO, maybe
================================
* Streamline process: break process into multiple steps
* Allow fine tuning of paramaters as well as preview generation
* More options?
* Support for URL upload? Youtube?
* Better css?

Thanks
================================
Thanks to Schneems for inspiring me and introducing me to his GIF workflow. Thanks to Aivis for his PHP file upload class that made writing this a whole lot nicer.

* http://schneems.com/post/41104255619/use-gifs-in-your-pull-request-for-good-not-evil
* https://github.com/aivis/PHP-file-upload-class/
