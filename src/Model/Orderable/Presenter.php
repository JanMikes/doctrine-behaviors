<?php

namespace Lexinek\DoctrineBehaviors\Model\Orderable;

/**
 *  @author Jan Mikes <j.mikes@me.com>
 *  @copyright Jan Mikes - janmikes.cz
 */
trait Presenter
{
	/** @var Lexinek\DoctrineBehaviors\Model\Orderable */
	private $orderableOrganiser;


	public function injectOrderableOrganiser(Organiser $organiser)
	{
		$this->orderableOrganiser = $organiser;
	}


	private function updateOrderablePositions($entityClass, array $positions)
	{
		if ($this->isAjax() && $this->request->isMethod("POST")) {
			$this->organiser->update($entityClass, $positions);
		}

		$this->terminate();
	}
}
