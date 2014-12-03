<?php

/*
 * Copyright (C) 2002-2013 AfterLogic Corp. (www.afterlogic.com)
 * Distributed under the terms of the license described in LICENSE
 *
 */

// remove the following line for real use
//exit('remove this line');

require_once dirname(__FILE__).'/../libraries/afterlogic/api.php';

/* Get WebMail Settings */
$oSettings =& \CApi::GetSettings();

$sDbPrefix = $oSettings->GetConf('Common/DBPrefix');
/* Database */
$oPdo = \CApi::GetPDO();

$sCalendarSharesTableName = $sDbPrefix . \afterlogic\DAV\Constants::T_CALENDARSHARES;

$stmt1 = $oPdo->prepare("SELECT * FROM " . $sDbPrefix . "adav_delegates");
$stmt1->execute();

while($aRow1 = $stmt1->fetch(\PDO::FETCH_ASSOC)) 
{ 
	$stmt2 = $oPdo->prepare("SELECT * FROM " . $sCalendarSharesTableName . " WHERE calendarid = ? and member = ?");
	$stmt2->execute(array($aRow1['calendarid'], $aRow1['principalid']));
	if (count($stmt2->fetchAll()) === 0)
	{
		$stmt3 = $oPdo->prepare("INSERT INTO " . $sCalendarSharesTableName . "(calendarid, member, readonly) VALUES (?, ?, ?)");
		$stmt3->execute(array($aRow1['calendarid'], $aRow1['principalid'], ((int)$aRow1['mode'] === \ECalendarPermission::Read)));
	}
}

