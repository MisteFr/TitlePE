<?php

namespace misteboss\commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use misteboss\Title;
use pocketmine\utils\TextFormat as TF;
use pocketmine\Player;

class TitleCommand extends PluginCommand {

private $pg;

public function __construct(Title $main, $name) {
parent::__construct($name, $main);
$this->pg = $main;
$this->setPermission("title.command");
}

public function execute(CommandSender $sender, $currentAlias, array $args) {
if($this->testPermission($sender)){
if($sender instanceof Player){
if(count($args) < 5){
$sender->sendMessage(Title::prefix."§7Usage : /title <player / all> <title> <subtitle> <fadeIn (20 = 1sec)> <duration (20 = 1sec)> <fadeOut (20 = 1sec)>");
}else{
if($args[0] == 'all'){
foreach($this->pg->getServer()->getOnlinePlayers() as $players){
$this->pg->addTitle($players, $args[1], $args[2], $args[3], $args[4], $args[5]);
}
$sender->sendMessage(Title::prefix.' §aCorrectly send ' .$args[1]. ' ' .$args[2]. ' as title to all online players (fadeIn : '.$args[3]. ') (duration : '.$args[4]. ') (fadeOut : ' .$args[5]. ')');
}else{
$player = $sender->getServer()->getPlayerExact($args[0]);
$this->pg->addTitle($player, $args[1], $args[2], $args[3], $args[4], $args[5]);
$sender->sendMessage(Title::prefix.' §aCorrectly send ' .$args[1]. ' ' .$args[2]. ' as title to '.$player->getName().'(fadeIn : '.$args[3]. ') (duration : '.$args[4]. ') (fadeOut : ' .$args[5]. ')');
}
}
}else{
$sender->sendMessage(Title::prefix."§cYou must run this command in game!");
}
}
}
}

