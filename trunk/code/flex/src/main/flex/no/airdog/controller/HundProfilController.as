package no.airdog.controller
{
	import no.airdog.domain.hund.Hund;
	
	[Bindable]
	public class HundProfilController
	{
		public var hund:Hund;
		
		public function HundProfilController()
		{
			hund = new Hund();
			hund.id = "1";
			hund.navn = "<NAVN>";
			hund.tittel = "<TITTEL>";
			hund.bilde = "Hund1.jpg";
			hund.foreldre = "<FORELDRE>";
			hund.kjonn = "<KJØNN>";
			hund.eier = "<EIER>";
		}
	}
}