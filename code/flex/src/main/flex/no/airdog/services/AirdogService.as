package no.airdog.services
{
	import flash.events.DataEvent;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	
    
	public class AirdogService extends AbstraktServiceobjekt
	{
		public function loggInn(brukernavn:String, passord:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.loggInn(brukernavn, passord), resultat, feil);
        }
        
        public function hundesok(soketekst:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hundesok(soketekst), resultat, feil);
        }
	}
}