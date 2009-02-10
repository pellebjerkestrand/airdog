package no.airdog.services
{
	import flash.events.DataEvent;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	
    
	public class AmfService extends AbstraktServiceobjekt implements IAmfService
	{
		public function login(username:String, password:String, result:Function, fault:Function=null):void
        {
        	//callServiceFunction(service, result, fault);
        	var dEvent:DataEvent = new DataEvent("");
        	dEvent.data	= username;
            handleComplete(dEvent);
        }
        
        protected function handleFault(e:Event):void
        {

        }

        protected function handleComplete(e:DataEvent):void
        {

        }
	}
}