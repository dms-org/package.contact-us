<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Tests\Core;

use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Persistence\ArrayRepository;
use Dms\Core\Util\DateTimeClock;
use Dms\Package\ContactUs\Core\ContactEnquiry;
use Dms\Package\ContactUs\Core\ContactEnquiryService;
use Dms\Package\ContactUs\Core\IContactEnquiryRepository;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ContactEnquiryServiceTest extends CmsTestCase
{
    /**
     * @var IContactEnquiryRepository
     */
    protected $repo;

    /**
     * @var ContactEnquiryService
     */
    protected $service;

    protected function setUp()
    {
        parent::setUp();

        $this->repo = new class(ContactEnquiry::collection()) extends ArrayRepository implements IContactEnquiryRepository
        {
        };

        $this->service = new ContactEnquiryService(
            $this->repo, new DateTimeClock()
        );
    }

    public function testRecordEnquiry()
    {
        $called = false;

        $enquiry = $this->service->recordEnquiry(
            'some@mail.com', 'Some Guy', 'Subject', 'Message',
            function (ContactEnquiry $enquiry) use (&$called) {
                $called = true;

                $this->assertNotNull($enquiry->getId());
                $this->assertSame('some@mail.com', $enquiry->email->asString());
                $this->assertSame('Some Guy', $enquiry->name);
                $this->assertSame('Subject', $enquiry->subject);
                $this->assertSame('Message', $enquiry->message);
            }
        );

        $this->assertSame($enquiry, $this->repo->get(1));

        $this->assertSame(true, $called);
        $this->assertNotNull($enquiry->getId());
        $this->assertSame('some@mail.com', $enquiry->email->asString());
        $this->assertSame('Some Guy', $enquiry->name);
        $this->assertSame('Subject', $enquiry->subject);
        $this->assertSame('Message', $enquiry->message);
    }
}