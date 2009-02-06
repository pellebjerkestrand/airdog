package no.airdog.controller
{
	import no.airdog.services.Components;
	
	public class Navigasjon
	{
		public static function visLastOpp():void
		{
			Components.instance.session.navigasjonNr = 0;
			Components.instance.session.navigasjonLaster = true;
		}
		
		public static function visHundeliste():void
		{
			Components.instance.session.navigasjonNr = 1;
			Components.instance.session.navigasjonLaster = false;
		}
		
		public static function visHundNr(nr:int):void
		{
			Components.instance.session.navigasjonNr = 2;
		}

	}
}