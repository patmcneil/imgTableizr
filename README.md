# imgTableizr

### Description
_A fun bit of code to generate an HTML table from a raster image._

**Tableizr** has no real practical application--- it's more of a thought experiment that arose during drinks that turned real. The only use I can think of is to generate a table to insert a graphic (e.g. a logo) into an HTML email or forum post without having to download a image resource. It's more of a funny tool than anything else.

A level of "compression" is achieved by comparing adjacent pixels and combining `<td>`s. This can be controlled via the parameters. With small, single color graphics, the weight of the code may be worth the trade-off. But larger, more complex images can increase the file size over the original image by over 300 times! Such enormous tables can cripple the browsers displaying them.

### Usage
`<?php include(img-tableizr.php) ?>`, then `echo` the function to print the table.
```php
imgTableizr(string $imgSrc[, mixed $quality='medium', mixed $width='no-resize']);
```

### Parameters
`$imgSrc` _Required._ The path to the image file. Accepts **.jpg, .png, .gif,** and **.bmp** files, Both relative and absolute paths.

`$quality` _Optional._ String: `'low'` `'medium'` `'high'` `'maximum'` or any positive integer, where quality decreases as value increases from `0`. See below chart for reference. **Defaults to medium.**

| String          | Value            |
|:---------------:|:----------------:|
| low             | 30               |
| medium          | 20               |
| high            | 10               |
| maximum         | 0                |

`$width` _Optional._ The width in pixels that the image will be resized to. Defaults to `no-resize`. _Resizing the image distorts the source pixels, and may cause rendering inaccuracies._ **Large images _will_ cause browser rendering failures.**

### Return Value
If successful, this function returns an HTML table as a string. On failure, this function returns `false`.

### Examples
Print a table using the original image size and medium quality:
```php
echo imgTableizr('pic.png');
```
Print a table using maximum quality:
```php
echo imgTableizr('images/pic.jpg', 'maximum');
```
Print a table using the URL to an image, between low and medium quality, and resized to 500px wide:
```php
echo imgTableizr('http://example.com/pic.jpg', 25, 500);
```
