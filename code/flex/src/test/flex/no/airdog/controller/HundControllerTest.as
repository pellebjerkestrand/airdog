package no.airdog.controller
{
	import flexunit.framework.TestCase;
	
	import mx.collections.ArrayCollection;
	
	import no.airdog.facade.AirdogFacade;

	public class HundControllerTest extends TestCase implements AirdogFacade
	{
		private var hasCalled:Boolean = false;
		private var myTestCollection:ArrayCollection = new ArrayCollection();
		
		public function testGetAlleHunder() : void
		{
			var controller:HundController = new HundController();
			controller.facade = this;
			
			controller.getAlleHunder();
			assertTrue(hasCalled);
			assertEquals("Alle hunder ble ikke satt", myTestCollection, controller.hunder);
		}
		
		public function getAlleHunder(resultHandler:Function, faultHandler:Function=null) : void
		{
			hasCalled = true;
			resultHandler(myTestCollection);
		}
	}
}