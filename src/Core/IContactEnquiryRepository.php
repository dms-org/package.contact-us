<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Core;

use Dms\Core\Exception;
use Dms\Core\Model\ICriteria;
use Dms\Core\Model\ISpecification;
use Dms\Core\Persistence\IRepository;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
interface IContactEnquiryRepository extends IRepository
{
    /**
     * {@inheritDoc}
     *
     * @return ContactEnquiry[]
     */
    public function getAll() : array;

    /**
     * {@inheritDoc}
     *
     * @return ContactEnquiry
     */
    public function get($id);

    /**
     * {@inheritDoc}
     *
     * @return ContactEnquiry[]
     */
    public function getAllById(array $ids) : array;

    /**
     * {@inheritDoc}
     *
     * @return ContactEnquiry|null
     */
    public function tryGet($id);

    /**
     * {@inheritDoc}
     *
     * @return ContactEnquiry[]
     */
    public function tryGetAll(array $ids) : array;

    /**
     * {@inheritDoc}
     *
     * @return ContactEnquiry[]
     */
    public function matching(ICriteria $criteria) : array;

    /**
     * {@inheritDoc}
     *
     * @return ContactEnquiry[]
     */
    public function satisfying(ISpecification $specification) : array;
}
