<?php
/** 
*
* acp_database.php [Arabic]
*
* @package language
* @version $Id: database.php,v 1.22 2007/06/09 11:10:23 acydburn Exp $
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
	'ACP_BACKUP_EXPLAIN'	=> 'هنا تستطيع أخد نسخة احتياطية من جميع المحتويات المتعلقة بـ phpBB . تستطيع تخزين أرشيف النتائج في مجلد <samp>store/</samp> أو القيام بتحميلها مباشرة . تبعاً لإعدادات السيرفر لديك تستطيع ضغط الملف على عدة أشكال',
	'ACP_RESTORE_EXPLAIN'	=> 'هذه الصفحة تساعدك في عمل استعادة كاملة لجميع جداول phpBB من الملف المحفوظ . إذا كان السيرفر الخاص بك يدعم ضغط الملفات ستستطيع رفع ملف نصي مضغوط بصيغة gzip أو bzip2 وسيتم إلغاء الضغط تلقائياً . <strong>تحذير</strong> سيؤدي هذا إلى الكتابة فوق البيانات الحالية. الاستعادة قد تأخد وقتاً طويلاً، رجاءاً لا تقم بإغلاق الصفحة إلى حين الانتهاء من العملية. النسخ الاحتياطية يتم تخزينها في مجلد <samp>store/</samp> ويفترض بها أن تكون متولدة عن طريق خاصية النسخ الاحتياطي في phpBB . محاولة استرجاع نسخة احتياطية متولدة بواسطة نظام آخر قد ينجح وقد لا ينجح.',
	
	'BACKUP_DELETE'	=> 'تم حذف ملف النسخة الاحتياطية لقاعدة البيانات بنجاح',
	'BACKUP_INVALID'	=> 'الملف المحدد للإستعادة غير صحيح',
	'BACKUP_OPTIONS'	=> 'خيارات النسخ الاحتياطي',
	'BACKUP_SUCCESS'	=> 'تم إنشاء ملف النسخة الاحتياطية لقاعدة البيانات بنجاح',
	'BACKUP_TYPE'	=> 'نوع النسخ الاحتياطي',
	
	'DATABASE'	=> 'أدوات قاعدة البيانات',
	'DATA_ONLY'	=> 'المحتويات فقط',
	'DELETE_BACKUP'	=> 'حذف النسخة الاحتياطية',
	'DELETE_SELECTED_BACKUP'	=> 'هل أنت متأكد من أنك تريد حذف ملف النسخة الاحتياطية المحدد ؟',
	'DESELECT_ALL'	=> 'إلغاء تحديد الكل',
	'DOWNLOAD_BACKUP'	=> 'تحميل النسخة الاحتياطية',
	
	'FILE_TYPE'	=> 'نوع الملف',
	'FULL_BACKUP'	=> 'كامل',
	
	'RESTORE_FAILURE'	=> 'قد يكون ملف النسخة الاحتياطية معطوباً',
	'RESTORE_OPTIONS'	=> 'خيارات الاستعادة',
	'RESTORE_SUCCESS'	=> 'تم استعادة قاعدة البيانات بنجاح<br /><br />يجدر بمنتداك الآن العودة إلى الحالة التي كان عليها عندما تم أخد النسخة الاحتياطية',
	
	'SELECT_ALL'	=> 'تحديد الكل',
	'SELECT_FILE'	=> 'اختيار ملف',
	'START_BACKUP'	=> 'ابدأ بأخد نسخة احتياطية',
	'START_RESTORE'	=> 'ابدأ الاستعادة',
	'STORE_AND_DOWNLOAD'	=> 'تخزين وتحميل',
	'STORE_LOCAL'	=> 'تخزين الملفات محلياً',
	'STRUCTURE_ONLY'	=> 'البنية فقط',
	
	'TABLE_SELECT'	=> 'تحديد جدول',
	'TABLE_SELECT_ERROR'	=> 'يجب عليك اختيار جدول واحد على الأقل',
));

?>