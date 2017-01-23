<?php

namespace Enes5519\OyuncuBuyukluk;

use pocketmine\plugin\PluginBase;
use pocketmine\command\{Command, CommandSender};
use pocketmine\entity\Entity;
use pocketmine\{Server, Player};

class OyuncuBuyukluk extends PluginBase{
    
    public $b = array();
    public function onEnable(){
        $this->getLogger()->info("§8» §a사람크기 변경 플러그인 로딩 성공");
        $this->getServer()->getCommandMap()->register("크기", new Komut($this));
    }
    
    public function respawn(PlayerRespawnEvent $e){
        $o = $e->getPlayer();
        if(!empty($this->b[$o->getName()])){
            $buyukluk = $this->b[$o->getName()];
            $o->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, $buyukluk);
        }
    }
}

class Komut extends Command{
    
    private $p;
    public function __construct($plugin){
        $this->p = $plugin;
        parent::__construct("크기", "Boyut ayarlama by Enes5519");
    }
    
    public function execute(CommandSender $g, $label, array $args){
        if($g->hasPermission("enes5519.buyut")){
            if(isset($args[0])){
                if(is_numeric($args[0])){
                    $this->p->b[$g->getName()] = $args[0];
                    $g->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, $args[0]);
                    $g->sendMessage("§8» §a크기가  ".$args[0]." 로 변경되었습니다");
                }elseif($args[0] == "kapat"){
                    if(!empty($this->p->b[$g->getName()])){
                        unset($this->p->b[$g->getName()]);
                        $g->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, 1);
                        $g->sendMessage("§8» §cBoyutun normale donduruldu!");
                    }else{
                        $g->sendMessage("§8» §cBoyut ayarlamamışsın!");
                    }
                }else{
                    $g->sendMessage("§8» §c/크기 kapat veya /크기 <크기>");
                }
            }
        }
    }
}