package no.airdog.controller
{
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.rpc.events.FaultEvent;
	
	import no.airdog.model.*;
	import no.airdog.services.Components;
	
	public class MockController implements IController
	{     
        public function MockController()
        {
        	var tmpCollection:ArrayCollection = new ArrayCollection();
        }
		
		public function loggInn(brukernavn:String, passord:String):void
		{
			Components.instance.session.bruker.brukernavn = brukernavn;
			Components.instance.session.bruker.passord = passord;
			Components.instance.services.airdogService.loggInn(Components.instance.session.bruker, loggInnResultEvent, loggInnFaultEvent);
		}
		
		private function loggInnResultEvent(bruker:Object):void
		{
			if (bruker["brukerRolle"] != "gjest")
			{	
				Components.instance.session.bruker.innlogget = true;
				Components.instance.session.bruker.GJELDENDE_BRUKERROLLE = bruker["brukerRolle"];
				
				Components.instance.session.ristVindu = true;
				Alert.show( "bruker.toString(): "+bruker+
							"\nBrukernavn: "+Components.instance.session.bruker.brukernavn+
							"\nPassord: "+Components.instance.session.bruker.passord+
							"\nInnlogget: "+Components.instance.session.bruker.innlogget+
							"\nsession.bruker.rolle: "+Components.instance.session.bruker.GJELDENDE_BRUKERROLLE, 
							"Innlogging lyktes", 0);
			}
			else
			{
				Components.instance.session.ristVindu = true;
				//Alert.show( "Feil brukernavn og/eller passord", "Innlogging mislyktes", 0);
				loggUt();
			}
		}
		
		private function loggInnFaultEvent(event:FaultEvent):void
		{
			Components.instance.session.ristVindu = true;
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
	}
}