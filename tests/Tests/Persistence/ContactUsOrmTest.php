<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Tests\Persistence;

use Dms\Common\Structure\Web\EmailAddress;
use Dms\Core\Exception\NotImplementedException;
use Dms\Core\Persistence\Db\Mapping\IOrm;
use Dms\Core\Tests\Persistence\Db\Integration\Mapping\DbIntegrationTest;
use Dms\Core\Util\IClock;
use Dms\Package\ContactUs\Core\ContactEnquiry;
use Dms\Package\ContactUs\Persistence\ContactUsOrm;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ContactUsOrmTest extends DbIntegrationTest
{

    /**
     * @return IOrm
     */
    protected function loadOrm()
    {
        return new ContactUsOrm();
    }

    public function testSaveAndLoad()
    {
        $clock = new class implements IClock
        {
            public function now() : \DateTimeImmutable
            {
                throw new NotImplementedException;
            }

            public function utcNow() : \DateTimeImmutable
            {
                return new \DateTimeImmutable('2000-01-01 00:00:00');
            }
        };

        $enquiry = new ContactEnquiry($clock, new EmailAddress('some@email.com'), 'Some Guy', 'The Subject', 'The Message');
        $this->repo->save($enquiry);

        $this->assertDatabaseDataSameAs([
            'contact_enquiries' => [
                [
                    'id'         => 1,
                    'email'      => 'some@email.com',
                    'name'       => 'Some Guy',
                    'subject'    => 'The Subject',
                    'message'    => 'The Message',
                    'created_at' => '2000-01-01 00:00:00',
                ],
            ],
        ]);

        $this->assertEquals($enquiry, $this->repo->get(1));
    }
}