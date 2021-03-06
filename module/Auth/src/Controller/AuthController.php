<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Auth\Controller;


use Auth\Adapter\Authentication;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class AuthController extends AbstractController
{

    /**
     * AbstractController constructor.
     * @param ContainerInterface $container
     */
    public function __construct( ContainerInterface $container )
    {
        $this->container = $container;
        $this->filter = "Auth\Filter\AuthFilter";
        $this->entity = "Auth\Entity\User";
    }

    public function getList()
    {


        if (is_string($this->service)):
            $this->getService();
        endif;
        $this->getFilter();
        /**
         * Pega o inputFilter Validate
         */
        $validate = $this->filter->getInputFilter();
        return parent::getList();
    }

    public function create( $data )
    {

        if (!$data):
            $this->httpStatusCode = 401;
            return $this->createResponse();
        endif;

        if (is_string($this->service)):
            $this->getService();
        endif;
        $this->getFilter();
        /**
         * Pega o inputFilter Validate
         */
        $validate = $this->filter->getInputFilter();

        // generate token if valid user
        $validate->setData($data);
        if ($validate->isValid()):
            /**
             * @var $auth Authentication
             */
            $auth = $this->serviceManager->get(Authentication::class);
            $password = $this->service->encryptPassword($data['document'], $data['password']);

            $Result = $auth->login($data['email'], $password);

            if ($Result->isValid()):
                $this->apiResponse['user'] = [
                    'id' => $this->identity()->getId(),
                    'firstName' => $this->identity()->getFirstName(),
                    'lastName' => $this->identity()->getLastName(),
                    'empresa' => $this->identity()->getEmpresa()->getId(),
                    'email' => $this->identity()->getEmail(),
                    'cover' => $this->identity()->getCover(),
                    'access' => $this->identity()->getAccess()->getId(),
                ];
                $this->apiResponse['token'] = $this->generateJwtToken($data);
                // Set the HTTP status code. By default, it is set to 200
                $this->httpStatusCode = 200;
            else:
                // Set the HTTP status code. By default, it is set to 200
                $this->httpStatusCode = 401;
                $this->apiResponse['defaultErrorText'] = $auth->getResult();

            endif;


        else:
            // Set the HTTP status code. By default, it is set to 200
            $this->httpStatusCode = 401;
            $this->getMessages($validate->getMessages());
        endif;
        return $this->createResponse();
    }
}