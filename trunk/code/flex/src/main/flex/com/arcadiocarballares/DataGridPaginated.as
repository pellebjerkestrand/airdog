/*
 * DataGridPaginated
 * v1.0
 * Arcadio Carballares Martín, 2008
 * http://www.carballares.es/arcadio
 */
package com.arcadiocarballares {
    import flash.events.Event;
    import flash.events.FocusEvent;
    import flash.events.MouseEvent;
    
    import mx.collections.ArrayCollection;
    import mx.containers.HBox;
    import mx.controls.DataGrid;
    import mx.controls.Image;
    import mx.controls.Label;
    import mx.controls.Spacer;
    import mx.controls.TextInput;
    
    [Event(name="next", type="flash.events.Event")]
    [Event(name="previous", type="flash.events.Event")]
    [Event(name="first", type="flash.events.Event")]
    [Event(name="last", type="flash.events.Event")] 
    
    public class DataGridPaginated extends DataGrid {
        public var page:int;
        public var index:int;
        public var pageTotal:int;
        [Inspectable(category="Other", enumeration="left,center,right", defaultValue="center")]
        public var pageAlign:String;
        [Embed('first.png')]
        private var first:Class;
        [Embed('last.png')]
        private var last:Class;
        [Embed('next.png')]
        private var next:Class;
        [Embed('previous.png')]
        private var previous:Class;
        private var pie:HBox;
        private var imgFirst:Image;
        private var imgLast:Image;
        private var imgNext:Image;
        private var imgPrevious:Image;
        private var pageInput:TextInput;
        private var pageText:Label;
        private var pageData:ArrayCollection;
        private var spaceLeft:Spacer;
        private var spaceRight:Spacer;
        
        public function DataGridPaginated() {
            super();
            init();
        }
        
        public function init():void {
            page=1;
            index=0;
            pageTotal=0;
            pageAlign="center";
        }
        
        override protected function createChildren():void {
            super.createChildren();
            pie=new HBox();
            pie.setStyle('horizontalGap',0);
            pie.setStyle('verticalAlign','middle');
            pie.alpha=1.0;
            imgFirst=new Image();
            imgFirst.addEventListener(MouseEvent.CLICK,onFirst);
            imgFirst.source=first;
            imgLast=new Image();
            imgLast.addEventListener(MouseEvent.CLICK,onLast);
            imgLast.source=last;
            spaceLeft=new Spacer();
            spaceRight=new Spacer();
            pageInput=new TextInput();
            pageInput.addEventListener(Event.CHANGE,onPageChange);
            pageInput.addEventListener(FocusEvent.FOCUS_IN,onPageFocus);
            pageInput.setStyle('textAlign','right'); 
            pageInput.setStyle('paddingTop',0);
            pageInput.setStyle('paddingLeft',0);
            pageInput.setStyle('paddingBottom',0);
            pageInput.setStyle('paddingRight',0);
            pageInput.setStyle('borderStyle','none');
            pageInput.setStyle('backgroundAlpha',0.2);
            pageInput.setStyle('backgroundColor','gray');
            pageInput.setStyle('fontSize',9);
            pageText=new Label();
            pageText.setStyle('textAlign','left');
            pageText.setStyle('fontSize',9); 
            imgNext=new Image();
            imgNext.addEventListener(MouseEvent.CLICK,onNext);
            imgNext.source=next;
            imgPrevious=new Image();
            imgPrevious.addEventListener(MouseEvent.CLICK,onPrevious);
            imgPrevious.source=previous;
            pie.addChild(imgFirst);
            pie.addChild(imgPrevious);
            pie.addChild(spaceLeft);
            pie.addChild(pageInput);
            pie.addChild(pageText);
            pie.addChild(spaceRight);
            pie.addChild(imgNext);
            pie.addChild(imgLast);
            addChild(pie);
          }
          
          override protected function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void {
            super.updateDisplayList(unscaledWidth, unscaledHeight);
            pie.setActualSize(width,rowHeight);
            pie.y=height;
            switch (pageAlign) {
                case 'left':
                    pie.setStyle('horizontalAlign','left');
                    break;
                case 'center':
                    spaceLeft.percentWidth=100;
                    spaceRight.percentWidth=100;
                    break;
                case 'right':
                    pie.setStyle('horizontalAlign','right');
                    break;
            }
            var pageNumber:int=index+1;
            if (!pageTotal) {
                pageTotal=Math.ceil(pageData.length/page);
            }
            pageInput.text=pageNumber.toString();
            pageInput.width=20;
            pageInput.height=14;
            pageText.height=14;
            pageText.text=' of '+ pageTotal;
        }
        
        override protected function measure():void {
            super.measure();
        }
        
        override public function set dataProvider(value:Object):void {
            pageData=ArrayCollection(value);
            super.dataProvider=getData();
        }
        
        private function getData():ArrayCollection {
            var dt:ArrayCollection=new ArrayCollection();
            for (var i:int=0;i<page;i++) {
                if (index*page+i<pageData.length) {
                    dt.addItem(pageData[(index*page)+i]);
                }
            }
            return dt;
        }
        
        private function onNext(event:MouseEvent):void {
            if (index<Math.ceil(pageData.length/page)-1) {
                index++;
                super.dataProvider=getData();
                dispatchEvent(new Event("next"));
            }
        }
        
        private function onPrevious(event:MouseEvent):void {
            if (index>0) {
                index--;
                super.dataProvider=getData();
                dispatchEvent(new Event("previous"));
            }
        }
        
        private function onFirst(event:MouseEvent):void {
            index=0;
            super.dataProvider=getData();
            dispatchEvent(new Event("first"));
        }
        
        private function onLast(event:MouseEvent):void {
            index=Math.ceil(pageData.length/page)-1;
            super.dataProvider=getData();
            dispatchEvent(new Event("last"));
        }
        
        private function onPageChange(event:Event):void {
            var num:int=parseInt(pageInput.text);
            if (num>0) {
                num--;
            }
            index=num;
            super.dataProvider=getData();
        }
        
        private function onPageFocus(event:Event):void {
            pageInput.setSelection(0,pageInput.text.length);
        }
    }
}