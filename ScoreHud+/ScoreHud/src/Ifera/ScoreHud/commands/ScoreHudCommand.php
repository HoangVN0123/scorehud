<?php
declare(strict_types = 1);

/**
 *     _____                    _   _           _
 *    /  ___|                  | | | |         | |
 *    \ `--.  ___ ___  _ __ ___| |_| |_   _  __| |
 *     `--. \/ __/ _ \| '__/ _ \  _  | | | |/ _` |
 *    /\__/ / (_| (_) | | |  __/ | | | |_| | (_| |
 *    \____/ \___\___/|_|  \___\_| |_/\__,_|\__,_|
 *
 * ScoreHud, a Scoreboard plugin for PocketMine-MP
 * Copyright (c) 2020 Ifera  < https://github.com/Ifera >
 *
 * Discord: Ifera#3717
 * Twitter: ifera_tr
 *
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken.
 *
 * ScoreHud is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 * ------------------------------------------------------------------------
 */

namespace Ifera\ScoreHud\commands;

use Ifera\ScoreHud\ScoreHud;
use Ifera\ScoreHud\ScoreHudSettings;
use Ifera\ScoreHud\session\PlayerManager;
use Ifera\ScoreHud\utils\HelperUtils;
use Ifera\ScoreHud\libs\jackmd\scorefactory\ScoreFactory;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;

class ScoreHudCommand extends PluginCommand{

	/** @var ScoreHud */
	private $plugin;

	/**
	 * ScoreHudCommand constructor.
	 *
	 * @param ScoreHud $plugin
	 */
	public function __construct(ScoreHud $plugin){
		parent::__construct("scorehud", $plugin);
		$this->setDescription("§r§fNhững câu lệnh của §eScorehud");
		$this->setUsage("§cHãy sử dụng: §6/scorehud §7<§aon§f|§coff§f|§eabout§f|§dhelp§7>");
		$this->setAliases(["sh"]);
		$this->setPermission("sh.command.sh");

		$this->plugin = $plugin;
	}

	/**
	 * @param CommandSender $sender
	 * @param string        $commandLabel
	 * @param array         $args
	 * @return bool|mixed
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(!$sender instanceof Player){
			$sender->sendMessage(ScoreHudSettings::PREFIX . "§cChỉ có thể dùng trong game.");

			return false;
		}

		if(!isset($args[0])){
			$sender->sendMessage(ScoreHudSettings::PREFIX . "§cHãy sử dụng: §6/scorehud §7<§aon§f|§coff§f|§eabout§f|§dhelp§7>");

			return false;
		}

		switch($args[0]){
			case "about":
				$sender->sendMessage(ScoreHudSettings::PREFIX . "§6Score§eHud §av" . $this->plugin->getDescription()->getVersion() . "§a.Edit by: §eAnhkhoaaa YT");
			break;

			case "on":
				if(HelperUtils::isDisabled($sender)){
					HelperUtils::destroy($sender);
					PlayerManager::getNonNull($sender)->handle();

					$sender->sendMessage(ScoreHudSettings::PREFIX . "§aBảng thông tin đã được bật.");
				}else{
					$sender->sendMessage(ScoreHudSettings::PREFIX . "§aBảng thông tin đã được bật.");
				}
			break;

			case "off":
				if(!HelperUtils::isDisabled($sender)){
					ScoreFactory::removeScore($sender);
					HelperUtils::disable($sender);

					$sender->sendMessage(ScoreHudSettings::PREFIX . "§cBảng thông tin đã được tắt.");
				}else{
					$sender->sendMessage(ScoreHudSettings::PREFIX . "§cBảng thông tin đã được tắt.");
				}
			break;

			case "help":
			default:
				$sender->sendMessage(ScoreHudSettings::PREFIX . "§cHãy sử dụng: §6/scorehud §7<§aon§f|§coff§f|§eabout§f|§dhelp§7>");
			break;
		}

		return false;
	}
}
