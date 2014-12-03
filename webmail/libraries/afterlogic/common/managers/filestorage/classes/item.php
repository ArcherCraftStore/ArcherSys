<?php

/*
 * Copyright (C) 2002-2013 AfterLogic Corp. (www.afterlogic.com)
 * Distributed under the terms of the license described in LICENSE
 *
 */

/**
 * @property string $Id
 * @property int $Type
 * @property string $Path
 * @property string $Name
 * @property int $Size
 * @property bool $IsFolder
 * @property bool $IsLink
 * @property int $LinkType
 * @property string $LinkUrl
 * @property bool $LastModified
 * @property string $ContentType
 * @property bool $Thumb
 * @property string $ThumbnailLink
 * @property string $Hash
 * @property bool $Shared
 * @property string $Owner
 * @property string $Content
 * @property bool $IsExternal
 * 
 * @package FileStorage
 * @subpackage Classes
 */
class CFileStorageItem  extends api_AContainer
{
	public function __construct()
	{
		parent::__construct(get_class($this));

		$this->SetDefaults(array(
			'Id' => '',
			'Type' => EFileStorageType::Personal,
			'Path' => '',
			'Name' => '',
			'Size' => 0,
			'IsFolder' => false,
			'IsLink' => false,
			'LinkType' => EFileStorageLinkType::Unknown,
			'LinkUrl' => '',
			'LastModified' => 0,
			'ContentType' => '',
			'Thumb' => false,
			'ThumbnailLink' => '',
			'Hash' => '',
			'Shared' => false,
			'Owner' => '',
			'Content' => '',
			'IsExternal' => false
		));
	}

	/**
	 * @return array
	 */
	public function GetMap()
	{
		return self::GetStaticMap();
	}

	/**
	 * @return array
	 */
	public static function GetStaticMap()
	{
		return array(
			'Id' => array('string'),
			'Type' => array('string'),
			'Path' => array('string'),
			'Name' => array('string'),
			'Size' => array('int'),
			'IsFolder' => array('bool'),
			'IsLink' => array('bool'),
			'LinkType' => array('int'),
			'LinkUrl' => array('string'),
			'LastModified' => array('int'),
			'ContentType' => array('string'),
			'Thumb' => array('bool'),
			'ThumbnailLink' => array('string'),
			'Hash' => array('string'),
			'Shared' => array('bool'),
			'Owner' => array('string'),		
			'Content' => array('string'),
			'IsExternal' => array('bool')
		);
	}
}
