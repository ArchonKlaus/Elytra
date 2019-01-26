<?php

namespace Elytra;

use pocketmine\plugin\PluginBase;
use pocketmine\entity\Entity;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\server\DataPacketReceiveEvent;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;

use pocketmine\network\mcpe\protocol\PlayerActionPacket;

use Elytra\item\Elytra;

class Main extends PluginBase implements Listener {

    public function onEnable(){
    	ItemFactory::registerItem(new Elytra());
    	Item::addCreativeItem(new Elytra());

    	$this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onMove(PlayerMoveEvent $event){
    	$player = $event->getPlayer();

    	if($this->isGliding($player)) $player->resetFallDistance();
    }

    public function onPacketReceive(DataPacketReceiveEvent $event){
    	$pk = $event->getPacket();
    	if($pk instanceof PlayerActionPacket){

    		switch ($pk->action) {

    			case PlayerActionPacket::ACTION_START_GLIDE:
    				$this->setGliding($event->getPlayer(), true);
    				return true;

    			case PlayerActionPacket::ACTION_STOP_GLIDE :
    				$this->setGliding($event->getPlayer(), false);
    				return true;

    		}

    	}
    }

    public function isGliding($player){
    	return $player->getGenericFlag(Entity::DATA_FLAG_GLIDING);
    }

    public function setGliding($player, $value){
    	$player->setGenericFlag(Entity::DATA_FLAG_GLIDING, $value);
    }

}