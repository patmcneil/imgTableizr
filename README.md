# imgTableizr

### Description
_A fun bit of code to generate an HTML table into a graphic based on an input of a raster image._

**Tableizr** has no real practical application, it is a thought experiment that turned real. The only use I can think of is inserting a small image (e.g. a logo) into an HTML email or forum post without having to download a resource.

A certain level of "compression" is achieved by comparing adjacent pixels and combining `<td>`s. This can be controlled via the parameters. With single color graphics, the weight of the code may be worth the trade-off. But, larger more complex images can increase the file size over the original .jpg by over 300x! Such enormous tables can cripple the browsers displaying them.

### Usage
```php
imgTableizr(string $imgSrc[, mixed $quality='medium', mixed $width='no-resize']);
```

### Parameters
`$imgSrc` _Required._ The path to the image file. Accepts **.jpg, png, gif,** and **.bmp** files, Both relative and absolute paths.

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
Return a table using the original image size and medium quality:
```php
echo imgTableizr('pic.png');
```
Return a table using maximum quality:
```php
echo imgTableizr('images/pic.jpg', 'maximum');
```
Return a table using the URL to an image, between low and medium quality, and resized to 500px wide:
```php
echo imgTableizr('http://example.com/pic.jpg', 25, 500);
```