<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */
namespace Core;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'ApiRequest' => [
        'responseFormat' => [
            'statusKey' => 'status',
            'statusOkText' => 'OK',
            'statusNokText' => 'NOK',
            'resultKey' => 'result',
            'messageKey' => 'message',
            'defaultMessageText' => 'Empty response!',
            'errorKey' => 'error',
            'defaultErrorText' => 'Unknown request!',
            'authenticationRequireText' => 'Authentication Required.',
            'pageNotFoundKey' => 'Request Not Found.',
        ],
        'jwtAuth' => [
            'cypherKey' => 'R1a#2%dY2fX@3g8r5&s4Kf6*sd(5dHs!5gD4s',
            'tokenAlgorithm' => 'HS256',
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
