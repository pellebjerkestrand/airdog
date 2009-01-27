package no.airdog.domain.hund
{

	[Bindable]
	public class Hund
	{		
		private var huid : String;	
		public function get id():* { return huid; }
    	public function set id(value:*):void { huid = value; }
    	
		public var tittel : String;
		public var navn : String;    	
		public var bilde : String;
		public var foreldre : String;
		public var oppdretter : String;
		public var kjonn : String;
    	
		public function equals( other:Hund ):Boolean
		{
			if (this == other) return true;
			if (other == null) return false;
			if (id == null) {
				if (other.id != null) return false;
			} else if (!(id == other.id)) return false;
			
			return true;
		}	
	}
}