<?php

namespace Hal\ReleaseWebBundle\Twig\Extension;

use Hal\ReleaseBundle\Service\RequirementServiceInterface;

class RequirementStateExtension extends \Twig_Extension
{
    private $requirementService;

    function __construct(RequirementServiceInterface $requirementService)
    {
        $this->requirementService = $requirementService;
    }


    public function getFunctions()
    {
        return array(
            'requirement_state' => new \Twig_Function_Method($this, 'getRequirementState'),
        );
    }

    public function getRequirementState($element)
    {
        return $this->requirementService->getStateOf($element);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'hal_release_requirement';
    }
}
