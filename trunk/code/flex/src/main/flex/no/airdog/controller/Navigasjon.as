package no.airdog.controller
{
	import mx.core.ClassFactory;
	
	import no.airdog.services.Components;
	import no.airdog.view.hundeListeRenderer.NavnRendererLiten;
	import no.airdog.view.hundeListeRenderer.NavnRendererStor;
	
	public class Navigasjon
	{
		public static function visLastOpp():void
		{
			Components.instance.session.hovedNavigasjon.nr = 0;
			Components.instance.session.hovedNavigasjon.laster = true;
		}
		
		public static function visHundeliste():void
		{
			Components.instance.session.hovedNavigasjon.nr = 1;
			Components.instance.session.hovedNavigasjon.laster = false;
		}
		
		public static function visHundNr(nr:int):void
		{
			Components.instance.session.hundprofil = Components.instance.session.hundesokListe.provider[nr];
			Components.instance.session.hovedNavigasjon.nr = 2;
		}
		
		public static function visHundprofil():void
		{
			Components.instance.session.hovedNavigasjon.nr = 2;
		}
		
		public static function visStorHundeliste():void
		{
			Components.instance.session.hundesokListe.renderer = new ClassFactory(no.airdog.view.hundeListeRenderer.NavnRendererStor);
			Components.instance.session.hundesokListe.rendererHoyde = 60;
		}
		
		public static function visLitenHundeliste():void
		{
			Components.instance.session.hundesokListe.renderer = new ClassFactory(no.airdog.view.hundeListeRenderer.NavnRendererLiten);
			Components.instance.session.hundesokListe.rendererHoyde = 20;
		}
		
		public static function visAdminRoller():void
		{
			Components.instance.session.hovedNavigasjon.nr = 4;
		}
		
		public static function visAdminBrukere():void
		{
			Components.instance.session.hovedNavigasjon.nr = 3;
		}
		
		public static function visACL():void
		{
			Components.instance.session.hovedNavigasjon.nr = 5;
		}
		
		public static function visArsgjennomsnitt():void
		{
			Components.instance.session.hovedNavigasjon.nr = 6;
		}
		
		public static function visFiktivStamtre():void
		{
			Components.instance.session.hovedNavigasjon.nr = 7;
		}
		
		
		public static function visHjem():void
		{
			Components.instance.session.hovedNavigasjon.nr = 8;
		}
		
		public static function visAdminBackup():void
		{
			Components.instance.controller.hentKopier();
			Components.instance.session.hovedNavigasjon.nr = 9;
		}
		
		public static function visJaktprove():void
		{
			Components.instance.session.hovedNavigasjon.nr = 10;
		}
	}
}