package no.airdog.controller
{
	import mx.core.ClassFactory;
	
	import no.airdog.services.Components;
	import no.airdog.view.renderer.hundeliste.NavnRendererLiten;
	import no.airdog.view.renderer.hundeliste.NavnRendererStor;
	
	public class Navigasjon
	{
		public static function naviger(barnNr:int):void
		{
			Components.instance.session.hovedNavigasjon.nr = barnNr;
			
			if(barnNr == 7)
			{
				Components.instance.controller.hentAlleBrukere();
				Components.instance.controller.hentRollersBrukere();
			}
			else if(barnNr == 8)
			{
				Components.instance.controller.hentAlleRettigheter();
				Components.instance.controller.hentRollersRettigheter();
			}
			else if(barnNr == 11)
			{
				Components.instance.controller.hentKopier();
			}
			else if(barnNr == 12)
			{
				Components.instance.controller.hentArrangementer();
			}
			else if(barnNr == 13)
			{
				Components.instance.session.aarbokHund = null;
			}
			
			Components.instance.historie.settPunkt();
		}
		
		public static function visStorHundeliste():void
		{
			Components.instance.session.hundesokListe.renderer = new ClassFactory(no.airdog.view.renderer.hundeliste.NavnRendererStor);
			Components.instance.session.hundesokListe.rendererHoyde = 60;
		}
		
		public static function visLitenHundeliste():void
		{
			Components.instance.session.hundesokListe.renderer = new ClassFactory(no.airdog.view.renderer.hundeliste.NavnRendererLiten);
			Components.instance.session.hundesokListe.rendererHoyde = 20;
		}
	}
}