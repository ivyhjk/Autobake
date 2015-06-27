<?php

namespace Autobake\Shell\Task;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Datasource\ConnectionManager;

use Bake\Shell\Task\ModelTask;

class AutoModelTask extends ModelTask {
	public $prefix = '';

	/**
     * Get a model object for a class name.
     *
     * @param string $className Name of class you want model to be.
     * @param string $table Table name
     * @return \Cake\ORM\Table Table instance
     */
    public function getTableObject($className, $table)
    {

    	$newTableName = preg_replace('/' . $this->getPrefix() . '/i', '', $table);
    	$newClassName = $this->_camelize($newTableName);

        if (TableRegistry::exists($newClassName)) {
            return TableRegistry::get($newClassName);
        }

        return TableRegistry::get($newClassName, [
            'name' => $newClassName,
            'table' => $table,
            'connection' => ConnectionManager::get($this->connection)
        ]);
    }

	public function getPrefix()
	{
		if ( ! $this->prefix) {
			$db = ConnectionManager::get($this->connection);

			$config = $db->config();

			if (isset($config['prefix'])) {
		        $this->prefix = $config['prefix'];
	        }
		}

        return $this->prefix;
	}
}
