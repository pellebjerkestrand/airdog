<?php
require_once "no/airdog/controller/Verktoy.php";
class BildeendringController
{
	public function __construct()
	{

	}
	
	public function lagreBilde($sti, $filnavn, $nyBredde, $nyHoyde, $kroppBredde, $kroppHoyde)
	{
		$nyttFilnavn = $this->lagBildeMedStorrelse($sti, $filnavn, Verktoy::fjernFilEndelse($filnavn).".jpg", $nyBredde, $nyHoyde);
				
		if($nyttFilnavn != -1)
		{
			echo "Bilde endret";
			
			$this->lagBildeMedStorrelse($sti, $nyttFilnavn, Verktoy::fjernFilEndelse($nyttFilnavn)."_thumb.jpg", $kroppBredde, $kroppHoyde);
			//$this->cropBilde($sti, $nyttFilnavn, Verktoy::fjernFilEndelse($nyttFilnavn)."_crop.jpg", $kroppBredde, $kroppHoyde);
		}
		else
		{
			echo "Feil i opplasting";
		}
		
	}
	
	public function erlendParser()
 	{
 		$sti = Verktoy::hoppBakover(dirname(__FILE__),3) . "/images/";
 		$handle = opendir($sti);
		
		while ($fil = readdir($handle)) 
		{
			if(!is_dir($sti . $fil))
			{
				$this->lagreBilde($sti, $fil, "230", "230", "50", "50");
				copy($sti . Verktoy::fjernFilEndelse($fil).".jpg", $sti . "348/".Verktoy::fjernFilEndelse($fil).".jpg");
				copy($sti . Verktoy::fjernFilEndelse($fil)."_thumb.jpg", $sti . "348/".Verktoy::fjernFilEndelse($fil)."_thumb.jpg");
				unlink($sti . Verktoy::fjernFilEndelse($fil).".jpg");
				unlink($sti . Verktoy::fjernFilEndelse($fil)."_thumb.jpg");
			}	
	    }
	}
	
	
	
	private function lagBildeMedStorrelse($sti, $filnavn, $nyttFilnavn, $nyBredde, $nyHoyde)
	{	
		$gammeltBilde = $sti.$filnavn;
		
		$bi = ImageCreateFromJPEG ($gammeltBilde) or
		$bi = ImageCreateFromPNG ($gammeltBilde) or 
		$bi = ImageCreateFromGIF ($gammeltBilde) or
		$bi = false;

		if ($bi) 
		{	
			$naStorrelse = @getimagesize($gammeltBilde);
			$bredde = $naStorrelse[0];
			$hoyde = $naStorrelse[1];
			
			$hx = (100 / ($bredde / $nyBredde)) * .01;
			$hx = @round ($hoyde * $hx);
	
			$wx = (100 / ($hoyde / $nyHoyde)) * .01;
			$wx = @round ($bredde * $wx);
	
			if ($hx < $nyHoyde)
			{
				$nyHoyde = (100 / ($bredde / $nyBredde)) * .01;
				$nyHoyde = @round ($hoyde * $nyHoyde);
			} 
			else 
			{
				$nyBredde = (100 / ($hoyde / $nyHoyde)) * .01;
				$nyBredde = @round ($bredde * $nyBredde);
			}
		
		
			$resBilde = @ImageCreateTrueColor ($nyBredde, $nyHoyde);
			@ImageCopyResampled ($resBilde, $bi, 0, 0, 0, 0, $nyBredde, $nyHoyde, $bredde, $hoyde);
			

			@Imagejpeg($resBilde, $sti.$nyttFilnavn, 50);
			

			return $nyttFilnavn;
		}
		else 
		{	
			return -1;
		} 
	}
	
	private function cropBilde($sti, $filnavn, $nyttFilnavn, $cropBredde, $cropHoyde)
	{
		$gammeltBilde = $sti.$filnavn;
		
		$bi = @ImageCreateFromJPEG ($gammeltBilde) or
		$bi = @ImageCreateFromPNG ($gammeltBilde) or 
		$bi = @ImageCreateFromGIF ($gammeltBilde) or
		$bi = false;
		
		if ($bi) 
		{
			$naStorrelse = @getimagesize($gammeltBilde);
			
			$bredde = $naStorrelse[0];
			$hoyde = $naStorrelse[1];
	 
			$nyBreddeNy = $bredde / $cropBredde;
			$nyHoydeNy = $hoyde / $cropHoyde;
				 
			$halvertHoyde = $cropHoyde / 2;
			$halvertBredde = $cropBredde / 2;

			$thumb = @ImageCreateTrueColor($cropBredde, $cropHoyde);	
			
			if($bredde > $hoyde) 
			{
				$tilpassetBredde = $bredde / $nyHoydeNy;
			    $halvBredde = $tilpassetBredde / 2;
			    $intBredde = $halvBredde - $halvertBredde;
			 
			    @ImageCopyResampled($thumb,$bi,-$intBredde,0,0,0,$tilpassetBredde,$cropHoyde,$bredde,$hoyde);
			} 
			elseif(($bredde < $hoyde) || ($bredde == $hoyde)) 
			{
			 	$tilPassetHoyde = $hoyde / $nyBreddeNy;
			    $halvHoyde = $tilPassetHoyde / 2;
			   	$intHoyde = $halvHoyde - $halvertHoyde;
			 
			 	@ImageCopyResampled($thumb,$bi,0,-$intHoyde,0,0,$cropBredde,$tilPassetHoyde,$bredde,$hoyde);
			}
			else
			{
				@ImageCopyResampled($thumb,$bi,0,0,0,0,$cropBredde,$cropHoyde,$bredde,$hoyde);
			}
						 	
			@imagejpeg ($thumb, $sti.$nyttFilnavn, 50);
			
			return $nyttFilnavn;
		}
		else 
		{	
			return -1;
		} 
	}
}