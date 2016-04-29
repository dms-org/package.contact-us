<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Persistence;

use Dms\Core\Persistence\Db\Connection\IConnection;
use Dms\Core\Persistence\Db\Mapping\IOrm;
use Dms\Core\Persistence\DbRepository;
use Dms\Package\ContactUs\Core\ContactEnquiry;
use Dms\Package\ContactUs\Core\IContactEnquiryRepository;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DbContactEnquiryRepository extends DbRepository implements IContactEnquiryRepository
{
    public function __construct(IConnection $connection, IOrm $orm)
    {
        parent::__construct($connection, $orm->getEntityMapper(ContactEnquiry::class));
    }
}