<?php

namespace Autobake\Shell\Task;

use Cake\Utility\Inflector;

use Bake\Shell\Task\ControllerTask;

class AutoControllerTask extends ControllerTask {

	public $tasks = ['Autobake.AutoModel'];

	public function main($name = null)
    {
    	$table = Inflector::tableize($name);
        $prefix = $this->AutoModel->getPrefix();
        $newName = preg_replace('/' . $prefix . '/i', '', $table);

        debug($this->params);

        parent::main($newName);
    }
}
