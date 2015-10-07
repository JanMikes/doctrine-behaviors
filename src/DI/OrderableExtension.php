<?php

namespace Lexinek\DoctrineBehaviors\DI;

use Kdyby;
use Kdyby\Events\DI\EventsExtension;
use Lexinek\DoctrineBehaviors\Model\Orderable\Orderable;
use Lexinek\DoctrineBehaviors\ORM\Orderable\OrderableSubscriber;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;
use Zenify\DoctrineBehaviors\DI\BehaviorExtension;

/**
 *  @author Jan Mikes <j.mikes@me.com>
 *  @copyright Jan Mikes - janmikes.cz
 */
final class OrderableExtension extends BehaviorExtension
{
	/** @var [] */
	protected $default = [
		"isRecursive" => TRUE,
		"trait" => Orderable::class
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$this->validateConfigTypes($config);
		$builder = $this->getContainerBuilder();

	    $this->compiler->parseServices($builder, $this->loadFromFile(__DIR__ . "/orderable.neon"), $this->name);

		$builder->addDefinition($this->prefix("listener"))
			->setClass(OrderableSubscriber::class, [
				"@" . $this->getClassAnalyzer()->getClass(),
				$config["isRecursive"],
				$config["trait"]
			])
			->setAutowired(FALSE)
			->addTag(EventsExtension::TAG_SUBSCRIBER);
	}


	/**
	 * @throws AssertionException
	 */
	private function validateConfigTypes(array $config)
	{
		Validators::assertField($config, "isRecursive", "bool");
		Validators::assertField($config, "trait", "type");
	}

}
