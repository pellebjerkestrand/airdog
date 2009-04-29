package no.airdog.services
{
	import mx.controls.Alert;
	import mx.core.Application;
	
	import no.airdog.controller.*;
	import no.airdog.model.*;
	
	public class MainComponents
	{
		public function MainComponents()
		{
			var component:Components = new Components();
			component.session = new Session();			
			component.controller = new MainController();
			component.services = new Services();
			component.historie = new Historie();
			
			component.services.rootPath = "http://localhost:8888/AirDog%20-%20PHP/src/main/php/no/airdog/";
			
			Alert.cancelLabel = "Avbryt";
			Alert.noLabel = "Nei";
			Alert.yesLabel = "Ja";
		}
	}
}