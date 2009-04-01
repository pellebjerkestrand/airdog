<?php

class BildeendringController
{
	public function __construct()
	{

	}
	
	function endreStorrelse($bilde, $nyBredde, $nyHoyde, $kroppBredde, $kroppHoyde)
	{
		$naStorrelse = @getimagesize($bilde);
		$nanyBredde = $naStorrelse[0];
		$nanyHoyde = $naStorrelse[1];
		
		$hx = (100 / ($nanyBredde / $nyBredde)) * .01;
		$hx = @round ($nanyHoyde * $hx);

		$wx = (100 / ($nanyHoyde / $nyHoyde)) * .01;
		$wx = @round ($nanyBredde * $wx);

		if ($hx < $nyHoyde)
		{
			$nyHoyde = (100 / ($nanyBredde / $nyBredde)) * .01;
			$nyHoyde = @round ($nanyHoyde * $nyHoyde);
		} 
		else 
		{
			$nyBredde = (100 / ($nanyHoyde / $nyHoyde)) * .01;
			$nyBredde = @round ($nanyBredde * $nyBredde);
		}
		
		$bi = @ImageCreateFromJPEG ($bilde) or
		$bi = @ImageCreateFromPNG ($bilde) or 
		$bi = @ImageCreateFromGIF ($bilde) or
		$bi = false;
		
		@unlink($bilde);
		
		if ($bi) 
		{
			$nyttBilde = @ImageCreateTrueColor ($nyBredde, $nyHoyde);
			@ImageCopyResampled ($nyttBilde, $bi, 0, 0, 0, 0, $nyBredde, $nyHoyde, $nanyBredde, $nanyHoyde);
			
			$bilde = $this->fjernFilEndelse($bilde).".jpg";
				
			@Imagejpeg($nyttBilde, $bilde, 100);
			
			//Croppingen
			$bi = @ImageCreateFromJPEG ($bilde);
			
			$thumb = @ImageCreateTrueColor($kroppBredde, $kroppHoyde);
 
			$nyBreddeNy = $nyBredde / $kroppBredde;
			$nyHoydeNy = $nyHoyde / $kroppHoyde;
			 
			$halvertHoyde = $kroppHoyde / 2;
			$halvertBredde = $kroppBredde / 2;
			
			$bilde = $this->fjernFilEndelse($bilde)."_thumb.jpg";	
			
			if($nyBredde > $nyHoyde) 
			{
				$tilpassetBredde = $nyBredde / $nyHoydeNy;
			    $halvBredde = $tilpassetBredde / 2;
			    $intBredde = $halvBredde - $halvertBredde;
			 
			    @ImageCopyResampled($thumb,$bi,-$intBredde,0,0,0,$tilpassetBredde,$kroppHoyde,$nyBredde,$nyHoyde);
			} 
			elseif(($nyBredde < $nyHoyde) || ($nyBredde == $nyHoyde)) 
			{
			 	$tilPassetHoyde = $nyHoyde / $nyBreddeNy;
			    $halvHoyde = $tilPassetHoyde / 2;
			   	$intHoyde = $halvHoyde - $halvertHoyde;
			 
			 	@ImageCopyResampled($thumb,$bi,0,-$intHoyde,0,0,$kroppBredde,$tilPassetHoyde,$nyBredde,$nyHoyde);
			}
			else
			{
				@ImageCopyResampled($thumb,$bi,0,0,0,0,$kroppBredde,$kroppHoyde,$nyBredde,$nyHoyde);
			}
			
						 	
			@imagejpeg ($thumb, $bilde, 100);
			
			echo "Bilde filene er opprettet";
		}
		else 
		{	
			echo "Feil type bilde";
		} 
	}

	private function fjernFilEndelse($fil) 
	{ 
		$ext = strrchr($fil, '.'); 
	
		if($ext !== false) 
		{ 
			$fil = substr($fil, 0, -strlen($ext)); 
		} 
		
		return $fil; 
	} 
}