<?php

namespace misteboss;

use misteboss\commands\TitleCommand;
use pocketmine\command\Command;
use pocketmine\network\mcpe\protocol\SetTitlePacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Title extends PluginBase{

	const TITLE_PREFIX = TextFormat::BOLD . TextFormat:: GOLD . "TITLE " TextFormat::YELLOW . "» " . TextFormat::RESET . TextFormat::GRAY;

	public function onEnable(){
		$this->getLogger()->info(TextFormat::GREEN . "Title plugin, by @Misteboss_mcpe, has been activated !");
		$this->getServer()->getCommandMap()->register("title", new TitleCommand($this, "title"));
	}

	public function titleText(Player $player, string $title, string $subtitle = "", int $fadeIn = -1, int $stay = -1, int $fadeOut = -1){
		$this->titleReset($player);
		$this->titleDuration($player, $fadeIn, $stay, $fadeOut);

		$this->titleType($player, $title, SetTitlePacket::TYPE_SET_TITLE);
		$this->titleType($player, $subtitle, SetTitlePacket::TYPE_SET_SUBTITLE);
	}
	
	public function titleReset(Player $player){
		$pk = new SetTitlePacket();
		$pk->type = SetTitlePacket::TYPE_RESET_TITLE;
		$player->dataPacket($pk);
	}
	
	public function titleDuration(Player $player, int $fadeIn, int $stay, int $fadeOut){
		if($fadeIn >= 0 and $stay >= 0 and $fadeOut >= 0){
			$pk = new SetTitlePacket();
			$pk->type = SetTitlePacket::TYPE_SET_ANIMATION_TIMES;
			$pk->fadeInTime = $fadeIn;
			$pk->stayTime = $stay;
			$pk->fadeOutTime = $fadeOut;
			$player->dataPacket($pk);
		}
	}

	public function titleType(Player $player, string $title, int $type){
		$pk = new SetTitlePacket();
		$pk->type = $type;
		$pk->text = $title;
		$player->dataPacket($pk);
	}

	public function actionBar(Player $player, string $message){
		$this->titleType($player, $message, SetTitlePacket::TYPE_SET_ACTIONBAR_MESSAGE);
	}
}
