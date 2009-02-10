package no.airdog.controller
{
	import mx.collections.ArrayCollection;
	import mx.controls.Label;
	
	import no.airdog.model.*;
	import no.airdog.services.Components;
	
	public class MockController implements IController
	{     
        public function MockController()
        {
        	var tmpCollection:ArrayCollection = new ArrayCollection();
			
			for (var i:int = 0; i < 100; i++)
			{
				var tempHund:Hund = new Hund();
				tempHund.id = i.toString();
				tempHund.navn = "Navn" + i;
				tempHund.tittel = "Tittel";
				tempHund.bilde = "Hund1.jpg";
				tempHund.foreldre = "Foreldre";
				tempHund.kjonn = "Kjonn";
				tempHund.oppdretter = "Oppdretter";
				tempHund.eier = "Eier";
				tmpCollection.addItem(tempHund);
			}
			Components.instance.session.hundeliste.provider = tmpCollection;
			
			Components.instance.session.hundprofil = tmpCollection[0];
        }
		
		public function login(username:String):void
		{
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