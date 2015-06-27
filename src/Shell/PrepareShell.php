<?php

namespace Autobake\Shell;

use Bake\Shell\BakeShell as CakeBake;

class PrepareShell extends CakeBake {
	public function all($name = null, $test = null)
    {
        $this->out('Bake All');
        $this->hr();

        if (!empty($this->params['connection'])) {
            $this->connection = $this->params['connection'];
        }

        $this->AutoModel->connection = $this->connection;

        if (empty($name) && !$this->param('everything')) {
            $this->out('Possible model names based on your database:');
            foreach ($this->AutoModel->listAll() as $table) {
            	$table = preg_replace('/' . $this->AutoModel->getPrefix() . '/i', '', $table);

                $this->out('- ' . $table);
            }

            $this->out('Run <info>`cake bake all [name]`</info> to generate skeleton files.');
            return false;
        }

        $name = $this->AutoModel->getPrefix() . $name;

        $allTables = collection([$name]);


        $filteredTables = $allTables;

        if ($this->param('everything')) {
            $this->AutoModel->connection = $this->connection;
            $allTables = collection($this->AutoModel->listAll());
            $filteredTables = $allTables->reject(function ($tableName) {
                $ignoredTables = ['i18n', 'cake_sessions', 'phinxlog', 'users_phinxlog'];
                return in_array($tableName, $ignoredTables);
            });
        }

        $this->params['prefix'] = 'admin';

        $filteredTables->each(function ($tableName) {
            foreach (['AutoModel', 'AutoController', 'Template'] as $task) {
                $this->{$task}->connection = $this->connection;
            }

            $tableName = $this->_camelize($tableName);

            $this->AutoModel->main($tableName);
            $this->AutoController->main($tableName);

            debug(':D');
            exit();
            $this->Template->main($tableName);
        });

        $this->out('<success>Bake All complete.</success>', 1, Shell::QUIET);
        return true;
    }
}
