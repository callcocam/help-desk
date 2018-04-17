<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Core;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Uri\UriFactory;
use Zend\View\Model\JsonModel;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }


    /**
     * @param $e
     * @return mixed
     */
    public function getJsonModelError( $e )
    {
        $error = $e->getError();
        if (!$error) {
            return;
        }

        $response = $e->getResponse();
        $exception = $e->getParam('exception');
        $exceptionJson = [];
        if ($exception) {
            $exceptionJson = [
                'class' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
                'stacktrace' => $exception->getTraceAsString(),
            ];
        }

        $errorJson = [
            'message' => 'An error occurred during execution; please try again later.',
            'error' => $error,
            'exception' => $exceptionJson,
        ];
        if ($error == 'error-router-no-match') {
            $errorJson['message'] = 'Resource not found.';
        }

        $model = new JsonModel(['errors' => [$errorJson]]);

        $e->setResult($model);

        return $model;
    }

    /**
     * @param MvcEvent $e
     */
    public function onBootstrap( MvcEvent $e )
    {
        UriFactory::registerScheme('chrome-extension', 'Zend\Uri\Uri');
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'onDispatchError'], 0);
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'onRenderError'], 0);
    }

    /**
     * @param $e
     * @return mixed
     */
    public function onDispatchError( $e )
    {
        return $this->getJsonModelError($e);
    }

    /**
     * @param $e
     * @return mixed
     */
    public function onRenderError( $e )
    {
        return $this->getJsonModelError($e);
    }
}
