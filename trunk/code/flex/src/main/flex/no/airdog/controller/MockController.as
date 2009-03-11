package no.airdog.controller
{
	import flash.display.DisplayObject;
	
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.events.*;
	import mx.formatters.DateFormatter;
	import mx.managers.PopUpManager;
	import mx.rpc.events.*;
	
	import no.airdog.model.*;
	import no.airdog.services.Components;
	import no.airdog.view.*;
	import no.airdog.view.admin.*;

	
	public class MockController implements IController
	{     
		private var vindu:InnloggingVindu;
		private var klubb:KlubbVindu;
		private var jaktproveVindu:JaktproveVindu;
		private var redigerHundVindu:RedigerHundVindu;
		
        public function MockController()
        {
        	var tmpCollection:ArrayCollection = new ArrayCollection();
        }
        
        public function visLeggInnJaktproveVindu(parent:DisplayObject):void
        {
        	Components.instance.session.jaktprove = new Jaktprove;
        	Components.instance.session.jaktprove.regAv = Components.instance.session.bruker.epost;
        	
	        var df:DateFormatter = new DateFormatter();
			df.formatString = "YYYY-MM-DD";
        	Components.instance.session.jaktprove.regDato = df.format(new Date());
        	
    		jaktproveVindu = PopUpManager.createPopUp(parent, JaktproveVindu, true) as JaktproveVindu;
    		jaktproveVindu.width = parent.width * 0.80;
    		jaktproveVindu.height = parent.height *  0.90;
        	PopUpManager.centerPopUp(jaktproveVindu);
			PopUpManager.bringToFront(jaktproveVindu);
			
        }      
        
        public function visRedigerJaktproveVindu(parent:DisplayObject, jaktprove:Jaktprove):void
        {
        	Components.instance.session.jaktprove = jaktprove as Jaktprove;
        	
    		jaktproveVindu = PopUpManager.createPopUp(parent, JaktproveVindu, true) as JaktproveVindu;
    		jaktproveVindu.width = parent.width * 0.80;
    		jaktproveVindu.height = parent.height *  0.90;
        	PopUpManager.centerPopUp(jaktproveVindu);
			PopUpManager.bringToFront(jaktproveVindu);
        }
       
        public function fjernJaktproveVindu():void
        {
        	Components.instance.session.jaktprove = null;
        	PopUpManager.removePopUp(jaktproveVindu);
        }
        
        public function visLoggInnVindu(parent:DisplayObject):void
        {
        	vindu = PopUpManager.createPopUp(parent, InnloggingVindu, true) as InnloggingVindu;
			PopUpManager.centerPopUp(vindu);
			PopUpManager.bringToFront(vindu);
    		vindu.isPopUp = false;
        }
        
        public function fjernLoggInnVindu():void
        {
        	PopUpManager.removePopUp(vindu);
        }
        
        public function settBrukersKlubb(klubb:String, klubbId:String):void
        {
        	Components.instance.session.bruker.sattKlubb = klubb;
        	Components.instance.session.bruker.sattKlubbId = klubbId;
        	fjernLoggInnVindu();
        	
        	hentBrukersRettigheter();
			hentBrukersRoller();
        }
		
		public function loggInn(brukernavn:String, passord:String):void
		{
			Components.instance.session.bruker.epost = brukernavn;
			Components.instance.session.bruker.passord = passord;
			Components.instance.services.airdogService.loggInn(Components.instance.session.bruker, loggInnResultEvent, loggInnFaultEvent);
		}
		
		private function loggInnResultEvent(bruker:Object):void
		{			
			if(bruker)
			{	
				if(bruker.toString() == "FEIL_BRUKERNAVN_PASSORD")
				{
					vindu.ristVindu();
					loggUt();
					return;
				}	
				
				Components.instance.session.bruker.innlogget = true;
							
				hentBrukersKlubber();
			}
			else
			{
				vindu.ristVindu();
				loggUt();
			}
		}
		
		private function loggInnFaultEvent(event:FaultEvent):void
		{
			vindu.ristVindu();
			Alert.show( "Klarer ikke å koble til server\n" + event.fault.message.toString(), "Innlogging mislyktes", 0);
			loggUt();
		}
		
		public function loggUt():void
		{
			
			Components.instance.session = new Session;
			

			
			Components.instance.session.hovedNavigasjon.nr = 1;
			
			Components.instance.services.airdogService.loggUt(new Function());
		}
		
		public function lastOppDatFil():void
		{
			var url:String = "http://localhost:8888/AirDog%20-%20PHP/src/main/php/no/airdog/controller/FilopplastController.php?";
			//var url:String = "http://airdog.no/backend/no/airdog/controller/FilopplastController.php?";
			
			url += "brukerEpost=" + Components.instance.session.bruker.epost + "&";
			url += "brukerPassord=" + Components.instance.session.bruker.passord + "&";
			url += "klubbId=" + Components.instance.session.bruker.sattKlubbId;
			
			var datOpplaster:Filopplaster = new Filopplaster(url);
			datOpplaster.velgFil();
		}
		
		public function sokHund(soketekst:String):void
		{
			Components.instance.session.hundesokListe.provider = new ArrayCollection();
			Components.instance.services.airdogService.sokHund(soketekst, hundesokResultat);
		}
		
		public function hundesokResultat(event:Object):void
		{
			Components.instance.session.hundesokListe.provider = new ArrayCollection(event as Array);
		}
		
		public function hentAvkom(hundId:String):void
		{
			//Components.instance.session.avkomListe = new ArrayCollection();
			Components.instance.services.airdogService.hentAvkom(hundId, hentAvkomResultat);
		}
		
		public function hentAvkomResultat(event:Object):void
		{
			Components.instance.session.avkomListe = new ArrayCollection(event as Array);
		}
		
		public function hentJaktprover(hundId:String):void
		{
			Components.instance.session.jaktproveListe = null;
			Components.instance.services.airdogService.hentJaktprover(hundId, hentJaktproverResultat);
		}
		
		public function hentJaktproverResultat(event:Object):void
		{
			Components.instance.session.jaktproveListe = new ArrayCollection(event as Array);
		}
		
		public function visHund(hundId:String):void
		{
			//Components.instance.session.hundprofil = null;
			Components.instance.services.airdogService.hentHund(hundId, visHundResultat);
		}
		
		public function visHundResultat(event:Hund):void
		{
			Components.instance.session.hundprofil = event;
			Components.instance.session.hovedNavigasjon.nr = 2;
		}
		
		public function hentBrukersKlubber():void
		{
			//Components.instance.session.bruker.klubber = new ArrayCollection();
			Components.instance.services.airdogService.hentBrukersKlubber(hentBrukersKlubberResultat);
		}
		
		public function hentBrukersKlubberResultat(event:Object):void
		{
			Components.instance.session.bruker.klubber = new ArrayCollection(event as Array);
		}
		
		public function hentBrukersRoller():void
		{
			//Components.instance.session.bruker.roller = new ArrayCollection();
			Components.instance.services.airdogService.hentBrukersRoller(hentBrukersRollerResultat);
		}
		
		public function hentBrukersRollerResultat(event:Object):void
		{
			Components.instance.session.bruker.roller = new ArrayCollection(event as Array);
		}
		
		public function hentBrukersRettigheter():void
		{
			//Components.instance.session.bruker.rettigheter = new ArrayCollection();
			Components.instance.services.airdogService.hentBrukersRettigheter(hentBrukersRettigheterResultat);
		}
		
		public function hentBrukersRettigheterResultat(event:Object):void
		{
			Components.instance.session.bruker.rettigheter = new ArrayCollection(event as Array);
		}
		
		public function hentStamtre(hundId:String, dybde:int):void
		{
			Components.instance.session.stamtre = null;
			Components.instance.services.airdogService.hentStamtre(hundId, dybde, hentStamtreResultat);
		}
		
		public function hentStamtreResultat(event:Object):void
		{
			Components.instance.session.stamtre = event as Hund;
		}
		
		public function redigerHund(hund:Hund):void
		{
			
			Components.instance.services.airdogService.redigerHund(hund, redigerHundResultat);			
		}
		
		public function redigerHundResultat(event:Object):void
		{
			
		}
		
		public function visRedigerHundVindu(parent:DisplayObject, hund:Object):void
        {
        	Components.instance.session.hundprofil = hund as Hund;
        	
    		redigerHundVindu = PopUpManager.createPopUp(parent, RedigerHundVindu, true) as RedigerHundVindu;
        	PopUpManager.centerPopUp(redigerHundVindu);
			PopUpManager.bringToFront(redigerHundVindu);
        }
        
        public function lukkRedigerHundVindu():void
        {
        	PopUpManager.removePopUp(redigerHundVindu);
        }
		
		public function sokArsgjennomsnitt(hund:String, ar:String):void
		{
			Components.instance.session.arsgjennomsnitt = new ArrayCollection();
			Components.instance.services.airdogService.sokArsgjennomsnitt(hund, ar, sokArsgjennomsnittResultat);
		}
		
		public function sokArsgjennomsnittResultat(event:Object):void
		{
			Components.instance.session.arsgjennomsnitt = new ArrayCollection(event as Array);
		}
		
		public function redigerJaktprove(verdier:Object):void
		{
			var jaktprove:Jaktprove = new Jaktprove;
			jaktprove.proveNr = verdier.proveNr;
			jaktprove.proveDato = verdier.proveDato;
			jaktprove.partiNr = verdier.partiNr;
			jaktprove.klasse = verdier.klasse;
			jaktprove.dommerId1 = verdier.dommerId1;
			jaktprove.dommerId2 = verdier.dommerId2;
			jaktprove.hundId = verdier.hundId;
			jaktprove.slippTid = verdier.slippTid;
			jaktprove.egneStand = verdier.egneStand;
			jaktprove.egneStokk = verdier.egneStokk;
			jaktprove.tomStand = verdier.tomStand;
			jaktprove.makkerStand = verdier.makkerStand;
			jaktprove.makkerStokk = verdier.makkerStokk;
			jaktprove.jaktlyst = verdier.jaktlyst;
			jaktprove.fart = verdier.fart;
			jaktprove.stil = verdier.stil;
			jaktprove.selvstendighet = verdier.selvstendighet;
			jaktprove.bredde = verdier.bredde;
			jaktprove.reviering = verdier.reviering;
			jaktprove.samarbeid = verdier.samarbeid;
			jaktprove.presUpresis = verdier.presUpresis;
			jaktprove.presNoeUpresis = verdier.presNoeUpresis;
			jaktprove.presPresis = verdier.presPresis;
			jaktprove.reisNekter = verdier.reisNekter;
			jaktprove.reisNoelende = verdier.reisNoelende;
			jaktprove.reisVillig = verdier.reisVillig;
			jaktprove.reisDjerv = verdier.reisDjerv;
			jaktprove.sokStjeler = verdier.sokStjeler;
			jaktprove.sokSpontant = verdier.sokSpontant;
			jaktprove.appIkkeGodkjent = verdier.appIkkeGodkjent;
			jaktprove.appGodkjent = verdier.appGodkjent;
			jaktprove.rappInnkalt = verdier.rappInnkalt;
			jaktprove.rappSpont = verdier.rappSpont;
			jaktprove.premiegrad = verdier.premiegrad;
			jaktprove.certifikat = verdier.certifikat;
			jaktprove.regAv = verdier.regAv;
			jaktprove.regDato = verdier.regDato;
			jaktprove.raseId = verdier.raseId;
			jaktprove.manueltEndretAv = verdier.manueltEndretAv;
			jaktprove.manueltEndretDato = verdier.manueltEndretDato;
			
			Components.instance.services.airdogService.redigerJaktprove(jaktprove, redigerJaktproveResultat);
		}
		
		public function redigerJaktproveResultat(event:Object):void
		{
			
		}
		
		public function slettJaktprove(jaktproveId:String):void
		{
			Components.instance.services.airdogService.slettJaktprove(jaktproveId, slettJaktproveResultat);
		}
		
		public function slettJaktproveResultat(event:Object):void
		{
			
		}
		
		public function leggInnJaktProve(verdier:Object):void
		{
			var jaktprove:Jaktprove = new Jaktprove;
			jaktprove.proveNr = verdier.proveNr;
			jaktprove.proveDato = verdier.proveDato;
			jaktprove.partiNr = verdier.partiNr;
			jaktprove.klasse = verdier.klasse;
			jaktprove.dommerId1 = verdier.dommerId1;
			jaktprove.dommerId2 = verdier.dommerId2;
			jaktprove.hundId = verdier.hundId;
			jaktprove.slippTid = verdier.slippTid;
			jaktprove.egneStand = verdier.egneStand;
			jaktprove.egneStokk = verdier.egneStokk;
			jaktprove.tomStand = verdier.tomStand;
			jaktprove.makkerStand = verdier.makkerStand;
			jaktprove.makkerStokk = verdier.makkerStokk;
			jaktprove.jaktlyst = verdier.jaktlyst;
			jaktprove.fart = verdier.fart;
			jaktprove.stil = verdier.stil;
			jaktprove.selvstendighet = verdier.selvstendighet;
			jaktprove.bredde = verdier.bredde;
			jaktprove.reviering = verdier.reviering;
			jaktprove.samarbeid = verdier.samarbeid;
			jaktprove.presUpresis = verdier.presUpresis;
			jaktprove.presNoeUpresis = verdier.presNoeUpresis;
			jaktprove.presPresis = verdier.presPresis;
			jaktprove.reisNekter = verdier.reisNekter;
			jaktprove.reisNoelende = verdier.reisNoelende;
			jaktprove.reisVillig = verdier.reisVillig;
			jaktprove.reisDjerv = verdier.reisDjerv;
			jaktprove.sokStjeler = verdier.sokStjeler;
			jaktprove.sokSpontant = verdier.sokSpontant;
			jaktprove.appIkkeGodkjent = verdier.appIkkeGodkjent;
			jaktprove.appGodkjent = verdier.appGodkjent;
			jaktprove.rappInnkalt = verdier.rappInnkalt;
			jaktprove.rappSpont = verdier.rappSpont;
			jaktprove.premiegrad = verdier.premiegrad;
			jaktprove.certifikat = verdier.certifikat;
			jaktprove.regAv = verdier.regAv;
			jaktprove.regDato = verdier.regDato;
			jaktprove.raseId = verdier.raseId;
			jaktprove.manueltEndretAv = verdier.manueltEndretAv;
			jaktprove.manueltEndretDato = verdier.manueltEndretDato;
			
			Components.instance.services.airdogService.leggInnJaktprove(jaktprove, leggInnJaktProveResultat);
		}
		
		public function leggInnJaktProveResultat(event:Object):void
		{
		
		}
		
		public function hentAlleRoller():void
		{
			Components.instance.services.airdogService.hentAlleRoller(hentAlleRollerResultat);
		}
		
		public function hentAlleRollerResultat(event:Object):void
		{
			Components.instance.session.alleRoller = new ArrayCollection(event as Array);
		}
		
		public function hentAlleRettigheter():void
		{
			Components.instance.services.airdogService.hentAlleRettigheter(hentAlleRettigheterResultat);
		}
		
		public function hentAlleRettigheterResultat(event:Object):void
		{
			Components.instance.session.alleRettigheter = new ArrayCollection(event as Array);
		}
	}
}