<?php

namespace Autobake\Shell\Task;

// use Cake\Utility\Inflector;

use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Bake\Shell\Task\TemplateTask;

class AutoTemplateTask extends TemplateTask {

    public $tasks = ['Autobake.AutoModel'];

    /**
     * Execution method always used for tasks
     *
     * @param string|null $name The name of the controller to bake views for.
     * @param string|null $template The template to bake with.
     * @param string|null $action The action to bake with.
     * @return mixed
     */
    public function main($name = null, $template = null, $action = null)
    {
        $this->Model = $this->AutoModel;

        // $table = $this->Model->getTable($name);

        // debug(compact('table'));

        return parent::main($name, $template, $action);
    }

    /**
     * Loads Controller and sets variables for the template
     * Available template variables:
     *
     * - 'modelClass'
     * - 'primaryKey'
     * - 'displayField'
     * - 'singularVar'
     * - 'pluralVar'
     * - 'singularHumanName'
     * - 'pluralHumanName'
     * - 'fields'
     * - 'keyFields'
     * - 'schema'
     *
     * @return array Returns variables to be made available to a view template
     */
    protected function _loadController()
    {
        $modelObj = TableRegistry::get($this->modelName);

        $tableWithPrefix = $this->Model->getPrefix() . $modelObj->table();

        $modelObj->table($tableWithPrefix);

        $primaryKey = (array)$modelObj->primaryKey();
        $displayField = $modelObj->displayField();
        $singularVar = $this->_singularName($this->controllerName);
        $singularHumanName = $this->_singularHumanName($this->controllerName);
        $schema = $modelObj->schema();
        $fields = $schema->columns();
        $modelClass = $this->modelName;
        $associations = $this->_filteredAssociations($modelObj);
        $keyFields = [];
        if (!empty($associations['BelongsTo'])) {
            foreach ($associations['BelongsTo'] as $assoc) {
                $keyFields[$assoc['foreignKey']] = $assoc['variable'];
            }
        }

        $pluralVar = Inflector::variable($this->controllerName);
        $pluralHumanName = $this->_pluralHumanName($this->controllerName);

        return compact(
            'modelClass',
            'schema',
            'primaryKey',
            'displayField',
            'singularVar',
            'pluralVar',
            'singularHumanName',
            'pluralHumanName',
            'fields',
            'associations',
            'keyFields'
        );
    }
}
