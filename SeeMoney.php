<?php

/**
 * @name SeeMoney
 * @author Yulla1234
 * @main Yulla1234\SeeMoney
 * @version 1.0.0
 * @api  [4.0.0, 3.9.0]
 */
 
namespace Yulla1234;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;

use onebone\economyapi\EconomyAPI;
use onebone\economyapi\event\money\AddMoneyEvent;
use onebone\economyapi\event\money\ReduceMoneyEvent;
use onebone\economyapi\event\money\SetMoneyEvent;

class SeeMoney extends PluginBase implements Listener {
    
    private $plugin = [ "PRE-FIX" => "§l§c[§fSeeMoney§c] §r", "CALL-OP" => false ];
    
    public function onEnable () {
        Server::getInstance()->getPluginManager()->registerEvents($this, $this);
    }
    
    public function onAddMoney (AddMoneyEvent $e) {
        $name = $e->getUserName();
        $player = Server::getInstance()->getPlayer ($name);
        if ($player instanceof Player) {
            $amount = $e->getAmount();
            $before = EconomyAPI::getInstance()->myMoney ($player);
            $after = $before + $amount;
            Server::getInstance()->getLogger()->info ($this->plugin ["PRE-FIX"] . "§c" . $name . "§r 님의 돈이 증가하였습니다. §l§c[§f" . $before . " -> " . $after . "§c]");
            if ($this->plugin ["CALL-OP"] !== false) {
                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                    if ($players->isOp()) {
                        $players->sendMessage ($this->plugin ["PRE-FIX"] . "§c" . $name . "§r 님의 돈이 증가하였습니다. §l§c[§f" . $before . " -> " . $after . "§c]");
                    }
                }
            }
        }
    }
    
    public function onReduceMoney (ReduceMoneyEvent $e) {
        $name = $e->getUserName();
        $player = Server::getInstance()->getPlayer ($name);
        if ($player instanceof Player) {
            $amount = $e->getAmount();
            $before = EconomyAPI::getInstance()->myMoney ($player);
            $after = $before - $amount;
            Server::getInstance()->getLogger()->info ($this->plugin ["PRE-FIX"] . "§c" . $name . "§r 님의 돈이 하락하였습니다. §l§c[§f" . $before . " -> " . $after . "§c]");
            if ($this->plugin ["CALL-OP"] !== false) {
                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                    if ($players->isOp()) {
                        $players->sendMessage ($this->plugin ["PRE-FIX"] . "§c" . $name . "§r 님의 돈이 하락하였습니다. §l§c[§f" . $before . " -> " . $after . "§c]");
                    }
                }
            }
        }
    }
    
    public function onSetMoney (SetMoneyEvent $e) {
        $name = $e->getUserName();
        $player = Server::getInstance()->getPlayer ($name);
        if ($player instanceof Player) {
            $before = EconomyAPI::getInstance()->myMoney ($player);
            $after = $e->getMoney();
            Server::getInstance()->getLogger()->info ($this->plugin ["PRE-FIX"] . "§c" . $name . "§r 님의 돈이 설정되었습니다. §l§c[§f" . $before . " -> " . $after . "§c]");
            if ($this->plugin ["CALL-OP"] !== false) {
                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                    if ($players->isOp()) {
                        $players->sendMessage ($this->plugin ["PRE-FIX"] . "§c" . $name . "§r 님의 돈이 설정되었습니다. §l§c[§f" . $before . " -> " . $after . "§c]");
                    }
                }
            }
        }
    }
}