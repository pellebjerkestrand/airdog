package no.airdog.controller
{
	import mx.controls.Label;
	
	public interface IController
	{
		function set statusLabel(l:Label):void;
		function setStatusLabel(text:String):void;
		function login(username:String):void
		function logout():void
		function lastOppDatFil():void
	}
}