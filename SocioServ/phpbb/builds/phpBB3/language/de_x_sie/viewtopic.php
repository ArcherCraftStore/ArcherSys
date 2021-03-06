<?php
/**
*
* viewtopic [Deutsch — Sie]
*
* @package language
* @version $Id: viewtopic.php 279 2007-07-29 16:05:27Z philipp $
* @copyright (c) 2005 phpBB Group; 2006 phpBB.de
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Deutsche Übersetzung durch die Übersetzer-Gruppe von phpBB.de:
* (http://www.phpbb.de/team.php#group_13086)
* Frank Doerr, Dirk Gaffke, Christopher Gerharz, Ingo Köhler, Philipp Kordowich, Ingo Migliarina, Paul Rauch
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
	'ATTACHMENT'						=> 'Dateianhang',
	'ATTACHMENT_FUNCTIONALITY_DISABLED'	=> 'Die Funktion für Dateianhänge wurde deaktiviert.',

	'BOOKMARK_ADDED'		=> 'Lesezeichen für das Thema erfolgreich gesetzt.',
	'BOOKMARK_REMOVED'		=> 'Lesezeichen für das Thema erfolgreich entfernt.',
	'BOOKMARK_TOPIC'		=> 'Lesezeichen setzen',
	'BOOKMARK_TOPIC_REMOVE'	=> 'Lesezeichen entfernen',
	'BUMPED_BY'				=> 'Zuletzt als neu markiert von %1$s am %2$s.',
	'BUMP_TOPIC'			=> 'Thema als neu markieren',

	'CODE'					=> 'Code',

	'DELETE_TOPIC'			=> 'Thema löschen',
	'DOWNLOAD_NOTICE'		=> 'Sie haben keine ausreichende Berechtigung, um die Dateianhänge dieses Beitrags anzusehen.',

	'EDITED_TIMES_TOTAL'	=> 'Zuletzt geändert von %1$s am %2$s, insgesamt %3$d-mal geändert.',
	'EDITED_TIME_TOTAL'		=> 'Zuletzt geändert von %1$s am %2$s, insgesamt %3$d-mal geändert.',
	'EMAIL_TOPIC'			=> 'Thema weiterempfehlen',
	'ERROR_NO_ATTACHMENT'	=> 'Der ausgewählte Dateianhang existiert nicht mehr.',

	'FILE_NOT_FOUND_404'	=> 'Die Datei <strong>%s</strong> existiert nicht.',
	'FORK_TOPIC'			=> 'Thema duplizieren',

	'LINKAGE_FORBIDDEN'		=> 'Sie sind nicht berechtigt, diese Seite anzusehen, von ihr herunterzuladen oder auf sie zu linken.',
	'LOGIN_NOTIFY_TOPIC'	=> 'Sie wurden über einen neuen Beitrag in diesem Thema informiert. Bitte melden Sie sich an, um es anzusehen.',
	'LOGIN_VIEWTOPIC'		=> 'Sie müssen registriert und angemeldet sein, um dieses Thema anzusehen.',

	'MAKE_ANNOUNCE'				=> 'In Bekanntmachung ändern',
	'MAKE_GLOBAL'				=> 'In globale Bekanntmachung ändern',
	'MAKE_NORMAL'				=> 'In Standard-Thema ändern',
	'MAKE_STICKY'				=> 'In wichtiges Thema ändern',
	'MAX_OPTIONS_SELECT'		=> 'Sie können bis zu <strong>%d</strong> Optionen auswählen',
	'MAX_OPTION_SELECT'			=> 'Sie können <strong>eine</strong> Option auswählen',
	'MISSING_INLINE_ATTACHMENT'	=> 'Der Dateianhang <strong>%s</strong> existiert nicht mehr.',
	'MOVE_TOPIC'				=> 'Thema verschieben',

	'NO_ATTACHMENT_SELECTED'=> 'Sie haben keinen Dateianhang zur Anzeige oder zum Herunterladen ausgewählt.',
	'NO_NEWER_TOPICS'		=> 'Es gibt keine neueren Themen in diesem Forum.',
	'NO_OLDER_TOPICS'		=> 'Es gibt keine älteren Themen in diesem Forum.',
	'NO_UNREAD_POSTS'		=> 'Es gibt keine neuen ungelesenen Beiträge in diesem Thema.',
	'NO_VOTE_OPTION'		=> 'Sie müssen eine Option auswählen, um abzustimmen.',
	'NO_VOTES'				=> 'Keine Stimmen',

	'POLL_ENDED_AT'			=> 'Umfrage endete am %s',
	'POLL_RUN_TILL'			=> 'Die Umfrage läuft bis %s.',
	'POLL_VOTED_OPTION'		=> 'Sie haben für diese Option gestimmt',
	'PRINT_TOPIC'			=> 'Druckansicht',

	'QUICK_MOD'				=> 'Schnellmoderation',
	'QUOTE'					=> 'Zitat',

	'REPLY_TO_TOPIC'		=> 'Auf das Thema antworten',
	'RETURN_POST'			=> '%sZurück zum Beitrag%s',

	'SUBMIT_VOTE'			=> 'Abstimmen',

	'TOTAL_VOTES'			=> 'Abstimmungen insgesamt',

	'UNLOCK_TOPIC'			=> 'Thema entsperren',

	'VIEW_INFO'				=> 'Beitrags-Details',
	'VIEW_NEXT_TOPIC'		=> 'Nächstes Thema',
	'VIEW_PREVIOUS_TOPIC'	=> 'Vorheriges Thema',
	'VIEW_RESULTS'			=> 'Ergebnis anzeigen',
	'VIEW_TOPIC_POST'		=> '1 Beitrag',
	'VIEW_TOPIC_POSTS'		=> '%d Beiträge',
	'VIEW_UNREAD_POST'		=> 'Erster ungelesener Beitrag',
	'VISIT_WEBSITE'			=> 'Website besuchen',
	'VOTE_SUBMITTED'		=> 'Ihre Abstimmung wurde erfasst.',
));

?>