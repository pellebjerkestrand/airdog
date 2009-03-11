package no.airdog.controller
{
	import mx.core.ClassFactory;
	
	import no.airdog.services.Components;
	import no.airdog.view.HundeListeRenderer.NavnRendererLiten;
	import no.airdog.view.HundeListeRenderer.NavnRendererStor;
	
	public class Navigasjon
	{
		public static function visLastOpp():void
		{
			Components.instance.session.hovedNavigasjon.nr = 0;
			Components.instance.session.hovedNavigasjon.laster = true;
			Components.instance.historie.settPunkt();
		}
		
		public static function visHundeliste():void
		{
			Components.instance.session.hovedNavigasjon.nr = 1;
			Components.instance.session.hovedNavigasjon.laster = false;
			Components.instance.historie.settPunkt();
		}
		
		public static function visHundNr(nr:int):void
		{
			Components.instance.session.hundprofil = Components.instance.session.hundesokListe.provider[nr];
			Components.instance.session.hovedNavigasjon.nr = 2;
		}
		
		public static function visStorHundeliste():void
		{
			Components.instance.session.hundesokListe.renderer = new ClassFactory(no.airdog.view.HundeListeRenderer.NavnRendererStor);
			Components.instance.session.hundesokListe.rendererHoyde = 60;
		}
		
		public static function visLitenHundeliste():void
		{
			Components.instance.session.hundesokListe.renderer = new ClassFactory(no.airdog.view.HundeListeRenderer.NavnRendererLiten);
			Components.instance.session.hundesokListe.rendererHoyde = 20;
		}
		
		public static function visAdminRoller():void
		{
			Components.instance.session.hovedNavigasjon.nr = 3;
			Components.instance.historie.settPunkt();
		}
		
		public static function visACL():void
		{
			Components.instance.session.hovedNavigasjon.nr = 4;
			Components.instance.historie.settPunkt();
		}
		
		public static function visArsgjennomsnitt():void
		{
			Components.instance.session.hovedNavigasjon.nr = 5;
			Components.instance.historie.settPunkt();
		}
	}
}