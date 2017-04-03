<?php

namespace misteboss\commands;

use misteboss\API\API;
use misteboss\Title;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class TitleCommand extends Command implements PluginIdentifiableCommand
{

    public $usage = "/titleplus <player / @all> <title> <subtitle> <fadeIn (20 = 1sec)> <duration (20 = 1sec)> <fadeOut (20 = 1sec)>";
    private $main;
    private $name;

    public function __construct(Title $main, $name)
    {
        parent::__construct($name, $main);
        $this->plugin = $main;
        $this->setPermission("titleplus.cmd");
        $this->setDescription("Send Title with command !");
        $this->setUsage($this->usage);
    }

    public function getPlugin()
    {
        return $this->plugin;
    }

    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if (!$this->plugin->isEnabled()) return false;
        if ($sender instanceof Player) {
            if (count($args) < 2) {
                $sender->sendMessage(Title::prefix . TF::GRAY . "Usage : " . $this->usage);
            } else {
                if (!isset($args[2])) $args[2] = "";
                if (!isset($args[3]) or !is_numeric($args[3])) $args[3] = 20;
                if (!isset($args[4]) or !is_numeric($args[4])) $args[4] = 20;
                if (!isset($args[5]) or !is_numeric($args[5])) $args[5] = 20;
                if (strtolower($args[0]) == "@all" or strtolower($args[0]) == "@a") {
                    foreach ($this->plugin->getServer()->getOnlinePlayers() as $players) {
                        API::addTitle($players, $args[1], $args[2], $args[3], $args[4], $args[5]);
                    }
                    $sender->sendMessage(Title::prefix . TF::GREEN . ' Correctly send " ' . $args[1] . ' " " ' . $args[2] . ' " as title to all online players (fadeIn : ' . $args[3] . ') (duration : ' . $args[4] . ') (fadeOut : ' . $args[5] . ')');
                } else {
                    if (!$this->plugin->getServer()->getPlayer($args[0]) instanceof Player) {
                        $sender->sendMessage(TF::DARK_RED . $args[0] . " is not online !");
                        return;
                    }
                    $player = $sender->getServer()->getPlayerExact($args[0]);
                    API::addTitle($player, $args[1], $args[2], $args[3], $args[4], $args[5]);
                    $sender->sendMessage(Title::prefix . TF::GREEN . ' Correctly send " ' . $args[1] . ' " " ' . $args[2] . ' " as title to ' . $player->getName() . '(fadeIn : ' . $args[3] . ') (duration : ' . $args[4] . ') (fadeOut : ' . $args[5] . ')');
                }
            }
        } else {
            $sender->sendMessage(Title::prefix . TF::RED . "You must run this command in game!");
        }
    }
}
