<?php

class GephiEdge extends GephiAbstract
{
    public $source;
    public $target;
    public $type = 'edge';
       
    public function build()
    {
        $this->edgeNode->setAttribute('source', $this->source);
        $this->edgeNode->setAttribute('target', $this->target);
        $this->edgeNode->setAttribute('xml:id', $this->id);
        
        
    }
    
    
}