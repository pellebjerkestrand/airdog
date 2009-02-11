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
			Components.instance.services.airdogService.loggInn("admin","admin", null, loggInnFaultEvent);
		}
		
		private function loggInnFaultEvent(event:FaultEvent):void
		{
			Alert.show( String(event.fault.faultDetail), "Innloging misslyktes", 0);
		}
		
		public function loggUt():void
		{
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