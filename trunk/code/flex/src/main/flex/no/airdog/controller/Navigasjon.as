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
		}
		
		public static function visHundeliste():void
		{
			Components.instance.session.hovedNavigasjon.nr = 1;
			Components.instance.session.hovedNavigasjon.laster = false;
		}
		
		public static function visHundNr(nr:int):void
		{
			Components.instance.session.hundprofil = Components.instance.session.hundeliste.provider[nr];
			Components.instance.session.hovedNavigasjon.nr = 2;
		}
		
		public static function visStorHundeliste():void
		{
			Components.instance.session.hundeliste.renderer = new ClassFactory(no.airdog.view.HundeListeRenderer.NavnRendererStor);
			Components.instance.session.hundeliste.storrelse = 60;
		}
		
		public static function visLitenHundeliste():void
		{
			Components.instance.session.hundeliste.renderer = new ClassFactory(no.airdog.view.HundeListeRenderer.NavnRendererLiten);
			Components.instance.session.hundeliste.storrelse = 20;
		}

	}
}