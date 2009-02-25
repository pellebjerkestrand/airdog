package no.airdog.controller
{
	import flash.display.DisplayObject;
	
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
		function hentJaktprove(hundId:String):void
		function visHund(hundId:String):void
		function hentBrukersRettigheter():void
		function hentBrukersRoller():void
	}
}