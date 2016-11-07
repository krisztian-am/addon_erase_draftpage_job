<?php
namespace Concrete\Package\EraseDraftpageJob;

use Concrete\Core\Package\Package;
use Job;

class Controller extends Package
{
    protected $pkgHandle = 'erase_draftpage_job';
    protected $appVersionRequired = '5.7.4.2';
    protected $pkgVersion = '0.0.1';
    protected $pkgAutoloaderMapCoreExtensions = true;

    public function getPackageDescription()
    {
        return t('Add Erase Draftpage Job');
    }

    public function getPackageName()
    {
        return t('Erase Draftpage');
    }

    public function install()
    {
        $pkg = parent::install();
        $this->installJobs($pkg);
    }
    public function upgrade()
    {
        $pkg = parent::upgrade();
        $this->installJobs($pkg);
    }

    protected function installJobs($pkg)
    {
        $jobHandle = 'erase_draftpage';
        $job = Job::getByHandle($jobHandle);
        if (!is_object($job)) {
            Job::installByPackage($jobHandle, $pkg);
        }
    }
}
