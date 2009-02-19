package no.airdog.controller
{
	import flash.display.DisplayObject;
	
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.managers.PopUpManager;
	import mx.rpc.events.FaultEvent;
	
	import no.airdog.model.*;
	import no.airdog.services.Components;
	import no.airdog.view.*;
	
	public class MockController implements IController
	{     
		private var vindu:InnloggingVindu;
		
        public function MockController()
        {
        	var tmpCollection:ArrayCollection = new ArrayCollection();
        }
        
        public function visLoggInnVindu(parent:DisplayObject):void
        {
        	vindu = PopUpManager.createPopUp(parent, InnloggingVindu, true) as InnloggingVindu;
			PopUpManager.centerPopUp(vindu);
    		vindu.isPopUp = false;
        }
        
        public function fjernLoggInnVindu():void
        {
        	PopUpManager.removePopUp(vindu);
        }
		
		public function loggInn(brukernavn:String, passord:String):void
		{
			Components.instance.session.bruker.brukernavn = brukernavn;
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
				Components.instance.session.bruker.GJELDENDE_BRUKERROLLE = bruker["brukerRolle"];
				
				Alert.show( "bruker.toString(): "+bruker+
							"\nBrukernavn: "+Components.instance.session.bruker.brukernavn+
							"\nPassord: "+Components.instance.session.bruker.passord+
							"\nInnlogget: "+Components.instance.session.bruker.innlogget+
							"\nsession.bruker.rolle: "+Components.instance.session.bruker.GJELDENDE_BRUKERROLLE, 
							"Innlogging lyktes", 0);
							
				fjernLoggInnVindu();
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
			Components.instance.session.bruker.brukernavn = "";
			Components.instance.session.bruker.passord = "";
			Components.instance.session.bruker.innlogget = false;
		}
		
		public function lastOppDatFil():void
		{
			var datOpplaster:Filopplaster = new Filopplaster("http://localhost:8888/AirDog%20-%20PHP/src/main/php/no/airdog/controller/FilopplastController.php");
			datOpplaster.velgFil();
		}
		
		public function hundesok(soketekst:String):void
		{
			Components.instance.services.airdogService.hundesok(soketekst, hundesokResultat);
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
		
		public function hentBrukersRettigheter(brukerEpost:String):void
		{
			Components.instance.services.airdogService.hentBrukersRettigheter(brukerEpost, hentBrukersRettigheterResultat);
		}
		
		public function hentBrukersRettigheterResultat(event:Object):void
		{
			Components.instance.session.rettigheter = new Array(event as Array);
		}
	}
}