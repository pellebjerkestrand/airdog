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
    		jaktproveVindu.width = 900;
    		jaktproveVindu.height = 580;
        	PopUpManager.centerPopUp(jaktproveVindu);
			PopUpManager.bringToFront(jaktproveVindu);
			
        }      
        
        public function visRedigerJaktproveVindu(parent:DisplayObject, jaktprove:Jaktprove):void
        {
        	Components.instance.session.jaktprove = jaktprove as Jaktprove;
        	
    		jaktproveVindu = PopUpManager.createPopUp(parent, JaktproveVindu, true) as JaktproveVindu;
    		jaktproveVindu.width = 900;
    		jaktproveVindu.height = 580;
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
			Components.instance.services.airdogService.loggUt(new Function());
			Components.instance.historie.nullstill();
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
			Components.instance.historie.settPunkt();
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
			Components.instance.session.jaktproveSammendrag = null;
			Components.instance.services.airdogService.hentJaktprover(hundId, hentJaktproverResultat);
			Components.instance.services.airdogService.hentJaktproveSammendrag(hundId, hentJaktproveSammendragResultat);
		}
		
		public function hentJaktproverResultat(event:Object):void
		{
			Components.instance.session.jaktproveListe = new ArrayCollection(event as Array);
		}
		
		public function hentJaktproveSammendragResultat(event:Object):void
		{
			Components.instance.session.jaktproveSammendrag = new ArrayCollection(event as Array);
		}
		
		public function hentUtstillinger(hundId:String):void
		{
			Components.instance.session.utstillingListe = null;
			Components.instance.services.airdogService.hentUtstillinger(hundId, hentUtstillingerResultat);
		}
		
		public function hentUtstillingerResultat(event:Object):void
		{
			Components.instance.session.utstillingListe = new ArrayCollection(event as Array);
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
			Components.instance.historie.settPunkt();
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
			Components.instance.historie.settPunkt();
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
		
		public function hentFiktivtStamtre(hundIdFar:String, hundIdMor:String, dybde:int):void
		{
			Components.instance.session.fiktivtStamtre = null;
			Components.instance.services.airdogService.hentFiktivtStamtre(hundIdFar, hundIdMor, dybde, hentFiktivtStamtreResultat);
		}
		
		public function hentFiktivtStamtreResultat(event:Object):void
		{
			Components.instance.session.fiktivtStamtre = event as Hund;
			Components.instance.historie.settPunkt();
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
			Components.instance.historie.settPunkt();
		}
		
		public function redigerJaktprove(jaktprove:Jaktprove):void
		{
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
		
		public function leggInnJaktprove(jaktprove:Jaktprove):void
		{	
			Components.instance.services.airdogService.leggInnJaktprove(jaktprove, leggInnJaktproveResultat);
		}
		
		public function leggInnJaktproveResultat(event:Object):void
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
		
		public function hentRollersRettigheter():void
		{
			Components.instance.services.airdogService.hentRollersRettigheter(hentRollersRettigheterResultat);
		}
		
		public function hentRollersRettigheterResultat(event:Object):void
		{
			Components.instance.session.rollersRettigheter = new ArrayCollection(event as Array);
		}
		
		public function leggtilRettighetPaRolle(rolle:String, rettighet:String):void
		{
			Components.instance.services.airdogService.leggtilRettighetPaRolle(rolle, rettighet, hentRollersRettigheterResultat);
		}
		
		public function slettRettighetPaRolle(rolle:String, rettighet:String):void
		{
			Components.instance.services.airdogService.slettRettighetPaRolle(rolle, rettighet, hentRollersRettigheterResultat);
		}
		
		public function leggInnNyRolle(rolle:String):void
		{
			Components.instance.services.airdogService.leggInnNyRolle(rolle, hentRollersRettigheterResultat);
		}
		
		public function slettRolle(rolle:String):void
		{
			Components.instance.services.airdogService.slettRolle(rolle, hentRollersRettigheterResultat);
		}
	}
}