<?php

# imgTableizr v 1.0 
# Patrick McNeil
# http://patmcneil.net
# Updated: Oct. 15, 2015

function imgTableizr( $imgSrc, $quality='medium', $width='no-resize' ){

	global $colspan, $prevHex, $prevRGB, $currentHex, $currentRGB, $tdCount, $output;

	$output = array();

	$explodedSrc = explode( '.', $imgSrc );
	$ext = $explodedSrc[ count($explodedSrc) - 1 ];

	if (preg_match('/jpg|jpeg/i',$ext)){
		$img = imagecreatefromjpeg( $imgSrc );
	}else if (preg_match('/png/i',$ext)){
		$img = imagecreatefrompng( $imgSrc );
	}else if (preg_match('/gif/i',$ext)){
		$img = imagecreatefromgif( $imgSrc );
	}else if (preg_match('/bmp/i',$ext)){
		$img = imagecreatefrombmp( $imgSrc );
	}else{
		return false;
	}

	if( $width != 'no-resize' && is_int( $width ) && $width > 0 ){
		$img = imagescale( $img, $width );
	}    

	$imgW = imagesx( $img );
	$imgH = imagesy( $img );

	switch($quality){
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

	array_push( $output,'<table style="border-spacing:0px;width:'.$imgW.'px;height:'.$imgH.'px;margin:0;padding:0;border-spacing:0;">' );

	for( $row = 0; $imgH > $row; $row++ ){

		array_push( $output,'<tr>' );

		for( $col = 0; $imgW > $col; $col++ ){

			$rgb = imagecolorat( $img, $col, $row );
			$r = ( $rgb >> 16 ) & 0xFF;
			$g = ( $rgb >> 8 ) & 0xFF;
			$b = $rgb & 0xFF;
			$currentRGB = array( 0 => $r, 1 => $g, 2 => $b) ;
			$currentHex = rgb2hex($currentRGB);
			
			if( $col != 0 ){
				if( abs( $currentRGB[0] - $prevRGB[0]) <= $threshold ){
					if( abs( $currentRGB[1] - $prevRGB[1]) <= $threshold ){
						if( abs( $currentRGB[2] - $prevRGB[2]) <= $threshold ){

							$colspan ++;

							if( $col+1 == $imgW ){
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
		array_push( $output,'</tr>' );
	}
	array_push( $output, '</table>');

	$output = implode( '', $output );

	imagedestroy( $img );

	return $output;
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
