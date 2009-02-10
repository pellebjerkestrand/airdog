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
		}

	}
}