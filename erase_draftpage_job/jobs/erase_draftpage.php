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
        $pageDrafts = Concrete\Core\Page\Page::getDrafts();
        foreach ($pageDrafts as $pageDraft) {
            $q->send($pageDraft->getCollectionID());
        }
    }

    public function processQueueItem(ZendQueueMessage $msg)
    {
        try {
            $pageDraft = Page::getByID($msg->body);
            if (is_object($pageDraft)) {
                $pageDraft->moveToTrash();
            } else {
                throw new Exception(t('Error occurred while getting the Page object of pID: %s', $msg->body));
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function finish(ZendQueue $q)
    {
        return t('Erase Draftpage.');
    }
}
