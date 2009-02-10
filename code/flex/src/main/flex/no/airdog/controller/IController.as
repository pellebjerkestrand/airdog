package no.airdog.controller
{
	import mx.controls.Label;
	
	public interface IController
	{
		function login(username:String):void
		function logout():void
		function lastOppDatFil():void
		function hundesok(soketekst:String):void
	}
}