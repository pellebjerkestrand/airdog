package no.airdog.controller
{
	[Bindable]
	public class HundProfilController{
		
		public var bilde:String
		public var navn:String;
		public var eier:String;
		public var tittel:String;
		public var foreldre:String;
		public var oppdretter:String;
		public var kjonn:String;
		
		public function HundProfilController(){
			bilde = "Bilde";
			navn = "Navn";
			eier = "Eier";
			tittel = "Tittel";
			foreldre = "Foreldre";
			oppdretter = "Oppdretter";
			kjonn = "Kjønn";
			
		  	/*profilbildet.source = "../assets/" + testData.hund[0].bilde;
	   		profilnavn.text = testData.hund[0].navn;
	   		profiltittel.text = testData.hund[0].tittel;
	   		profileier.text = "Jan";
	   		grid1.dataProvider = testProve.JAKTPROVE;*/
		}
	}
}