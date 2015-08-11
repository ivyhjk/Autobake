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

        // debug(compact('newName', 'table', 'prefix', 'name'));
        // exit();

        parent::main($newName);
    }

    /**
     * Outputs and gets the list of possible controllers from database
     *
     * @return array Set of controllers
     */
    public function listAll()
    {
        $this->AutoModel->connection = $this->connection;
        return $this->AutoModel->listAll();
    }
}
