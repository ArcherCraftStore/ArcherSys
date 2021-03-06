<?php
/** 
*
* common [Česky]
*
* @package language
* @version $Id: common.php,v 1.183 2007/04/24 17:19:00 acydburn Exp $
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
//
// Some characters you may want to copy&paste: 
// â€™ Â» â€ś â€ť
//

$lang = array_merge($lang, array(
	'TRANSLATION_INFO'	=> 'Český překlad - <a href="http://www.phpbb.cz/">phpBB.cz</a>',
	'DIRECTION'		=> 'ltr',
	'DATE_FORMAT'	=> '|d M Y|',
	'USER_LANG'			=> 'cs-cz',

	'1_DAY'					=> '1 Den',
	'1_MONTH'				=> '1 Měsíc',
	'1_YEAR'				=> '1 Rok',
	'2_WEEKS'				=> '2 Týdny',
	'3_MONTHS'				=> '3 Měsíce',
	'6_MONTHS'				=> '6 Měsíců',
	'7_DAYS'				=> '7 Dní',

	'ACCOUNT_ALREADY_ACTIVATED'		=> 'Váš účet je již aktivován',
	'ACCOUNT_DEACTIVATED'			=> 'Váš účet byl ručně deaktivován a musí být znovuaktivován administrátorem.',
	'ACCOUNT_NOT_ACTIVATED'			=> 'Váš účet ještě nebyl aktivován',
	'ACP'							=> 'Ovládací panel fóra',
	'ACTIVE'						=> 'aktivní',
	'ACTIVE_ERROR'					=> 'Uvedli jste neaktivní uživatelské jméno, prosíme aktivujte svůj účet, a zkuste znovu. Pokud budete mít stále problémy, zkontaktujte administrátora fóra',
	'ADMINISTRATOR'					=> 'Administrátor',
	'ADMINISTRATORS'				=> 'Administrátoři',
	'AGE'							=> 'Věk',
	'AIM'							=> 'AIM',
	'ALLOWED'						=> 'Povoleno',
	'ALL_FILES'						=> 'Všechny soubory',
	'ALL_FORUMS'					=> 'Všechna fóra',
	'ALL_MESSAGES'					=> 'Všechny zprávy',
	'ALL_POSTS'						=> 'Všechny příspěvky',
	'ALL_TIMES'						=> 'Všechny časy jsou v %1$s %2$s',
	'ALL_TOPICS'					=> 'Všechna temata',
	'AND'							=> 'A',
	'ARE_WATCHING_FORUM'			=> 'Přihlásil jste se k odběru novinek z tohoto fóra.',
	'ARE_WATCHING_TOPIC'			=> 'Odhlásil jste se odběr novinek z tohoto fóra.',
	'ASCENDING'						=> 'Vzestupně',
	'ATTACHMENTS'					=> 'Přílohy',
	'ATTACHED_IMAGE_NOT_IMAGE'		=> 'Pokusili jste se připojit neplatný obrázek.',
	'AUTHOR'						=> 'Autor',
  	'AUTH_NO_PROFILE_CREATED'		=> 'Vytváření uživatelského účtu selhalo',
	'AVATAR_DISALLOWED_EXTENSION'	=> 'Přípona %s není povolena',
	'AVATAR_EMPTY_REMOTE_DATA'		=> 'Avatar nemohl být nahrán na server, zkuste nahrát soubor ručně.',
	'AVATAR_EMPTY_FILEUPLOAD'		=> 'Nahraný avatar je prázdný soubor.',
	'AVATAR_INVALID_FILENAME'		=> '%s je neplatný název souboru',
	'AVATAR_NOT_UPLOADED'			=> 'Avatar nemohl být nahrán.',
	'AVATAR_NO_SIZE'				=> 'Nelze zjistit šířku a/nebo výšku avataru z odkazu, prosíme vložte tyto údaje ručně.',
	'AVATAR_PARTIAL_UPLOAD'			=> 'Soubor byl nahrán na server jen z části',
	'AVATAR_PHP_SIZE_NA'			=> 'Avatar je příliš velký .<br />Nelze zjistit nejvyšší povolenou velikost souboru danou PHP ze souboru php.ini.',
	'AVATAR_PHP_SIZE_OVERRUN'		=> 'Avatar je příliš velký, nejvyšší možná velikost je %d MB.<br />Tato hodnota je nastavena v souboru php.ini a nelze ji ignorovat.',
	'AVATAR_URL_INVALID'			=> 'Uvedená URL je neplatná.',
 	'AVATAR_URL_NOT_FOUND'			=> 'Zvolený soubor nebyl nalezen.',
	'AVATAR_WRONG_FILESIZE'			=> 'Avatar musí mít velikost mezi 0 a %1d %2s.',
	'AVATAR_WRONG_SIZE'				=> 'Avatar musí být nejméně %1$d pixelů široký, %2$d pixelů vysoký a nejvýše %3$d pixelů široký a %4$d pixelů vysoký. Odeslaný avatar je %5$d pixelů široký a %6$d pixelů vysoký.',

  	'BACK_TO_TOP'			=> 'Nahoru',
	'BACK_TO_PREV'			=> 'Zpět na předchozí stránku',
	'BAN_TRIGGERED_BY_EMAIL'=> 'Tento ban byl vydán na vaši e-mailovou adresu.',
	'BAN_TRIGGERED_BY_IP'	=> 'Tento ban byl vydán na vaši IP adresu.',
	'BAN_TRIGGERED_BY_USER'	=> 'Tento ban byl vydán na vaše uživatelské jméno.',
	'BBCODE_GUIDE'			=> 'Průvodce BBCode',
	'BCC'					=> 'Bcc',
	'BIRTHDAYS'				=> 'Narozeniny',
	'BOARD_BAN_PERM'		=> 'Byli jste <b>trvale</b> zabanováni na tomto fóru.<br /><br />Kontaktujte %2$sAdministrátora fóra%3$s pro další informace.',
	'BOARD_BAN_REASON'		=> 'Důvod banu: <b>%s</b>',
	'BOARD_BAN_TIME'		=> 'Byli jste vykázáni z tohoto fóra do <b>%1$s</b>.<br /><br />Kontaktujte %2$sAdministrátora fóra%3$s pro další informace.',
	'BOARD_DISABLE'			=> 'Omlouváme se, ale fórum je nedostupné',
	'BOARD_DISABLED'		=> 'Toto fórum je momentálně vypnuté',
	'BOARD_UNAVAILABLE'		=> 'Omlouváme se, ale fórum je dočasně nedostupné',
	'BROWSING_FORUM_GUEST'	=> 'Uživatelé procházející toto fórum: %1$s a %2$d návštěvník',
	'BROWSING_FORUM_GUESTS'	=> 'Uživatelé procházející toto fórum: %1$s a %2$d návštevníků',
	'BYTES'					=> 'Bytů',

	'CANCEL'				=> 'Zrušit',
	'CHANGE'				=> 'Změnit',
	'CHANGE_FONT_SIZE'		=> 'Změnit velikost textu',
	'CHANGING_PREFERENCES'	=> 'Mění nastavení fóra',
	'CHANGING_PROFILE'		=> 'Mění profil na fóru',
	'CLICK_VIEW_PRIVMSG'	=> 'Klikněte %szde%s pro vstup do Příchozích zpráv',
	'COLLAPSE_VIEW'			=> 'Zmenšit náhled',
	'CLOSE_WINDOW'			=> 'Zavřít okno',
	'COLOUR_SWATCH'			=> 'Vzorník barev',
	'COMMA_SEPARATOR'		=> ', ',	// Used in pagination and secret yet-to-be-release style, use localised comma if appropiate, eg: Ideographic or Arabic
	'CONFIRM'				=> 'Potvrdit',
	'CONFIRM_CODE'			=> 'Ověřovací kód',
	'CONFIRM_CODE_EXPLAIN'	=> 'Vložte kód přesně tak jak ho vidíte na obrázku, je rozdíl mezi velkými/malými písmeny, nula je proškrtnutá šikmou čarou.',
	'CONFIRM_CODE_WRONG'	=> 'Vložený kód není správný.',
	'CONFIRM_OPERATION'		=> 'Opravdu chcete spustit tuto operaci?',
	'CONGRATULATIONS'		=> 'Gratulujeme uživateli',
	'CONNECTION_FAILED'		=> 'Spojení selhalo',
	'CONNECTION_SUCCESS'	=> 'Spojení bylo úspešné',
	'COOKIES_DELETED'		=> 'Všechny cookies z tohoto fóra byla úspešně odstraněna.',
	'CURRENT_TIME'			=> 'Právě je %s',

	'DAY'					=> 'Den',
	'DAYS'					=> 'Dní',
	'DELETE'				=> 'Odstranit',
	'DELETE_ALL'			=> 'Odstranit vše',
	'DELETE_COOKIES'		=> 'Smazat všechna cookies z fóra',
	'DELETE_MARKED'			=> 'Odstranit označené',
	'DELETE_POST'			=> 'Odstranit příspěvek',
	'DELIMITER'				=> 'Oddělovač',
	'DESCENDING'			=> 'Sestupně',
	'DISABLED'				=> 'Zakázáno',
	'DISPLAY'				=> 'Zobrazit',
	'DISPLAY_GUESTS'		=> 'Zobrazit návštěvníky',
	'DISPLAY_MESSAGES'		=> 'Zobrazit zprávy za předchozí',
	'DISPLAY_POSTS'			=> 'Zobrazit příspěvky za předchozí',
	'DISPLAY_TOPICS'		=> 'Zobrazit témata za předchozí',
	'DOWNLOADED'			=> 'Staženo',
	'DOWNLOADING_FILE'		=> 'Stahuje soubor',
	'DOWNLOAD_COUNT'		=> '%d krát',
	'DOWNLOAD_COUNTS'		=> '%d krát',
	'DOWNLOAD_COUNT_NONE'	=> 'Zatím nestaženo',
	'VIEWED_COUNT'			=> 'Zobrazeno %d krát',
	'VIEWED_COUNTS'			=> 'Zobrazeno %d krát',
	'VIEWED_COUNT_NONE'		=> 'Ještě nezobrazeno',
	
	'EDIT_POST'							=> 'Upravit příspěvek',
	'EMAIL'								=> 'E-mail',
	'EMAIL_ADDRESS'						=> 'E-mailová adresa',
	'EMAIL_SMTP_ERROR_RESPONSE'			=> 'Objevily se potíže při odesílání mailu na <strong>řádce %1$s</strong>. Odpověď: %2$s',
	'EMPTY_SUBJECT'						=> 'Musíte uvést předmět při zakládání nového tématu.',
	'EMPTY_MESSAGE_SUBJECT'				=> 'Musíte uvést předmět při psaní nového zprávy.',
	'ENABLED'							=> 'Povoleno',
	'ENCLOSURE'							=> 'Uzavření',
	'ERR_CHANGING_DIRECTORY'			=> 'Nelze změnit adresář',
	'ERR_CONNECTING_SERVER'				=> 'Chyba při připojení k serveru',
	'ERR_UNABLE_TO_LOGIN'				=> 'Nelze se přihlásit. Bylo zadané špatné uživatelské jméno nebo heslo.',
	'ERR_WRONG_PATH_TO_PHPBB'			=> 'Cesta pro phpBB se zdá neplatná.',
	'EXPAND_VIEW'						=> 'Rozšířit náhled',
	'EXTENSION'							=> 'Rozšíření',
	'EXTENSION_DISABLED_AFTER_POSTING'	=> 'Rozšíření <b>%s</b> bylo deaktivováno a dále nemůže být zobrazováno',

	'FAQ'					=> 'FAQ',
	'FAQ_EXPLAIN'			=> 'Často kladené otázky',
	'FILENAME'				=> 'Název souboru',
	'FILESIZE'				=> 'Velikost souboru',
	'FILEDATE'				=> 'Datum souboru',
	'FILE_COMMENT'			=> 'Poznámka',
	'FILE_NOT_FOUND'		=> 'Vybraný soubor nebyl nalezen',
	'FIND_USERNAME'			=> 'Najít uživatele',
	'FOLDER'				=> 'Složka',
	'FORGOT_PASS'			=> 'Zapomněl(a) jsem heslo',
	'FORUM'					=> 'Fórum',
	'FORUMS'				=> 'Fóra',
	'FORUMS_MARKED'			=> 'Všechna fóra byla označena za přečtená',
	'FORUM_CAT'				=> 'Kategorie fóra',
	'FORUM_INDEX'			=> 'Obsah fóra',
	'FORUM_LINK'			=> 'Odkaz na fórum',
	'FORUM_LOCATION'		=> 'Činnost',
	'FORUM_LOCKED'			=> 'Fórum je zamknuté',
	'FORUM_RULES'			=> 'Pravidla fóra',
	'FORUM_RULES_LINK'		=> 'Prosím klikněte pro zobrazení pravidel fóra',
	'FROM'					=> 'od',
	'FSOCK_DISABLED'		=> 'Operace nemohla být dokončena, protože funkce fsock jsou zakázány nebo dotazovaný server nebyl nalezen.',

	'FTP_FSOCK_HOST'				=> 'FTP server',
	'FTP_FSOCK_HOST_EXPLAIN'		=> 'FTP server, kterým se připojujete na vaši stránku',
	'FTP_FSOCK_PASSWORD'			=> 'FTP heslo',
	'FTP_FSOCK_PASSWORD_EXPLAIN'	=> 'Heslo pro uživatelské jméno',
	'FTP_FSOCK_PORT'				=> 'FTP port',
	'FTP_FSOCK_PORT_EXPLAIN'		=> 'Port využívaný k připojení na váš FTP server',
	'FTP_FSOCK_ROOT_PATH'			=> 'Cesta k phpBB',
	'FTP_FSOCK_ROOT_PATH_EXPLAIN'	=> 'Cesta k phpBB z kořenového adresáře',
	'FTP_FSOCK_TIMEOUT'				=> 'Doba vypršení',
	'FTP_FSOCK_TIMEOUT_EXPLAIN'		=> 'Doba, v sekundách, kterou bude systém čekat na odpoveď od FTP serveru',
	'FTP_FSOCK_USERNAME'			=> 'FTP uživatelské jméno',
	'FTP_FSOCK_USERNAME_EXPLAIN'	=> 'Uživatelské jméno k přístupu na FTP server',

	'FTP_HOST'					=> 'FTP Server',
	'FTP_HOST_EXPLAIN'			=> 'FTP Server používaný pro připojení k vašemu fóru',
	'FTP_PASSWORD'				=> 'FTP Heslo',
	'FTP_PASSWORD_EXPLAIN'		=> 'Heslo pro uživatelské jméno k FTP',
	'FTP_PORT'					=> 'FTP Port',
	'FTP_PORT_EXPLAIN'			=> 'Port používaný pro připojení na FTP server',
	'FTP_ROOT_PATH'				=> 'Cesta phpBB',
	'FTP_ROOT_PATH_EXPLAIN'		=> 'Cesta z kořenové složky k vašemu phpBB',
	'FTP_TIMEOUT'				=> 'Čas vypršení',
	'FTP_TIMEOUT_EXPLAIN'		=> 'Čas, v sekundách, po který bude systém čekat na odpověď od serveru',
	'FTP_USERNAME'				=> 'FTP Uživatelské jméno',
	'FTP_USERNAME_EXPLAIN'		=> 'Uživ. jméno pro připojení k FTP Serveru',

	'GENERAL_ERROR'             => 'Všeobecná chyba',
	'GO'						=> 'Přejít',
	'GOTO_PAGE'					=> 'Přejít na stránku',
	'GROUP'						=> 'Skupina',
	'GROUPS'					=> 'Skupiny',
	'GROUP_ERR_TYPE'			=> 'Byl zvolen nesprávný druh skupiny.',
	'GROUP_ERR_USERNAME'		=> 'Nebyl zvolen název skupiny.',
	'GROUP_ERR_USER_LONG'		=> 'Název skupiny je příliš dlouhý.',
	'GUEST'						=> 'Návštěvník',
	'GUEST_USERS_ONLINE'		=> 'Na fóru se nachází %d návštěvníků',
	'GUEST_USERS_TOTAL'			=> '%d návštěvníků',
	'GUEST_USERS_ZERO_ONLINE'	=> 'Na fóru je 0 návštěvníků',
	'GUEST_USERS_ZERO_TOTAL'	=> '0 návštěvníků',
	'GUEST_USER_ONLINE'			=> 'Na fóru se nachází %d návštěvník',
	'GUEST_USER_TOTAL'			=> '%d návštěvník',
	'G_ADMINISTRATORS'			=> 'Administrátoři',
	'G_BOTS'					=> 'Boti',
	'G_GUESTS'					=> 'Návštěvníci',
	'G_REGISTERED'				=> 'Registrovaní uživatelé',
	'G_REGISTERED_COPPA'		=> 'Registrovaní COPPA uživatelé',
	'G_GLOBAL_MODERATORS'		=> 'Globální moderátoři',

	'HIDDEN_USERS_ONLINE'		=> '%d skrytých uživatelů',
	'HIDDEN_USERS_TOTAL'		=> '%d skrytých a ',
	'HIDDEN_USERS_ZERO_ONLINE'	=> '0 skrytých uživatelů',
	'HIDDEN_USERS_ZERO_TOTAL'	=> '0 skrytých a ',
	'HIDDEN_USER_ONLINE'		=> '%d skrytý uživatel',
	'HIDDEN_USER_TOTAL'			=> '%d skrytý a ',
	'HIDE_GUESTS'				=> 'Skrýt návštevníky',
	'HIDE_ME'					=> 'Skrýt můj online stav pro toto přihlášení',
	'HOURS'						=> 'Hodin',
	'HOME'						=> 'Domů',

	'ICQ'						=> 'ICQ',
	'ICQ_STATUS'			=> 'ICQ Stav',
	'IF'					=> 'Jestli',
	'IMAGE'						=> 'Obrázek',
	'IMAGE_FILETYPE_INVALID'	=> 'Koncovka souboru %d pro mimetype %s není podporován.',
	'IMAGE_FILETYPE_MISMATCH'	=> 'Nesedí druh souboru: očekávaná koncovka %1$s, ale byla zadána koncovka %2$s.',
	'IN'					=> 'v',
	'INDEX'					=> 'Obsah',
	'INFORMATION'			=> 'Informace',
	'INTERESTS'				=> 'Zájmy',
	'INVALID_DIGEST_CHALLENGE'	=> 'Neplatný požadavek na zpracování',
	'INVALID_EMAIL_LOG'		=> 'Není <b>%s</b> neplatná e-mailová adresa?',
	'IP'						=> 'IP',
	'IP_BLACKLISTED'			=> 'Vaše IP %1$s byla blokována, protože je obsažena v blacklistu. Pro podrobnosti se koukněte na <a href="%2$s">%2$s</a>.',

	'JABBER'				=> 'Jabber',
	'JOINED'				=> 'Registrován',
	'JUMP_PAGE'				=> 'Napište číslo stránky, na kterou chcete přejít',
	'JUMP_TO'				=> 'Přeskočit na',
	'JUMP_TO_PAGE'			=> 'Klikněte pro přeskočení na stránku...',

	'KB'				=> 'KB',

	'LAST_POST'							=> 'Poslední příspěvek',
	'LAST_UPDATED'						=> 'Naposledy aktualizováno',
	'LAST_VISIT'						=> 'Poslední návštěva',
	'LDAP_NO_LDAP_EXTENSION'			=> 'Rozšíření LDAP není dostupné',
	'LDAP_NO_SERVER_CONNECTION'			=> 'Nelze se připojit na LDAP server',
	'LEGEND'							=> 'Legenda',
	'LOCATION'							=> 'Bydliště',
	'LOCK_POST'							=> 'Zamknout příspěvek',
	'LOCK_POST_EXPLAIN'					=> 'Zabránit úpravám',
	'LOCK_TOPIC'						=> 'Zamknout téma',
	'LOGIN'								=> 'Přihlásit se',
	'LOGIN_CHECK_PM'					=> 'Přihlašte se, pro kontrolu souk. zpráv',
	'LOGIN_CONFIRMATION'				=> 'Potvrzení přihlášení',
	'LOGIN_CONFIRM_EXPLAIN'				=> 'Pro zamezení brute force útokům na účty uživatelů, administrátor vyžaduje zadání ověřovacího kódu, po stanoveném počtu neúspěšných přihlášení. Kód je zobrazen na obrázku níže. Pokud máte zrakovou vadu, nebo jinak nemůžete přečíst kód, kontaktujte %sAdministrátora%s.',
	'LOGIN_ERROR_ATTEMPTS'				=> 'Překročil jste maximální počet pokusů o přihlášení. Nyní musíte kromě uživatelského jména zadat také ověřovací kód, který vidíte na obrázku níže.',
	'LOGIN_ERROR_EXTERNAL_AUTH_APACHE'	=> 'Nebyl jste autorizován apachem.',
	'LOGIN_ERROR_PASSWORD'				=> 'Zadali jste nesprávné heslo. Zkontrolujte vaše heslo a zkuste znovu. Pokud potíže přetrvají, kontakujte administrátora fóra.',
	'LOGIN_ERROR_PASSWORD_CONVERT'		=> 'Nebylo možné převést vaše heslo při přechodu ze starší verze fóra. %sZažádejte prosím o nové%s. Pokud potíže přetrvají, kontaktujte %sAdministrátora fóra%s.',
	'LOGIN_ERROR_USERNAME'				=> 'Zadali jste nesprávné uživatelské jméno. Zkontrolujte vaše uživ. jméno a zkuste znovu. Pokud potíže přetrvají, kontakujte administrátora fóra.',
	'LOGIN_FORUM'						=> 'Pro zobrazení fóra musíte vložit heslo.',
	'LOGIN_INFO'						=> 'Pro přihlášení musíte být registrován. Registrace trvá jen pár vteřin, ale dává vám mnohem větší možnosti. Administrátor fóra též může dávat rozšířené pravomoci registrovaným uživatelům. Před registrací se ujistěte, že jste se obeznámili s našimi podmínkami pro použití a s dalšími pravidly a ujednáními. Také se ujistěte, že si přečtete jakákoliv pravidla, která se na fóru objeví.',
	'LOGIN_VIEWFORUM'					=> 'Administrátor fóra požaduje abyste byli registrováni a přihlášeni k prohlížení fór.',
	'LOGIN_EXPLAIN_EDIT'				=> 'Pro úpravu příspěvků na tomto fóru musíte být registrován a přihlášen.',
	'LOGIN_EXPLAIN_VIEWONLINE'         	=> 'Pro zobrazení výpisu uživatelů online musíte být registrován a přihlášen.',
	'LOGOUT'							=> 'Odhlásit se',
	'LOGOUT_USER'						=> 'Odhlásit [ %s ]',
	'LOG_ME_IN'							=> 'Přihlásit mě automaticky při každé návštěvě',

	'MARK'				=> 'Označit',
	'MARK_ALL'			=> 'Označit vše',
	'MARK_FORUMS_READ'	=> 'Označit všechna fóra jako přečtená',
	'MB'				=> 'MB',
	'MCP'				=> 'Moderátorský panel',
	'MEMBERLIST'		=> 'Členové',
	'MEMBERLIST_EXPLAIN'	=> 'Zobrazit úplný seznam členů',
	'MERGE'					=> 'Sloučit',
	'MERGE_POSTS'			=> 'Sloučit příspěvky',
	'MERGE_TOPIC'		=> 'Sloučit téma',
	'MESSAGE'			=> 'Zpráva',
	'MESSAGES'			=> 'Zprávy',
	'MESSAGE_BODY'		=> 'Tělo zprávy',
	'MINUTES'			=> 'Minut',
	'MODERATE'			=> 'Moderovat',
	'MODERATOR'			=> 'Moderátor',
	'MODERATORS'		=> 'Moderátoři',
	'MONTH'				=> 'Měsíc',
	'MOVE'				=> 'Přesunout',
	'MSNM'				=> 'MSNM/WLM',

	'NA'						=> 'N/A',
	'NEWEST_USER'				=> 'Nejnovějším uživatelem je <b>%s</b>',
	'NEW_MESSAGE'				=> 'Nová zpráva',
	'NEW_MESSAGES'				=> 'Nové zprávy',
	'NEW_PM'					=> '<b>%d</b> nová zpráva',
	'NEW_PMS'					=> '<b>%d</b> nových zpráv',
	'NEW_POST'					=> 'Nový příspěvek',
	'NEW_POSTS'					=> 'Nové příspěvky',
	'NEXT'						=> 'Další',
	'NEXT_STEP'					=> 'Další',
	'NEVER'						=> 'Nikdy',
	'NO'						=> 'Ne',
	'NOT_ALLOWED_MANAGE_GROUP'	=> 'Nemůžete spravovat tuto skupinu z “Ovládacích panelů fóra”.',
	'NOT_AUTHORISED'			=> 'Nejste autorizován pro přístup do této oblasti.',
	'NOT_WATCHING_FORUM'		=> 'Už nejste přihlášen pro odběr novinek z tohoto fóra.',
	'NOT_WATCHING_TOPIC'		=> 'Už nejste přihlášen pro upozornění na zprávy pro toto téma.',
	'NOTIFY_ADMIN'              => 'Informujte prosím administrátora fóra nebo webmastera',
	'NOTIFY_ADMIN_EMAIL'        => 'Informujte prosím administrátora fóra nebo webmastera: <a href="mailto:%1$s">%1$s</a>',
	'NO_ACCESS_ATTACHMENT'		=> 'Nemáte přístup k tomuto souboru.',
	'NO_ACTION'					=> 'Nebyla zvolena žádná akce.',
	'NO_ADMINISTRATORS'			=> 'Toto fórum nemá žádné adminsitrátory.',
	'NO_AUTH_ADMIN'				=> 'Nemáte administrátorské pravomoci, tudíž nemáte přístup k Administraci fóra.',
	'NO_AUTH_ADMIN_USER_DIFFER'	=> 'Nejste schopen se reautorizovat jako jiný uživatel.',
	'NO_AUTH_OPERATION'			=> 'Nemáte dostatečné oprávnění pro dokončení této operace.',
	'NO_CONNECT_TO_SMTP_HOST'	=> 'Nelze se připojit na SMTP server : %s : %s',
	'NO_BIRTHDAYS'				=> 'Dnes nemá nikdo narozeniny',
	'NO_EMAIL_MESSAGE'			=> 'E-mailová zpráva je prázdná',
	'NO_EMAIL_RESPONSE_CODE'	=> 'Nelze obdržet odezvu od serveru',
	'NO_EMAIL_SUBJECT'			=> 'Nebyl zvolen předmět zprávy',
	'NO_FORUM'					=> 'Vybrané fórum neexistuje',
	'NO_FORUMS'					=> 'Tato stránka nemá žádná fóra',
	'NO_GROUP'					=> 'Zvolená skupina neexistuje.',
	'NO_GROUP_MEMBERS'			=> 'Tato skupina nemá členy',
	'NO_IPS_DEFINED'			=> 'Nebyly zvoleny žádné IP ani jména hostitelů',
	'NO_MEMBERS'				=> 'Pro zvolené kriteria nebyl nalezen žádný uživatel',
	'NO_MESSAGES'				=> 'Žádné zprávy',
	'NO_MODE'					=> 'Nebyl zvolen žádný režim.',
	'NO_MODERATORS'				=> 'Toto fórum nemá moderátory.',
	'NO_NEW_MESSAGES'			=> 'Žádné nové zprávy',
	'NO_NEW_PM'					=> '<b>0</b> nových zpráv',
	'NO_NEW_POSTS'				=> 'Žádné nové příspěvky',
	'NO_ONLINE_USERS'			=> 'Žádní registrovaní uživatelé',
	'NO_POSTS'					=> 'Žádné příspěvky',
	'NO_POSTS_TIME_FRAME'		=> 'Pro toto časové obodobí neexistují v tomto tématu žádné příspěvky.',
	'NO_SUBJECT'				=> 'Nebyl zvolen předmět',
	'NO_SUCH_SEARCH_MODULE'		=> 'Zvolený způsob hledání neexistuje',
	'NO_SUPPORTED_AUTH_METHODS'	=> 'Žádné podporované autentifikační metody',  
  	'NO_TOPIC'					=> 'Zvolené téma neexistuje.',
	'NO_TOPICS'					=> 'V tomto fóru nejsou žádná témata nebo příspěvky.',
	'NO_TOPICS_TIME_FRAME'		=> 'Pro toto časové obodobí neexistují v tomto fóru žádná témata.',
	'NO_UNREAD_PM'				=> '<b>0</b> nepřečtených zpráv',
	'NO_UPLOAD_FORM_FOUND'		=> 'Nahrávání se spustilo, ale nebyl nalezen žádný platný způsob pro nahrání souboru.',
	'NO_USER'					=> 'Zvolený uživatel neexistuje.',
	'NO_USERS'					=> 'Zvolení uživatelé neexistují.',
	'NO_USER_SPECIFIED'			=> 'Nebylo zvoleno žádné uživatelské jméno',

	'OCCUPATION'				=> 'Povolání',
	'OFFLINE'					=> 'Offline',
	'ONLINE'					=> 'Online',
	'ONLINE_BUDDIES'			=> 'Přátelé online',
	'ONLINE_USERS_TOTAL'		=> 'Celkem je online <b>%d</b> uživatelů :: ',
	'ONLINE_USERS_ZERO_TOTAL'	=> 'Celkem je online <b>0</b> uživatelů :: ',
	'ONLINE_USER_TOTAL'			=> 'Celkem je online <b>%d</b> uživatel :: ',
	'OPTIONS'					=> 'Možnosti',

	'PAGE_OF'			=> 'Stránka <b>%1$d</b> z <b>%2$d</b>',
	'PASSWORD'			=> 'Heslo',
	'PLAY_QUICKTIME_FILE'	=> 'Přehrát soubor quicktime',
	'PM'				=> 'SZ',
	'POSTING_MESSAGE'	=> 'Píše zprávu v %s',
	'POSTING_PRIVATE_MESSAGE'	=> 'Píše soukromou zprávu',
	'POST'				=> 'Odeslat',
	'POST_ANNOUNCEMENT'	=> 'Oznámení',
	'POST_STICKY'		=> 'Důležité',
	'POSTED'			=> 'Napsal',
	'POSTED_IN_FORUM'	=> 've',
	'POSTED_ON_DATE'	=> 'v',
	'POSTS'				=> 'Příspěvky',
	'POSTS_UNAPPROVED'	=> 'Nejméně jeden příspěvek v tomto tématu nebyl schválen',
	'POST_BY_AUTHOR'	=> 'od',
	'POST_BY_FOE'		=> 'Tento příspěvek napsal <b>%1$s</b>, který je právě ve vašem seznamu ignorovaných. Pro zobrazení příspěvku klikněte %2$szde%3$s.',
	'POST_DAY'			=> '%.2f příspěvků za den',
	'POST_DETAILS'		=> 'Podrobnosti o příspěvku',
	'POST_NEW_TOPIC'	=> 'Odeslat nové téma',
	'POST_REPLY'		=> 'Odeslat odpověď',
	'POST_PCT'			=> '%.2f%% ze všech příspěvků',
	'POST_PCT_ACTIVE'		=> '%.2f%% z uživatelových příspěvků',
	'POST_PCT_ACTIVE_OWN'	=> '%.2f%% z vašich příspěvků',
	'POST_REPORTED'		=> 'Klikněte pro zobrazení oznámení',
	'POST_SUBJECT'		=> 'Předmět příspěvku',
	'POST_TIME'			=> 'Čas odeslání',
	'POST_TOPIC'			=> 'Odeslat nové téma',
	'POST_UNAPPROVED'	=> 'Klikněte pro schválení příspěvku',
	'PREVIEW'			=> 'Náhled',
	'PREVIOUS'			=> 'Předchozí',
	'PREVIOUS_STEP'		=> 'Předchozí',
	'PRIVACY'			=> 'Ochrana soukromí',
	'PRIVATE_MESSAGE'	=> 'Soukromá zpráva',
	'PRIVATE_MESSAGES'	=> 'Soukromé zprávy',
	'PRIVATE_MESSAGING'	=> 'Soukromé zprávy',
	'PROFILE'			=> 'Uživatelský panel',

	'READING_FORUM'				=> 'Čte témata v %s',
	'READING_GLOBAL_ANNOUNCE'	=> 'Čte globální oznámění',
	'READING_LINK'				=> 'Přechází na odkaz na fóru %s',
	'READING_TOPIC'				=> 'Čte téma v %s',
	'READ_PROFILE'				=> 'Profil',
	'REASON'					=> 'Důvod',
	'RECORD_ONLINE_USERS'		=> 'Nejvíce zde současně bylo přítomno <b>%1$s</b> uživatelů dne %2$s',
	'REDIRECT'					=> 'Přesměrovat',
	'REDIRECTS'					=> 'Celkem přesměrování',
	'REGISTER'					=> 'Registrovat',
	'REGISTERED_USERS'			=> 'Registrovaní uživatelé:',
	'REG_USERS_ONLINE'			=> 'Právě je online %d registrovaných uživatelů a ',
	'REG_USERS_TOTAL'			=> '%d registrovaných, ',
	'REG_USERS_ZERO_ONLINE'		=> 'Právě je online 0 registrovaných uživatelů a ',
	'REG_USERS_ZERO_TOTAL'		=> '0 registrovaných, ',
	'REG_USER_ONLINE'			=> 'Právě je online %d registrovaný uživatel a ',
	'REG_USER_TOTAL'			=> '%d registrovaný, ',
	'REMOVE'					=> 'Odstranit',
	'REMOVE_INSTALL'			=> 'Prosím smažte, přesuňte nebo přejmenujte složku install.',
	'REPLIES'					=> 'Odpovědi',
	'REPLY_WITH_QUOTE'			=> 'Odpovědět s citací',
	'REPLYING_GLOBAL_ANNOUNCE'	=> 'Odpovídá na globální oznámení',
	'REPLYING_MESSAGE'			=> 'Odpovídá na zprávu v %s',
	'REPORT_BY'					=> 'Ohlásit',
	'REPORT_POST'				=> 'Ohlásit tento příspěvek',
	'REPORTING_POST'			=> 'Ohlašuje příspěvek',
	'RESEND_ACTIVATION'			=> 'Znovu poslat aktivační e-mail',
	'RESET'						=> 'Reset',
	'RESTORE_PERMISSIONS'		=> 'Obnovit oprávnění',
	'RETURN_INDEX'				=> 'Klikněte %szde%s pro návrat na hlavní stránku',
	'RETURN_FORUM'				=> 'Klikněte %szde%s pro návrat na obsah fóra',
	'RETURN_PAGE'				=> 'Klikněte %szde%s pro návrat na předchozí stránku',
	'RETURN_TOPIC'				=> 'Klikněte %szde%s pro návrat na téma',
	'RETURN_TO'					=> 'Zpět na',
	'RULES_ATTACH_CAN'			=> '<b>Můžete</b> přikládat soubory v tomto fóru',
	'RULES_ATTACH_CANNOT'		=> '<b>Nemůžete</b> přikládat soubory v tomto fóru',
	'RULES_DELETE_CAN'			=> '<b>Můžete</b> mazat své příspěvky v tomto fóru',
	'RULES_DELETE_CANNOT'		=> '<b>Nemůžete</b> mazat své příspěvky v tomto fóru',
	'RULES_DOWNLOAD_CAN'		=> '<b>Můžete</b> stahovat soubory v tomto fóru',
	'RULES_DOWNLOAD_CANNOT'		=> '<b>Nemůžete</b> stahovat soubory v tomto fóru',
	'RULES_EDIT_CAN'			=> '<b>Můžete</b> upravovat své příspěvky v tomto fóru',
	'RULES_EDIT_CANNOT'			=> '<b>Nemůžete</b> upravovat své příspěvky v tomto fóru',
	'RULES_LOCK_CAN'			=> '<b>Můžete</b> zamykat svá témata v tomto fóru',
	'RULES_LOCK_CANNOT'			=> '<b>Nemůžete</b> zamykat svá témata v tomto fóru',
	'RULES_POST_CAN'			=> '<b>Můžete</b> zakládat nová témata v tomto fóru',
	'RULES_POST_CANNOT'			=> '<b>Nemůžete</b> zakládat nová témata v tomto fóru',
	'RULES_REPLY_CAN'			=> '<b>Můžete</b> odpovídat v tomto fóru',
	'RULES_REPLY_CANNOT'		=> '<b>Nemůžete</b> odpovídat v tomto fóru',
	'RULES_VOTE_CAN'			=> '<b>Můžete</b> hlasovat v tomto fóru',
	'RULES_VOTE_CANNOT'			=> '<b>Nemůžete</b> hlasovat v tomto fóru',

	'SEARCH'					=> 'Hledat',
	'SEARCH_MINI'				=> 'Hledej…',
	'SEARCH_ADV'				=> 'Pokročilé hledání',
	'SEARCH_ADV_EXPLAIN'		=> 'Zobrazit možnosti rozšířeného hledání',
	'SEARCH_KEYWORDS'			=> 'Hledat klíčová slova',
	'SEARCHING_FORUMS'			=> 'Prohledává fóra',
	'SEARCH_ACTIVE_TOPICS'		=> 'Zobrazit aktivní témata',
	'SEARCH_FOR'				=> 'Hledat',
	'SEARCH_FORUM'				=> 'Hledat v tomto fóru',	
	'SEARCH_NEW'				=> 'Zobrazit nové příspěvky',
	'SEARCH_POSTS_BY'			=> 'Hledat příspěvky od',
	'SEARCH_SELF'				=> 'Zobrazit vaše příspěvky',
	'SEARCH_TOPIC'				=> 'Hledat v tomto tématu',
	'SEARCH_UNANSWERED'			=> 'Zobrazit nezodpovězené příspěvky',
	'SECONDS'					=> 'Vteřin',
	'SELECT'					=> 'Vybrat',
  	'SELECT_ALL_CODE'			=> 'Vybrat vše',
	'SELECT_DESTINATION_FORUM'	=> 'Vyberte cílové fórum',
	'SELECT_FORUM'				=> 'Vyberte fórum',
	'SEND_EMAIL'				=> 'E-mail',
	'SEND_EMAIL_USER'			=> 'Poslat e-mail uživateli',				// Used as: {L_SEND_EMAIL_USER} {USERNAME} -> E-mail UserX
	'SEND_PRIVATE_MESSAGE'		=> 'Poslat soukromou zprávu',
	'SETTINGS'					=> 'Nastavení',
	'SIGNATURE'					=> 'Podpis',
	'SKIP'						=> 'Přeskočit na obsah',
	'SMTP_NO_AUTH_SUPPORT'		=> 'SMTP server nepodporuje přihlašování',
	'SORRY_AUTH_READ'			=> 'Nejste oprávněn číst toto fórum',
	'SORRY_AUTH_VIEW_ATTACH'	=> 'Nemáte oprávnění pro stažení tohoto souboru',
	'SORT_BY'					=> 'Seřadit podle',
	'SORT_JOINED'				=> 'Datum registrace',
	'SORT_LOCATION'				=> 'Bydliště',
	'SORT_RANK'					=> 'Hodnost',
	'SORT_TOPIC_TITLE'			=> 'Název tématu',
	'SORT_USERNAME'				=> 'Uživatelské jméno',
	'SPLIT_TOPIC'				=> 'Rozdělit téma',
	'SQL_ERROR_OCCURRED'		=> 'Objevila se SQL chyba při generování této stránky, pokud problém přetrvá, kontaktujte administrátora fóra.',
	'STATISTICS'				=> 'Statistiky',
	'START_WATCHING_FORUM'		=> 'Sledovat fórum',
	'START_WATCHING_TOPIC'		=> 'Sledovat toto téma',
	'STOP_WATCHING_FORUM'		=> 'Ukončit sledování tohoto fóra',
	'STOP_WATCHING_TOPIC'		=> 'Ukončit sledování tohoto tématu',
	'SUBFORUM'					=> 'Sub-fórum',
	'SUBFORUMS'					=> 'Sub-fóra',
	'SUBJECT'					=> 'Předmět',
	'SUBMIT'					=> 'Odeslat',

	'TERMS_USE'			=> 'Podmínky pro užívání',
	'TEST_CONNECTION'	=> 'Testovat připojení',
	'THE_TEAM'			=> 'Tým',
	'TIME'				=> 'Čas',

	'TOO_LONG_AIM'					=> 'AIM jméno, které jste zadali, je přiliš dlouhé.',
	'TOO_LONG_CONFIRM_CODE'			=> 'Ověřovací kód, který jste zadali, je přiliš dlouhý.',
	'TOO_LONG_DATEFORMAT'         => 'Zadaný formát data je příliš dlouhý.',
	'TOO_LONG_ICQ'					=> 'ICQ číslo, které jste zadali, je přiliš dlouhé.',
	'TOO_LONG_INTERESTS'			=> 'Zájmy, které jste zadali, jsou přiliš dlouhé.',
	'TOO_LONG_JABBER'				=> 'Jabber účet, který jste zadali, je přiliš dlouhý.',
	'TOO_LONG_LOCATION'				=> 'Bydliště, které jste zadali, je přiliš dlouhé.',
	'TOO_LONG_MSN'					=> 'MSN jméno, které jste zadali, je přiliš dlouhé.',
	'TOO_LONG_NEW_PASSWORD'			=> 'Heslo, které jste zadali, je přiliš dlouhé.',
	'TOO_LONG_OCCUPATION'			=> 'Zaměstnání, které jste zadali, je přiliš dlouhé.',
	'TOO_LONG_PASSWORD_CONFIRM'		=> 'Ověřovací kód, které jste zadali, je přiliš dlouhý.',
	'TOO_LONG_USER_PASSWORD'		=> 'Heslo, které jste zadali, je přiliš dlouhé.',
	'TOO_LONG_USERNAME'				=> 'Uživatelské jméno, které jste zadali, je přiliš dlouhé.',
	'TOO_LONG_EMAIL'				=> 'Zadaná e-mailová adresa je příliš dlouhá.',
	'TOO_LONG_EMAIL_CONFIRM'		=> 'Zadaná e-mailová adresa pro potvrzení je příliš dlouhá.',
	'TOO_LONG_WEBSITE'				=> 'Webová stránka, kterou jste zadali, je příliš dlouhá.',
	'TOO_LONG_YIM'					=> 'Yahoo Messenger, který jste zadali, je příliš dlouhý.',
	
	'TOO_MANY_VOTE_OPTIONS'			=> 'Pokusili jste se hlasovat pro příliš mnoho možností.',
	
	'TOO_SHORT_AIM'					=> 'AIM jméno, které jste zadali, je přiliš krátké.',
	'TOO_SHORT_CONFIRM_CODE'		=> 'Ověřovací kód, který jste zadali, je přiliš krátký.',
	'TOO_SHORT_DATEFORMAT'         => 'Zadaný formát data je příliš krátký.',
	'TOO_SHORT_ICQ'					=> 'ICQ číslo, které jste zadali, je přiliš krátké.',
	'TOO_SHORT_INTERESTS'			=> 'Zájmy, které jste zadali, jsou přiliš krátké.',
	'TOO_SHORT_JABBER'				=> 'Jabber účet, který jste zadali, je přiliš krátký.',
	'TOO_SHORT_LOCATION'			=> 'Bydliště, které jste zadali, je přiliš krátké.',
  	'TOO_SHORT_MSN'					=> 'MSN jméno, které jste zadali, je přiliš krátké.',
	'TOO_SHORT_NEW_PASSWORD'		=> 'Heslo, které jste zadali, je příliš krátké.',
	'TOO_SHORT_OCCUPATION'			=> 'Zaměstnání, které jste zadali, je přiliš krátké.',
	'TOO_SHORT_PASSWORD_CONFIRM'	=> 'Ověřovací heslo, které jste zadali, je příliš krátké.',
	'TOO_SHORT_USER_PASSWORD'		=> 'Heslo, které jste zadali, je příliš krátké.',
	'TOO_SHORT_USERNAME'			=> 'Uživatelské jméno, které jste zadali, je příliš krátké.',
	'TOO_SHORT_EMAIL'				=> 'E-mailová adresa, kterou jste zadali, je příliš krátká.',
	'TOO_SHORT_EMAIL_CONFIRM'		=> 'E-mailová adresa pro ověření, kterou jste zadali, je příliš krátká.',
	'TOO_SHORT_WEBSITE'				=> 'Webová stránka, kterou jste zadali, je příliš krátká.',
	'TOO_SHORT_YIM'					=> 'Yahoo Messenger, který jste zadali, je příliš krátký.',

	'TOPIC'				=> 'Téma',
	'TOPICS'			=> 'Témata',
	'TOPIC_ICON'		=> 'Ikona tématu',
	'TOPIC_LOCKED'		=> 'Toto téma je zamknuté, nemůžete posílat nové příspěvky nebo odpovídat na starší',
	'TOPIC_MOVED'		=> 'Přesunuté téma',
	'TOPIC_REVIEW'		=> 'Přehled tématu',
	'TOPIC_TITLE'		=> 'Název tématu',
	'TOPIC_UNAPPROVED'	=> 'Toto téma nebylo schváleno',
	'TOTAL_ATTACHMENTS'	=> 'Příloha(y)',
	'TOTAL_LOG'			=> '1 záznam',
	'TOTAL_LOGS'		=> '%d záznamů',
	'TOTAL_NO_PM'		=> '0 soukromých zpráv celkem',
	'TOTAL_PM'			=> '1 soukromá zpráva celkem',
	'TOTAL_PMS'			=> '$d soukromých zpráv celkem',
	'TOTAL_POSTS'		=> 'Celkem příspěvků',
	'TOTAL_POSTS_OTHER'	=> 'Celkem příspěvků <b>%d</b>',
	'TOTAL_POSTS_ZERO'	=> 'Celkem příspěvků <b>0</b>',
	'TOPIC_REPORTED'	=> 'Téma bylo nahlášeno',
	'TOTAL_TOPICS_OTHER'=> 'Celkem témat <b>%d</b>',
	'TOTAL_TOPICS_ZERO'	=> 'Celkem témat <b>0</b>',
	'TOTAL_USERS_OTHER'	=> 'Celkem členů <b>%d</b>',
	'TOTAL_USERS_ZERO'	=> 'Celkem členů <b>0</b>',
	'TRACKED_PHP_ERROR'	=> 'Vystopované PHP chyby: %s',
	
	'UNABLE_GET_IMAGE_SIZE'	=> 'Přístup k obrázku není možný, nebo soubor není platný obrázek.',
	'UNABLE_TO_DELIVER_FILE'=> 'Nelze doručit soubor.',
	'UNKNOWN_BROWSER'		=> 'Neznámý prohlížeč',
	'UNMARK_ALL'			=> 'Odznačit vše',
	'UNREAD_MESSAGES'		=> 'Nepřečtené zprávy',
	'UNREAD_PM'				=> '<b>%d</b> neprečtená zpráva',
	'UNREAD_PMS'			=> '<b>%d</b> nepřečtených zpráv',
  'UNWATCHED_FORUMS'         => 'Přestali jste sledovat zvolená fóra.',
  'UNWATCHED_TOPICS'         => 'Přestali jste sledovat zvolená témata.',
  'UNWATCHED_FORUMS_TOPICS'   => 'Přestali jste sledovat zvolené příspěvky.',
	'UPDATE'				=> 'Aktualizovat',
	'UPLOAD_IN_PROGRESS'	=> 'Právě probíhá nahrávání souboru',
	'URL_REDIRECT'			=> 'Pokud váš prohlížeč nepodporuje přesměrování přes meta tagy, klikněte%ssem%s.',
	'USERGROUPS'			=> 'Skupiny',
	'USERNAME'				=> 'Uživatelské jméno',
	'USERNAMES'				=> 'Uživatelská jména',
	'USER_AVATAR'			=> 'Uživatelský avatar',
	'USER_CANNOT_READ'		=> 'Nemůžete číst témata z tohoto fóra',
	'USER_POST'				=> '%d příspěvek',
	'USER_POSTS'			=> '%d příspěvků',
	'USERS'					=> 'Uživatelé',
	'USE_PERMISSIONS'		=> 'Otestovat oprávnění uživatelů',

	'VARIANT_DATE_SEPARATOR'	=> ' / ',	// Used in date format dropdown, eg: "Today, 13:37 / 01 Jan 2007, 13:37" ... to join a relative date with calendar date
	'VIEWED'					=> 'Zobrazeno',
	'VIEWING_FAQ'				=> 'Prohlíží si FAQ',
	'VIEWING_MEMBERS'			=> 'Prohlíží uživatelé',
	'VIEWING_ONLINE'			=> 'Prohlíží Kdo je online',
	'VIEWING_MCP'				=> 'Prohlíží moderátorský ovládací panel',
	'VIEWING_MEMBER_PROFILE'	=> 'Prohlíží si uživatelský profil',
	'VIEWING_PRIVATE_MESSAGES'	=> 'Prohlíží si soukromé zprávy',
	'VIEWING_REGISTER'			=> 'Registruje nový účet',
	'VIEWING_UCP'				=> 'Prohlíží si uživatelský panel',
	'VIEWS'						=> 'Zobrazení',
	'VIEW_BOOKMARKS'			=> 'Zobrazit záložky',
	'VIEW_FORUM_LOGS'			=> 'Zobrazit logy',
	'VIEW_LATEST_POST'			=> 'Zobrazit poslední příspěvek',
	'VIEW_NEWEST_POST'			=> 'Zobrazit nejnovější příspěvek',
	'VIEW_NOTES'				=> 'Prohlédnout si uživatelovy poznámky',
	'VIEW_ONLINE_TIME'			=> 'Tato data jsou založena na uživatelích aktivních za poslední %d minutu',
	'VIEW_ONLINE_TIMES'			=> 'Tato data jsou založena na uživatelích aktivních za posledních %d minut',
	'VIEW_TOPIC'				=> 'Zobrazit téma',
	'VIEW_TOPIC_ANNOUNCEMENT'	=> 'Oznámení: ',
	'VIEW_TOPIC_GLOBAL'			=> 'Globální Oznámení: ',
	'VIEW_TOPIC_LOCKED'			=> 'Zamknuto: ',
	'VIEW_TOPIC_LOGS'			=> 'Zobrazit logy',
	'VIEW_TOPIC_MOVED'			=> 'Přesunuto: ',
	'VIEW_TOPIC_POLL'			=> 'Hlasování: ',
	'VIEW_TOPIC_STICKY'			=> 'Důležité: ',
	'VISIT_WEBSITE'				=> 'Navštívit webovou stránku',

	'WARNINGS'			=> 'Varování',
	'WARN_USER'			=> 'Varovat uživatele',
	'WELCOME_SUBJECT'	=> 'Vítejte na fóru %s',
	'WEBSITE'			=> 'WWW',
	'WHOIS'				=> 'Whois',
	'WHO_IS_ONLINE'		=> 'Kdo je online',
	'WRONG_PASSWORD'	=> 'Vložil(a) jste špatné heslo.',
	'WROTE'             => 'napsal',
	
	'WRONG_DATA_ICQ'			=> 'Vložené číslo není platné ICQ.',
	'WRONG_DATA_JABBER'			=> 'Jméno, které jste zadali není platný jabber účet.',
	'WRONG_DATA_LANG'			=> 'Zvolený jazyk je neplatný.',
	'WRONG_DATA_WEBSITE'		=> 'Webová stránka musí být platná URL. Např. http://www.priklad.cz/.',

	'YEAR'				=> 'Rok',
	'YEAR_MONTH_DAY'    => '(RRRR-MM-DD)',
	'YES'				=> 'Ano',
	'YIM'				=> 'YIM',	
	'YOU_LAST_VISIT'	=> 'Poslední návštěva: %s',
	'YOU_NEW_PM'		=> 'Čeká na váš nová soukromá zpráva ve vašich příchozích zprávách',
	'YOU_NEW_PMS'		=> 'Čekájí na vás nové soukromé zprávy ve vašich příchozích zprávách',
	'YOU_NO_NEW_PM'		=> 'Nemáte žádné nové soukromé zprávy',

	'datetime'			=> array(
		'TODAY'		=> 'Dnes, ',
		'TOMORROW'	=> 'Zítra, ',
		'YESTERDAY'	=> 'Včera, ',

		'Sunday'	=> 'Neděle',
		'Monday'	=> 'Pondělí',
		'Tuesday'	=> 'Úterý',
		'Wednesday'	=> 'Středa',
		'Thursday'	=> 'Čtvrtek',
		'Friday'	=> 'Pátek',
		'Saturday'	=> 'Sobota',

		'Sun'		=> 'Ned',
		'Mon'		=> 'Pon',
		'Tue'		=> 'Úte',
		'Wed'		=> 'Stř',
		'Thu'		=> 'Čtv',
		'Fri'		=> 'Pát',
		'Sat'		=> 'Sob',

		'January'	=> 'Leden',
		'February'	=> 'Únor',
		'March'		=> 'Březen',
		'April'		=> 'Duben',
		'May'		=> 'Květen',
		'June'		=> 'Červen',
		'July'		=> 'Červenec',
		'August'	=> 'Srpen',
		'September' => 'Září',
		'October'	=> 'Říjen',
		'November'	=> 'Listopad',
		'December'	=> 'Prosinec',

		'Jan'		=> 'Led',
		'Feb'		=> 'Úno',
		'Mar'		=> 'Bře',
		'Apr'		=> 'Dub',
		'May_short'	=> 'Kvě',	// Short representation of "May". May_short used because in english the short and long date are the same for May.
		'Jun'		=> 'Čer',
		'Jul'		=> 'Črc',
		'Aug'		=> 'Srp',
		'Sep'		=> 'Zář',
		'Oct'		=> 'Říj',
		'Nov'		=> 'Lis',
		'Dec'		=> 'Pro',
	),

	'tz'				=> array(
		'-12'	=> 'UTC - 12 hodin',
		'-11'	=> 'UTC - 11 hodin',
		'-10'	=> 'UTC - 10 hodin',
		'-9.5'	=> 'UTC - 9:30 hodin',
		'-9'	=> 'UTC - 9 hodin',
		'-8'	=> 'UTC - 8 hodin',
		'-7'	=> 'UTC - 7 hodin',
		'-6'	=> 'UTC - 6 hodin',
		'-5'	=> 'UTC - 5 hodin',
		'-4'	=> 'UTC - 4 hodiny',
		'-3.5'	=> 'UTC - 3:30 hodiny',
		'-3'	=> 'UTC - 3 hodiny',
		'-2'	=> 'UTC - 2 hodiny',
		'-1'	=> 'UTC - 1 hodina',
		'0'		=> 'UTC',
		'1'		=> 'UTC + 1 hodina',
		'2'		=> 'UTC + 2 hodiny',
		'3'		=> 'UTC + 3 hodiny',
		'3.5'	=> 'UTC + 3:30 hodiny',
		'4'		=> 'UTC + 4 hodiny',
		'4.5'	=> 'UTC + 4:30 hodiny',
		'5'		=> 'UTC + 5 hodin',
		'5.5'	=> 'UTC + 5:30 hodin',
		'5.75'	=> 'UTC + 5:45 hodin',
		'6'		=> 'UTC + 6 hodin',
		'6.5'	=> 'UTC + 6:30 hodin',
		'7'		=> 'UTC + 7 hodin',
		'8'		=> 'UTC + 8 hodin',
		'8.75'	=> 'UTC + 8:45 hodin',
		'9'		=> 'UTC + 9 hodin',
		'9.5'	=> 'UTC + 9:30 hodin',
		'10'	=> 'UTC + 10 hodin',
		'10.5'	=> 'UTC + 10:30 hodin',
		'11'	=> 'UTC + 11 hodin',
		'11.5'	=> 'UTC + 11:30 hodin',
		'12'	=> 'UTC + 12 hodin',
		'12.75'	=> 'UTC + 12:45 hodin',
		'13'	=> 'UTC + 13 hodin',
		'14'	=> 'UTC + 14 hodin',
		'dst'	=> '[ Letní čas ]',
	),

	'tz_zones'	=> array(
		'-12'	=> '[UTC - 12, Y] Bakerův ostrov, Západní mezinárodní časová osa',
		'-11'	=> '[UTC - 11, X] Midwayské ostrovy , Samoa ',
		'-10'	=> '[UTC - 10, W] Havaj, Aleutské ostrovy, Cookovy ostrovy',
		'-9.5'	=> '[UTC - 9:30, V*] Marquesasovy ostrovy',
		'-9'	=> '[UTC - 9, V] Aljaška, Gambierův ostrov Time',
		'-8'	=> '[UTC - 8, U] Pacifický standartní čas',
		'-7'	=> '[UTC - 7, T] Západní pobřeží USA, Horská oblast USA',
		'-6'	=> '[UTC - 6, S] Střed USA a Kanady',
		'-5'	=> '[UTC - 5, R] Východní pobřeží USA a Kanady, Bogota, Lima',
		'-4'	=> '[UTC - 4, Q] Atlantský standartní čas, Caracas, La Paz',
		'-3.5'	=> '[UTC - 3:30, P*] Newfoundland',
		'-3'	=> '[UTC - 3, P] Amazonský standartní čas, Grónsko, Brazílie',
		'-2'	=> '[UTC - 2, O] Střední Atlantik Jižní Sandwichovy ostrovy',
		'-1'	=> '[UTC - 1, N] Azory, Kapvery',
		'0'		=> '[UTC, Z] Casablanca, Západní Evropa, Greenwich, Londýn',
		'1'		=> '[UTC + 1, A] Střední Evropa, Amsterdam, Berlín, Řím, Praha',
		'2'		=> '[UTC + 2, B] Východní Evropa, Atény, Bejrút, Bukurešť',
		'3'		=> '[UTC + 3, C] Moskva, Bagdád, Nairobi',
		'3.5'	=> '[UTC + 3:30, C*] Írán, Teherán',
		'4'		=> '[UTC + 4, D] Perský záliv, Samara, Baku, Tbilisi',
		'4.5'	=> '[UTC + 4:30, D*] Afganistán, Kábul',
		'5'		=> '[UTC + 5, E] Pakistán, Karáčí, Taškent',
		'5.5'	=> '[UTC + 5:30, E*] Indie, Sri Lanka, Bombaj, Nové Dillí',
		'5.75'	=> '[UTC + 5:45, E&Dagger;] Nepál',
		'6'		=> '[UTC + 6, F] Bangladéš, Bhútán, Novosibirsk',
		'6.5'	=> '[UTC + 6:30, F*] Kokosové ostrovy, Myanmar',
		'7'		=> '[UTC + 7, G] Indočína, Bangkok, Hanoj, Jakarta',
		'8'		=> '[UTC + 8, H] Ćína, Západní Austrálie, SIngapur',
		'8.75'	=> '[UTC + 8:45, H&Dagger;] Jihovýchodní Západní Austrálie',
		'9'		=> '[UTC + 9, I] Japonsko, Korea, Jakutsk, Tokio, Ósaka',
		'9.5'	=> '[UTC + 9:30, I*] Střední Austrálie, Darwin',
		'10'	=> '[UTC + 10, K] Východní Austrálie, Vladivostok, Sydney, Canberra',
		'10.5'	=> '[UTC + 10:30, K*] Lord Howe',
		'11'	=> '[UTC + 11, L] Šalamounovy ostrovy, Magadan, Nová Kaledonie',
		'11.5'	=> '[UTC + 11:30, L*] Norfolk Island Time',
		'12'	=> '[UTC + 12, M] Nový Zéland, Kamčatka, Fidži',
		'12.75'	=> '[UTC + 12:45, M&Dagger;] Chathamovy ostrovy',
		'13'	=> '[UTC + 13, M*] Tonga',
		'14'	=> '[UTC + 14, M&dagger;] Ostrovy Line',
	),

	// The value is only an example and will get replaced by the current time on view
	'dateformats'	=> array(
		'|d M Y| H:i'			=> '10 Led 2005 17:54 [Relativní dny]',
		'd M Y, H:i'			=> '10 Led 2005, 17:57',
		'd M Y H:i'				=> '10 Led 2005 17:57',
		'D M d, Y g:i a'		=> 'Pon Led 10, 2005 5:57 pm',
		'M j, y, H:i'			=> 'Led 10, 05, 5:57 pm',
		'F j, Y, g:i a'			=> 'Leden 10, 2005, 5:57 pm',
		'|F jS, Y|, g:i a'		=> 'Dnes, 1:37 pm / Leden 1., 2007, 1:37 pm'
	),
	
	// The default dateformat which will be used on new installs in this language
	// Translators should change this if a the usual date format is different
	'default_dateformat'	=> 'D d. M Y G:i:s', // po 10. leden 2005 17:57:23

));

?>