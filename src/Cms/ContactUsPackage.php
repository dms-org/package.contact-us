<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Cms;

use Dms\Core\Package\Definition\PackageDefinition;
use Dms\Core\Package\Package;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ContactUsPackage extends Package
{

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