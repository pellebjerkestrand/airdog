package no.airdog.controller
{
	import flash.display.DisplayObject;
	
	import no.airdog.model.*;
	
	public interface IController
	{
		function visLoggInnVindu(parent:DisplayObject):void
		function fjernLoggInnVindu():void
		function settBrukersKlubb(klubb:String, klubbId:String):void;
		function loggInn(brukernavn:String, passord:String):void
		function loggUt():void
		function lastOppDatFil():void
		function sokHund(soketekst:String):void
		function hentAvkom(hundId:String):void
		function hentJaktprover(hundId:String):void
		function visHund(hundId:String):void
		function hentBrukersRettigheter():void
		function hentBrukersRoller():void
		function hentStamtre(hundId:String, dybde:int):void
		function redigerJaktprove(jaktprove:Jaktprove):void
		function redigerHund(hund:Hund):void 
		function visRedigerHundVindu(parent:DisplayObject, hund:Object):void
		function lukkRedigerHundVindu():void
		function sokArsgjennomsnitt(hund:String, ar:String):void
		function slettJaktprove(jaktproveId:String):void
		function leggInnJaktprove(jaktprove:Jaktprove):void
		function visLeggInnJaktproveVindu(parent:DisplayObject):void
		function visRedigerJaktproveVindu(parent:DisplayObject, jaktprove:Jaktprove):void
		function fjernJaktproveVindu():void
		function hentAlleRoller():void
		function hentAlleRettigheter():void
	}
}