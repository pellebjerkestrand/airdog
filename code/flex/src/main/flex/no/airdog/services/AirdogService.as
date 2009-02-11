package no.airdog.services
{
	import no.airdog.model.Bruker;
	  
	public class AirdogService extends AbstraktServiceobjekt
	{
		public function loggInn(bruker:Bruker, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.loggInn(bruker), resultat, feil);
        }
        
        public function hundesok(soketekst:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hundesok(soketekst), resultat, feil);
        }
	}
}