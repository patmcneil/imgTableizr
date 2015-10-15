# Tableizr

A fun bit of code to convert a raster image to an HTML table.

### Description

`imgTableizr( string $imgSrc [, mixed $quality = 'medium' , mixed $width = 'no-resize' ] );`

### Parameters
`imgSrc` _Required._ The path to the image file. Accepts **.jpg, png, gif,** and **.bmp** files, both relative and absolute paths.

`quality` _Optional._ String: `'low'` `'medium'` `'high'` `'maximum'` or an integer, where quality decreases as value increases from 0. **Defaults to medium.**

`width` _Optional._ The width in pixels that the image will be resized to. Defaults to `no-resize`. _Modifying the image distorts the source pixels, and may cause rendering innacuracies._ **Large images _will_ cause browser rendering failures.**

### Return Value
If successful, this function returns an HTML table in the form of a string. On failure, this function returns false.

### Examples
`echo imgTableizr('pic.png');` returns a table using the original image size and medium quality. 

`echo imgTableizr('images/pic.jpg', 'maximum');` returns a table using maximum quality.

`echo imgTableizr('http://example.com/pic.jpg', 25, 500);`