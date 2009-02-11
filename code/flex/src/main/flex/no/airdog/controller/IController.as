package no.airdog.controller
{
	import mx.controls.Label;
	
	public interface IController
	{
		function loggInn(username:String, passord:String):void
		function loggUt():void
		function lastOppDatFil():void
		function hundesok(soketekst:String):void
	}
}