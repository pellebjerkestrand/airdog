package no.airdog.controller
{
	import flash.display.DisplayObject;
	
	import mx.collections.ArrayCollection;
	import mx.collections.Sort;
	import mx.collections.SortField;
	import mx.controls.Alert;
	import mx.events.*;
	import mx.managers.PopUpManager;
	import mx.rpc.events.*;
	
	import no.airdog.model.*;
	import no.airdog.services.Components;
	import no.airdog.view.*;
	import no.airdog.view.admin.*;

	
	public class MainController implements IController
	{     
		private var innloggingVindu:InnloggingView;
		private var klubb:KlubbvalgView;
		private var jaktproveVindu:JaktproveView;
		private var brukerVindu:BrukerView;
		private var redigerHundVindu:RedigerHundView;
		private var redigerEgenBrukerVindu:RedigerEgenBrukerView;
		private var redigerKlubbVindu:RedigerKlubbView;
		
        public function MainController()
        {
        	var tmpCollection:ArrayCollection = new ArrayCollection();
        }
        
        public function visLagAarbok(hund:Hund):void
        {
        	Components.instance.session.aarbokHund = hund;
        	Components.instance.session.hovedNavigasjon.nr = 13;
        }     
        
        public function visRedigerJaktproveVindu(parent:DisplayObject, jaktprove:Jaktprove):void
        {
    		jaktproveVindu = PopUpManager.createPopUp(parent, JaktproveView, true) as JaktproveView;
    		jaktproveVindu.aktivJaktprove = jaktprove;
    		jaktproveVindu.width = 900;
    		jaktproveVindu.height = 580;
    		jaktproveVindu.isPopUp = true;
        	PopUpManager.centerPopUp(jaktproveVindu);
			PopUpManager.bringToFront(jaktproveVindu);
        }
       
        public function fjernJaktproveVindu():void
        {
        	PopUpManager.removePopUp(jaktproveVindu);
        }
        
        public function visRedigerKlubbVindu(parent:DisplayObject):void
        {
    		redigerKlubbVindu = PopUpManager.createPopUp(parent, RedigerKlubbView, true) as RedigerKlubbView;
    		redigerKlubbVindu.isPopUp = false;
        	PopUpManager.centerPopUp(redigerKlubbVindu);
			PopUpManager.bringToFront(redigerKlubbVindu);
        }
        
        public function fjernRedigerKlubbVindu():void
        {
        	PopUpManager.removePopUp(redigerKlubbVindu);
        }
        
        public function redigerKlubb(klubb:Klubb):void
        {
       		Components.instance.services.airDogService.redigerKlubb(klubb, new Function());
       		Components.instance.session.bruker.sattKlubb = klubb;
        }

        public function visRedigerBrukerVindu(parent:DisplayObject, bruker:Bruker):void
        {
    		brukerVindu = PopUpManager.createPopUp(parent, BrukerView, true) as BrukerView;
        	PopUpManager.centerPopUp(brukerVindu);
			PopUpManager.bringToFront(brukerVindu);
			brukerVindu.aktivBruker = bruker;
        }
       
        public function fjernBrukerVindu():void
        {
        	PopUpManager.removePopUp(brukerVindu);
        }
        
        public function visRedigerEgenBrukerVindu(parent:DisplayObject):void
        {
    		redigerEgenBrukerVindu = PopUpManager.createPopUp(parent, RedigerEgenBrukerView, true) as RedigerEgenBrukerView;
        	PopUpManager.centerPopUp(redigerEgenBrukerVindu);
			PopUpManager.bringToFront(redigerEgenBrukerVindu);
        }
       
        public function fjernRedigerEgenBrukerVindu():void
        {
        	PopUpManager.removePopUp(redigerEgenBrukerVindu);
        }
        
        public function visLoggInnVindu(parent:DisplayObject):void
        {
        	innloggingVindu = PopUpManager.createPopUp(parent, InnloggingView, true) as InnloggingView;
			PopUpManager.centerPopUp(innloggingVindu);
			PopUpManager.bringToFront(innloggingVindu);
    		innloggingVindu.isPopUp = false;
        }
        
        public function fjernLoggInnVindu():void
        {
        	PopUpManager.removePopUp(innloggingVindu);
        }
        
        public function settBrukersKlubb(raseid:String):void
        {
        	Components.instance.services.airDogService.settBrukersKlubb(raseid, settBrukersKlubbResultat);
        }
        
        public function settBrukersKlubbResultat(event:Object):void
        {
        	Components.instance.session.bruker.sattKlubb = event as Klubb;        	
        	
        	fjernLoggInnVindu();
        	
        	hentBrukersRettigheter();
			hentBrukersRoller();
//			hentNyheterDirekte();
        }
		
		public function hentKlubbForsidetekstResultat(event:Object):void
		{
			Components.instance.session.bruker.roller = new ArrayCollection(event as Array);
		}
		
		public function loggInn(bruker:Bruker):void
		{
			Components.instance.services.airDogService.loggInn(bruker, loggInnResultEvent, loggInnFaultEvent);
		}
		
		private function loggInnResultEvent(bruker:Object):void
		{		
			if(bruker)
			{	
				if(bruker.toString() == "FEIL_BRUKERNAVN_PASSORD")
				{
					innloggingVindu.feil = true;
					innloggingVindu.ristVindu();
					loggUt();
					return;
				}	
								
				Components.instance.session.bruker = bruker as Bruker;
				Components.instance.session.bruker.innlogget = true;
							
				hentBrukersKlubber();
				
				innloggingVindu.feil = false;
			}
			else
			{
				innloggingVindu.feil = true;
				innloggingVindu.ristVindu();
				loggUt();
			}
		}
		
		private function loggInnFaultEvent(event:FaultEvent):void
		{
			innloggingVindu.ristVindu();
			Alert.show( "Klarer ikke å koble til server\n" + event.fault.message.toString(), "Innlogging mislyktes", 0);
			loggUt();
		}
		
		public function loggUt():void
		{	
			Components.instance.session = new Session();	
			Components.instance.services.airDogService.loggUt(new Function());
			Components.instance.historie.nullstill();
		}
		
		public function lastOpp(laster:Opplastning):void
		{	
			var url:String = Components.instance.services.rootPath + "controller/FilopplastController.php?";
			
			url += "brukerEpost=" + Components.instance.session.bruker.epost + "&";
			url += "brukerPassord=" + Components.instance.session.bruker.passord + "&";
			url += "klubbId=" + Components.instance.session.bruker.sattKlubb.raseid;
			
			if (laster.type == "bilde")
			{
				Components.instance.session.bildeOpplastning.resultat = null;
				
				var regex:RegExp = new RegExp("[^a-zA-Z0-9]", "ig");
				var id:String = Components.instance.session.hundprofil.hundId;
				
				url += "&hundId=" + id.replace(regex, "_");
			}
			
			var datOpplaster:Filopplaster = new Filopplaster(url, laster);
			datOpplaster.velgFil();
		}
		
		public function sokHund(soketekst:String):void
		{
			Components.instance.session.hundesokListe.provider = new ArrayCollection();
			Components.instance.services.airDogService.sokHund(soketekst, hundesokResultat);		
		}
		
		public function hundesokResultat(event:Object):void
		{
			Components.instance.session.hundesokListe.provider = new ArrayCollection(event as Array);
			Components.instance.historie.settPunkt();
			
			if(Components.instance.session.hundesokListe.provider.length == 0)
			{				
				Components.instance.session.tomtSok = true;				
			}
			else
			{
				Components.instance.session.tomtSok = false;
			}
								
		}
		
		public function hentCupListe(fra:String, til:String):void
		{
			Components.instance.services.airDogService.hentCupListe(fra, til, hentCupListeResultat);
		}
		
		public function hentCupListeResultat(event:Object):void
		{
			Components.instance.session.cupListe = new ArrayCollection(event as Array);
			
			var sorteringsfelt:SortField = new SortField();
			sorteringsfelt.name = "poeng";
			sorteringsfelt.numeric = true;
			sorteringsfelt.descending = true;
			
			var sortering:Sort = new Sort();
			sortering.fields = [sorteringsfelt];
			
			Components.instance.session.cupListe.sort = sortering;
			Components.instance.session.cupListe.refresh();
		}
		
		public function hentAvkom(hundId:String):void
		{
			Components.instance.services.airDogService.hentAvkom(hundId, hentAvkomResultat);
		}
		
		public function hentAvkomResultat(event:Object):void
		{
			Components.instance.session.avkomListe = new ArrayCollection(event as Array);
		}
		
		public function hentJaktprover(hundId:String):void
		{
			//Components.instance.session.jaktproveListe = new ArrayCollection();
			Components.instance.services.airDogService.hentJaktprover(hundId, hentJaktproverResultat);
		}
		
		public function hentJaktproverResultat(event:Object):void
		{
			Components.instance.session.jaktproveListe = new ArrayCollection(event as Array);
			
			if(jaktproveVindu && jaktproveVindu.isPopUp)
			{
				PopUpManager.removePopUp(jaktproveVindu);
			}
		}
		
		public function hentAlleJaktproverAar(aar:String):void
		{
			Components.instance.session.jaktproveListe = null;
			Components.instance.services.airDogService.hentAlleJaktproverAar(aar, hentAlleJaktproverAarResultat);			
		}
		public function hentAlleJaktproverAarResultat(event:Object):void
		{
			Components.instance.session.jaktproveListeAar = new ArrayCollection(event as Array);
		}
				
		public function hentJaktproveSammendragResultat(event:Object):void
		{
			Components.instance.session.jaktproveSammendrag = event as Jaktprove;
		}
		
		public function hentJaktproverSammendragAar(aar:String):void
		{
			Components.instance.services.airDogService.hentJaktproveSammendragAar(aar, hentJaktproveSammendragAarResultat);
		}
		
		public function hentJaktproveSammendragAarResultat(event:Object):void
		{
			Components.instance.session.jaktproveSammendragAar = new ArrayCollection(event as Array);
		}		
		
		public function fjernJaktproverSammendragAar():void
		{
			Components.instance.session.jaktproveSammendragAar = null;
		}
		
		public function hentProvestatistikk(id:String):void
		{
			Components.instance.services.airDogService.hentProvestatistikk(id, hentProvestatistikkResultat);
		}
		
		public function hentProvestatistikkResultat(event:Object):void
		{
			Components.instance.session.provestatistikk = new ArrayCollection(event as Array);
		}
		
		public function hentUtstillinger(hundId:String):void
		{
			Components.instance.session.utstillingListe = null;
			Components.instance.services.airDogService.hentUtstillinger(hundId, hentUtstillingerResultat);
		}
		
		public function hentUtstillingerResultat(event:Object):void
		{
			Components.instance.session.utstillingListe = new ArrayCollection(event as Array);
		}
		
		public function visHund(hundId:String):void
		{
			Components.instance.session.jaktproveSammendrag = null;
			Components.instance.session.hundprofil = null;
			Components.instance.services.airDogService.hentHund(hundId, visHundResultat);
			Components.instance.services.airDogService.hentJaktproveSammendrag(hundId, hentJaktproveSammendragResultat);
		}
		
		public function visHundResultat(event:Hund):void
		{
			Components.instance.session.hundprofil = event;
			Components.instance.session.hovedNavigasjon.nr = 2;
			Components.instance.session.hundNavigasjon.nr = 0;
			Components.instance.historie.settPunkt();
		}
		
		public function hentHund(hundId:String, resultat:Function):void
		{
			Components.instance.services.airDogService.hentHund(hundId, resultat);
		}
		
		public function hentPerson(personId:String, resultat:Function):void
		{
			Components.instance.services.airDogService.hentPerson(personId, resultat);
		}
		
		public function hentBrukersKlubber():void
		{
			//Components.instance.session.bruker.klubber = new ArrayCollection();
			Components.instance.services.airDogService.hentBrukersKlubber(hentBrukersKlubberResultat);
		}
		
		public function hentBrukersKlubberResultat(event:Object):void
		{
			Components.instance.session.bruker.klubber = new ArrayCollection(event as Array);
		}
		
		public function hentBrukersRoller():void
		{
			Components.instance.services.airDogService.hentBrukersRoller(hentBrukersRollerResultat);
		}
		
		public function hentBrukersRollerResultat(event:Object):void
		{
			Components.instance.session.bruker.roller = new ArrayCollection(event as Array);
		}
		
		public function hentBrukersRettigheter():void
		{
			Components.instance.services.airDogService.hentBrukersRettigheter(hentBrukersRettigheterResultat);
		}
		
		public function hentBrukersRettigheterResultat(event:Object):void
		{
			Components.instance.session.bruker.rettigheter = event as Rettigheter;
			Components.instance.historie.settPunkt();
		}
		
		public function hentStamtre(hundId:String, dybde:int):void
		{
			Components.instance.session.stamtre = null;
			Components.instance.services.airDogService.hentStamtre(hundId, dybde, hentStamtreResultat);
		}
		
		public function hentStamtreResultat(event:Object):void
		{
			Components.instance.session.stamtre = event as Hund;
		}
		
		public function hentFiktivtStamtre(hundIdFar:String, hundIdMor:String, dybde:int):void
		{
			Components.instance.session.fiktivtStamtre = null;
			Components.instance.services.airDogService.hentFiktivtStamtre(hundIdFar, hundIdMor, dybde, hentFiktivtStamtreResultat);
		}
		
		public function hentFiktivtStamtreResultat(event:Object):void
		{
			Components.instance.session.fiktivtStamtre = event as Hund;
			Components.instance.historie.settPunkt();
		}
		
		public function redigerHund(hund:Hund):void
		{
			
			Components.instance.services.airDogService.redigerHund(hund, redigerHundResultat);			
		}
		
		public function redigerHundResultat(event:Object):void
		{
			if(redigerHundVindu && redigerHundVindu.isPopUp)
			{
				lukkRedigerHundVindu();
			}
		}
		
		public function visRedigerHundVindu(parent:DisplayObject, hund:Object):void
        {
        	Components.instance.session.hundprofil = hund as Hund;
        	
    		redigerHundVindu = PopUpManager.createPopUp(parent, RedigerHundView, true) as RedigerHundView;
			redigerHundVindu.isPopUp = true;
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
			Components.instance.services.airDogService.sokArsgjennomsnitt(hund, ar, sokArsgjennomsnittResultat);
		}
		
		public function sokArsgjennomsnittResultat(event:Object):void
		{
			Components.instance.session.arsgjennomsnitt = new ArrayCollection(event as Array);
			Components.instance.historie.settPunkt();
		}
		
		public function redigerJaktprove(gammelJaktprove:Jaktprove, jaktprove:Jaktprove):void
		{
			Components.instance.services.airDogService.redigerJaktprove(gammelJaktprove, jaktprove, hentJaktproverResultat);
		}
		
		public function slettJaktprove(jaktproveId:String, hundId:String, jaktproveDato:String):void
		{
			Components.instance.services.airDogService.slettJaktprove(jaktproveId, hundId, jaktproveDato, slettJaktproveResultat);
		}
		
		public function slettJaktproveResultat(event:Object):void
		{
			hentJaktprover(Components.instance.session.hundprofil.hundId);
		}
		
		public function leggInnJaktprove(jaktprove:Jaktprove):void
		{	
			Components.instance.services.airDogService.leggInnJaktprove(jaktprove, leggInnJaktproveResultat);
		}
		
		public function leggInnJaktproveResultat(event:Object):void
		{
		
		}
				
		public function hentAlleRettigheter():void
		{
			Components.instance.services.airDogService.hentAlleRettigheter(hentAlleRettigheterResultat);
		}
		
		public function hentAlleRettigheterResultat(event:Object):void
		{
			Components.instance.session.alleRettigheter = new ArrayCollection(event as Array);
		}
		
		public function hentRollersRettigheter():void
		{
			Components.instance.services.airDogService.hentRollersRettigheter(hentRollersRettigheterResultat);
		}
		
		public function hentRollersRettigheterResultat(event:Object):void
		{
			Components.instance.session.rollersRettigheter = new ArrayCollection(event as Array);
		}
		
		public function leggtilRettighetPaRolle(rolle:String, rettighet:String):void
		{
			Components.instance.services.airDogService.leggtilRettighetPaRolle(rolle, rettighet, hentRollersRettigheterResultat);
		}
		
		public function slettRettighetPaRolle(rolle:String, rettighet:String):void
		{
			Components.instance.services.airDogService.slettRettighetPaRolle(rolle, rettighet, hentRollersRettigheterResultat);
		}
		
		public function leggInnNyRolle(rolle:String, beskrivelse:String):void
		{
			Components.instance.services.airDogService.leggInnNyRolle(rolle, beskrivelse, hentRollersRettigheterResultat);
		}
		
		public function slettRolle(rolle:String):void
		{
			Components.instance.services.airDogService.slettRolle(rolle, hentRollersRettigheterResultat);
		}
		
		
		public function hentTabeller():void
		{
			Components.instance.services.airDogService.hentTabeller(hentTabellerResultat);
		}
		
		public function hentTabellerResultat(event:Object):void
		{
			Components.instance.session.backupTabeller = new ArrayCollection(event as Array);
		}
		
		public function hentKopier():void
		{
			Components.instance.services.airDogService.hentKopier(hentKopierResultat);
		}
		
		public function hentKopierResultat(event:Object):void
		{
			Components.instance.session.backupKopier = new ArrayCollection(event as Array);
		}
		
		public function lagFullKopi(navn:String):void
		{
			Components.instance.services.airDogService.lagFullKopi(navn, lagFullKopiResultat);
		}
		
		public function lagFullKopiResultat(event:Object):void
		{
			Components.instance.controller.hentKopier();
		}
		
		public function hentFiler(mappe:String):void
		{
			Components.instance.services.airDogService.hentFiler(mappe, hentFilerResultat);
		}
		
		public function hentFilerResultat(event:Object):void
		{
			var array:Array = event as Array;
			var filer:ArrayCollection = new ArrayCollection();
			
			for (var i:int = 0; i < array.length; i++) 
			{
          		filer.addItem(new Valg(array[i], false));
   			}
			Components.instance.session.backupFiler = filer;
		}
		
		public function lastKopier(tabeller:ArrayCollection, mappe:String):void
		{
			Components.instance.services.airDogService.lastKopier(tabeller, mappe, lastKopierResultat);
		}
		
		public function lastKopierResultat(event:Object):void
		{
			Alert.show("Gjennoppretningen ble fullført", "Backup");
		}
		
		public function hentRollersBrukere():void
		{
			Components.instance.services.airDogService.hentRollersBrukere(hentRollersBrukereResultat);
		}
		
		public function hentRollersBrukereResultat(event:Object):void
		{
			Components.instance.session.rollersBrukere = new ArrayCollection(event as Array);
		}
			
		public function hentAlleBrukere():void
		{
			Components.instance.services.airDogService.hentAlleBrukere(hentAlleBrukereResultat);
		}
		
		public function hentAlleBrukereResultat(event:Object):void
		{
			Components.instance.session.alleBrukere = new ArrayCollection(event as Array);
			fjernBrukerVindu();
		}
		
		public function leggBrukerTilRolle(rolle:String, bruker:String):void
		{
			Components.instance.services.airDogService.leggBrukerTilRolle(rolle, bruker, hentRollersBrukereResultat);
		}
		
		public function slettBrukerFraRolle(rolle:String, bruker:String):void
		{
			Components.instance.services.airDogService.slettBrukerFraRolle(rolle, bruker, hentRollersBrukereResultat);
		}
		
		public function slettBruker(epost:String):void
		{
			Components.instance.services.airDogService.slettBruker(epost, hentAlleBrukereResultat);
		}
		
		public function redigerBruker(fraBruker:Bruker, tilBruker:Bruker):void
		{
			Components.instance.services.airDogService.redigerBruker(fraBruker, tilBruker, redigerBrukerResultat);
		}
		
		public function redigerBrukerResultat(brukere:Object):void
		{
			hentAlleBrukereResultat(brukere);
			hentRollersBrukere();
		}
		
		public function leggInnBruker(bruker:Bruker):void
		{
			Components.instance.services.airDogService.leggInnBruker(bruker, hentAlleBrukereResultat);
		}
		
		public function redigerEgenBruker(fraBruker:Bruker, tilBruker:Bruker):void
		{
			Components.instance.services.airDogService.redigerEgenBruker(fraBruker, tilBruker, redigerEgenBrukerResultat);
		}
		
		public function redigerEgenBrukerResultat(bruker:Object):void
		{
			Components.instance.session.bruker.epost = bruker.epost;
			Components.instance.session.bruker.passord = bruker.passord;
			Components.instance.session.bruker.fornavn = bruker.fornavn;
			Components.instance.session.bruker.etternavn = bruker.etternavn;
			
			hentAlleBrukere();
			hentRollersBrukere();
		}
		
		public function overskrivDatInnlegg(objekter:ArrayCollection, objektType:String):void
		{
			Components.instance.services.airDogService.overskrivDatInnlegg(objekter, objektType, overskrivDatInnleggResultat);
		}
		
		public function overskrivDatInnleggResultat(event:Object):void
		{
			Alert.show("Innlegging ble fullført" + event.toString(), "Dat-opplastning");
		}
		
		public function slettArrangement(proveNr:String):void
		{
			Components.instance.services.airDogService.slettArrangement(proveNr, slettArrangementResultat);
		}
		
		public function slettArrangementResultat(event:Object):void
		{
			hentArrangementer();
		}
		
		public function leggInnArrangement(arrangement:Arrangement):void
		{
			Components.instance.services.airDogService.leggInnArrangement(arrangement, leggInnArrangementResultat);
		}
		
		public function leggInnArrangementResultat(event:Object):void
		{
			//hentArrangementer();
		}
		
		public function hentArrangementer():void
		{
			Components.instance.services.airDogService.hentArrangementer(hentArrangementerResultat);
		}
		
		public function hentArrangementerResultat(event:Object):void
		{
			Components.instance.session.arrangementer = new ArrayCollection(event as Array);
			Components.instance.session.arrangementer.addItem(new Arrangement());
		}
		
		public function hentNyheterFraServer():void
		{
			Components.instance.services.airDogService.hentNyheter(hentNyheterFraServerResultat);
		}
		
		private function hentNyheterFraServerResultat(event:Object):void
		{
			Components.instance.session.nyheter = new ArrayCollection(event as Array);
		}
	}
}