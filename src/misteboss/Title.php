<?php

namespace misteboss;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use misteboss\commands\TitleCommand;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\network\mcpe\protocol\SetTitlePacket;

Class Title extends PluginBase implements Listener{

CONST prefix = "§6§lTITLE §e»§r ";

public function onEnable(){
$this->getLogger()->info(self::prefix."§aTitle Plugin has been activated !\n§7Developped by §c@Misteboss_mcpe");
$this->getServer()->getCommandMap()->register("title", new TitleCommand($this, "title"));
}

public function addTitle($player, string $title, string $subtitle = "", int $fadeIn = -1, int $stay = -1, int $fadeOut = -1){
$this->resetTitleSettings($player);
$this->setTitleDuration($player, $fadeIn, $stay, $fadeOut);
$this->sendTitleText($player,$title, SetTitlePacket::TYPE_SET_TITLE);
$this->sendTitleText($player, $subtitle, SetTitlePacket::TYPE_SET_SUBTITLE);
}

public function resetTitleSettings(Player $player){
$pk = new SetTitlePacket();
$pk->type = SetTitlePacket::TYPE_RESET_TITLE;
$player->dataPacket($pk);
}

public function setTitleDuration(Player $player, int $fadeIn, int $stay, int $fadeOut){
if($fadeIn >= 0 and $stay >= 0 and $fadeOut >= 0){
$pk = new SetTitlePacket();
$pk->type = SetTitlePacket::TYPE_SET_ANIMATION_TIMES;
$pk->fadeInTime = $fadeIn;
$pk->stayTime = $stay;
$pk->fadeOutTime = $fadeOut;
$player->dataPacket($pk);
}
}
  
public function sendTitleText(Player $player,string $title, int $type){
$pk = new SetTitlePacket();
$pk->type = $type;
$pk->text = $title;
$player->dataPacket($pk);
}
  
public function actionBar(Player $player, string $message){
$this->sendTitleText($player, $message, SetTitlePacket::TYPE_SET_ACTIONBAR_MESSAGE);
}
  
}
