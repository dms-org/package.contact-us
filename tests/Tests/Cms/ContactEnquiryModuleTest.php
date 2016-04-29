<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Tests\Cms;

use Dms\Common\Structure\Web\EmailAddress;
use Dms\Core\Auth\IPermission;
use Dms\Core\Auth\Permission;
use Dms\Core\Common\Crud\ICrudModule;
use Dms\Core\Model\IMutableObjectSet;
use Dms\Core\Persistence\ArrayRepository;
use Dms\Core\Tests\Common\Crud\Modules\CrudModuleTest;
use Dms\Core\Tests\Module\Mock\MockAuthSystem;
use Dms\Core\Util\DateTimeClock;
use Dms\Package\ContactUs\Cms\ContactEnquiryModule;
use Dms\Package\ContactUs\Core\ContactEnquiry;
use Dms\Package\ContactUs\Core\IContactEnquiryRepository;

/**
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ContactEnquiryModuleTest extends CrudModuleTest
{
    /**
     * @return IMutableObjectSet
     */
    protected function buildRepositoryDataSource() : IMutableObjectSet
    {
        return new class(ContactEnquiry::collection()) extends ArrayRepository implements IContactEnquiryRepository
        {

        };
    }

    /**
     * @param IMutableObjectSet $dataSource
     * @param MockAuthSystem    $authSystem
     *
     * @return ICrudModule
     */
    protected function buildCrudModule(IMutableObjectSet $dataSource, MockAuthSystem $authSystem) : ICrudModule
    {
        return new ContactEnquiryModule($dataSource, $authSystem, new DateTimeClock());
    }

    /**
     * @return string
     */
    protected function expectedName()
    {
        return 'contact-enquiries';
    }

    /**
     * @return IPermission[]
     */
    protected function expectedReadModulePermissions()
    {
        return [
            Permission::named(ICrudModule::EDIT_PERMISSION),
            Permission::named(ICrudModule::CREATE_PERMISSION),
            Permission::named(ICrudModule::REMOVE_PERMISSION),
        ];
    }

    /**
     * @return IPermission[]
     */
    protected function expectedReadModuleRequiredPermissions()
    {
        return [
            Permission::named(ICrudModule::VIEW_PERMISSION),
        ];
    }

    public function testCreate()
    {
        $this->module->getCreateAction()->run([
            'name'    => 'Some Guy',
            'email'   => 'some@email.com',
            'subject' => 'The Subject',
            'message' => 'The Message',
        ]);

        $this->assertCount(1, $this->dataSource);

        /** @var ContactEnquiry $enquiry */
        $enquiry = $this->dataSource->get(1);

        $this->assertEquals('Some Guy', $enquiry->name);
        $this->assertEquals('some@email.com', $enquiry->email->asString());
        $this->assertEquals('The Subject', $enquiry->subject);
        $this->assertEquals('The Message', $enquiry->message);
    }

    public function testEdit()
    {
        $enquiry = new ContactEnquiry(new DateTimeClock(), new EmailAddress('some@mail.com'), 'Existing', 'Subject', 'Abc');
        $this->dataSource->save($enquiry);

        $this->module->getEditAction()->run([
            'object'  => 1,
            'name'    => 'Some Guy',
            'email'   => 'some@email.com',
            'subject' => 'The Subject',
            'message' => 'The Message',
        ]);

        $this->assertCount(1, $this->dataSource);

        /** @var ContactEnquiry $enquiry */
        $enquiry = $this->dataSource->get(1);

        $this->assertEquals('Some Guy', $enquiry->name);
        $this->assertEquals('some@email.com', $enquiry->email->asString());
        $this->assertEquals('The Subject', $enquiry->subject);
        $this->assertEquals('The Message', $enquiry->message);
    }
}