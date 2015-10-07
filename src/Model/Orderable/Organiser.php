<?php

namespace Lexinek\Doctrine\Behaviors\Model\Orderable;

use Nette;
use Kdyby\Doctrine\EntityManager;

/**
 *  @author Jan Mikes <j.mikes@me.com>
 *  @copyright Jan Mikes - janmikes.cz
 */
final class Organiser extends Nette\Object
{
	/** @var Kdyby\Doctrine\EntityManager */
	private $em;


	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}


	public function update($entityClass, array $items)
	{
		$position = 1;
		foreach ($items as $id) {
			$entity = $this->em->find($entityClass, $id);
			$entity->position = $position * 10;
			$this->em->persist($entity);
			$position++;
		}

		$this->em->flush();
	}
}
