<?php

namespace misteboss\API;

use pocketmine\network\mcpe\protocol\SetTitlePacket;
use pocketmine\Player;

/*
 * => Plugin API <=
 * API + Documentation
 */

Class API
{

    /**
     * @param $player
     * @param string $title
     * @param string $subtitle
     * @param int $fadeIn
     * @param int $stay
     * @param int $fadeOut
     */
     
    public static function addTitle(Player $player, string $title, string $subtitle = "", int $fadeIn = -1, int $stay = -1, int $fadeOut = -1)
    {
        API::resetTitleSettings($player);
        API::setTitleDuration($player, $fadeIn, $stay, $fadeOut);
        API::sendTitleText($player, $subtitle, SetTitlePacket::TYPE_SET_SUBTITLE);
        API::sendTitleText($player, $title, SetTitlePacket::TYPE_SET_TITLE);
    }

    /**
     * @param Player $player
     */
    public static function resetTitleSettings(Player $player)
    {
        $pk = new SetTitlePacket();
        $pk->type = SetTitlePacket::TYPE_RESET_TITLE;
        $player->dataPacket($pk);
    }

    /**
     * @param Player $player
     * @param int $fadeIn
     * @param int $stay
     * @param int $fadeOut
     */
    public static function setTitleDuration(Player $player, int $fadeIn, int $stay, int $fadeOut)
    {
        if ($fadeIn >= 0 and $stay >= 0 and $fadeOut >= 0) {
            $pk = new SetTitlePacket();
            $pk->type = SetTitlePacket::TYPE_SET_ANIMATION_TIMES;
            $pk->fadeInTime = $fadeIn;
            $pk->stayTime = $stay;
            $pk->fadeOutTime = $fadeOut;
            $player->dataPacket($pk);
        }
    }

    /**
     * @param Player $player
     * @param string $title
     * @param int $type
     */
    public static function sendTitleText(Player $player, string $title, int $type)
    {
        $pk = new SetTitlePacket();
        $pk->type = $type;
        $pk->text = $title;
        $player->dataPacket($pk);
    }

    /**
     * @param Player $player
     * @param string $message
     */
    public static function actionBar(Player $player, string $message)
    {
        API::sendTitleText($player, $message, SetTitlePacket::TYPE_SET_ACTIONBAR_MESSAGE);
    }
}
