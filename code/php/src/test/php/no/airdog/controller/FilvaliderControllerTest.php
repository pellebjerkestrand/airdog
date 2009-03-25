<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'\..\..\LastZendTest.php';
require_once str_replace('.','/','no.airdog.controller').'/FilvaliderController.php';

class FilvaliderControllerTest extends PHPUnit_Framework_TestCase 
{
    function testGetFiltypeFraFil() 
    {
    	$fv = new FilvaliderController();
    	$this->assertEquals("Eier", $fv->getFiltypeFraFil(dirname(__FILE__).'\..\..\..\..\dummyfiler\Eier.dat'));
    }
    
	function testGetFiltypeController() 
    {
    	$fv = new FilvaliderController();
    	$this->assertEquals("Eier", $fv->getFiltype("EIER|HUID|RAID"));
    	$this->assertEquals("Fugl", $fv->getFiltype("ProeveNr|ProveDato|PartiNr|Klasse|PEID_Domm1|PEID_Domm2|HUID|SlippTid|EgneStand|EgneStoekk|TomStand|MakkerStand|MakkerStoekk|JaktLyst|Fart|Stil|Selvstendighet|Bredde|Reviering|Samarbeid|Pres_Upresis|Pres_NoeUpresis|Pres_Presis|Reis_Nekter|Reis_Noelende|Reis_Villig|Reis_Djerv|Sek_Stjeler|Sek_Spontan|App_IkkeGodkj|App_Godkj|Rapp_Innkalt|Rapp_Spont|Premiegrad|CERTIFIKAT|RegAv|RegDato|RAID"));
    	$this->assertEquals("Hdsykdom", $fv->getFiltype("AvlestAv|Betaling|Diagnose|DiagnoseKode|EndretAv|HDID|HUID|IdMerket|IdMerkerKode|Kode|Lidelse|LidelseKode|PEID|RAID|RegAv|SekHoyre|SekHoyreKode|SekVenstre|SekVenstreKode|Sendes|VEID|RontgenDato|AvlestDato"));
    	$this->assertEquals("Hund", $fv->getFiltype("RAID|KUID|HUID|Tittel|Navn|HUIDFar|HUIDMor|IDNR|FargeBeskrivelse|FargeVariant|AD|HD|Haarlag|IDMerk|Kjoenn|PEID|EndretAv|EndretDato|RegDato|Stoerrelse"));
    	$this->assertEquals("Kull", $fv->getFiltype("KUID|HUIDFar|HUIDMor|PEIDOppdretter|EndretDato|Foedt|RAID"));
    	$this->assertEquals("Oppdrett", $fv->getFiltype("KUID|Oppdretter|RAID"));
    	$this->assertEquals("Person", $fv->getFiltype("PEID|Navn|Adresse1|Adresse2|Adresse3|Postnr|Landkode|RAID|Status|Telefon1|EndretDato|RegDato|Foedt"));
    	$this->assertEquals("Premie", $fv->getFiltype("DOID|UTID|HUID|Katalognr|PEIDdommer|Klasse|Kjonn|RAID|IM|KIP|JK|JKK|UK|UKK|BK|BKK|AK|AKK|VK|CHK|CHKK|VTK|VTKK|HP|CK|CC|CA|BIK|BIR|BIM"));
    	$this->assertEquals("Utstilling", $fv->getFiltype("UTID|KLID|PEID|RegDato|RegAv|Navn|Adresse1|Adresse2|Postnr|SpesialAdresse|UtstillingDato|UtstillingSted|ArrangoerNavn1|ArrangoerNavn2|OverfoertDato"));
    	$this->assertEquals("Veteriner", $fv->getFiltype("VEID|PEID|Adresse1|Adresse2|Adresse3|Postnr|Telefon|Telefax|KlinikkNavn|RegDato|RegAv|EndretAv"));
    	$this->assertEquals("Aasykdom", $fv->getFiltype("VEID|AAID|DiagnoseKode|IdMerkerKode|LidelseKode|SekHoyreKode|SekVenstreKode|EndretAv|RegAv|AvlestAv|Betaling|Diagnose|HUID|IdFeil|IdMerket|Kode|Lidelse|PEID|Purring|RAID|Retur|SekHoyre|SekVenstre|Sendes|AvlestDato|RontgenDato"));
    
    	$this->assertEquals("Ukjent", $fv->getFiltype("EIER|HUIT|RAID"));
    	$this->assertEquals("Ukjent", $fv->getFiltype(""));
    }
}
?>