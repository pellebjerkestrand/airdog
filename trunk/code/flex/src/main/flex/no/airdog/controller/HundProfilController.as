package no.airdog.controller
{
	[Bindable]
	public class HundProfilController{
		import no.airdog.domain.hund.Hund;
		
		public function HundProfilController(){
			var tempHund:Hund = new Hund();
			tempHund.id = i;
			tempHund.navn = "<NAVN " + i + ">";
			tempHund.tittel = "<TITTEL " + i + ">";
			tempHund.bilde = "Hund1.jpg";
			tempHund.foreldre = "<FORELDRE>";
			tempHund.kjonn = "<KJØNN>";
			
		  	/*profilbildet.source = "../assets/" + testData.hund[0].bilde;
	   		profilnavn.text = testData.hund[0].navn;
	   		profiltittel.text = testData.hund[0].tittel;
	   		profileier.text = "Jan";
	   		grid1.dataProvider = testProve.JAKTPROVE;*/
		}
	}
}