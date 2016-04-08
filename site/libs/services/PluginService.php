<?php
namespace services;

class PluginService
{

    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function process($matches)
    {
        if (!is_array($matches)) {
            return null;
        }
        list($pluginObject, $methodName, $params) = $this->parseMatchString($matches[1]);

        return call_user_func_array(array($pluginObject, $methodName), $params);
    }

    public function parseBodyPlugins(&$body)
    {

        if (($newBody = preg_replace_callback('/(?:{\$([\w.-_\(\)]+)})/', array($this, 'process'), $body))) {
            $body = $newBody;

        }
    }

    protected function parseMatchString($pluginString)
    {

        if (strpos($pluginString, '.')) {
            $parts = explode('.', $pluginString);
            $objectName = $parts[0];
            $methodName = $parts[1];
            if (array_key_exists($this->app, $objectName)) {
                $pluginObject = $this->app[$pluginString];
            }
        } else {
            $pluginObject = $this;
            $methodName = $pluginString;
        }

        if (strpos($methodName, '(')) {
            if (\preg_match_all('/(\w+)/', $methodName, $matches)) {
                $methodName = array_shift($matches[1]);
                $params = $matches[1];
            }
        } else {
            $params = array();
        }

        return array($pluginObject, $methodName, $params);

    }

    protected function lista_resurse()
    {
        $modelService = $this->app['models'];
        $model = $modelService->getModel('ResourceModel');
        return $this->app['twig']->render('/partials/resource_list.twig', array(
            'resources' => $model->getListing(),
        ));
    }

    protected function carousel($mediaTypeId)
    {

        $modelService = $this->app['models'];
        $model = $modelService->getModel('ResourceModel');
        return $this->app['twig']->render('/layers/carousel.twig', array(
            'carousel' => $model->byMediaType($mediaTypeId),
        ));
    }
}
