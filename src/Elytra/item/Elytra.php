<?php

namespace Elytra\item;

use pocketmine\item\Armor;

class Elytra extends Armor
{

	public function __construct(int $meta = 0)
	{
		parent::__construct(self::ELYTRA, $meta, "Elytra");
	}

	public function getMaxDurability() : int
	{
		return 431;
	}

	public function getDefensePoints() : int
	{
		return 0;
	}

}