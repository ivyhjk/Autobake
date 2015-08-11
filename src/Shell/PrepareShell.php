<?php

namespace Autobake\Shell;

use Bake\Shell\BakeShell as CakeBake;

class PrepareShell extends CakeBake {
	public function all($name = null, $test = null)
    {
        $this->Model = $this->AutoModel;
        $this->Controller = $this->AutoController;
        $this->Template = $this->AutoTemplate;


        if ( ! isset($this->params['prefix']) || ! $this->params['prefix']) {
            // $prefix = $this->in('No ha seleccionado un prefijo, desea que el prefijo sea "admin"?');
            $prefix = $this->in('No ha seleccionado un prefijo, desea que el prefijo sea "admin"?', ['y', 'n'], 'y');

            if ($prefix === 'y') {
                $this->params['prefix'] = 'admin';
            }
        }

        return parent::all($name, $test);
    }

    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        $parser->addOption('prefix', [
            'help' => 'Realiza un "bake" con el prefijo dado.'
        ]);
        return $parser;
    }
}
