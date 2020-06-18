<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Models\ArdorNode;

class ArdorBase {

    public ArdorNode $node;

    public function __construct(ArdorNode $node = null){
        $this->node = $node != null ? $node : new ArdorNode();
    }

}