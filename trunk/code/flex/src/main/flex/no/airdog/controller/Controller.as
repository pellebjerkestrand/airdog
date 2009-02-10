package no.airdog.controller
{
	import mx.controls.Label;
	
	import no.airdog.services.Components;
	
	public class Controller implements IController
	{	
		public function login(username:String):void
		{
			//Components.instance.amfService.login(username, "lol");
		}
		
		public function logout():void
		{
		}
		
		public function lastOppDatFil():void
		{
			var datOpplaster:Filopplaster = new Filopplaster("http://localhost:8888/AirDog%20-%20PHP/src/main/php/no/airdog/controller/FilopplastController.php");
			datOpplaster.velgFil();
		}
	}
}