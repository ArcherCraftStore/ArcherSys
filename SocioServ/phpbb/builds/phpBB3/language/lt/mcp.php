<?php
/** 
*
* mcp.php [Lithuanian]
*
* @package language
* @version $Id: $
* @copyright (c) 2007 phpBB Group 
* @author 2007-08-01 - Vilius Šumskas
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
	'ACTION'	=> 'Veiksmas',
	'ACTION_NOTE'	=> 'Veiksmas/Pastaba',
	'ADD_FEEDBACK'	=> 'Parašyti atsiliepimą',
	'ADD_FEEDBACK_EXPLAIN'	=> 'Jeigu norite parašyti atsiliepimą, užpildykite formą žemiau. Naudokite tik paprastą tekstą; HTML, BBKodo, ir t.t. naudoti negalima.',
	'ADD_WARNING'	=> 'Parašyti perspėjimą',
	'ADD_WARNING_EXPLAIN'	=> 'Jeigu norite perspėti šį vartotoją, užpildykite formą žemiau. Naudokite tik paprastą tekstą; HTML, BBKodo, ir t.t. naudoti negalima.',
	'ALL_ENTRIES'	=> 'Visi įrašai',
	'ALL_NOTES_DELETED'	=> 'Visi atsiliepimai apie vartotoją sėkmingai ištrinti.',
	'ALL_REPORTS'	=> 'Visi raportai',
	'ALREADY_REPORTED'	=> 'Jau raportuota apie šį pranešimą.',
	'ALREADY_WARNED'	=> 'Perspėjimas dėl šio pranešimo jau duotas.',
	'APPROVE'	=> 'Patvirtinti',
	'APPROVE_POST'	=> 'Patvirtinti pranešimą',
	'APPROVE_POST_CONFIRM'	=> 'Ar tikrai norite patvirtinti šį pranešimą?',
	'APPROVE_POSTS'	=> 'Patvirtinti pranešimus',
	'APPROVE_POSTS_CONFIRM'	=> 'Ar tikrai norite patvirtinti pasirinktus pranešimus?',
	'CANNOT_MOVE_SAME_FORUM'	=> 'Jūs negalite perkelti temos į forumą kuriame ji jau yra.',
	'CANNOT_WARN_ANONYMOUS'	=> 'Jūs negalite perspėti neregistruotų vartotojų.',
	'CANNOT_WARN_SELF'	=> 'Jūs negalite perspėti saves.',
	'CAN_LEAVE_BLANK'	=> 'Šis laukas gali būti tuščias.',
	'CHANGE_POSTER'	=> 'Pakeisti autorių',
	'CLOSE_REPORT'	=> 'Uždaryti raportą',
	'CLOSE_REPORT_CONFIRM'	=> 'Ar tikrai norite uždaryti pasirinktą raportą?',
	'CLOSE_REPORTS'	=> 'Uždaryti raportus',
	'CLOSE_REPORTS_CONFIRM'	=> 'Ar tikrai norite uždaryti pasirinktus raportus?',
	'DELETE_POSTS'	=> 'Ištrinti pranešimus',
	'DELETE_POSTS_CONFIRM'	=> 'Ar tikrai norite ištrinti šiuos pranešimus?',
	'DELETE_POST_CONFIRM'	=> 'Ar tikrai norite ištrinti šį pranešimą?',
	'DELETE_REPORT'	=> 'Ištrinti raportą',
	'DELETE_REPORT_CONFIRM'	=> 'Ar tikrai norite ištrinti pasirinktą raportą?',
	'DELETE_REPORTS'	=> 'Ištrinti raportus',
	'DELETE_REPORTS_CONFIRM'	=> 'Ar tikrai norite ištrinti pasirinktus raportus?',
	'DELETE_SHADOW_TOPIC'	=> 'Ištrinti temos šešėlį',
	'DELETE_TOPICS'	=> 'Ištrinti pasirinktas temas',
	'DELETE_TOPICS_CONFIRM'	=> 'Ar tikrai norite ištrinti šias temas?',
	'DELETE_TOPIC_CONFIRM'	=> 'Ar tikrai norite ištrinti šią temą?',
	'DISAPPROVE'	=> 'Atmesti',
	'DISAPPROVE_REASON'	=> 'Atmetimo priežastis',
	'DISAPPROVE_POST'	=> 'Atmesti šį pranešimą',
	'DISAPPROVE_POST_CONFIRM'	=> 'Ar tikrai norite atmesti šį pranešimą?',
	'DISAPPROVE_POSTS'	=> 'Atmesti pranešimus',
	'DISAPPROVE_POSTS_CONFIRM'	=> 'Ar tikrai norite atmesti pasirinktus pranešimus?',
	'DISPLAY_LOG'	=> 'Rodyti paskutinius įrašus',
	'DISPLAY_OPTIONS'	=> 'Rodyti nustatymus',
	'EMPTY_REPORT'	=> 'Pasirinkę šią priežastį turite įvesti detalesnį raporto aprašymą.',
	'EMPTY_TOPICS_REMOVED_WARNING'	=> 'Iš duomenų bazės buvo ištrintos viena arba keletas temų, kadangi jos tapo tuščios.',
	'FEEDBACK'	=> 'Atsiliepimai',
	'FORK'	=> 'Kopijuoti',
	'FORK_TOPIC'	=> 'Kopijuoti temą',
	'FORK_TOPIC_CONFIRM'	=> 'Ar tikrai norite kopijuoti šią temą?',
	'FORK_TOPICS'	=> 'Kopijuoti pasirinktas temas',
	'FORK_TOPICS_CONFIRM'	=> 'Ar tikrai norite kopijuoti pasirinktas temas?',
	'FORUM_DESC'	=> 'Aprašymas',
	'FORUM_NAME'	=> 'Forumo pavadinimas',
	'FORUM_NOT_EXIST'	=> 'Forumas, kurį pasirinkote, neegzistuoja.',
	'FORUM_NOT_POSTABLE'	=> 'Forumas, kurį pasirinkote, yra užrakintas.',
	'FORUM_STATUS'	=> 'Forumo būsena',
	'FORUM_STYLE'	=> 'Forumo stilius',
	'GLOBAL_ANNOUNCEMENT'	=> 'Labai svarbus pranešimas',
	'IP_INFO'	=> 'Duomenys apie IP adresą',
	'IPS_POSTED_FROM'	=> 'IP adresai iš kurių rašė šis vartotojas',
	'LATEST_LOGS'	=> 'Naujausi 5 įrašai apie veiksmus',
	'LATEST_REPORTED'	=> 'Naujausi 5 raportai',
	'LATEST_UNAPPROVED'	=> 'Naujausi 5 pranešimai laukiantys patvirtinimo',
	'LATEST_WARNING_TIME'	=> 'Naujausias perspėjimas duotas',
	'LATEST_WARNINGS'	=> 'Naujausi 5 perspėjimai',
	'LEAVE_SHADOW'	=> 'Palikti temos šešėlį',
	'LIST_REPORT'	=> '1 raportas',
	'LIST_REPORTS'	=> '%d raportai(ų)',
	'LOCK'	=> 'Užrakinti',
	'LOCK_POST_POST'	=> 'Užrakinti pranešimą',
	'LOCK_POST_POST_CONFIRM'	=> 'Ar tikrai norite užrakinti pranešimą ir neleisti jo redaguoti?',
	'LOCK_POST_POSTS'	=> 'Užrakinti pasirinktus pranešimus',
	'LOCK_POST_POSTS_CONFIRM'	=> 'Ar tikrai norite užrakinti pasirinktus pranešimus ir neleisti jų redaguoti?',
	'LOCK_TOPIC_CONFIRM'	=> 'Ar tikrai norite užrakinti šią temą?',
	'LOCK_TOPICS'	=> 'Užrakinti pasirinktas temas',
	'LOCK_TOPICS_CONFIRM'	=> 'Ar tikrai norite užrakinti visas pasirinktas temas?',
	'LOGS_CURRENT_TOPIC'	=> 'Rodomi įrašai apie:',
	'LOGIN_EXPLAIN_MCP'	=> 'Norėdami moderuoti šį forumą, turite prisijungti.',
	'LOGVIEW_VIEWTOPIC'	=> 'Peržiūrėti temą',
	'LOGVIEW_VIEWLOGS'	=> 'Peržiūrėti temos veiksmų registrą',
	'LOGVIEW_VIEWFORUM'	=> 'Peržiūrėti forumą',
	'LOOKUP_ALL'	=> 'Rodyti informaciją apie visus IP adresus',
	'LOOKUP_IP'	=> 'Rodyti informaciją apie IP adresą',
	'MARKED_NOTES_DELETED'	=> 'Visi pažymėti atsiliepimai apie vartotoją sėkmingai ištrinti.',
	'MCP_ADD'	=> 'Perspėti',
	'MCP_BAN'	=> 'Blokavimas',
	'MCP_BAN_EMAILS'	=> 'Blokuoti el. pašto adresus',
	'MCP_BAN_IPS'	=> 'Blokuoti IP adresus',
	'MCP_BAN_USERNAMES'	=> 'Blokuoti vartotojų vardus',
	'MCP_LOGS'	=> 'Moderatorių veiksmų registras',
	'MCP_LOGS_FRONT'	=> 'Pirmas puslapis',
	'MCP_LOGS_FORUM_VIEW'	=> 'Forumo registras',
	'MCP_LOGS_TOPIC_VIEW'	=> 'Temos registras',
	'MCP_MAIN'	=> 'Pagrindinis',
	'MCP_MAIN_FORUM_VIEW'	=> 'Peržiūrėti forumą',
	'MCP_MAIN_FRONT'	=> 'Pirmas puslapis',
	'MCP_MAIN_POST_DETAILS'	=> 'Detalus pranešimo aprašymas',
	'MCP_MAIN_TOPIC_VIEW'	=> 'Peržiūrėti temą',
	'MCP_MAKE_ANNOUNCEMENT'	=> 'Pakeisti būseną į “Svarbu!”',
	'MCP_MAKE_ANNOUNCEMENT_CONFIRM'	=> 'Ar tikrai norite pakeisti šios temos tipą į “Svarbu!”?',
	'MCP_MAKE_ANNOUNCEMENTS'	=> 'Pakeisti tipą į “Svarbu!”',
	'MCP_MAKE_ANNOUNCEMENTS_CONFIRM'	=> 'Ar tikrai norite pakeisti pasirinktų temų tipą į “Svarbu!”?',
	'MCP_MAKE_GLOBAL'	=> 'Pakeisti tipą į “Labai svarbu!”',
	'MCP_MAKE_GLOBAL_CONFIRM'	=> 'Ar tikrai norite pakeisti šios temos tipą į “Labai svarbu!”?',
	'MCP_MAKE_GLOBALS'	=> 'Pakeisti tipą į “Labai svarbu!”',
	'MCP_MAKE_GLOBALS_CONFIRM'	=> 'Ar tikrai norite pakeisti pasirinktų temų tipą į “Labai svarbu!”?',
	'MCP_MAKE_STICKY'	=> 'Pakeisti tipą į “Dažna tema”',
	'MCP_MAKE_STICKY_CONFIRM'	=> 'Ar tikrai norite pakeisti šios temos tipą į “Dažna tema”?',
	'MCP_MAKE_STICKIES'	=> 'Pakeisti būseną į “Dažna tema”',
	'MCP_MAKE_STICKIES_CONFIRM'	=> 'Ar tikrai norite pakeisti pasirinktų temų tipą į “Dažna tema”?',
	'MCP_MAKE_NORMAL'	=> 'Pakeisti tipą į “Standartinė tema”',
	'MCP_MAKE_NORMAL_CONFIRM'	=> 'Ar tikrai norite pakeisti šios temos tipą į “Standartinė tema”?',
	'MCP_MAKE_NORMALS'	=> 'Pakeisti tipą į “Standartinė tema”',
	'MCP_MAKE_NORMALS_CONFIRM'	=> 'Ar tikrai norite pakeisti pasirinktų temų tipą į “Standartinė tema”?',
	'MCP_NOTES'	=> 'Atsiliepimai apie vartotojus',
	'MCP_NOTES_FRONT'	=> 'Pirmas puslapis',
	'MCP_NOTES_USER'	=> 'Detalus vartotojo aprašymas',
	'MCP_POST_REPORTS'	=> 'Raportai dėl šio pranešimo',
	'MCP_REPORTS'	=> 'Raportuoti pranešimai',
	'MCP_REPORT_DETAILS'	=> 'Detalus raporto aprašymas',
	'MCP_REPORTS_CLOSED'	=> 'Uždaryti raportai',
	'MCP_REPORTS_CLOSED_EXPLAIN'	=> 'Raportų, kurie yra išspręsti, sąrašas.',
	'MCP_REPORTS_OPEN'	=> 'Atviri raportai',
	'MCP_REPORTS_OPEN_EXPLAIN'	=> 'Raportų, kuriais reikia pasirūpinti, sąrašas.',
	'MCP_QUEUE'	=> 'Moderavimo eilė',
	'MCP_QUEUE_APPROVE_DETAILS'	=> 'Detalus patvirtinimo aprašymas',
	'MCP_QUEUE_UNAPPROVED_POSTS'	=> 'Pranešimai laukiantys patvirtinimo',
	'MCP_QUEUE_UNAPPROVED_POSTS_EXPLAIN'	=> 'Pranešimų, kuriuos reikia patvirtinti prieš tai kai jie bus matomi vartotojams, sąrašas.',
	'MCP_QUEUE_UNAPPROVED_TOPICS'	=> 'Temos laukiančios patvirtinimo',
	'MCP_QUEUE_UNAPPROVED_TOPICS_EXPLAIN'	=> 'Temų, kurias reikia patvirtinti prieš tai kai jos bus matomos vartotojams, sąrašas.',
	'MCP_VIEW_USER'	=> 'Peržiūrėti duotus perspėjimus šiam vartotojui',
	'MCP_WARN'	=> 'Perspėjimai',
	'MCP_WARN_FRONT'	=> 'Pirmas puslapis',
	'MCP_WARN_LIST'	=> 'Rodyti perspėjimų sąrašą',
	'MCP_WARN_POST'	=> 'Perspėti dėl tam tikro pranešimo',
	'MCP_WARN_USER'	=> 'Perspėti vartotoją',
	'MERGE_POSTS'	=> 'Sujungti pranešimus',
	'MERGE_POSTS_CONFIRM'	=> 'Ar tikrai norite sujungti pasirinktus pranešimus?',
	'MERGE_TOPIC_EXPLAIN'	=> 'Pasinaudoję forma apačioje galite sujungti pasirinktus pranešimus į vieną temą. Pranešimai naujoje temoje bus surūšiuoti pagal datą.<br />Įrašykite temos su kuria norite sujungti numerį arba paspauskite ant “Pasirinkti temą” ir susiraskite reikiamą temą.',
	'MERGE_TOPIC_ID'	=> 'Temos su kuria norite sujungti identifikacinis numeris',
	'MERGE_TOPICS'	=> 'Sujungti temas',
	'MERGE_TOPICS_CONFIRM'	=> 'Ar tikrai norite sujungti pasirinktas temas?',
	'MODERATE_FORUM'	=> 'Moderuoti forumą',
	'MODERATE_TOPIC'	=> 'Moderuoti temą',
	'MODERATE_POST'	=> 'Moderuoti pranešimą',
	'MOD_OPTIONS'	=> 'Moderatoriaus nustatymai',
	'MORE_INFO'	=> 'Tolesnė informacija',
	'MOST_WARNINGS'	=> 'Vartotojai gavę daugiausią perspėjimų',
	'MOVE_TOPIC_CONFIRM'	=> 'Ar tikrai norite perkelti šią temą į naują forumą?',
	'MOVE_TOPICS'	=> 'Perkelti pasirinktas temas',
	'MOVE_TOPICS_CONFIRM'	=> 'Ar tikrai norite perkelti pasirinktas temas į naują forumą?',
	'NOTIFY_POSTER_APPROVAL'	=> 'Ar informuoti autorių apie patvirtinimą?',
	'NOTIFY_POSTER_DISAPPROVAL'	=> 'Ar informuoti autorių apie atmestą pranešimą?',
	'NOTIFY_USER_WARN'	=> 'Ar informuoti vartotoją apie perspėjimą?',
	'NOT_MODERATOR'	=> 'Jūs nesate šio forumo moderatorius.',
	'NO_DESTINATION_FORUM'	=> 'Pasirinkite forumą į kurį norite perkelti.',
	'NO_DESTINATION_FORUM_FOUND'	=> 'Tokio forumo nėra.',
	'NO_ENTRIES'	=> 'Pasirinktu periodu nėra jokių įrašų.',
	'NO_FEEDBACK'	=> 'Atsiliepimų apie vartotoją nėra.',
	'NO_FINAL_TOPIC_SELECTED'	=> 'Jūs turite pasirinkti temą su kuria norite sujungti pranešimus.',
	'NO_MATCHES_FOUND'	=> 'Atitikmenų nėra.',
	'NO_POST'	=> 'Norėdami perspėti vartotoją dėl pranešimo, turite pasirinkti pranešimą.',
	'NO_POST_REPORT'	=> 'Raportų apie šį pranešimą nėra.',
	'NO_POST_SELECTED'	=> 'Šiam veiksmui reikia pasirinkti bent vieną pranešimą.',
	'NO_REASON_DISAPPROVAL'	=> 'Nurodykite teisingą atmetimo priežastį.',
	'NO_REPORT'	=> 'Raporto nėra',
	'NO_REPORTS'	=> 'Raportų nėra',
	'NO_REPORT_SELECTED'	=> 'Šiam veiksmui reikia pasirinkti bent vieną raportą.',
	'NO_TOPIC_ICON'	=> 'Nėra',
	'NO_TOPIC_SELECTED'	=> 'Šiam veiksmui reikia pasirinkti bent vieną temą.',
	'NO_TOPICS_QUEUE'	=> 'Temų, laukiančių patvirtinimo, nėra',
	'ONLY_TOPIC'	=> 'Tik temą "%s"',
	'OTHER_USERS'	=> 'Kiti vartotojai rašantys iš šio IP adreso',
	'POSTER'	=> 'Autorius',
	'POSTS_APPROVED_SUCCESS'	=> 'Pranešimai, kuriuos pasirinkote, patvirtinti.',
	'POSTS_DELETED_SUCCESS'	=> 'Pranešimai, kuriuos pasirinkote, sėkmingai ištrinti iš duomenų bazės.',
	'POSTS_DISAPPROVED_SUCCESS'	=> 'Pranešimai, kuriuos pasirinkote, atmesti.',
	'POSTS_LOCKED_SUCCESS'	=> 'Pranešimai, kuriuos pasirinkote, sėkmingai užrakinti.',
	'POSTS_MERGED_SUCCESS'	=> 'Pranešimai, kuriuos pasirinkote, sujungti.',
	'POSTS_UNLOCKED_SUCCESS'	=> 'Pranešimai, kuriuos pasirinkote, sėkmingai atrakinti.',
	'POSTS_PER_PAGE'	=> 'Pranešimų per puslapį',
	'POSTS_PER_PAGE_EXPLAIN'	=> '(Įrašykite 0, kad matytumėte visus pranešimus.)',
	'POST_APPROVED_SUCCESS'	=> 'Pranešimas, kurį pasirinkote, patvirtintas.',
	'POST_DELETED_SUCCESS'	=> 'Pranešimas, kurį pasirinkote, sėkmingai ištrintas iš duomenų bazės.',
	'POST_DISAPPROVED_SUCCESS'	=> 'Pranešimas, kurį pasirinkote, atmestas.',
	'POST_LOCKED_SUCCESS'	=> 'Pranešimas sėkmingai užrakintas.',
	'POST_NOT_EXIST'	=> 'Pranešimas, kurio ieškote, neegzistuoja.',
	'POST_REPORTED_SUCCESS'	=> 'Raportas apie pranešimą sėkmingai išsiųstas.',
	'POST_UNLOCKED_SUCCESS'	=> 'Pranešimas sėkmingai atrakingas.',
	'READ_USERNOTES'	=> 'Atsiliepimai apie vartotoją',
	'READ_WARNINGS'	=> 'Perspėjimai duoti vartotojui',
	'REPORTER'	=> 'Reporteris',
	'REPORTED'	=> 'Raportuota',
	'REPORTED_BY'	=> 'Raportuota',
	'REPORTED_ON_DATE'	=> '',
	'REPORTS_CLOSED_SUCCESS'	=> 'Raportai, kuriuos pasirinkote, sėkmingai uždaryti.',
	'REPORTS_DELETED_SUCCESS'	=> 'Raportai, kuriuos pasirinkote, sėkmingai ištrinti.',
	'REPORTS_TOTAL'	=> 'Iš viso yra <strong>%d</strong> atviri(ų) raportai(ų).',
	'REPORTS_ZERO_TOTAL'	=> 'Atvirų raportų nėra.',
	'REPORT_CLOSED'	=> 'Raportas uždarytas.',
	'REPORT_CLOSED_SUCCESS'	=> 'Raportas, kurį pasirinkote, sėkmingai uždarytas.',
	'REPORT_DELETED_SUCCESS'	=> 'Raportas, kurį pasirinkote, sėkmingai ištrintas.',
	'REPORT_DETAILS'	=> 'Detalus raporto aprašymas',
	'REPORT_MESSAGE'	=> 'Siųsti raportą apie šią žinutę',
	'REPORT_MESSAGE_EXPLAIN'	=> 'Norėdami išsiųsti raportą apie pasirinktą žinutę, naudokite formą apačioje. Naudokite raportus tik tada, jeigu žinutė pažeidžia forumo taisykles.',
	'REPORT_NOTIFY'	=> 'Informuoti mane',
	'REPORT_NOTIFY_EXPLAIN'	=> 'Informuoja jus, jeigu dėl jūsų raporto imtąsi kokių nors veiksmų.',
	'REPORT_POST_EXPLAIN'	=> 'Naudokite šią formą, jeigu norite raportuoti apie pasirinktą pranešimą forumo moderatoriams arba diskusijų administratoriams. Naudokite raportus tik tada, jeigu pranešimas pažeidžia forumo taisykles.',
	'REPORT_REASON'	=> 'Raporto priežastis',
	'REPORT_TIME'	=> 'Raporto laikas',
	'REPORT_TOTAL'	=> 'Iš viso yra <strong>1</strong> atviras raportas.',
	'RESYNC'	=> 'Sinchronizuoti',
	'RETURN_MESSAGE'	=> '%sGrįžti į žinutę%s',
	'RETURN_NEW_FORUM'	=> '%sGrįžti į naują forumą%s',
	'RETURN_NEW_TOPIC'	=> '%sGrįžti į naują temą%s',
	'RETURN_POST'	=> '%sGrįžti į pranešimą%s',
	'RETURN_QUEUE'	=> '%sGrįžti į eilę%s',
	'RETURN_REPORTS'	=> '%sGrįžti į raportų sąrašą%s',
	'RETURN_TOPIC_SIMPLE'	=> '%sGrįžti į temą%s',
	'SEARCH_POSTS_BY_USER'	=> 'Ieškoti vartotojo pranešimų',
	'SELECT_ACTION'	=> 'Pasirinkite pageidaujamą veiksmą',
	'SELECT_FORUM_GLOBAL_ANNOUNCEMENT'	=> 'Pasirinkite forumą, kuriame norite rodyti šią labai svarbią temą.',
	'SELECT_FORUM_GLOBAL_ANNOUNCEMENTS'	=> 'Viena ar daugiau iš pasirinktų temų yra labai svarbi. Pasirinkite forumą, kuriame norite rodyti šias temas.',
	'SELECT_MERGE'	=> 'Pasirinkti sujungimui',
	'SELECT_TOPICS_FROM'	=> 'Pasirinkti temas iš',
	'SELECT_TOPIC'	=> 'Pasirinkti temą',
	'SELECT_USER'	=> 'Pasirinkti vartotoją',
	'SORT_ACTION'	=> 'Įrašo veiksmą',
	'SORT_DATE'	=> 'Datą',
	'SORT_IP'	=> 'IP adresą',
	'SORT_WARNINGS'	=> 'Perspėjimų skaičių',
	'SPLIT_AFTER'	=> 'Išskirti iš pasirinktų pranešimų',
	'SPLIT_FORUM'	=> 'Kurti temą forume',
	'SPLIT_POSTS'	=> 'Išskirti pasirinktus pranešimus',
	'SPLIT_SUBJECT'	=> 'Naujos temos pavadinimas',
	'SPLIT_TOPIC_ALL'	=> 'Išskirti pasirinktus pranešimus į atskirą temą',
	'SPLIT_TOPIC_ALL_CONFIRM'	=> 'Ar tikrai norite išskirti šią temą?',
	'SPLIT_TOPIC_BEYOND'	=> 'Išskirti temą nuo pasirinkto pranešimo',
	'SPLIT_TOPIC_BEYOND_CONFIRM'	=> 'Ar tikrai norite išskirti temą nuo pasirinkto pranešimo?',
	'SPLIT_TOPIC_EXPLAIN'	=> 'Pasinaudoję forma apačioje galite išskirti temą į dvi atskiras temas. Galite tai padaryti arba pasirinkę norimus pranešimus, arba pasirinkę vieną pranešimą, nuo kurio norite išskirti temą.',
	'THIS_POST_IP'	=> 'Šio pranešimo IP adresas',
	'TOPICS_APPROVED_SUCCESS'	=> 'Temos, kurias pasirinkote, patvirtintos.',
	'TOPICS_DELETED_SUCCESS'	=> 'Temos, kurias pasirinkote, sėkmingai ištrintos iš duomenų bazės.',
	'TOPICS_DISAPPROVED_SUCCESS'	=> 'Temos, kurias pasirinkote, atmestos.',
	'TOPICS_FORKED_SUCCESS'	=> 'Temos, kurias pasirinkote, sėkmingai nukopijuoti.',
	'TOPICS_LOCKED_SUCCESS'	=> 'Temos, kurias pasirinkote, užrakintos.',
	'TOPICS_MOVED_SUCCESS'	=> 'Temos, kurias pasirinkote, sėkmingai perkeltos.',
	'TOPICS_RESYNC_SUCCESS'	=> 'Temos, kurias pasirinkote, susinchronizuotos.',
	'TOPICS_TYPE_CHANGED'	=> 'Temų būsena sėkmingai pakeista.',
	'TOPICS_UNLOCKED_SUCCESS'	=> 'Temos, kurias pasirinkote, atrakintos.',
	'TOPIC_APPROVED_SUCCESS'	=> 'Tema, kurią pasirinkote, patvirtinta.',
	'TOPIC_DELETED_SUCCESS'	=> 'Tema, kurią pasirinkote, sėkmingai ištrinta iš duomenų bazės.',
	'TOPIC_DISAPPROVED_SUCCESS'	=> 'Tema, kurią pasirinkote, atmesta.',
	'TOPIC_FORKED_SUCCESS'	=> 'Tema, kurią pasirinkote, sėkmingai nukopijuota.',
	'TOPIC_LOCKED_SUCCESS'	=> 'Tema, kurią pasirinkote, užrakinta.',
	'TOPIC_MOVED_SUCCESS'	=> 'Tema, kurią pasirinkote, sėkmingai perkelta.',
	'TOPIC_NOT_EXIST'	=> 'Tema, kurią pasirinkote, neegzistuoja.',
	'TOPIC_RESYNC_SUCCESS'	=> 'Tema, kurią pasirinkote, susinchronizuota.',
	'TOPIC_SPLIT_SUCCESS'	=> 'Tema, kurią pasirinkote, sėkmingai išskirta.',
	'TOPIC_TIME'	=> 'Temos laikas',
	'TOPIC_TYPE_CHANGED'	=> 'Temos būsena sėkmingai pakeista.',
	'TOPIC_UNLOCKED_SUCCESS'	=> 'Tema, kurią pasirinkote, atrakinta.',
	'TOTAL_WARNINGS'	=> 'Iš viso perspėjimų',
	'UNAPPROVED_POSTS_TOTAL'	=> 'Iš viso yra <strong>%d</strong> pranešimai(ų) laukantys(čių) patvirtinimo.',
	'UNAPPROVED_POSTS_ZERO_TOTAL'	=> 'Pranešimų laukiančių patvirtinimo nėra.',
	'UNAPPROVED_POST_TOTAL'	=> 'Iš viso yra <strong>1</strong> pranešimas laukiantis patvirtinimo.',
	'UNLOCK'	=> 'Atrakinti',
	'UNLOCK_POST'	=> 'Atrakinti pranešimą',
	'UNLOCK_POST_EXPLAIN'	=> 'Leisti redaguoti',
	'UNLOCK_POST_POST'	=> 'Atrakinti pranešimą',
	'UNLOCK_POST_POST_CONFIRM'	=> 'Ar tikrai norite leisti redaguoti šį pranešimą?',
	'UNLOCK_POST_POSTS'	=> 'Atrakinti pasirinktus pranešimus',
	'UNLOCK_POST_POSTS_CONFIRM'	=> 'Ar tikrai norite leisti redaguoti pasirinktus pranešimus?',
	'UNLOCK_TOPIC'	=> 'Atrakinti temą',
	'UNLOCK_TOPIC_CONFIRM'	=> 'Ar tikrai norite atrakinti šią temą?',
	'UNLOCK_TOPICS'	=> 'Atrakinti pasirinktas temas',
	'UNLOCK_TOPICS_CONFIRM'	=> 'Ar tikrai norite atrakinti pasirinktas temas?',
	'USER_CANNOT_POST'	=> 'Jūs negalite rašyti šiame forume.',
	'USER_CANNOT_REPORT'	=> 'Jūs negalite siųsti raportų apie pranešimus šiame forume.',
	'USER_FEEDBACK_ADDED'	=> 'Atsiliepimas apie vartotoją išsiųstas sėkmingai.',
	'USER_WARNING_ADDED'	=> 'Perspėjimas išsiųstas sėkmingai.',
	'VIEW_DETAILS'	=> 'Rodyti detalesnį aprašymą',
	'WARNED_USERS'	=> 'Perspėti vartotojai',
	'WARNED_USERS_EXPLAIN'	=> 'Vartotojų, kurių perspėjimų galiojimo laikas dar nesibaigė, sąrašas.',
	'WARNING_PM_BODY'	=> 'Jūs gavote šį perspėjimą nuo diskusijų administratoriaus arba moderatoriaus.[quote]%s[/quote]',
	'WARNING_PM_SUBJECT'	=> 'Perspėjimas',
	'WARNING_POST_DEFAULT'	=> 'Jūs gavote perspėjimą dėl šio pranešimo: %s .',
	'WARNINGS_ZERO_TOTAL'	=> 'Perspėjimų nėra.',
	'YOU_SELECTED_TOPIC'	=> 'Jūs pasirinkote temą numeris %d: %s.',

	'report_reasons'	=> array(

		'TITLE'	=> array(
			'WAREZ'	=> 'Nelegali programinė įranga',
			'SPAM'	=> 'Internetinės šiukšlės (spam)',
			'OFF_TOPIC'	=> 'Neatitinka temos',
			'OTHER'	=> 'Kita',
		),


		'DESCRIPTION'	=> array(
			'WAREZ'	=> 'Pranešime yra nuorodų į nelegalę arba piratinę programinę įrangą.',
			'SPAM'	=> 'Vienintelis pranešimo tikslas - reklamuoti puslapį arba kitą produktą.',
			'OFF_TOPIC'	=> 'Pranešimo turinys neatitinka temos.',
			'OTHER'	=> 'Pranešimas neatitinka nei vienos iš šių kategorijų. Užpildykite aprašymo laukelį.',
		),

	),

));

?>