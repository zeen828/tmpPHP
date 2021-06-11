<?php

namespace App\Libraries\Upgrades;

use App\Libraries\Upgrades\BetterControllerGenerator;
use Str;

class ExchangeControllerGenerator extends BetterControllerGenerator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'controller/ExchangeController';

    /**
     * Gets service name.
     *
     * @return string
     */
    public function getServiceName()
    {
        return ucwords(str_replace('_', ' ',  Str::replaceFirst('_third', '', Str::snake($this->getControllerName()))));
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return array_merge(parent::getReplacements(), [
            'controller' => $this->getControllerName(),
            'plural' => $this->getPluralName(),
            'singular' => $this->getSingularName(),
            'validator' => $this->getValidator(),
            'repository' => $this->getRepository(),
            'appname' => $this->getAppNamespace(),
            'dummyclass' => $this->getDummyClass(),
            'servicename' => $this->getServiceName()
        ]);
    }
}