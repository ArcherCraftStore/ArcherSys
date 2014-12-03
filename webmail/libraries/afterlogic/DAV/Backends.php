<?php

/*
 * Copyright (C) 2002-2013 AfterLogic Corp. (www.afterlogic.com)
 * Distributed under the terms of the license described in LICENSE
 * 
 */

namespace afterlogic\DAV;

class Backends
{
	public static $aBackends = array();

	public static function GetBackend($sName)
	{
		if (!isset(self::$aBackends[$sName]))
		{
			$oBackend = null;
			switch ($sName) {
				case 'auth':
					$oBackend = \afterlogic\DAV\Auth\Backend::getInstance();
					break;
				case 'principal':
					$oBackend = new \afterlogic\DAV\Principal\Backend\PDO();
					break;
				case 'caldav':
					$oBackend = new \afterlogic\DAV\CalDAV\Backend\PDO();
					break;
				case 'carddav':
					$oBackend = new \afterlogic\DAV\CardDAV\Backend\PDO();
					break;
				case 'carddav-owncloud':
					$oBackend = new \afterlogic\DAV\CardDAV\Backend\OwnCloudPDO();
					break;
				case 'lock':
					$oBackend = new \afterlogic\DAV\Locks\Backend\PDO();
					break;
				case 'reminders':
					$oBackend = new \afterlogic\DAV\Reminders\Backend\PDO();
					break;
			}
			if (isset($oBackend))
			{
				self::$aBackends[$sName] = $oBackend;
			}
		}
		return self::$aBackends[$sName];
	}
	
	public static function Auth()
	{
		return self::GetBackend('auth');
	}

	public static function Principal()
	{
		return self::GetBackend('principal');
	}

	public static function Caldav()
	{
		return self::GetBackend('caldav');
	}

	public static function Carddav()
	{
		return self::GetBackend('carddav');
	}

	public static function Lock()
	{
		return self::GetBackend('lock');
	}

	public static function Reminders()
	{
		return self::GetBackend('reminders');
	}	
}