package data
{		
	[Bindable]
	public class Dog
	{
		public var id:int;
		public var name:String;
		public var imageURL:String;
		
		public function toString():String
		{
			return name;
		}		
	}
}
