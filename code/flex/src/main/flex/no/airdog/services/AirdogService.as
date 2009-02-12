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
        
        public function hentAvkom(hundId:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentAvkom(hundId), resultat, feil);
        }
        
        public function hentJaktprove(hundId:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentJaktprove(hundId), resultat, feil);
        }
        
        public function hentHund(hundId:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentHund(hundId), resultat, feil);
        }
	}
}