<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Persistence;

use Dms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Dms\Core\Persistence\Db\Mapping\Orm;
use Dms\Package\ContactUs\Core\ContactEnquiry;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ContactUsOrm extends Orm
{
    /**
     * Defines the object mappers registered in the orm.
     *
     * @param OrmDefinition $orm
     *
     * @return void
     */
    protected function define(OrmDefinition $orm)
    {
        $orm->entities([
            ContactEnquiry::class => ContactEnquiryMapper::class,
        ]);
    }
}