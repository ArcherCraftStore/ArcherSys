<?php
/** 
*
* groups [Česky]
*
* @package language
* @version $Id: groups.php,v 1.21 2007/03/07 16:55:20 acydburn Exp $
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
	'ALREADY_DEFAULT_GROUP'	=> 'Vybraná skupina je již vaší výchozí skupinou',
	'ALREADY_IN_GROUP'		=> 'Už jste členem této skupiny',
	'ALREADY_IN_GROUP_PENDING'	=> 'Už jste zažádali o členství v této skupině.',

	'CHANGED_DEFAULT_GROUP'	=> 'Výchozí skupina byla úspešně změněna',
	
	'GROUP_AVATAR'			=> 'Avatar skupiny', 
	'GROUP_CHANGE_DEFAULT'	=> 'Jste si jistí, že chcete změnit vaše výchozí členství na skupinu "%s"?',
	'GROUP_CLOSED'			=> 'Zavřená',
	'GROUP_DESC'			=> 'Popis skupiny',
	'GROUP_HIDDEN'			=> 'Skrytá',
	'GROUP_INFORMATION'		=> 'Podrobnosti o skupině',
 	'GROUP_IS_CLOSED'		=> 'Toto je uzavřená skupina, automaticky do ní nemohou vstoupit noví uživatelé.',
	'GROUP_IS_OPEN'			=> 'Toto je oteřená skupina, noví uživatelé mohou žádat o vstup do této skupiny.',
	'GROUP_IS_HIDDEN'		=> 'Toto je skrytá skupina, jen členové mohou vidět další členy této skupiny.',
	'GROUP_IS_FREE'			=> 'Toto je volně otevřená skupina, všichni noví uživatelé jsou vítáni.', 
	'GROUP_IS_SPECIAL'		=> 'Toto je zvláštní skupina, zvláštní skupiny jsou spravovány administrátory fóra.',  
	'GROUP_JOIN'			=> 'Vstoupit do skupiny',
	'GROUP_JOIN_CONFIRM'	=> 'Opravdu chcete vstoupit do této skupiny?',
	'GROUP_JOIN_PENDING'	=> 'Zažádat o vstup do skupiny',
	'GROUP_JOIN_PENDING_CONFIRM'	=> 'Opravdu chcete zažádat o členství v této skupině?',
	'GROUP_JOINED'			=> 'Úspěšně jste vstoupil/a do skupiny',
	'GROUP_JOINED_PENDING'	=> 'Úspěšně jste zažádal/a o členství ve skupině. Vyčkejte na ověření žádosti moderátorem skupiny.',
	'GROUP_LIST'			=> 'Spravovat uživatele',
	'GROUP_MEMBERS'			=> 'Členové skupiny',
	'GROUP_NAME'			=> 'Název skupiny',
	'GROUP_OPEN'			=> 'Otevřená',
	'GROUP_RANK'			=> 'Hodnost skupiny', 
	'GROUP_RESIGN_MEMBERSHIP'		=> 'Vystoupit ze skupiny',
	'GROUP_RESIGN_MEMBERSHIP_CONFIRM'	=> 'Opravdu chcete vystoupit z vybrané skupiny?',
	'GROUP_RESIGN_PENDING'			=> 'Vzít zpět žádost o vstup',
	'GROUP_RESIGN_PENDING_CONFIRM'	=> 'Opravdu chcete zrušit vaši žádost o vstup do této skupiny?',
	'GROUP_RESIGNED_MEMBERSHIP'		=> 'Byli jste úspešně odstraněni z vybrané skupiny',
	'GROUP_RESIGNED_PENDING'		=> 'Vaše žádost byla úspešně stažena',
	'GROUP_TYPE'			=> 'Druh skupiny',
  	'GROUP_UNDISCLOSED'					=> 'Skrytá skupina',
	'FORUM_UNDISCLOSED'					=> 'Moderující skrytá fóra',

	'LOGIN_EXPLAIN_GROUP'	=> 'Musíte se přihlásit pro zobrazení podrobností o skupině',

	'NO_LEADERS'					=> 'Nejste moderátorem žádné skupiny',
	'NOT_LEADER_OF_GROUP'	=> 'K této operaci nemáte dostatečná oprávnění, protože nejste moderátorem této skupiny.',
	'NOT_MEMBER_OF_GROUP'	=> 'K této operaci nemáte dostatečná oprávnění, protože nejste členem této skupiny.',
	'NOT_RESIGN_FROM_DEFAULT_GROUP'	=> 'Nemůžete vystoupit ze své výchozí skupiny.',

	'PRIMARY_GROUP'		=> 'Hlavní skupina',

	'REMOVE_SELECTED'		=> 'Odstranit vybrané',

	'USER_GROUP_CHANGE'			=> 'Z skupiny "%1$s" do "%2$s"',
	'USER_GROUP_DEMOTE'			=> 'Odebrat moderátorství',
	'USER_GROUP_DEMOTE_CONFIRM'	=> 'Opravdu chcete odstoupit jako moderátor skupiny?',
	'USER_GROUP_DEMOTED'		=> 'Vedení skupiny bylo úspešně odebráno.',
));

?>