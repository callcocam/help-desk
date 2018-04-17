<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 12/04/2018
 * Time: 18:54
 */

namespace Core\Controller;


use Core\Filter\AbstractFilter;
use Core\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Firebase\JWT\JWT;
use Interop\Container\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\JsonModel;

abstract class ApiController extends AbstractRestfulController
{


    protected $serviceManager;

    abstract public function __construct( ContainerInterface $container );

    /**
     * @var EntityManager
     */
    protected $em;

    protected $repository;


    protected $entity;

    /**
     * @var AbstractService
     */
    protected $service;

    /**
     * @var AbstractFilter
     */
    protected $filter;

    protected $factoryService = "Core\\Service\\Factory\\FactoryService";

    protected $factoryTable = "Core\\Table\\Factory\\FactoryTable";

    protected $factoryFilter = "Core\\Filter\\Factory\\FactoryFilter";
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var Integer $httpStatusCode Define Api Response code.
     */
    public $httpStatusCode = 200;
    /**
     * @var array $apiResponse Define response for api
     */
    public $apiResponse;
    /**
     *
     * @var type string
     */
    public $token;
    /**
     *
     * @var type Object or Array
     */
    public $tokenPayload;
    /**
     * @var array
     */
    protected $args = [
        'icon' => 'fa fa-warning',
        'title' => 'OPPSS!',
        'msg' => 'Não conseguimos atender a sua solicitação!',
        'type' => 'error',
    ];
    /**
     * set Event Manager to check Authorization
     * @param \Zend\EventManager\EventManagerInterface $events
     */
    public function setEventManager( EventManagerInterface $events )
    {
        parent::setEventManager($events);
        $events->attach('dispatch', array($this, 'checkAuthorization'), 10);
    }

    /**
     * This Function call from eventmanager to check authntication and token validation
     * @param type $event
     *
     */
    public function checkAuthorization( $event )
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $isAuthorizationRequired = $event->getRouteMatch()->getParam('isAuthorizationRequired');
        $config = $event->getApplication()->getServiceManager()->get('Config');
        $event->setParam('config', $config);
        if (isset($config['ApiRequest'])) {
            $responseStatusKey = $config['ApiRequest']['responseFormat']['statusKey'];
            if (!$isAuthorizationRequired) {
                return;
            }
            $jwtToken = $this->findJwtToken($request);
            if ($jwtToken) {
                $this->token = $jwtToken;
                $this->decodeJwtToken();
                if (is_object($this->tokenPayload)) {
                    return;
                }
                $response->setStatusCode(400);
                $jsonModelArr = [$responseStatusKey => $config['ApiRequest']['responseFormat']['statusNokText'], $config['ApiRequest']['responseFormat']['resultKey'] => [$config['ApiRequest']['responseFormat']['errorKey'] => $this->tokenPayload]];
            } else {
                $response->setStatusCode(401);
                $jsonModelArr = [$responseStatusKey => $config['ApiRequest']['responseFormat']['statusNokText'], $config['ApiRequest']['responseFormat']['resultKey'] => [$config['ApiRequest']['responseFormat']['errorKey'] => $config['ApiRequest']['responseFormat']['authenticationRequireText']]];
            }
        } else {
            $response->setStatusCode(400);
            $jsonModelArr = ['status' => 'NOK', 'result' => ['error' => 'Require copy this file vender\multidots\zf3-rest-api\config\restapi.global.php and paste to root config\autoload\restapi.global.php']];
        }
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $view = new JsonModel($jsonModelArr);
        $response->setContent($view->serialize());
        return $response;
    }

    /**
     * Check Request object have Authorization token or not
     * @param type $request
     * @return type String
     */
    public function findJwtToken( $request )
    {
        $jwtToken = $request->getHeaders("Authorization") ? $request->getHeaders("Authorization")->getFieldValue() : '';
        if ($jwtToken) {
            $jwtToken = trim(trim($jwtToken, "Bearer"), " ");
            return $jwtToken;
        }
        if ($request->isGet()) {
            $jwtToken = $request->getQuery('token');
        }
        if ($request->isPost()) {
            $jwtToken = $request->getPost('token');
        }
        return $jwtToken;
    }

    /**
     * contain user information for createing JWT Token
     */
    protected function generateJwtToken( $payload )
    {
        if (!is_array($payload) && !is_object($payload)) {
            $this->token = false;
            return false;
        }
        $this->tokenPayload = $payload;
        $config = $this->getEvent()->getParam('config', false);
        $cypherKey = $config['ApiRequest']['jwtAuth']['cypherKey'];
        $tokenAlgorithm = $config['ApiRequest']['jwtAuth']['tokenAlgorithm'];
        $this->token = JWT::encode($this->tokenPayload, $cypherKey, $tokenAlgorithm);
        return $this->token;
    }

    /**
     * contain encoded token for user.
     */
    protected function decodeJwtToken()
    {
        if (!$this->token) {
            $this->tokenPayload = false;
        }
        $config = $this->getEvent()->getParam('config', false);
        $cypherKey = $config['ApiRequest']['jwtAuth']['cypherKey'];
        $tokenAlgorithm = $config['ApiRequest']['jwtAuth']['tokenAlgorithm'];
        try {
            $decodeToken = JWT::decode($this->token, $cypherKey, [$tokenAlgorithm]);
            $this->tokenPayload = $decodeToken;
        } catch (\Exception $e) {
            $this->tokenPayload = $e->getMessage();
        }
    }

    /**
     * Create Response for api Assign require data for response and check is valid response or give error
     * @return \Zend\View\Model\JsonModel
     *
     */
    public function createResponse()
    {
        $config = $this->getEvent()->getParam('config', false);
        $event = $this->getEvent();
        $response = $event->getResponse();
        if (is_array($this->apiResponse)) {
            $response->setStatusCode($this->httpStatusCode);
        } else {
            $this->httpStatusCode = 500;
            $response->setStatusCode($this->httpStatusCode);
            $errorKey = $config['ApiRequest']['responseFormat']['errorKey'];
            $defaultErrorText = $config['ApiRequest']['responseFormat']['defaultErrorText'];
            $this->apiResponse[$errorKey] = $defaultErrorText;
        }
        $statusKey = $config['ApiRequest']['responseFormat']['statusKey'];
        if ($this->httpStatusCode == 200) {
            $sendResponse[$statusKey] = $config['ApiRequest']['responseFormat']['statusOkText'];
        } else {
            $sendResponse[$statusKey] = $config['ApiRequest']['responseFormat']['statusNokText'];
        }
        $sendResponse[$config['ApiRequest']['responseFormat']['resultKey']] = $this->apiResponse;
        return new JsonModel($sendResponse);
    }

    /**
     * @param mixed $entity
     * @return ApiController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setEntity( $entity )
    {
        $this->entity = $entity;
        if (!$this->repository) {
            $this->getRepository();
        }
        return $this;
    }

    /**
     * @return ApiController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getRepository()
    {
        $this->repository = $this->getEm()->getRepository($this->entity);
        return $this;
    }

    /**
     * @return AbstractFilter
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getFilter(): AbstractFilter
    {
        if (!$this->container->has($this->filter)):
            $this->setServiceManager($this->filter, $this->factoryFilter);
        endif;
        $this->filter = $this->serviceManager->get($this->filter);
        return $this->filter;
    }

    /**
     * @return AbstractController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getService()
    {
        if (!$this->container->has($this->service)):
            $this->setServiceManager($this->service, $this->factoryService);
        endif;
        $this->service = $this->serviceManager->get($this->service);
        return $this->service;
    }

    /**
     * @return EntityManager
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getEm(): EntityManager
    {
        if (is_null($this->em)):
            $this->em = $this->container->get("Doctrine\ORM\EntityManager");
        endif;
        return $this->em;
    }

    /**
     * @param string $table
     * @return ApiController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setTable( $table )
    {
        $this->table = $this->serviceManager->get($table);
        return $this;
    }

    /**
     * @param $service
     * @param $factory
     * @param string $type
     * @return ApiController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setServiceManager( $service, $factory, $type = "factories" )
    {
        $this->serviceManager = $this->container->get(ServiceManager::class);
        $this->serviceManager->setFactory($service, $factory);
        return $this;
    }

    public function getMessages( $Messages )
    {
        if ($Messages):
            $ArayMsg = [];
            foreach ($Messages as $key => $msg) {
                $ArayMsg[$key] = array_pop($msg);
            }
            $this->apiResponse['zf_validate'] = $ArayMsg;
        endif;
    }
}