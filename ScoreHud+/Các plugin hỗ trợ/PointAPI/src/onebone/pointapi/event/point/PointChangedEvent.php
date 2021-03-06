<?php

/*
 * PointS, the massive point plugin with many features for PocketMine-MP
 * Copyright (C) 2013-2017  onebone <jyc00410@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace onebone\pointapi\event\point;

use onebone\pointapi\PointAPI;
use onebone\pointapi\event\PointAPIEvent;

class PointChangedEvent extends PointAPIEvent{
	private $username, $point;
	public static $handlerList;

	public function __construct(PointAPI $plugin, $username, $point, $issuer){
		parent::__construct($plugin, $issuer);
		$this->username = $username;
		$this->point = $point;
	}

	/**
	 * @return string
	 */
	public function getUsername(){
		return $this->username;
	}

	/**
	 * @return float
	 */
	public function getPoint(){
		$k = $this->point;
		$m = $k;
    	if($m >= 1000){
    	    $xu = $m/1000;
    	    $xu2 = round($xu, 2);
    	    $point = $xu2."K";
    	    return $point;
     	}elseif($m >= 1000000){
    	   $xu = $m/1000000;
    	   $xu2 = round($xu, 2);
           $point = $xu2."M";
           return $point;
    	}elseif($m >= 1000000000){
    	    $xu = $m/1000000000;
       	$xu2 = round($xu, 2);
        	$point = $xu2."B";
        	return $point;
    	} else {
    		return $this->point;
    	}
		
	}
}
