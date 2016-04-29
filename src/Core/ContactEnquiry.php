<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Core;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\Web\EmailAddress;
use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\Entity;
use Dms\Core\Util\IClock;

/**
 * The contact enquiry entity
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ContactEnquiry extends Entity
{
    const EMAIL = 'email';
    const NAME = 'name';
    const SUBJECT = 'subject';
    const MESSAGE = 'message';
    const CREATED_AT = 'createdAt';
    
    /**
     * @var EmailAddress
     */
    public $email;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $message;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * ContactEnquiry constructor.
     *
     * @param IClock       $clock
     * @param EmailAddress $email
     * @param string       $name
     * @param string       $subject
     * @param string       $message
     */
    public function __construct(IClock $clock, EmailAddress $email, $name, $subject, $message)
    {
        parent::__construct();

        $this->email     = $email;
        $this->name      = $name;
        $this->subject   = $subject;
        $this->message   = $message;
        $this->createdAt = new DateTime($clock->utcNow());
    }

    /**
     * Defines the structure of this entity.
     *
     * @param ClassDefinition $class
     */
    protected function defineEntity(ClassDefinition $class)
    {
        $class->property($this->email)->asObject(EmailAddress::class);
        
        $class->property($this->name)->asString();

        $class->property($this->subject)->asString();

        $class->property($this->message)->asString();

        $class->property($this->createdAt)->asObject(DateTime::class);
    }
}