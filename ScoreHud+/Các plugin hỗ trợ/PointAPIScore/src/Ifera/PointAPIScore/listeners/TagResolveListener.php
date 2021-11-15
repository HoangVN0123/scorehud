<?php
declare(strict_types = 1);

namespace Ifera\PointAPIScore\listeners;

use Ifera\ScoreHud\event\TagsResolveEvent;
use Ifera\PointAPIScore\Main;
use onebone\pointapi\PointAPI;
use pocketmine\event\Listener;
use pocketmine\Player;
use function count;
use function explode;
use function strval;

class TagResolveListener implements Listener{

	/** @var Main */
	private $plugin;

	public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}

	public function getPlayerPoint(Player $player){
		$PointAPI = $this->plugin->getServer()->getPluginManager()->getPlugin("PointAPI");
		if($PointAPI instanceof PointAPI){
        	$m =$PointAPI->mypoint($player); 
        	    $money = $m;
        	if($m >= 1000){
        	    $xu = $m/1000;
        	    $xu2 = round($xu, 2);
        	    $money = $xu2."K";
         	}
           if($m >= 1000000){
        	   $xu = $m/1000000;
        	   $xu2 = round($xu, 2);
               $money = $xu2."M";
        	}
            if($m >= 1000000000){
        	    $xu = $m/1000000000;
           	$xu2 = round($xu, 2);
            	$money = $xu2."B";
        	}
		    
			return $money;
		}else{
			return "Plugin not found";
		}
	}

	public function onTagResolve(TagsResolveEvent $event){
		$tag = $event->getTag();
		$tags = explode('.', $tag->getName(), 2);
		$value = "";

		if($tags[0] !== 'pointapiscore' || count($tags) < 2){
			return;
		}

		switch($tags[1]){
			case "point":
			$value = $this->getPlayerPoint($event->getPlayer());;
			break;
		}

		$tag->setValue(strval($value));
	}

	
}