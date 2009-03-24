package no.airdog.services
{
	import mx.controls.Alert;
    import mx.rpc.AsyncToken;
    import mx.rpc.IResponder;
    import mx.rpc.events.FaultEvent;
    import mx.rpc.remoting.RemoteObject;

	public class AbstraktServiceobjekt
	{
		public var service:Object;
                
	    private var _faultHandler:Function = getDefaultFaultHandler();
	    
	    // Grei å bruke med integrasjonstester, flexunit, etc..
	    public var getDataSomEvent:Boolean = false;
	    
	    
        public function get faultHandler( ) : Function
        {
            return _faultHandler;
        }
        
        /**
         * Set The faultHandler of this Facade
         * @param fault
         */
        public function set faultHandler( fault:Function ) : void
        {
            _faultHandler = fault;
        }
        
        /**
         * 
         * @param token - The servicecall. Example service.save(myObject)
         * @param resultHandler - Function callback
         * @param fault - Function faultHandler
         * 
         */
        protected function callServiceFunction( token:AsyncToken, resultHandler:Function, faultHandler:Function=null) : void
        {
            var responder:IResponder = new mx.rpc.Responder( getResultHandler(resultHandler), getFaultFunction(faultHandler) );
            token.addResponder( responder );
        }
        
        /**
         * Creates a default Function for handling faults. This implementations just shows an Alertbox.
         * 
         * @return A default Function for handling faults 
         */
        protected function getDefaultFaultHandler() : Function
        {
            return function( info:Object ) : void
            {
                var fault:FaultEvent = info as FaultEvent
                trace(fault.fault.faultDetail);
                Alert.show( String(fault.fault.faultDetail), "Stacktrace", 0); //Skrus av ved lansering
                Alert.show(fault.fault.faultCode + ": " + fault.fault.faultString, "Feil");
            }
        }
        
        /**
         * If the fault is null we return the default faultHandler.
         * If not, the calling component wants to override the faultHandling it self so we return the fault function parameter
         * 
         * @param fault - The faultFunction from the component
         * @return A faultHandler Function 
         */
        private function getFaultFunction( fault:Function ) : Function
        {
            if( fault == null ) return _faultHandler;
            return fault;
        }
        
        /**
         * Function to get the result from the data on the server and put it on the resultFunction.
         * 
         * @param func - The resultHandling function from the component
         * @return - A newly created function encapsulating the result of the data
         */
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