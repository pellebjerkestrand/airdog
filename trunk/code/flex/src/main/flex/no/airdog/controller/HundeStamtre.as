package no.airdog.controller
{
	import flash.events.*;
	import flash.geom.Rectangle;
	
	import mx.containers.HBox;
	import mx.containers.VBox;
	import mx.controls.*;
	import mx.events.*;
	
	import no.airdog.model.Hund;
	import no.airdog.services.Components;
	
	public class HundeStamtre extends HBox
	{
		private var _box:HBox;
		
		public function HundeStamtre()
		{
			this.setStyle("horizontalAlign", "center");
			this.setStyle("verticalAlign", "middle");
			this.setStyle("width", "100%");
			this.setStyle("height", "100%");
		}
		
		public function set hund(val:Hund):void
		{
			while (this.numChildren > 0)
			{             
				this.removeChildAt(0);        
			}
			
			if (val != null)
			{
				_box = leggTilHund(val);
				this.addChild(_box);
			}
			else
			{
				_box = null;
				this.invalidateDisplayList();
			}
		}
			
		private function visHund(event:Event):void
		{
			var sender:LinkButton = event.target as LinkButton;
			if (sender != null)
			{
				Components.instance.controller.visHund(sender.data.toString());
			}
		}
		
		private function oppdaterStrek(event:Event):void
		{
			this.invalidateDisplayList();
		}
		
		private function leggTilHund(hund:Hund):HBox
		{
			var hBox:HBox = new HBox();
			var vBox:VBox = new VBox();
			
			var hundNode:VBox = new VBox();
			var hundNodeHBox:HBox = new HBox();
			var kjonnIkon:Image = new Image();
			var hundIdLabel:Label = new Label();
			var tittelLabel:Label = new Label();
			
			var hRule:HRule = new HRule();
			var hundNavn:LinkButton = new LinkButton();
			
			hundNodeHBox.addChild(kjonnIkon);
			hundNodeHBox.addChild(hundIdLabel);
			hundNodeHBox.addChild(tittelLabel);
			hundNodeHBox.percentWidth = 100;
			
			if (hund.hundId != "")
			{
				hundNode.addChild(hundNodeHBox);
				hundNode.addChild(hRule);
			}
			
			hundNode.addChild(hundNavn);
			
			hundNavn.label = hund.navn;
			hundNavn.data = hund.hundId;
			tittelLabel.text = hund.tittel;
			
			if(hund.kjonn == "H")
			{
				kjonnIkon.source = "no/airdog/view/assets/ikoner/gender.png";
				hundNodeHBox.setStyle("backgroundColor", "#ceceff");
			}
			else if(hund.kjonn == "T")
			{
				kjonnIkon.source = "no/airdog/view/assets/ikoner/gender_female.png";
				hundNodeHBox.setStyle("backgroundColor", "#ffcece");
			}
			
			hundIdLabel.text = hund.hundId;
			
			hundNode.name = "hundKnapp";
			hundNode.width = 250;
			hundNode.setStyle("backgroundColor", "#F5F5F5");
			hundNode.setStyle("borderStyle", "solid");
			hundNode.setStyle("borderThickness", "1");
			hundNode.setStyle("cornerRadius", "6");
			hundNode.setStyle("borderColor", "#a3a3a3");
			hundNode.verticalScrollPolicy = "off";
			hundNode.horizontalScrollPolicy = "off";
			hundNode.setStyle("verticalGap", "0");
			
			hRule.percentWidth = 100;
			
			hundNavn.percentWidth = 100;
			hundNavn.setStyle("fontSize", "12");
			hundNavn.setStyle("textAlign", "left");
			
			hundIdLabel.setStyle("fontSize", "9");
			hundIdLabel.selectable = true;
			
			tittelLabel.setStyle("fontSize", "9");
			tittelLabel.setStyle("color", "#878787");
			tittelLabel.percentWidth = 100;
			tittelLabel.setStyle("textAlign", "right");
			
			hBox.setStyle("verticalAlign","middle")
			hBox.addChild(hundNode);
			hBox.addChild(vBox);
			
			hundNavn.addEventListener(MouseEvent.CLICK, visHund);
			hundNode.addEventListener(FlexEvent.UPDATE_COMPLETE, oppdaterStrek);
			
			vBox.name = "foreldreBoks";
			
			if (hund.far != null && hund.far.navn != null)
			{
				vBox.addChild(leggTilHund(hund.far));
			}
			
			if (hund.mor != null && hund.mor.navn != null)
			{
				vBox.addChild(leggTilHund(hund.mor));
			}
	
			return hBox;
		}
		
		private function tegnStrek(hBox:HBox):void
		{
			var node:VBox = hBox.getChildByName("hundKnapp") as VBox;
			var nodeRect:Rectangle = node.getRect(this);
			
			var vBox:VBox = hBox.getChildByName("foreldreBoks") as VBox;
			
			if (vBox != null)
			{
				var foreldre:Array = vBox.getChildren();
				
				var i:int;
				for (i = 0; i < foreldre.length; i++) 
				{
					var nyBox:HBox = foreldre[i] as HBox;
					tegnStrek(nyBox);
					
					var nyBoxRect:Rectangle = nyBox.getRect(this);
					
					graphics.moveTo(nodeRect.right, nodeRect.y + (nodeRect.height / 2));
					graphics.lineStyle(2,0xd2d8de);
					graphics.lineTo(nyBoxRect.x, nyBoxRect.y + (nyBoxRect.height / 2));
				}
			}
		}
		
		override protected function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void
		{
			graphics.clear();
			
			super.updateDisplayList(unscaledWidth, unscaledHeight);
			
			if (_box != null)
			{
				_box.invalidateSize();
				_box.invalidateProperties();
				_box.invalidateDisplayList();
				tegnStrek(_box);
			}
		}
	}
}