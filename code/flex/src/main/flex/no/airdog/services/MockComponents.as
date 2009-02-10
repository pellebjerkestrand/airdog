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
			component.services.rootPath = "http://localhost";
		}
	}
}