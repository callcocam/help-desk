<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 18/03/2018
 * Time: 16:43
 */

namespace Core\Filter;


use Interop\Container\ContainerInterface;

interface FilterInterface
{

    /**
     * FilterInterface constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container);

    /**
     * @return mixed
     */
    public function getInputFilter();
}