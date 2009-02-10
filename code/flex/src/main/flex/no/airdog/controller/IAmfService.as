package no.airdog.services
{
	public interface IAmfService
	{
		function login(username:String, password:String, result:Function, fault:Function = null):void;
	}
}