package no.airdog.services
{
	import flash.events.DataEvent;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	
    
	public class AirdogService extends AbstraktServiceobjekt
	{
		public function login(username:String, password:String, result:Function, fault:Function=null):void
        {
        	callServiceFunction(service.lol(), result, fault);
        }
	}
}