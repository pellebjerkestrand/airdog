package no.airdog.controller
{
	import flash.display.DisplayObject;
	
	import mx.collections.ArrayCollection;
	
	import no.airdog.model.*;
	
	public interface IController
	{
		function visLoggInnVindu(parent:DisplayObject):void
		function fjernLoggInnVindu():void
		function settBrukersKlubb(klubb:String, klubbId:String):void;
		function loggInn(bruker:Bruker):void
		function loggUt():void
		function lastOpp(laster:Opplastning):void
		function sokHund(soketekst:String):void
		function hentCupListe(fra:String, til:String):void
		function hentAvkom(hundId:String):void
		function hentJaktprover(hundId:String):void
		function hentAlleJaktproverAar(aar:String):void
		function hentJaktproverSammendragAar(aar:String):void
		function hentUtstillinger(hundId:String):void
		function visHund(hundId:String):void
		function hentHund(hundId:String, resultat:Function):void
		function hentPerson(personId:String, resultat:Function):void
		function hentBrukersRettigheter():void
		function hentBrukersRoller():void
		function hentStamtre(hundId:String, dybde:int):void
		function redigerJaktprove(gammelJaktprove:Jaktprove, jaktprove:Jaktprove):void
		function redigerHund(hund:Hund):void 
		function visRedigerHundVindu(parent:DisplayObject, hund:Object):void
		function lukkRedigerHundVindu():void
		function sokArsgjennomsnitt(hund:String, ar:String):void
		function slettJaktprove(jaktproveId:String, hundId:String, proveDato:String):void
		function leggInnJaktprove(jaktprove:Jaktprove):void
		function visLeggInnJaktproveVindu(parent:DisplayObject):void
		function visRedigerJaktproveVindu(parent:DisplayObject, jaktprove:Jaktprove):void
		function fjernJaktproveVindu():void
		function visRedigerBrukerVindu(parent:DisplayObject, bruker:Bruker):void
		function fjernBrukerVindu():void
		function hentAlleRettigheter():void
		function hentRollersRettigheter():void
		function leggtilRettighetPaRolle(rolle:String, rettighet:String):void
		function hentFiktivtStamtre(hundIdFar:String, hundIdMor:String, dybde:int):void
		function slettRettighetPaRolle(rolle:String, rettighet:String):void
		function leggInnNyRolle(rolle:String, beskrivelse:String):void
		function slettRolle(rolle:String):void
		function hentTabeller():void
		function hentKopier():void
		//function lagKopi(tabell:String):void
		function lagFullKopi(navn:String):void
		function hentFiler(mappe:String):void
		//function lastKopi(tabell:String, mappe:String):void
		function lastKopier(tabeller:ArrayCollection, mappe:String):void
		function hentRollersBrukere():void
		function hentAlleBrukere():void
		function leggBrukerTilRolle(rolle:String, bruker:String):void
		function slettBrukerFraRolle(rolle:String, bruker:String):void
		function slettBruker(epost:String):void
		function redigerBruker(fraBruker:Bruker, tilBruker:Bruker):void
		function leggInnBruker(bruker:Bruker):void	
		function redigerEgenBruker(fraBruker:Bruker, tilBruker:Bruker):void
		function fjernRedigerEgenBrukerVindu():void
		function visRedigerEgenBrukerVindu(parent:DisplayObject):void
		function overskrivDatInnlegg(objekter:ArrayCollection, objektType:String):void
	}
}