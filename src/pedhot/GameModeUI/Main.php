<?php

namespace pedhot\GameModeUI;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\{Player, Server};
use pocketmine\command\{Command, CommandSender};
use jojoe77777\FormAPI\SimpleForm;

class Main extends PluginBase implements Listener{
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("[GameModeUI] By Pedhot Enabled");
		
		$this->saveResource("config.yml");
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
	}
	
	public function onDisable(){
		$this->getLogger()->info("[GameModeUI] By Pedhot Disabled");
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){                    
            case "gamemodeui":
                if($sender instanceof Player){
                    if($sender->hasPermission("pocketmine.command.gamemode")){
                        $this->GameModeUI($sender);
                        return true;
                    }else{
						$sender->sendMessage("§cDont Have Permissions");
					}

                }else{
                    $sender->sendMessage("§cUse Command in Game!");
                    return true;
                }
        }
    }
	
	public function GameModeUI(Player $sender){
		$form = new SimpleForm(function (Player $sender, $data){
			$result = $data;
			if($result === null){
				return true;
			}
			switch($result){
				case 0:
				$sender->addTitle($this->config->getNested("exit.title"), $this->config->getNested("exit.subtitle"));
				$sender->sendMessage($this->config->getNested("exit.message"));
				break;
				case 1:
				$sender->setGamemode(0);
				$sender->addTitle($this->config->getNested("survival.title"), $this->config->getNested("survival.subtitle"));
				$sender->sendMessage($this->config->getNested("survival.message"));
				break;
				case 2:
				$sender->setGamemode(1);
				$sender->addTitle($this->config->getNested("creative.title"), $this->config->getNested("creative.subtitle"));
				$sender->sendMessage($this->config->getNested("creative.message"));
				break;
				case 3:
				$sender->setGamemode(3);
				$sender->addTitle($this->config->getNested("spectator.title"), $this->config->getNested("spectator.subtitle"));
				$sender->sendMessage($this->config->getNested("spectator.message"));
				break;
				case 4:
				$sender->setGamemode(2);
				$sender->addTitle($this->config->getNested("adventure.title"), $this->config->getNested("adventure.subtitle"));
				$sender->sendMessage($this->config->getNested("adventure.message"));
				break;
			}
		});
		$form->setTitle($this->config->getNested("gamemodeui.title-form"));
		$form->setContent($this->config->getNested("gamemodeui.content"));
		$form->addButton($this->config->getNested("exit.button.name"), $this->config->getNested("exit.button.image-type"), $this->config->getNested("exit.button.image-url"));
		$form->addButton($this->config->getNested("survival.button.name"), $this->config->getNested("survival.button.image-type"), $this->config->getNested("survival.button.image-url"));
		$form->addButton($this->config->getNested("creative.button.name"), $this->config->getNested("creative.button.image-type"), $this->config->getNested("creative.button.image-url"));
		$form->addButton($this->config->getNested("spectator.button.name"), $this->config->getNested("spectator.button.image-type"), $this->config->getNested("spectator.button.image-url"));
		$form->addButton($this->config->getNested("adventure.button.name"), $this->config->getNested("adventure.button.image-type"), $this->config->getNested("adventure.button.image-url"));
		$form->sendToPlayer($sender);
	}
	
}