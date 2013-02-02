<?php

namespace Hal\Bundle\GithubBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Hal\Bundle\GithubBundle\Repository\RepositoryRepositoryInterface;

/**
 * @Annotation
 */
class RepositoryParamConverter implements ParamConverterInterface
{

    private $repository;

    function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function apply(Request $request, ConfigurationInterface $configuration)
    {


        $name = $configuration->getName();
        $class = $configuration->getClass();
        $fullname = implode('/', array($request->get('owner'), $request->get('repository')));

        $object = $this->repository->getByName($fullname);
        if (!$object) {
            throw new NotFoundHttpException(sprintf('%s object not found.', $class));
        }


        $request->attributes->set($name, $object);
        return true;
    }

    public function supports(ConfigurationInterface $configuration)
    {

        if (!$configuration->getClass()) {
            return false;
        }

        return $configuration->getClass() == 'Hal\\Bundle\\GithubBundle\\Entity\\Repository';
    }

}
