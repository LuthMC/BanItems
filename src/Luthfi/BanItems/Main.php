<?php

declare(strict_types=1);

namespace Luthfi\BanItems;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {
    /** @var Config */
    private $config;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    public function getPluginConfig(): Config {
        return $this->config;
    }
}
