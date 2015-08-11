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
     * Generate code for the given model name.
     *
     * @param string $name The model name to generate.
     * @return void
     */
    public function bake($name)
    {
        $table = $this->getTable($name);
        $model = $this->getTableObject($name, $table);

        $associations = $this->getAssociations($model);
        $this->applyAssociations($model, $associations);

        $primaryKey = $this->getPrimaryKey($model);
        $displayField = $this->getDisplayField($model);
        $fields = $this->getFields($model);
        $validation = $this->getValidation($model, $associations);
        $rulesChecker = $this->getRules($model, $associations);
        $behaviors = $this->getBehaviors($model);
        $connection = $this->connection;

        $data = compact(
            'associations',
            'primaryKey',
            'displayField',
            'table',
            'fields',
            'validation',
            'rulesChecker',
            'behaviors',
            'connection'
        );
        $this->bakeTable($model, $data);
        $this->bakeEntity($model, $data);
        $this->bakeFixture($model->alias(), $model->table());
        $this->bakeTest($model->alias());
    }

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

        $finalTableName = $this->getPrefix() . $newTableName;

        $model = TableRegistry::get($newClassName, [
            'name' => $newClassName,
            // 'table' => $finalTableName,
            'connection' => ConnectionManager::get($this->connection)
        ]);

        $model->table($finalTableName);

        return $model;
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

    /**
     * Outputs the a list of possible models or controllers from database
     *
     * @return array
     */
    public function listAll()
    {
        if (!empty($this->_tables)) {
            return $this->_tables;
        }

        $prefix = $this->getPrefix();

        $this->_modelNames = [];
        $this->_tables = $this->_getAllTables();

        foreach ($this->_tables as $key => $table) {
            $table = str_replace($prefix, '', $table);

            $this->_modelNames[] = $this->_camelize($table);

            $this->_tables[ $key ] = $table;
        }

        return $this->_tables;
    }
}
