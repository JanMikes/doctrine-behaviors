<?php

namespace Lexinek\DoctrineBehaviors\ORM\Orderable;

use Knp\DoctrineBehaviors\Reflection\ClassAnalyzer;
use Knp\DoctrineBehaviors\ORM\AbstractSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 *  @author Jan Mikes <j.mikes@me.com>
 *  @copyright Jan Mikes - janmikes.cz
 */
final class OrderableSubscriber extends AbstractSubscriber
{
	private $orderableTrait;


	public function __construct(ClassAnalyzer $classAnalyzer, $isRecursive, $orderableTrait)
	{
		parent::__construct($classAnalyzer, $isRecursive);

		$this->orderableTrait = $orderableTrait;
	}


	public function getSubscribedEvents()
	{
		return [Events::loadClassMetadata];
	}


	public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
	{
		$classMetadata = $eventArgs->getClassMetadata();

		if ($classMetadata->reflClass === NULL) {
			return;
		}

		if ($this->isOrderable($classMetadata)) {
			if ($classMetadata->reflClass->hasMethod("updatePosition")) {
				$classMetadata->addLifecycleCallback("updatePosition", Events::postPersist);
			}

			if (!$classMetadata->hasField("position")) {
				$classMetadata->mapField([
					"fieldName" => "position",
					"type"      => "integer",
					"nullable"  => true
				]);
			}
		}
	}


	private function isOrderable(ClassMetadata $classMetadata)
	{
		return $this->getClassAnalyzer()->hasTrait(
			$classMetadata->reflClass,
			$this->orderableTrait,
			$this->isRecursive
		);
	}
}
