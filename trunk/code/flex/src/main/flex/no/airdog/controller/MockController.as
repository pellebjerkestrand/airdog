package no.airdog.controller
{
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	
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
			Components.instance.services.airdogService.loggInn(brukernavn, passord, loggInnResultEvent, loggInnFaultEvent);
		}
		
		private function loggInnFaultEvent(event:FaultEvent):void
		{
			Alert.show( event.fault.faultDetail.toString(), "Innlogging mislyktes", 0);
			loggUt();
		}
		
		private function loggInnResultEvent(event:Boolean):void
		{
			if (event)
			{
				Components.instance.session.bruker.innlogget = true;
			}
			else
			{
				Alert.show( "Feil brukernavn og/eller passord", "Innlogging mislyktes", 0);
				loggUt();
			}
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
	}
}