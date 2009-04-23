package no.airdog.services
{
	import mx.controls.Alert;
    import mx.rpc.AsyncToken;
    import mx.rpc.events.FaultEvent;
    import mx.rpc.IResponder;
    import mx.rpc.remoting.RemoteObject;

	public class AbstraktServiceobjekt
	{
		private var _faultHandler:Function = getDefaultFaultHandler();
		
		public var service:Object;
	    public var getDataSomEvent:Boolean = false;
	    
        public function get faultHandler( ) : Function
        {
            return _faultHandler;
        }

        public function set faultHandler( fault:Function ) : void
        {
            _faultHandler = fault;
        }
        
        protected function callServiceFunction( token:AsyncToken, resultHandler:Function, faultHandler:Function=null) : void
        {
            var responder:IResponder = new mx.rpc.Responder( getResultHandler(resultHandler), getFaultFunction(faultHandler) );
            token.addResponder( responder );
        }

        protected function getDefaultFaultHandler() : Function
        {
            return function( info:Object ) : void
            {
                var fault:FaultEvent = info as FaultEvent
                trace(fault.fault.faultDetail);
                //Alert.show( String(fault.fault.faultDetail), "Stacktrace", 0); //Skrus av ved lansering
                Alert.show(fault.fault.faultCode + ": " + fault.fault.faultString, "Feil");
            }
        }
        
        private function getFaultFunction( fault:Function ) : Function
        {
            if( fault == null ) return _faultHandler;
            return fault;
        }

        private function getResultHandler( func:Function ) : Function
        {
            if (getDataSomEvent) 
            {
                return func;
            }
            else 
            { 
                return function( data : Object ) : void 
                {
                    func( data.result ); 
                }
            }       
        }
	}
}