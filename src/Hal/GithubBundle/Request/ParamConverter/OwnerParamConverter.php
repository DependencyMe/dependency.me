<?php
namespace Hal\GithubBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Hal\GithubBundle\Repository\OwnerRepositoryInterface;

/**
 * @Annotation
 */
class OwnerParamConverter implements ParamConverterInterface
{


    private $repository;

    function __construct( $repository)
    {
        $this->repository = $repository;
    }

    public function apply(Request $request, ConfigurationInterface $configuration)
    {


        $name = $configuration->getName();
        $class = $configuration->getClass();

        $login = $request->get('login');
        if(strlen($login) == 0){
            $login = $request->get('login');
        }

        $object = $this->repository->getOwnerByLogin($login);
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

        return $configuration->getClass() == 'Hal\\GithubBundle\\Entity\\Owner';
    }


}
