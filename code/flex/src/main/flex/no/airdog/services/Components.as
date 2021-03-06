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
        public var session:Session;
        
        [Bindable]
        public var services:Services;
        
        public var historie:Historie;
        
		public function Components()
		{
			super();
            _instance = this;
            dispatchEvent(new Event("instanceChanged"));
		}

		[Bindable("instanceChanged")]
        public static function get instance():Components
        {
            return _instance;
        }
	}
}