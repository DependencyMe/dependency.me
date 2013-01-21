<?php
namespace Hal\Bundle\EntityOverridingBundle\Doctrine\ORM\Mapping\Driver;

use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\Common\Persistence\Mapping\MappingException;

/**
 * @author @Halleck45 Jean-François Lépine
 */
class YamlExtendedDriver extends SimplifiedYamlDriver
{


    public function getElement($className)
    {
        $element = parent::getElement($className);

        $paths = $this->getLocator()->getPaths();
        foreach ($paths as $path) {

            $fileName = $path . '-override' . DIRECTORY_SEPARATOR . str_replace('\\', '.', $className) . $this->getLocator()->getFileExtension();

            //
            // Entity is overrided
            if (file_exists($fileName)) {

                $result = $this->loadMappingFile($fileName);

                if (!isset($result[$className])) {
                    throw new MappingException(sprintf('Incorrect overriding mapping file found in "%s" for class "%s"', $fileName, $className));
                }

                $infos = $result[$className];


                //
                // Override
                foreach ($infos as $name => $value) {
                    if (is_array($value)) {
                        if(!isset($element[$name])) {
                            $element[$name] = array();
                        }
                        $element[$name] = array_merge($element[$name], $value);
                    } else {
                        $element[$name] = $value;
                    }
                }
            }
        }

        return $element;
    }
}