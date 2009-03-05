package no.airdog.controller
{
	import flash.display.DisplayObject;
	
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.events.*;
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
    		jaktproveVindu = PopUpManager.createPopUp(parent, JaktproveVindu, true) as JaktproveVindu;
        	PopUpManager.centerPopUp(jaktproveVindu);
			PopUpManager.bringToFront(jaktproveVindu);
			
        }      
        
        public function visRedigerJaktproveVindu(parent:DisplayObject, jaktprove:Object):void
        {
        	Components.instance.session.jaktprove = jaktprove as Jaktprove;
        	
    		jaktproveVindu = PopUpManager.createPopUp(parent, JaktproveVindu, true) as JaktproveVindu;
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
			Components.instance.session.bruker.epost = "";
			Components.instance.session.bruker.passord = "";
			Components.instance.session.bruker.innlogget = false;
			Components.instance.session.bruker.rettigheter = null;
			Components.instance.session.bruker.roller = null;
			Components.instance.session.bruker.klubber = null;
			Components.instance.session.bruker.sattKlubb = "";
			Components.instance.session.bruker.sattKlubbId = "";
			
			Components.instance.session.hovedNavigasjon.nr = 1;
			
			Components.instance.services.airdogService.loggUt(new Function());
		}
		
		public function lastOppDatFil():void
		{
			var url:String = "http://localhost:8888/AirDog%20-%20PHP/src/main/php/no/airdog/controller/FilopplastController.php?";
			url += "brukerEpost=" + Components.instance.session.bruker.epost + "&";
			url += "brukerPassord=" + Components.instance.session.bruker.passord + "&";
			url += "klubbId=" + Components.instance.session.bruker.sattKlubbId;
			
			var datOpplaster:Filopplaster = new Filopplaster(url);
			datOpplaster.velgFil();
		}
		
		public function sokHund(soketekst:String):void
		{
			Components.instance.services.airdogService.sokHund(soketekst, hundesokResultat);
		}
		
		public function hundesokResultat(event:Object):void
		{
			Components.instance.session.hundesokListe.provider = new ArrayCollection(event as Array);
		}
		
		public function hentAvkom(hundId:String):void
		{
			Components.instance.services.airdogService.hentAvkom(hundId, hentAvkomResultat);
		}
		
		public function hentAvkomResultat(event:Object):void
		{
			Components.instance.session.avkomListe = new ArrayCollection(event as Array);
		}
		
		public function hentJaktprove(hundId:String):void
		{
			Components.instance.services.airdogService.hentJaktprove(hundId, hentJaktproveResultat);
		}
		
		public function hentJaktproveResultat(event:Object):void
		{
			Components.instance.session.jaktproveListe = new ArrayCollection(event as Array);
		}
		
		public function visHund(hundId:String):void
		{
			Components.instance.services.airdogService.hentHund(hundId, visHundResultat);
		}
		
		public function visHundResultat(event:Hund):void
		{
			Components.instance.session.hundprofil = event;
			Components.instance.session.hovedNavigasjon.nr = 2;
		}
		
		public function hentBrukersKlubber():void
		{
			Components.instance.services.airdogService.hentBrukersKlubber(hentBrukersKlubberResultat);
		}
		
		public function hentBrukersKlubberResultat(event:Object):void
		{
			Components.instance.session.bruker.klubber = new ArrayCollection(event as Array);
		}
		
		public function hentBrukersRoller():void
		{
			Components.instance.services.airdogService.hentBrukersRoller(hentBrukersRollerResultat);
		}
		
		public function hentBrukersRollerResultat(event:Object):void
		{
			Components.instance.session.bruker.roller = new ArrayCollection(event as Array);
		}
		
		public function hentBrukersRettigheter():void
		{
			Components.instance.services.airdogService.hentBrukersRettigheter(hentBrukersRettigheterResultat);
		}
		
		public function hentBrukersRettigheterResultat(event:Object):void
		{
			Components.instance.session.bruker.rettigheter = new ArrayCollection(event as Array);
		}
		
		public function hentStamtre(hundId:String, dybde:int):void
		{
			Components.instance.services.airdogService.hentStamtre(hundId, dybde, hentStamtreResultat);
		}
		
		public function hentStamtreResultat(event:Object):void
		{
			Components.instance.session.stamtre = event as Hund;
		}
		public function redigerHund(verdier:Object):void
		{
			var hund:Hund = new Hund();
			
			hund.raseId = verdier['raseId'];
			hund.kullId = verdier['kullId'];
			hund.hundId = verdier['hundId'];
			hund.tittel = verdier['tittel'];
			hund.navn = verdier['navn'];
			hund.farId = verdier['farId'];
			hund.morId = verdier['morId'];
			hund.idNr = verdier['idNr'];
			hund.farge = verdier['farge'];
			hund.fargeVariant = verdier['fargeVariant'];
			hund.oyesykdom = verdier['oyesykdom'];
			hund.hoftesykdom = verdier['hoftesykdom'];
			hund.haarlag = verdier['haarlag'];
			hund.idMerke = verdier['idMerke'];
			hund.kjonn = verdier['kjonn'];
			hund.eierId = verdier['eierId'];
			hund.endretAv = verdier['endretAv'];
			hund.endretDato = verdier['endretDato'];
			hund.regDato = verdier['regDato'];
			hund.storrelse = verdier['storrelse'];
			hund.manueltEndretAv = verdier['manueltEndretAv'];
			hund.manueltEndretDato = verdier['manueltEndretDato'];
			
			Alert.show('Endret hunden '+hund.navn);
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
			Components.instance.services.airdogService.sokArsgjennomsnitt(hund, ar, sokArsgjennomsnittResultat);
		}
		
		public function sokArsgjennomsnittResultat(event:Object):void
		{
			Components.instance.session.arsgjennomsnitt = new ArrayCollection(event as Array);
		}
		
		public function redigerJaktprove(		    
			proveNr:String,
			proveDato:String,
			partiNr:String,
			klasse:String,
			dommerId1:String,
			dommerId2:String,
			hundid:String,
			slippTid:String,
			egneStand:String,
			egneStokk:String,
			tomStand:String,
			makkerStand:String,
			makkerStokk:String,
			jaktlyst:String,
			fart:String,
			stil:String,
			selvstendighet:String,
			bredde:String,
			reviering:String,
			samarbeid:String,
			presUpresis:String,
			presNoeUpresis:String,
			presPresis:String,
			reisNekter:String,
			reisNoelende:String,
			reisVillig:String,
			reisDjerv:String,
			sokStjeler:String,
			sokSpontant:String,
			appIkkeGodkjent:String,
			appGodkjent:String,
			rappInnkalt:String,
			rappSpont:String,
			premiegrad:String,
			certifikat:String,
			regAv:String,
			regDato:String,
			raseId:String,
			manueltEndretAv:String,
			manueltEndretDato:String
		):void
		{
			var jaktprove:Jaktprove = new Jaktprove;
			jaktprove.proveNr = proveNr;
			jaktprove.proveDato = proveDato;
			jaktprove.partiNr = partiNr;
			jaktprove.klasse = klasse;
			jaktprove.dommerId1 = dommerId1;
			jaktprove.dommerId2 = dommerId2;
			jaktprove.hundId = hundid;
			jaktprove.slippTid = slippTid;
			jaktprove.egneStand = egneStand;
			jaktprove.egneStokk = egneStokk;
			jaktprove.tomStand = tomStand;
			jaktprove.makkerStand = makkerStand;
			jaktprove.makkerStokk = makkerStokk;
			jaktprove.jaktlyst = jaktlyst;
			jaktprove.fart = fart;
			jaktprove.stil = stil;
			jaktprove.selvstendighet = selvstendighet;
			jaktprove.bredde = bredde;
			jaktprove.reviering = reviering;
			jaktprove.samarbeid = samarbeid;
			jaktprove.presUpresis = samarbeid;
			jaktprove.presNoeUpresis = presNoeUpresis;
			jaktprove.presPresis = presNoeUpresis;
			jaktprove.reisNekter = reisNekter;
			jaktprove.reisNoelende = reisNoelende;
			jaktprove.reisVillig = reisVillig;
			jaktprove.reisDjerv = reisDjerv;
			jaktprove.sokStjeler = sokStjeler;
			jaktprove.sokSpontant = sokSpontant;
			jaktprove.appIkkeGodkjent = appIkkeGodkjent;
			jaktprove.appGodkjent = appGodkjent;
			jaktprove.rappInnkalt = rappInnkalt;
			jaktprove.rappSpont = rappSpont;
			jaktprove.premiegrad = premiegrad;
			jaktprove.certifikat = certifikat;
			jaktprove.regAv = regAv;
			jaktprove.regDato = regDato;
			jaktprove.raseId = raseId;
			jaktprove.manueltEndretAv = manueltEndretAv;
			jaktprove.manueltEndretDato = manueltEndretDato;
			
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
		
		public function leggInnJaktProve(
		    proveNr:String,
			proveDato:String,
			partiNr:String,
			klasse:String,
			dommerId1:String,
			dommerId2:String,
			hundid:String,
			slippTid:String,
			egneStand:String,
			egneStokk:String,
			tomStand:String,
			makkerStand:String,
			makkerStokk:String,
			jaktlyst:String,
			fart:String,
			stil:String,
			selvstendighet:String,
			bredde:String,
			reviering:String,
			samarbeid:String,
			presUpresis:String,
			presNoeUpresis:String,
			presPresis:String,
			reisNekter:String,
			reisNoelende:String,
			reisVillig:String,
			reisDjerv:String,
			sokStjeler:String,
			sokSpontant:String,
			appIkkeGodkjent:String,
			appGodkjent:String,
			rappInnkalt:String,
			rappSpont:String,
			premiegrad:String,
			certifikat:String,
			regAv:String,
			regDato:String,
			raseId:String,
			manueltEndretAv:String,
			manueltEndretDato:String
		):void
		{
			var jaktprove:Jaktprove = new Jaktprove;
			jaktprove.proveNr = proveNr;
			jaktprove.proveDato = proveDato;
			jaktprove.partiNr = partiNr;
			jaktprove.klasse = klasse;
			jaktprove.dommerId1 = dommerId1;
			jaktprove.dommerId2 = dommerId2;
			jaktprove.hundId = hundid;
			jaktprove.slippTid = slippTid;
			jaktprove.egneStand = egneStand;
			jaktprove.egneStokk = egneStokk;
			jaktprove.tomStand = tomStand;
			jaktprove.makkerStand = makkerStand;
			jaktprove.makkerStokk = makkerStokk;
			jaktprove.jaktlyst = jaktlyst;
			jaktprove.fart = fart;
			jaktprove.stil = stil;
			jaktprove.selvstendighet = selvstendighet;
			jaktprove.bredde = bredde;
			jaktprove.reviering = reviering;
			jaktprove.samarbeid = samarbeid;
			jaktprove.presUpresis = samarbeid;
			jaktprove.presNoeUpresis = presNoeUpresis;
			jaktprove.presPresis = presNoeUpresis;
			jaktprove.reisNekter = reisNekter;
			jaktprove.reisNoelende = reisNoelende;
			jaktprove.reisVillig = reisVillig;
			jaktprove.reisDjerv = reisDjerv;
			jaktprove.sokStjeler = sokStjeler;
			jaktprove.sokSpontant = sokSpontant;
			jaktprove.appIkkeGodkjent = appIkkeGodkjent;
			jaktprove.appGodkjent = appGodkjent;
			jaktprove.rappInnkalt = rappInnkalt;
			jaktprove.rappSpont = rappSpont;
			jaktprove.premiegrad = premiegrad;
			jaktprove.certifikat = certifikat;
			jaktprove.regAv = regAv;
			jaktprove.regDato = regDato;
			jaktprove.raseId = raseId;
			jaktprove.manueltEndretAv = manueltEndretAv;
			jaktprove.manueltEndretDato = manueltEndretDato;
			
			Components.instance.services.airdogService.leggInnJaktprove(jaktprove, leggInnJaktProveResultat);
		}
		
		public function leggInnJaktProveResultat(event:Object):void
		{
		
		}
	}
}