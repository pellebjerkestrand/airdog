package no.airdog.domain
{
	/*
	* Entity interface for å følge litt Domain Drive Design.
	*/
	public interface Entity
	{
		function get id():*;

    	function set id(value:*) : void;
    	
		function equals( other:Entity ) : Boolean;
	}
}