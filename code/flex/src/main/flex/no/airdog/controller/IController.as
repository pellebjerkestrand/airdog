package no.airdog.controller
{
	import mx.controls.Label;
	
	public interface IController
	{
		function loggInn(brukernavn:String, passord:String):void
		function loggUt():void
		function lastOppDatFil():void
		function hundesok(soketekst:String):void
		function hentAvkom(hundId:String):void
		function hentJaktprove(hundId:String):void
	}
}