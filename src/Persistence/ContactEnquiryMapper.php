<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Persistence;

use Dms\Common\Structure\DateTime\Persistence\DateTimeMapper;
use Dms\Common\Structure\Web\Persistence\EmailAddressMapper;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\EntityMapper;
use Dms\Package\ContactUs\Core\ContactEnquiry;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ContactEnquiryMapper extends EntityMapper
{
    /**
     * Defines the entity mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(ContactEnquiry::class);
        $map->toTable('contact_enquiries');

        $map->idToPrimaryKey('id');

        $map->embedded(ContactEnquiry::EMAIL)->using(new EmailAddressMapper('email'));
        $map->property(ContactEnquiry::NAME)->to('name')->asVarchar(255);
        $map->property(ContactEnquiry::SUBJECT)->to('subject')->asVarchar(255);
        $map->property(ContactEnquiry::MESSAGE)->to('message')->asVarchar(8000);
        $map->embedded(ContactEnquiry::CREATED_AT)->using(new DateTimeMapper('created_at'));
    }
}