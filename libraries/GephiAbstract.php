<?php

abstract class GephiAbstract
{
    public $id;
    public $atts;
    public $dom;
    public $node;
    public $metaAtts;
    abstract public $type;
    
    
    public function __construct($init = array())
    {
        $this->dom = new DomDocument();
        $this->dom->loadXML("{$type}Base.xml");
        $this->node = $this->dom->getTags($this->type)->item(0);
        $this->atts = array();
        $this->buildXml();
         
    }
    
    public function init($init = array())
    {
        foreach($init as $key=>$val) {
            $this->key = $val;
        }
    
    }
    
    public function buildXml()
    {
        foreach($this->atts as $att=>$value)
        {
            $this->node->setAttribute($att, $value);
        }
        
        foreach($this->metaAtts as $att ) {
            
            
        }
        
    }
    
    
}