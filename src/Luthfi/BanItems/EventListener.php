<?php

declare(strict_types=1);

namespace Luthfi\BanItems;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerPickupItemEvent;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\player\Player;

class EventListener implements Listener {
    /** @var Main */
    private $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onPlayerInteract(PlayerInteractEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();

        if ($this->isBanned($item)) {
            $event->cancel();
            $message = str_replace("{item}", $item->getName(), $this->plugin->getPluginConfig()->get("messages")["cannot-use-message"]);
            $player->sendMessage($message);
        }
    }

    public function onPlayerItemHeld(PlayerItemHeldEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();

        if ($this->isBanned($item)) {
            $player->getInventory()->remove($item);
            $message = str_replace("{item}", $item->getName(), $this->plugin->getPluginConfig()->get("messages")["ban-message"]);
            $player->sendMessage($message);
        }
    }

    public function onPlayerPickupItem(PlayerPickupItemEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem()->getItem();

        if ($this->isBanned($item)) {
            $event->cancel();
            $message = str_replace("{item}", $item->getName(), $this->plugin->getPluginConfig()->get("messages")["ban-message"]);
            $player->sendMessage($message);
        }
    }

    private function isBanned(Item $item): bool {
        return in_array($item->getName(), $this->plugin->getPluginConfig()->get("banned-items"), true);
    }
}
