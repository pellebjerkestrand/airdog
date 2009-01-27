package no.airdog.controller
{
	[Bindable]
	public class HundProfilController{
		public function HundProfilController{
			
		  	profilbildet.source = "../assets/" + testData.hund[0].bilde;
	   		profilnavn.text = testData.hund[0].navn;
	   		profiltittel.text = testData.hund[0].tittel;
	   		profileier.text = "Jan";
	   		grid1.dataProvider = testProve.JAKTPROVE;
		}
	}
}