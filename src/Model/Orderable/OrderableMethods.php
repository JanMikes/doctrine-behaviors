<?php

namespace Lexinek\DoctrineBehaviors\Model\Orderable;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Kdyby\Doctrine\EntityManager;

/**
 *  @author Jan Mikes <j.mikes@me.com>
 *  @copyright Jan Mikes - janmikes.cz
 */
trait OrderableMethods
{
	public function updatePosition(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();
		$em = $args->getEntityManager();

		$entity->setPosition($this->getLastPosition($em) + 10);

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


	private function getLastPosition(EntityManager $em)
	{
		$last = $em->getRepository(get_class($this))->findOneBy([], ["position" => "DESC"]);

		if ($last) {
			return $last->getPosition();
		}

		return 0;
	}
}
