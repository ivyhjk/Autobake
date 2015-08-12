<?php

namespace Autobake\Shell\Task;

use Cake\Core\Configure;
use Bake\Shell\Task\BakeTemplateTask;

// use Bake\View\BakeView;
// use Cake\Console\Shell;
// use Cake\Core\Configure;
// use Cake\Core\ConventionsTrait;
// use Cake\Event\Event;
// use Cake\Event\EventManager;
// use Cake\Network\Request;
// use Cake\Network\Response;
// use Cake\View\Exception\MissingTemplateException;
// use Cake\View\ViewVarsTrait;


class AutoBakeTemplateTask extends BakeTemplateTask
{
    /**
     * Get view instance
     *
     * @return \Cake\View\View
     * @triggers Bake.initialize $view
     */
    public function getView()
    {
        $bakeTemplates = dirname(dirname(dirname(__FILE__))) . DS . 'Template' . DS;
        $templateDirs = Configure::read('App.paths.templates');

        array_unshift($templateDirs, $bakeTemplates);

        Configure::write('App.paths.templates', $templateDirs);

        return parent::getView();
    }
}
