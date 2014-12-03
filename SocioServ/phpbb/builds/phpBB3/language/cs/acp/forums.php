<?php
/** 
*
* acp_forums [Česky]
*
* @package language
* @version $Id: forums.php,v 1.27 2007/01/21 18:33:45 acydburn Exp $
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

// Forum Admin
$lang = array_merge($lang, array(
	'AUTO_PRUNE_DAYS'			=> 'Poslední příspěvek pro pročištění',
	'AUTO_PRUNE_DAYS_EXPLAIN'	=> 'Počet dní od posledního příspěvku nutných pro smazaní tématu automatickým pročištěním.',
	'AUTO_PRUNE_FREQ'			=> 'Frekvence automatického pročištění',
	'AUTO_PRUNE_FREQ_EXPLAIN'	=> 'Čas (ve dnech) mezi jednotlivými pročištěními',
	'AUTO_PRUNE_VIEWED'			=> 'Poslední zobrazení pro pročištění',
	'AUTO_PRUNE_VIEWED_EXPLAIN'	=> 'Počet dní od posledního zobrazení tématu nutných pro smazaní automatickým pročištěním.',

	'COPY_PERMISSIONS'				=> 'Zkopírovat oprávnění z',
	'COPY_PERMISSIONS_ADD_EXPLAIN'	=> 'Po vytvoření bude mít fórum stejná oprávnění jako zde zvolené. Není-li žádné zvoleno, nově vytvořené fórum nebude viditelné, dokud nenastavíte základní oprávnění.',
	'COPY_PERMISSIONS_EDIT_EXPLAIN'	=> 'Pokud vyberete Zkopírovat oprávnění, fórum bude mít stejná oprávnění jako zde zvolené. To přepíše všechna oprávnění, která jste předtím nastavili pro toto fórum. Pokud není zvoleno žádné fórum, budou ponechána současná oprávnění.',
	'CREATE_FORUM'					=> 'Vytvořit nové fórum',

	'DECIDE_MOVE_DELETE_CONTENT'		=> 'Odstranit obsah nebo přesunout do fóra',
	'DECIDE_MOVE_DELETE_SUBFORUMS'		=> 'Odstranit subfóra nebo přesunout do fóra',
	'DEFAULT_STYLE'						=> 'Výchozí styl',
	'DELETE_ALL_POSTS'					=> 'Smazat příspěvky',
	'DELETE_SUBFORUMS'					=> 'Smazat subfóra a příspěvky',
	'DISPLAY_ACTIVE_TOPICS'				=> 'Povolit oblíbená témata',
	'DISPLAY_ACTIVE_TOPICS_EXPLAIN'		=> 'Zapněte, pokud chcete, aby se ve fóru označovala oblíbená témata.',

	'EDIT_FORUM'					=> 'Upravit fórum',
	'ENABLE_INDEXING'				=> 'Povolit indexování pro vyhledávání',
	'ENABLE_INDEXING_EXPLAIN'		=> 'Je-li zapnuto, příspěvky ve fóru budou zahrunty při hledání.',
	'ENABLE_POST_REVIEW'			=> 'Povolit prohlédnutí příspěvku',
	'ENABLE_POST_REVIEW_EXPLAIN'	=> 'Je-li povoleno, uživatelé si budou moci prohlédnout a přehodnotit svůj příspěvek, pokud byl do tématu během psaní odeslán další příspěvek. Pro čistě diskuzní fóra by tato funkce měla být vypnuta.',
	'ENABLE_RECENT'					=> 'Zobrazit aktivní témata',
	'ENABLE_RECENT_EXPLAIN'			=> 'Je-li nastaveno na "Ano", oblíbená témata v tomto fóru budou označena v kompletním přehledu oblíbených témat.',
	'ENABLE_TOPIC_ICONS'			=> 'Povolit ikonky tématu',

	'FORUM_ADMIN'						=> 'Administrace fór',
	'FORUM_ADMIN_EXPLAIN'				=> 'V phpBB3 neexistují kategorie, všechno je založeno na fórech. Každé fórum může mít neomezený počet subfóra a můžete určit, zda lze do fóra přispívat (tj. bude se chovat jako kategorie). Kromě další akcí zde můžete přidávat, upravovat, odstraňovat, zamykat nebo odemykat jednotlivá fóra. Pokud jsou vaše příspěvky a témata nesynchronní a objevují se chyby, lze fóra také resynchronizovat. <strong>Musíte nastavit nebo zkopírovat příslušná oprávnění, aby se nová fóra zobrazila.</strong>',
	'FORUM_AUTO_PRUNE'					=> 'Zapnout automatické pročištění',
	'FORUM_AUTO_PRUNE_EXPLAIN'			=> 'Automaticky pročistí fórum od starých témat, nastavte frekvenci/stáří níže.',
	'FORUM_CREATED'						=> 'Fórum úspěšně vytvořeno.',
	'FORUM_DATA_NEGATIVE'				=> 'Prametry pročištění nemohou být záporné.',
	'FORUM_DESC_TOO_LONG'				=> 'Popis fóra je příliš dlouhý, může mít maximálně 4000 znaků.',
	'FORUM_DELETE'						=> 'Smazat fórum',
	'FORUM_DELETE_EXPLAIN'				=> 'Následující formulář vám umožní smazat fórum. Pokud do fóra lze přispívat, budete se moci rozhodnout, kam chcete umístit všechna témata(a fóra), které obsahovalo.',
	'FORUM_DELETED'						=> 'Fórum úspěšně smazáno.',
	'FORUM_DESC'						=> 'Popis',
	'FORUM_DESC_EXPLAIN'				=> 'Všechny tagy HTML zde zadané nebudou zpracovány.',
	'FORUM_EDIT_EXPLAIN'				=> 'Tento formulář umožňuje přizpůsobit fórum vašim představám. Nastavení moderátorů a počítání příspěvků je však třeba nastavit přes Oprávnění fór pro jednotlivé uživatele nebo skupiny.',
	'FORUM_IMAGE'						=> 'Obrázek fóra',
	'FORUM_IMAGE_EXPLAIN'				=> 'Umístění obrázku zobrazeného u tohoto fóra, příbuzné kořenovému adresáři phpBB.',
	'FORUM_LINK_EXPLAIN'				=> 'Uplná adresa URL (Včetně protokolu; například <samp>http://</samp>), kam bude uživatel po kliknutí přesměrován.',
	'FORUM_LINK_TRACK'					=> 'Sledovat kliknutí',
	'FORUM_LINK_TRACK_EXPLAIN'			=> 'Sleduje, kolikrát bylo kliknuto na odkaz.',
	'FORUM_NAME'						=> 'Jméno fóra',
	'FORUM_NAME_EMPTY'					=> 'Musíte zadat jméno pro toto fórum.',
	'FORUM_PARENT'						=> 'Nadřazené fórum',
	'FORUM_PASSWORD'					=> 'Heslo fóra',
	'FORUM_PASSWORD_CONFIRM'			=> 'Potvrdit heslo fóra',
	'FORUM_PASSWORD_CONFIRM_EXPLAIN'	=> 'Vyplňte, pouze pokud nastavujete heslo pro fórum.',
	'FORUM_PASSWORD_EXPLAIN'			=> 'Zadejte heslo pro toto fórum. Použijte systém oprávnění v nastavení.',
	'FORUM_PASSWORD_MISMATCH'			=> 'Zadená hesla se neshodují.',
	'FORUM_PRUNE_SETTINGS'				=> 'Nastavení pročištění fóra',
	'FORUM_RESYNCED'					=> 'Fórum "%s" bylo úspěšně resynchronizováno',
	'FORUM_RULES_EXPLAIN'				=> 'Pravidla fóra budou zobrazena na všech stránkách daného fóra.',
	'FORUM_RULES_LINK'					=> 'Odkaz na pravidla fóra.',
	'FORUM_RULES_LINK_EXPLAIN'			=> 'Zde můžete zadar URL stránky/příspěvku s pravidly. Tomuto nastavení bude dána přednost před textem, který jste zde mohli zadat.',
	'FORUM_RULES_PREVIEW'				=> 'Náhled pravidel fóra.',
	'FORUM_RULES_TOO_LONG'				=> 'Pravidla fóra mohou mít maximálně 4000 znaků.',
	'FORUM_SETTINGS'					=> 'Nastavení fóra',
	'FORUM_STATUS'						=> 'Stav fóra',
	'FORUM_STYLE'						=> 'Styl fóra',
	'FORUM_TOPICS_PAGE'					=> 'Témat na stránku',
	'FORUM_TOPICS_PAGE_EXPLAIN'			=> 'Pokud není nastaveno na 0, bude tomuto nastavení dána přednost před nastavením globálním.',
	'FORUM_TYPE'						=> 'Typ fóra',
	'FORUM_UPDATED'						=> 'Informace o fóru uspěšně aktualizovány.',

	'FORUM_WITH_SUBFORUMS_NOT_TO_LINK'  => 'Chcete změnit fórum, které obsahuje subfóra a do kterého lze přispívat na odkaz. Přesuňte nejdříve všechna subfóra jinam, protože po změně fóra na odkaz už nebudou viditelná ani dostupná.',
	
	'GENERAL_FORUM_SETTINGS'	=> 'Základní nastavení fóra',

	'LINK'					=> 'Odkaz',
	'LIST_INDEX'			=> 'Zobrazit fórum v přehledu subfór',
	'LIST_INDEX_EXPLAIN'	=> 'Zobrazí odkaz na toto fórum ve výpisu subfór u nadřazeného fóra.',
	'LOCKED'				=> 'Zamknuto',

	'MOVE_POSTS_NO_POSTABLE_FORUM'	=> 'Do fóra, které jste vybrali pro přesunutí příspěvku, není možno přispívat. Prosíme, zvolte dostupné fórum.',
	'MOVE_POSTS_TO'		=> 'Přesunout příspěvky do',
	'MOVE_SUBFORUMS_TO'	=> 'Přesunout subfóra do',

	'NO_DESTINATION_FORUM'			=> 'Nezvolili jste fórum, do něhož bude přesunut obsah.',
	'NO_FORUM_ACTION'				=> 'Nebyla definována akce pro naložení s obsahem fóra',
	'NO_PARENT'						=> 'Nemá nadřazené',
	'NO_PERMISSIONS'				=> 'Nekopírovat oprávnění',
	'NO_PERMISSION_FORUM_ADD'		=> 'Nemáte dostatečná oprávnění pro přidání fóra.',
	'NO_PERMISSION_FORUM_DELETE'	=> 'Nemáte dostatečná oprávnění pro mazaní fór.',

	'PARENT_IS_LINK_FORUM'		=> 'Nadřazené fórum, které jste zvolili, je nastaveno jako odkaz. Odkazující fóra nemohou mít subfóra, vyberte jako nadřazené fórum kategorii nebo jiné fórum.',
	'PARENT_NOT_EXIST'			=> 'Nadřazené fórum neexistuje.',
	'PRUNE_ANNOUNCEMENTS'		=> 'Pročistit důležité',
	'PRUNE_STICKY'				=> 'Pročistit oznámení',
	'PRUNE_OLD_POLLS'			=> 'Pročistit staré anktety',
	'PRUNE_OLD_POLLS_EXPLAIN'	=> 'Vymazat témata s anketami, ve kterých nikdo nehlasoval od zadaných dnů.',

	'REDIRECT_ACL'	=> 'Nyní můžete %snastavit oprávnění%s pro toto fórum.',

	'SYNC_IN_PROGRESS'			=> 'Synchronizace fóra...',
	'SYNC_IN_PROGRESS_EXPLAIN'	=> 'Právě synchornizuji témata %1$d až %2$d.',

	'TYPE_CAT'			=> 'Kategorie',
	'TYPE_FORUM'		=> 'Fórum',
	'TYPE_LINK'			=> 'Odkaz',

	'UNLOCKED'			=> 'Odemknuté',
));

?>