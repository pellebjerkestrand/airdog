package no.airdog.services
{
	import mx.collections.ArrayCollection;
	
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
        
        public function hentUtstillinger(hundId:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentUtstillinger(
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
        
        public function hentPerson(personId:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentPerson(
        		personId,
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
        
        public function leggtilRettighetPaRolle(rolle:String, rettighet:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.leggtilRettighetPaRolle(
        		rolle,
        		rettighet,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function slettRettighetPaRolle(rolle:String, rettighet:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.slettRettighetPaRolle(
        		rolle,
        		rettighet,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
       	public function leggInnNyRolle(rolle:String, beskrivelse:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.leggInnNyRolle(
        		rolle,
        		beskrivelse,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
       	public function slettRolle(rolle:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.slettRolle(
        		rolle,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function hentTabeller(resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentTabeller(
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function hentKopier(resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentKopier(
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
//        public function lagKopi(tabell:String, resultat:Function, feil:Function=null):void
//        {
//        	callServiceFunction(service.lagKopi(
//        		tabell,
//        		Components.instance.session.bruker.epost,
//        		Components.instance.session.bruker.passord,
//        		Components.instance.session.bruker.sattKlubbId),
//        	resultat, feil);
//        }
        
        public function lagFullKopi(navn:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.lagFullKopi(
        		navn,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function hentFiler(mappe:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentFiler(
        		mappe,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
//        public function lastKopi(tabell:String, mappe:String, resultat:Function, feil:Function=null):void
//        {
//        	callServiceFunction(service.lastKopi(
//        		tabell,
//        		mappe,
//        		Components.instance.session.bruker.epost,
//        		Components.instance.session.bruker.passord,
//        		Components.instance.session.bruker.sattKlubbId),
//        	resultat, feil);
//        }
        
        public function lastKopier(tabeller:ArrayCollection, mappe:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.lastKopier(
        		tabeller.toArray(),
        		mappe,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function hentRollersBrukere(resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentRollersBrukere(
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function hentAlleBrukere(resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.hentAlleBrukere(
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function leggBrukerTilRolle(rolle:String, bruker:String, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.leggBrukerTilRolle(
        		rolle,
        		bruker,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function slettBrukerFraRolle(rolle:String, bruker:String, resultat:Function, feil:Function=null):void
        {
       		callServiceFunction(service.slettBrukerFraRolle(
        		rolle,
        		bruker,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function slettBruker(epost:String, resultat:Function, feil:Function=null):void
		{
			callServiceFunction(service.slettBruker(
        		epost,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
		}
        
        public function leggInnBruker(bruker:Bruker, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.leggInnBruker(
        		bruker,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function redigerBruker(fraBruker:Bruker, tilBruker:Bruker, resultat:Function, feil:Function=null):void
        {
        	callServiceFunction(service.redigerBruker(
        		fraBruker, tilBruker,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
        
        public function redigerEgenBruker(fraBruker:Bruker, tilBruker:Bruker, resultat:Function, feil:Function=null):void
        {
       		callServiceFunction(service.redigerEgenBruker(
        		fraBruker, 
        		tilBruker,
        		Components.instance.session.bruker.epost,
        		Components.instance.session.bruker.passord,
        		Components.instance.session.bruker.sattKlubbId),
        	resultat, feil);
        }
	}
}