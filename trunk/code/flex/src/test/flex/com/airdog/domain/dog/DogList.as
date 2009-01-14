package com.airdog.domain.dog
{
	import flash.utils.Dictionary;
	import flash.xml.XMLDocument;
	import mx.collections.ArrayCollection;
	
	public class DogList
	{
		private var dogXML:XML = new XML("DogList.xml");
		private var dogs:ArrayCollection = getDogs();
			
		public function getDogs():ArrayCollection
		{
			if(dogs==null)
			{	
				dogs = xml2array(dogXML);
			}
			return dogs;
		}
		
		private function xml2array(xml:XMLDocument):ArrayCollection
		{  
	    	var ac:ArrayCollection = new ArrayCollection();  
	     	var xmlNodes:ArrayCollection = new ArrayCollection(xml.childNodes);  
	     	
	     	for (var i:int = 0; i < xmlNodes.length; i++)
	     	{  
	        	var thisRecord:Dictionary = new Dictionary();  
	         	var rowObj:Object = xmlNodes[i].childNodes;  
	         	
	         	for (var j:int = 0; j < rowObj.length; j++)
	         	{  
	             	var thisNodeName:String = rowObj[j].localName;  
	             	var thisNodeValue:String = '';  
	             	
	             	if (rowObj[j].childNodes && rowObj[j].childNodes.length > 0)
	             	{  
	                 	if (rowObj[j].childNodes[0].nodeValue)  
	                     	thisNodeValue = rowObj[j].childNodes[0].nodeValue;  
	                 	else   
	                     	thisNodeValue = '';  
	             	}  
	             	thisRecord[thisNodeName] = thisNodeValue;  
	         	}  
	         	ac.addItem(thisRecord);  
	     	}  
	     	return ac;  
	 	}
	}
}