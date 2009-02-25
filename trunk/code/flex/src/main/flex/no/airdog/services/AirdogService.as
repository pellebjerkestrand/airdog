package no.airdog.services
{
	import no.airdog.model.Bruker;
	  
	public class AirdogService extends AbstraktServiceobjekt
	{		
		public function loggInn(bruker:Bruker, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.loggInn(bruker), resultat, feil);
        }
        
        public function sokHund(soketekst:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.sokHund(
        		soketekst,
        		Components.instance.session.bruker.epost,
    			Components.instance.session.bruker.passord,
    			Components.instance.session.bruker.sattKlubbId), 
			resultat, feil);
        }
        
        public function hentAvkom(hundId:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentAvkom(
        		hundId,
        		Components.instance.session.bruker.epost,
    			Components.instance.session.bruker.passord,
    			Components.instance.session.bruker.sattKlubbId), 
			resultat, feil);
        }
        
        public function hentJaktprove(hundId:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentJaktprove(
        		hundId,
        		Components.instance.session.bruker.epost,
    			Components.instance.session.bruker.passord,
    			Components.instance.session.bruker.sattKlubbId), 
			resultat, feil);
        }
        
        public function hentHund(hundId:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentHund(
        		hundId,
        		Components.instance.session.bruker.epost,
    			Components.instance.session.bruker.passord,
    			Components.instance.session.bruker.sattKlubbId), 
			resultat, feil);
        }
        
		public function hentBrukersKlubber(resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(
        		service.hentBrukersKlubber(
        			Components.instance.session.bruker.epost,
        			Components.instance.session.bruker.passord),
        		resultat, feil);
        }
        
        public function hentBrukersRoller(resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(
        		service.hentBrukersRoller(
        			Components.instance.session.bruker.epost,
        			Components.instance.session.bruker.passord,
        			Components.instance.session.bruker.sattKlubbId),
        		resultat, feil);
        }
        
        public function hentBrukersRettigheter(resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(
        		service.hentBrukersRettigheter(
        			Components.instance.session.bruker.epost,
        			Components.instance.session.bruker.passord,
        			Components.instance.session.bruker.sattKlubbId),
        		resultat, feil);
        }
        
        public function loggUt(resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.loggUt(), resultat, resultat);
        }
	}
}