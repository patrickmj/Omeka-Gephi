<?php

class GephiDoc
{
    public $dom;
    public $atts;
    public $nodes;
    public $edges;
    
    public function __construct()
    {
        $this->dom = new DomDocument();
        $this->dom->load('/var/www/html/coe/plugins/Gephi/baseDoc.xml');        
        $this->nodes = $this->dom->getElementsByTagName('nodes')->item(0);
        $this->edges = $this->dom->getElementsByTagName('edges')->item(0);
    }       
    
    public function addNode($data) 
    {
        $node = $this->dom->createElement('node');
        $node->setAttribute('label', $data['label']);
        $node->setAttribute('id', $data['id']);
        $attValues = $this->dom->createElement('attvalues');
        $node->appendChild($attValues);
        $this->nodes->appendChild($node);
        return $node;
    }
    
    public function addEdgeByData($data)
    {
        $edge = $this->dom->createElement('edge');
        $edge->setAttribute('source', $data['source']);
        $edge->setAttribute('target', $data['target']);
        $edge->setAttribute('id', $data['id']);
        $attValues = $this->dom->createElement('attvalues');
        $edge->appendChild($attValues);        
        $this->edges->appendChild($edge);
        return $edge;
    }
    
    public function addEdge($source, $target)
    {
        $data = array();
        $data['source'] = $source->getAttribute('id');
        $data['target'] = $target->getAttribute('id');
        $data['id'] = $data['source'] . "_to_" . $data['target'];
        return $this->addEdgeByData($data);
    }
    
    public function setViz($el, $vizData)
    {        
        $vizEl = $this->dom->createElement('viz:' . $vizData['prop']);
        foreach($vizData['values'] as $att=>$val) {
            $vizEl->setAttribute($att, $val);
        }
        $el->appendChild($vizEl);
    }

    public function setAtts($el, $atts)
    {
        foreach($atts as $att)
        {
            $attValEl = $this->dom->createElement('attvalue');
            $attValEl->setAttribute('for', $att['for'] );
            $attValEl->setAttribute('value', $att['value']);     
            $attValues = $el->getElementsByTagName('attvalues')->item(0);
            $attValues->appendChild($attValEl);       
        }
        
    }
    
    public function save($filename = 'gephi.gexf')
    {
        $filename = '/var/www/html/coe/plugins/Gephi/files/' . $filename;
        $this->dom->save($filename);
        
    }
    
}