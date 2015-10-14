<?php

namespace Lexinek\DoctrineBehaviors\Model\Orderable;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 *  @author Jan Mikes <j.mikes@me.com>
 *  @copyright Jan Mikes - janmikes.cz
 */
trait OrderableMethods
{
	public function updatePosition(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();
		$entity->setPosition($entity->id * 10);
		
		$em = $args->getEntityManager();
		$em->persist($entity);
		$em->flush();
	}


	public function getPosition()
	{
		return $this->position;
	}


	public function setPosition($position)
	{
		$this->position = $position;
		return $this;
	}

}
