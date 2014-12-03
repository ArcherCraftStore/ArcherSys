<?php
/** 
*
* acp_bots [Česky]
*
* @package language
* @version $Id: bots.php,v 1.10 2007/01/21 18:33:45 acydburn Exp $
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

// Bot settings
$lang = array_merge($lang, array(
	'BOTS'				=> 'Spravovat boty',
	'BOTS_EXPLAIN'		=> '&quot;Boti&quot; jsou automatičtí roboti, které zpravidla používají vyhledávače pro přidávání odkazů do vlastních databází. Vzhledem k tomu, že využívají sessions správným způsobem jen zřídka, mohou narušit počítání návštěvníků, zvýšit zatížení serveru a občas chybně zaindexovat stránky. Zde lze nastavit zvláštní druh uživatele, čímž můžete problémům předejít.',
	'BOT_ACTIVATE'		=> 'Aktivovat',
	'BOT_ACTIVE'		=> 'Aktivní bot',
	'BOT_ADD'			=> 'Přidat bota',
	'BOT_ADDED'			=> 'Nový bot byl úspěšně přidán.',
	'BOT_AGENT'			=> 'Rozpoznáni bota podle označení',
	'BOT_AGENT_EXPLAIN'	=> 'Označený řetězec, pod nímž se vyskytuje bot. Částečné shody jsou možné.',
	'BOT_DEACTIVATE'	=> 'Deaktivovat',
	'BOT_DELETED'		=> 'Bot byl úspěšně odstraněn.',
	'BOT_EDIT'			=> 'Upravit boty',
	'BOT_EDIT_EXPLAIN'	=> 'Zde můžete přidat či upravit existující záznam o botovi. Pro rozeznání bota lze nastavit, pod jakým označením nebo IP adresou (popř. rozsahem adres) se vyskytuje. Buďte opatrní při definování řetězců nebo IP pro rozpoznání botů. Je rovněž možné nastavit styl a jazyk, který bot uvidí při přístupu na fórum. Nastavením jednoduchého stylu pro boty lze snížit objem přenesených dat. Nezapomeňte nadefinovat vlastní oprávnění skupiny s boty.',
	'BOT_LANG'			=> 'Jazyk bota',
	'BOT_LANG_EXPLAIN'	=> 'Přednastavený jazyk pro bota během jeho procházení stránek.',
	'BOT_LAST_VISIT'	=> 'Poslední návštěva',
	'BOT_IP'			=> 'IP adresa bota',
	'BOT_IP_EXPLAIN'	=> 'Částečné shody jsou povoleny. Adresy oddělte čárkou.',
	'BOT_NAME'			=> 'Název bota',
	'BOT_NAME_EXPLAIN'	=> 'Použito jen pro váš přehled.',
	'BOT_NAME_TAKEN'	=> 'Tento název je na vašem fóru již používán a nelze ho použít pro tohoto bota.',
	'BOT_NEVER'			=>	'Nikdy',
	'BOT_STYLE'			=> 'Vzhled bota',
	'BOT_STYLE_EXPLAIN'	=> 'Vzhled fóra pro bota.',
	'BOT_UPDATED'		=> 'Existující bot byl úspěšně upraven.',

	'ERR_BOT_AGENT_MATCHES_UA'	=> 'Označení bota je podobné tomu, které používáte vy nyní. Změnte označení tohoto bota.',
	'ERR_BOT_NO_IP'				=> 'Zadaná IP adresa je neplatná, nebo se nepodařilo přeložit název hostitele.',
	'ERR_BOT_NO_MATCHES'		=> 'Musíte zvolit nejméně jedno označení nebo IP adresu bota.',

	'NO_BOT'		=> 'Nebyl nalezen žádný bot se zvoleným ID.',
	'NO_BOT_GROUP'	=> 'Nelze najít zvláštní skupinu pro boty.',
));

?>