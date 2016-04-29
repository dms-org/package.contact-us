<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Core;
use Dms\Common\Structure\Web\EmailAddress;
use Dms\Core\Util\IClock;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ContactEnquiryService
{
    /**
     * @var IContactEnquiryRepository
     */
    protected $repository;

    /**
     * @var IClock
     */
    protected $clock;

    /**
     * ContactEnquiryService constructor.
     *
     * @param IContactEnquiryRepository $repository
     * @param IClock                    $clock
     */
    public function __construct(IContactEnquiryRepository $repository, IClock $clock)
    {
        $this->repository = $repository;
        $this->clock      = $clock;
    }

    /**
     * Records an contact enquiry.
     *
     * @param string   $email
     * @param string   $name
     * @param string   $subject
     * @param string   $message
     * @param callable $sendMailToAdminCallback
     *
     * @return ContactEnquiry
     */
    public function recordEnquiry(string $email, string $name, string $subject, string $message, callable $sendMailToAdminCallback) : ContactEnquiry
    {
        $enquiry = new ContactEnquiry(
            $this->clock, new EmailAddress($email), $name, $subject, $message
        );

        $this->repository->save($enquiry);

        $sendMailToAdminCallback($enquiry);

        return $enquiry;
    }
}