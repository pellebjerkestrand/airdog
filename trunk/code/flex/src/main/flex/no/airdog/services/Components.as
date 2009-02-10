package no.airdog.services
{
	import mx.core.UIComponent;
	
	import no.airdog.controller.*;
	import no.airdog.model.*;
	
	public class Components extends UIComponent
	{
		private static var _instance:Components;
		
		[Bindable]
        public var controller:IController;
        
        [Bindable]
        public var session:Session = new Session();
        
        [Bindable]
        public var amfService:IAmfService = new AmfService();
	}
}