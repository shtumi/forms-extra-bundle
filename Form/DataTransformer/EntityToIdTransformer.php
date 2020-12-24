<?php

namespace Artprima\Bundle\FormsExtraBundle\Form\DataTransformer;

use Artprima\Bundle\FormsExtraBundle\Form\Model\EntityView;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class EntityToIdTransformer
 *
 * source: Dpn\ToolsBundle\Form\DataTransformer
 */
class EntityToIdTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $class;

    public function __construct(EntityManagerInterface $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->class = $class;
    }

    public function transform($entity)
    {
        if (null === $entity) {
            return null;
        }

        return $entity->getId();
    }

    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $entity = $this->objectManager
            ->getRepository($this->class)
            ->find($id);

        if (null === $entity) {
            throw new TransformationFailedException();
        }

        return $entity;
    }
}