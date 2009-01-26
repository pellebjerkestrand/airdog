package no.airdog.domain.hund
{
	import no.airdog.domain.Entity;

	[Bindable]
	public class Hund implements Entity
	{
		private var huid : String;
		private var navn : String;
		
		// huid	
		public function get id():* { return huid; }
    	public function set id(value:*):void { huid = value; }
		
		// navn    	
		public function get navn():* { return navn; }
    	public function set navn(value:*):void { navn = value; }
    	
		public function equals( other:Entity ):Boolean
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