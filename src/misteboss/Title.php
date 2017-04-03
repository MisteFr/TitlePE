<?php

namespace misteboss;

use misteboss\commands\TitleCommand;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

Class Title extends PluginBase implements Listener
{

    CONST prefix = TextFormat::GOLD . TextFormat::BOLD . "TITLE" . TextFormat::YELLOW . " »" . TextFormat::RESET;
    CONST author = "Misteboss MCPE";

    public function onEnable()
    {
        $this->getLogger()->info(self::prefix . "§aTitle Plugin has been activated !\n§7Developped by §c@" . self::author);
        $this->RegisterListener();
    }

    /*
     * Register All Event in Private Function . Why? I don't know <3
     */
    private function RegisterListener()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register("titleplus", new TitleCommand($this, "titleplus"));
    }
}

