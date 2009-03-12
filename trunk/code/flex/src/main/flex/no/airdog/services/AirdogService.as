package no.airdog.services
{
	import no.airdog.model.Bruker;
	import no.airdog.model.Hund;
	import no.airdog.model.Jaktprove;
	  
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
        
        public function hentJaktprover(hundId:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentJaktprover(
        		hundId,
        		Components.instance.session.bruker.epost,
    			Components.instance.session.bruker.passord,
    			Components.instance.session.bruker.sattKlubbId), 
			resultat, feil);
        }
        
     public function hentJaktproveSammendrag(hundId:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentJaktproveSammendrag(
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
        	callServiceFunction(service.loggUt(), resultat, feil);
        }
        
        public function hentStamtre(hundId:String, dybde:int, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentStamtre(
        		hundId,
        		dybde,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function hentFiktivtStamtre(hundIdFar:String, hundIdMor:String, dybde:int, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentFiktivtStamtre(
        		hundIdFar,
        		hundIdMor,
        		dybde,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function redigerHund(hund:Hund, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.redigerHund(
        		hund,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);        	
        }
        
        
        public function sokArsgjennomsnitt(hund:String, ar:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.sokArsgjennomsnitt(
        		hund,
        		ar,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function redigerJaktprove(jaktprove:Jaktprove, resultat:Function, feil:Function=null):void
        {
       		callServiceFunction(service.redigerJaktprove(
        		jaktprove,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);        	
        }

		public function slettJaktprove(jaktproveId:String, resultat:Function, feil:Function=null):void
        {
       		callServiceFunction(service.slettJaktprove(
        		jaktproveId,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        	
        }
        
       	public function leggInnJaktprove(jaktprove:Jaktprove, resultat:Function, feil:Function=null):void
        {
       		callServiceFunction(service.leggInnJaktprove(
        		jaktprove,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);        	
        }
        
        public function hentAlleRoller(resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentAlleRoller(
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function hentAlleRettigheter(resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentAlleRettigheter(
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function hentRollersRettigheter(resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentRollersRettigheter(
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
	}
}