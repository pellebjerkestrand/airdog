package no.airdog.controller
{
	import no.airdog.services.Components;
	
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
			Components.instance.session.hundprofil = Components.instance.session.hundeliste[nr];
			Components.instance.session.hovedNavigasjon.nr = 2;
		}

	}
}