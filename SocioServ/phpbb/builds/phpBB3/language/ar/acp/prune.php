<?php
/** 
*
* acp_prune.php [Arabic]
*
* @package language
* @version $Id: prune.php,v 1.13 2007/05/11 12:25:28 acydburn Exp $
* @copyright (c) 2007 phpBB Group 
* @author 2007-06-17 - phpBBegypt.com
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
	'ACP_PRUNE_USERS_EXPLAIN'	=> 'هنا تستطيع حذف أو تعطيل الأعضاء من منتداك. يمكنك أفعل هذا بطرق عديدة, عن طريق عدد المشاركات أو آخر نشاط وغيرها. كل هذه المعايير يمكن الجمع بينها, مثال : تستطيع تهذيب الأعضاء الذين كانت آخر مشاركة لهم قبل 01-01-2002 ومشاركاتهم أقل من 10 مشاركات. كبديل تستطيع إدخال قائمة من الأعضاء مباشرة إلى صندوق النص, حيث سيتم تجاهل أي معايير تم إدخالها. كن حذراً عند استخدام هذه الخاصية! فبمجرد حذف العضو لن تكون هناك طريقة لاسترجاعه',
	
	'DEACTIVATE_DELETE'	=> 'تعطيل أو حذف',
	'DEACTIVATE_DELETE_EXPLAIN'	=> 'اختر ما إذا كنت تريد حذف الأعضاء أو فقط تعطيل حساباتهم, تذكر أنه لا يمكن التراجع عن هذه العملية !',
	'DELETE_USERS'	=> 'حذف',
	'DELETE_USER_POSTS'	=> 'حذف مشاركات الأعضاء المحذوفين',
	'DELETE_USER_POSTS_EXPLAIN'	=> 'حذف المشاركات المكتوبة بواسطة الأعضاء المحذوفين, لا يوجد أي تأثير على الأعضاء المعطلة حساباتهم.',
	
	'JOINED_EXPLAIN'	=> 'أدخل التاريخ على شكل <kbd>YYYY-MM-DD</kbd> .',
	
	'LAST_ACTIVE_EXPLAIN'	=> 'أدخل التاريخ على شكل <kbd>YYYY-MM-DD</kbd> .',
	
	'PRUNE_USERS_LIST'	=> 'الأعضاء الذين سيتم تهذيبهم',
	'PRUNE_USERS_LIST_DELETE'	=> 'باستعمال المعايير المحددة لتهذيب الأعضاء سيتم حذف الحسابات التالية.',
	'PRUNE_USERS_LIST_DEACTIVATE'	=> 'باستعمال المعايير المحددة لتهذيب الأعضاء سيتم تعطيل الحسابات التالية.',
	
	'SELECT_USERS_EXPLAIN'	=> 'قم بإدخال أسماء المستخدمين هنا, سيتم استخدامهم بدلاً من المعيير أعلاه.',
	
	'USER_DEACTIVATE_SUCCESS'	=> 'تم تعطيل الأعضاء المحددين بنجاح.',
	'USER_DELETE_SUCCESS'	=> 'تم حذف الأعضاء المحددين بنجاح.',
	'USER_PRUNE_FAILURE'	=> 'لا يوجد أعضاء يطابقون المعايير المدخلة.',
	
	'WRONG_ACTIVE_JOINED_DATE'	=> 'التاريخ الذي أدخلته خاطئ, يجب أن يكون على شكل <kbd>YYYY-MM-DD</kbd>.',
));

// Forum Pruning
$lang = array_merge($lang, array(
	'ACP_PRUNE_FORUMS_EXPLAIN'	=> 'هذه ستقوم بحذف أي موضوع لم يتم المشاركة فيه أو مشاهدته بدئاً من عدد الأيام التي ستحددها إذا لم تقم بإدخال أي رقم فسيتم حذف جميع المواضيع. افتراضياً لن يتم حذف مواضيع الاستفتاءات التي لا زالت نشطة، ولن تحذف المواضيع المثبتة والإعلانات.',
	
	'FORUM_PRUNE'	=> 'تهذيب المنتدى',
	
	'NO_PRUNE'	=> 'لم يتم تهذيب المنتديات.',
	'SELECTED_FORUM'	=> 'المنتدى المحدد',
	'SELECTED_FORUMS'	=> 'المنتديات المحددة',
	
	'POSTS_PRUNED'	=> 'المشاركات المهذبة',
	'PRUNE_ANNOUNCEMENTS'	=> 'تهذيب الإعلانات',
	'PRUNE_FINISHED_POLLS'	=> 'تهذيب مواضيع الاستفتاءات المغلقة',
	'PRUNE_FINISHED_POLLS_EXPLAIN'	=> 'تهذيب مواضيع الاستفتاءات المنتهية.',
	'PRUNE_FORUM_CONFIRM'	=> 'هل أنت متأكد من أنك تريد تهذيب المنتديات المحددة بإستخدام هذه المعايير؟ بمجرد حذفها, لن تكون هناك طريقة لاستعادة المواضيع والمشاركات التي تم تهذيبها.',
	'PRUNE_NOT_POSTED'	=> 'الأيام منذ آخر مشاركة',
	'PRUNE_NOT_VIEWED'	=> 'الأيام منذ آخر مشاهدة',
	'PRUNE_OLD_POLLS'	=> 'تهذيب الاستفتاءات القديمة',
	'PRUNE_OLD_POLLS_EXPLAIN'	=> 'تهذيب مواضيع الاستفتاء التي لم يتم التصويت عليها بعد مرور الأيام المسموح بها.',
	'PRUNE_STICKY'	=> 'تهذيب المواضيع المثبتة',
	'PRUNE_SUCCESS'	=> 'تم تهذيب المنتديات بنجاح.',
	
	'TOPICS_PRUNED'	=> 'المواضيع المهذبة',
));

?>