<?php

namespace Concrete\Package\EraseDraftpageJob\Job;

use QueueableJob;
use ZendQueue\Queue as ZendQueue;
use ZendQueue\Message as ZendQueueMessage;
use Exception;
use Concrete\Core\Page\Page;

class EraseDraftpage extends QueueableJob
{
    public $jSupportsQueue = true;

    protected $files;

    public function getJobName()
    {
        return t('Erase Draft Pages');
    }

    public function getJobDescription()
    {
        return t('The job will erase all draft pages. It would be useful for those who ended up having too many draft pages.');
    }

    public function start(ZendQueue $q)
    {
        $pageDrafts = Page::getDrafts();
        foreach ($pageDrafts as $pageDraft) {
            $q->send($pageDraft->getCollectionID());
        }
    }

    public function processQueueItem(ZendQueueMessage $msg)
    {
        try {
            $pageDraft = Page::getByID($msg->body);
            if ($pageDraft->isPageDraft()) {
                $pageDraft->delete();
            } else {
                throw new Exception(t('Error occurred while getting the Page object of pID: %s', $msg->body));
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function finish(ZendQueue $q)
    {
        return t('Finished erasing draft pages.');
    }
}
