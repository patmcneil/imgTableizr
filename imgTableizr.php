<?php

# imgTableizr v 1.0 
# Patrick McNeil
# http://patmcneil.net

function imgTableizr( $imgSrc, $quality='medium', $width='no-resize' ){

	global $colspan, $prevHex, $prevRGB, $currentHex, $currentRGB, $tdCount, $output;

	$output = array();

	$explodedSrc = explode( '.', $imgSrc );
	$ext = end( $explodedSrc );

	switch( $ext ){
		case 'jpg' || 'jpeg':
			$img = imagecreatefromjpeg( $imgSrc );
		break;
		case 'png':
			$img = imagecreatefrompng( $imgSrc );
		break;
		case 'gif':
			$img = imagecreatefromgif( $imgSrc );
		break;
		case 'bmp':
			$img = imagecreatefrombmp( $imgSrc );
		break;
		default: return false;
	}

	if( $width != 'no-resize' && is_int( $width ) && $width > 0 ){
		$img = imagescale( $img, $width );
	}    

	switch( $quality ){
		case 'medium':
			$threshold = 20;
		break;
		case 'low':
			$threshold = 30;
		break;
		case 'high':
			$threshold = 10;
		break;
		case 'maximum':
			$threshold = 0;
		break;
		case is_int($quality) && $quality >= 0:
			$threshold = $quality;
		break;
		case is_int($quality) && $quality < 0:
			$threshold = 0;
		break;
		default: return false;
	}

	$imgW = imagesx( $img );
	$imgH = imagesy( $img );

	array_push( $output,'<table style="border-spacing:0;width:'.$imgW.'px;height:'.$imgH.'px;margin:0;padding:0;">' );

	for( $y = 0; $imgH > $y; $y++ ){

		array_push( $output, '<tr>' );

		for( $x = 0; $imgW > $x; $x++ ){

			$rgb = imagecolorat( $img, $x, $y );
			$currentRGB = array( 0 => ( $rgb >> 16 ) & 0xFF, 1 => ( $rgb >> 8 ) & 0xFF, 2 => $rgb & 0xFF);
			$currentHex = rgb2hex($currentRGB);
			
			if( $x != 0 ){
				if( abs( $currentRGB[0] - $prevRGB[0]) <= $threshold ){
					if( abs( $currentRGB[1] - $prevRGB[1]) <= $threshold ){
						if( abs( $currentRGB[2] - $prevRGB[2]) <= $threshold ){

							$colspan++;

							if( $x + 1 == $imgW ){
								generateCell();
							}
						}else{
							generateCell();
						}
					}else{
						generateCell();
					}
				}else{
					generateCell();
				}
			}else{
				$prevHex = $currentHex;
				$prevRGB = $currentRGB;
			}
		}
		array_push( $output, '</tr>' );
	}
	array_push( $output, '</table>');

	imagedestroy( $img );

	echo implode( '', $output );
}

function rgb2hex($rgb) {
	$hex = str_pad( dechex( $rgb[0] ), 2, "0", STR_PAD_LEFT );
	$hex .= str_pad( dechex( $rgb[1] ), 2, "0", STR_PAD_LEFT );
	$hex .= str_pad( dechex( $rgb[2] ), 2, "0", STR_PAD_LEFT );
	return $hex;
}

function generateCell(){
	global $colspan, $prevHex, $prevRGB, $currentHex, $currentRGB, $output;

	array_push( $output, '<td style="height:1px;width:'.$colspan.'px;margin:0;padding:0;border-spacing:0"bgcolor="#'.$prevHex.'"colspan="'.$colspan.'"></td>' );
	$prevHex = $currentHex;
	$prevRGB = $currentRGB;
	$colspan = 1;
}
