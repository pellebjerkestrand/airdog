package no.airdog.controller
{
	import mx.controls.Label;
	import no.airdog.services.Components;
	
	public class Controller implements IController
	{			
		public function Controller()
		{
		}
		
		public function loggInn(brukernavn:String, passord:String):void
		{
		}
		
		public function loggUt():void
		{
		}
		
		public function lastOppDatFil():void
		{
			var datOpplaster:Filopplaster = new Filopplaster("http://localhost:8888/AirDog%20-%20PHP/src/main/php/no/airdog/controller/FilopplastController.php");
			datOpplaster.velgFil();
		}
	}
}