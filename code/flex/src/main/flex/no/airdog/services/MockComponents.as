package no.airdog.services
{
	import no.airdog.controller.*;
	import no.airdog.model.*;
	
	public class MockComponents
	{
		public function MockComponents()
		{
			var component:Components = new Components();
			component.session = new Session();			
			component.controller = new MockController();
			component.services = new Services();
			component.historie = new Historie();
			
			//component.services.rootPath = "http://localhost:8888/AirDog%20-%20PHP/src/main/php/no/airdog/";
			component.services.rootPath = "http://airdog.no/backend/no/airdog/";
		}
	}
}