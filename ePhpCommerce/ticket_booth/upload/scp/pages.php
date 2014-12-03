<?php
/*********************************************************************
    pages.php

    Site pages.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('admin.inc.php');
require_once(INCLUDE_DIR.'class.page.php');

$page = null;
if($_REQUEST['id'] && !($page=Page::lookup($_REQUEST['id'])))
   $errors['err']=sprintf(__('%s: Unknown or invalid'), __('site page'));

if($_POST) {
    switch(strtolower($_POST['do'])) {
        case 'add':
            if(($pageId=Page::create($_POST, $errors))) {
                $_REQUEST['a'] = null;
                $msg=sprintf(__('Successfully added %s'), Format::htmlchars($_POST['name']));
                // Attach inline attachments from the editor
                if ($page = Page::lookup($pageId))
                    $page->attachments->upload(
                        Draft::getAttachmentIds($_POST['body']), true);
                Draft::deleteForNamespace('page');
            } elseif(!$errors['err'])
                $errors['err'] = sprintf(__('Unable to add %s. Correct error(s) below and try again.'),
                    __('this site page'));
        break;
        case 'update':
            if(!$page)
                $errors['err'] = sprintf(__('%s: Invalid or unknown'),
                    __('site page'));
            elseif($page->update($_POST, $errors)) {
                $msg=sprintf(__('Successfully updated %s'),
                    __('this site page'));
                $_REQUEST['a']=null; //Go back to view
                // Attach inline attachments from the editor
                $page->attachments->deleteInlines();
                $page->attachments->upload(
                    Draft::getAttachmentIds($_POST['body']),
                    true);
                Draft::deleteForNamespace('page.'.$page->getId());
            } elseif(!$errors['err'])
                $errors['err'] = sprintf(__('Unable to update %s. Correct error(s) below and try again.'),
                    __('this site page'));
            break;
        case 'mass_process':
            if(!$_POST['ids'] || !is_array($_POST['ids']) || !count($_POST['ids'])) {
                $errors['err'] = sprintf(__('You must select at least %s.'),
                    __('one site page'));
            } elseif(array_intersect($_POST['ids'], $cfg->getDefaultPages()) && strcasecmp($_POST['a'], 'enable')) {
                $errors['err'] = sprintf(__('One or more of the %s is in-use and CANNOT be disabled/deleted.'),
                    _N('selected site page', 'selected site pages', 2));
            } else {
                $count=count($_POST['ids']);
                switch(strtolower($_POST['a'])) {
                    case 'enable':
                        $sql='UPDATE '.PAGE_TABLE.' SET isactive=1 '
                            .' WHERE id IN ('.implode(',', db_input($_POST['ids'])).')';
                        if(db_query($sql) && ($num=db_affected_rows())) {
                            if($num==$count)
                                $msg = sprintf(__('Successfully enabled %s'),
                                    _N('selected site page', 'selected site pages', $count));
                            else
                                $warn = sprintf(__('%1$d of %2$d %3$s enabled'), $num, $count,
                                    _N('selected site page', 'selected site pages', $count));
                        } else {
                            $errors['err'] = sprintf(__('Unable to enable %s'),
                                _N('selected site page', 'selected site pages', $count));
                        }
                        break;
                    case 'disable':
                        $i = 0;
                        foreach($_POST['ids'] as $k=>$v) {
                            if(($p=Page::lookup($v)) && $p->disable())
                                $i++;
                        }

                        if($i && $i==$count)
                            $msg = sprintf(__('Successfully disabled %s'),
                                _N('selected site page', 'selected site pages', $count));
                        elseif($i>0)
                            $warn = sprintf(__('%1$d of %2$d %3$s disabled'), $i, $count,
                                _N('selected site page', 'selected site pages', $count));
                        elseif(!$errors['err'])
                            $errors['err'] = sprintf(__('Unable to disable %s'),
                                _N('selected site page', 'selected site pages', $count));
                        break;
                    case 'delete':
                        $i=0;
                        foreach($_POST['ids'] as $k=>$v) {
                            if(($p=Page::lookup($v)) && $p->delete())
                                $i++;
                        }

                        if($i && $i==$count)
                            $msg = sprintf(__('Successfully deleted %s'),
                                _N('selected site page', 'selected site pages', $count));
                        elseif($i>0)
                            $warn = sprintf(__('%1$d of %2$d %3$s deleted'), $i, $count,
                                _N('selected site page', 'selected site pages', $count));
                        elseif(!$errors['err'])
                            $errors['err'] = sprintf(__('Unable to delete %s'),
                                _N('selected site page', 'selected site pages', $count));
                        break;
                    default:
                        $errors['err']=__('Unknown action - get technical help.');
                }
            }
            break;
        default:
            $errors['err']=__('Unknown action');
            break;
    }
}

$inc='pages.inc.php';
$tip_namespace = 'manage.pages';
if($page || $_REQUEST['a']=='add') {
    $inc='page.inc.php';
}

$nav->setTabActive('manage');
$ost->addExtraHeader('<meta name="tip-namespace" content="' . $tip_namespace . '" />',
    "$('#content').data('tipNamespace', '".$tip_namespace."');");
require_once(STAFFINC_DIR.'header.inc.php');
require_once(STAFFINC_DIR.$inc);
require_once(STAFFINC_DIR.'footer.inc.php');
?>
