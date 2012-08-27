<?php

class Gephi_DocController extends Omeka_Controller_Action
{
    public $gephi;
    public $nodes = array();
    
    public function init()
    {
        require_once('/var/www/html/coe/plugins/Gephi/libraries/GephiDoc.php');
        $this->gephi = new GephiDoc;        
        
        
    }
    

    
    public function notesAction()
    {
        $notes = get_db()->getTable('MlaTeiElement_CommentaryNote')->findAll();
        foreach($notes as $note) {
            $noteNode = $this->mlaTeiElementToNode($note);
            $this->gephi->setViz($noteNode, array('prop'=> 'color',
                                                'values' => array('r'=>'255', 'g'=>'0', 'b'=>'0')));
            $commentatorItems = $note->getCommentatorItems();
            foreach($commentatorItems as $commentator) {
                if(array_key_exists('item_' . $commentator->id, $this->nodes)) {
                    $cNode = $this->nodes['item_' . $commentator->id];
                } else {
                    $cNode = $this->itemToNode($commentator);
                    $this->nodes['item_' . $commentator->id] = $cNode;
                    $this->gephi->setViz($cNode, array('prop'=>'color', 'values'=>array('r'=>'0', 'g'=>'0', 'b'=>'255')));
                }
                $edge = $this->gephi->addEdge($noteNode, $cNode);
            }
        }
        $this->gephi->save('commentators.gexf');
    }
    
    public function appendixPsAction()
    {
        
        $notes = get_db()->getTable('MlaTeiElement_AppendixP')->findAll();
        foreach($notes as $note) {
            $noteNode = $this->mlaTeiElementToNode($note);
            $this->gephi->setViz($noteNode, array('prop'=> 'color',
                    'values' => array('r'=>'255', 'g'=>'0', 'b'=>'0')));
            $commentatorItems = $note->getCommentatorItems();
            foreach($commentatorItems as $commentator) {
                if(array_key_exists('item_' . $commentator->id, $this->nodes)) {
                    $cNode = $this->nodes['item_' . $commentator->id];
                } else {
                    $cNode = $this->itemToNode($commentator);
                    $this->nodes['item_' . $commentator->id] = $cNode;
                    $this->gephi->setViz($cNode, array('prop'=>'color', 'values'=>array('r'=>'0', 'g'=>'0', 'b'=>'255')));
                }
                $edge = $this->gephi->addEdge($noteNode, $cNode);
            }
        }
        $this->gephi->save('appendixPs.gexf');        
    }
    
    public function speechesAction()
    {
        $speeches = get_db()->getTable('MlaTeiElement_Speech')->findAll();
        foreach($speeches as $speech) {
            $commentatorItems = mla_get_commentators_for_speech($speech);
            $speechNode = $this->mlaTeiElementToNode($speech);
            $this->gephi->setViz($speechNode, array('prop'=> 'color',
                    'values' => array('r'=>'255', 'g'=>'0', 'b'=>'0')));
            foreach($commentatorItems as $commentator) {
                if(array_key_exists('item_' . $commentator->id, $this->nodes)) {
                    $cNode = $this->nodes['item_' . $commentator->id];
                } else {
                    $cNode = $this->itemToNode($commentator);
                    $this->nodes['item_' . $commentator->id] = $cNode;
                    $this->gephi->setViz($cNode, array('prop'=>'color', 'values'=>array('r'=>'0', 'g'=>'0', 'b'=>'255')));
                }
                $edge = $this->gephi->addEdge($speechNode, $cNode);
            }
        }
        $this->gephi->save('speeches.gexf');
    }
    
    private function itemToNode($item)
    {        
        $data = array('id'=>'item_' . $item->id);
        $data['label'] = item('Dublin Core', 'Title', array(), $item);
        return $this->gephi->addNode($data);                
    }
    
    private function mlaTeiElementToNode($el)
    {
        $data = array('id'=>$el->xml_id);
        if($el->label) {
            $data['label'] = $el->label;
        }
        return $this->gephi->addNode($data);
        
    }
    
    
}