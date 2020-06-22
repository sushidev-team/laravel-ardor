<?php 

namespace AMBERSIVE\Ardor\Interfaces;

use AMBERSIVE\Ardor\Models\ArdorBlock;

interface ArdorBundlerInterface {


    public function __construct();
    public function run(ArdorBlock $block);

}
