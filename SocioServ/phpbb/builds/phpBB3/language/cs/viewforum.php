<?php
/** 
*
* viewforum [Česky]
*
* @package language
* @version $Id: viewforum.php,v 1.17 2006/12/01 16:12:15 shs Exp $
* @copyright (c) 2005 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE 
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'ACTIVE_TOPICS'			=> 'Oblíbená',
	'ANNOUNCEMENTS'			=> 'Oznámení',

	'FORUM_PERMISSIONS'		=> 'Oprávnění fóra',
		
	'ICON_ANNOUNCEMENT'		=> 'Oznámení',
	'ICON_STICKY'			=> 'Důležité',
	
	'LOGIN_NOTIFY_FORUM'	=> 'Fórum je pouze pro registrované, prosím přihlašte se.',

	'MARK_TOPICS_READ'		=> 'Označit všechna témata jako přečtená',

	'NEW_POSTS_HOT'			=> 'Nové příspěvky[ Oblíbené ]',
	'NEW_POSTS_LOCKED'		=> 'Nové příspěvky [ Zamknuté ]',
	'NO_NEW_POSTS_HOT'		=> 'Žádné nové příspěvky [ Oblíbené ]',
	'NO_NEW_POSTS_LOCKED'	=> 'Žádné nové příspěvky [ Zamknuté ]',
	'NO_READ_ACCESS'		=> 'Nemáte potřebná oprávnění pro čtení témat v tomto fóru.',

	'POST_FORUM_LOCKED'		=> 'Toto fórum je zamknuto',

	'TOPICS_MARKED'			=> 'Všechna témata ve fóru byla označena jako přečtená',

	'VIEW_FORUM'			=> 'Zobrazit téma',
	'VIEW_FORUM_TOPIC'		=> '1 téma',
	'VIEW_FORUM_TOPICS'		=> '%d témat',
));

?>