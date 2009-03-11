package no.airdog.services
{
	import no.airdog.controller.*;
	import no.airdog.model.*;
	
	public class MainComponents
	{
		public function MainComponents()
		{
			var component:Components = new Components();
			component.session = new Session();
			component.controller = new Controller();
			component.services = new Services();
			component.historie = new Historie();
			component.services.rootPath = "http://localhost:8888/AirDog - PHP/src/main/php/no/airdog";
		}

	}
}