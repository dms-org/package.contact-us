<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Cms;

use Dms\Core\ICms;
use Dms\Core\Ioc\IIocContainer;
use Dms\Core\Package\Definition\PackageDefinition;
use Dms\Core\Package\Package;
use Dms\Package\ContactUs\Core\IContactEnquiryRepository;
use Dms\Package\ContactUs\Persistence\DbContactEnquiryRepository;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ContactUsPackage extends Package
{
    /**
     * @param ICms $cms
     *
     * @return void
     */
    public static function boot(ICms $cms)
    {
        $cms->getIocContainer()->bind(IIocContainer::SCOPE_SINGLETON, IContactEnquiryRepository::class, DbContactEnquiryRepository::class);
    }

    /**
     * Defines the structure of this cms package.
     *
     * @param PackageDefinition $package
     *
     * @return void
     */
    protected function define(PackageDefinition $package)
    {
        $package->name('contact-us');

        $package->metadata([
            'icon' => 'question-circle',
        ]);

        $package->modules([
            'contact-enquiries' => ContactEnquiryModule::class,
        ]);
    }
}