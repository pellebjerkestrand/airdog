package no.airdog.domain.hund
{
	import flexunit.framework.TestCase;

	public class HundTest extends TestCase
	{
		public function testPass() : void
		{
			var hund1:Hund = new Hund();
			var hund2:Hund = new Hund();
			var hund3:Hund = new Hund();
			hund1.id = "huid";
			hund2.id = "huid";
			hund3.id = "crap";
			
			assertTrue(hund1.equals(hund1));
			assertTrue(hund1.equals(hund2));
			assertTrue(hund1.equals(hund3));
		}
		
		public function testFail() : void
		{
			var hund1:Hund = new Hund();
			var hund2:Hund = new Hund();
			var hund3:Hund = new Hund();
			hund1.id = "huid";
			hund2.id = "huid";
			hund3.id = "crap";
			
			assertTrue(hund1.equals(hund1));
			assertTrue(hund1.equals(hund2));
			assertFalse(hund1.equals(hund3));
		}
	}
}