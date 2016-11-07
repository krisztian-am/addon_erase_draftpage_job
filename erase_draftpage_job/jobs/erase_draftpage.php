<?php

namespace Concrete\Package\EraseDraftpageJob\Job;

use QueueableJob;
use ZendQueue\Queue as ZendQueue;
use ZendQueue\Message as ZendQueueMessage;
use Exception;
use File;
use FileList;

class EraseDraftpage extends QueueableJob
{
    public $jSupportsQueue = true;

    protected $files;

    public function getJobName()
    {
        return t('Erase Draftpage');
    }

    public function getJobDescription()
    {
        return t('Erase Draftpage.');
    }

    public function start(ZendQueue $q)
    {
        $list = new \Concrete\Core\Page\PageList();
        $list->includeInactivePages();
        $pages = $list->getResults();
    }

    public function processQueueItem(ZendQueueMessage $msg)
    {
        // try {
        //     $f = File::getbyID($msg->body);
        //     if (is_object($f)) {
        //         $fv = $f->getApprovedVersion();
        //         if (is_object($fv)) {
        //             $fv->refreshAttributes();
        //         } else {
        //             throw new Exception(t('Error occurred while getting the file version object of fID: %s', $msg->body));
        //         }
        //     } else {
        //         throw new Exception(t('Error occurred while getting the file object of fID: %s', $msg->body));
        //     }
        // } catch (Exception $e) {
        //     return false;
        // }
    }

    public function finish(ZendQueue $q)
    {
        return t('Draftpage Delete.');
    }
}
