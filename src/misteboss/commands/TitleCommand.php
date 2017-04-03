<?php

namespace misteboss\commands;

use misteboss\Title;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class TitleCommand extends PluginCommand{

	public function __construct(Title $main, $name) {
		parent::__construct($name, $main);
		$this->p = $main;
		$this->server = $this->pg->getServer();
		$this->setPermission("title.command");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args) {
		if($this->testPermission($sender)){
			if($sender instanceof Player){
				if(count($args) < 5){
					$sender->sendMessage(
						Title::TITLE_PREFIX . TextFormat::GRAY . "Usage: /title <player/all> <title> <subtitle> <fadeIn (20 = 1sec)> <duration (20 = 1sec)> <fadeOut (20 = 1 sec)>"
					);
				}else{
					if($args[0] == "all"){
						foreach($this->server->getOnlinePlayers() as $players){
							$this->p->titleText($players, $args[1], $args[2], $args[3], $args[4], $args[5]);
						}
						$sender->sendMessage(Title::TITLE_PREFIX . 
							TextFormat::GREEN . "Correctly sended " . $args[1] . " " . $args[2] . " as title to all online players (fadeIn: " . $args[3] . ") (duration: " . $args[4] . ") (fadeOut: " . $args[5] . ") !"
						);
					}else{
						$player = $sender->getServer()->getPlayerExact($args[0]);
						$name = $player->getName();

						$this->p->titleText($player, $args[1], $args[2], $args[3], $args[4], $args[5]);
						$sender->sendMessage(Title::TITLE_PREFIX . 
							TextFormat::GREEN . "Correctly sended " . $args[1] . " " . $args[2] . " as title to " . $name . " (fadeIn: " . $args[3] . ") (duration: " . $args[4] . ") (fadeOut: " . $args[5] . ") !"
						);
					}
				}
			}else{
				$sender->sendMessage(Title::TITLE_PREFIX . TextFormat::RED . "You must run this command in game !");
			}
		}
	}
}
