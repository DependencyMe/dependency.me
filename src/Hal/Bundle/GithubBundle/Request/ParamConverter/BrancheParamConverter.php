<?php
namespace Hal\Bundle\GithubBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Hal\Bundle\GithubBundle\Repository\BrancheRepositoryInterface;

/**
 * @Annotation
 */
class BrancheParamConverter implements ParamConverterInterface
{


    private $brancheRepository;

    function __construct($brancheRepository)
    {
        $this->brancheRepository = $brancheRepository;
    }

    public function apply(Request $request, ConfigurationInterface $configuration)
    {


        $name = $configuration->getName();
        $class = $configuration->getClass();

        $fullname = $request->get('branche');
        if (null !== $request->get('owner') && null !== $request->get('repository') && null !== $request->get('branche')) {
            $fullname = implode('/', array($request->get('owner'), $request->get('repository'), $request->get('branche')));
        }

        $object = $this->brancheRepository->getByFullName($fullname);
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

        return $configuration->getClass() == 'Hal\\Bundle\\GithubBundle\\Entity\\Branche';
    }


}
