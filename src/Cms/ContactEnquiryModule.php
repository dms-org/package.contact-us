<?php declare(strict_types = 1);

namespace Dms\Package\ContactUs\Cms;

use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\Field;
use Dms\Core\Auth\IAuthSystem;
use Dms\Core\Common\Crud\CrudModule;
use Dms\Core\Common\Crud\Definition\CrudModuleDefinition;
use Dms\Core\Common\Crud\Definition\Form\CrudFormDefinition;
use Dms\Core\Common\Crud\Definition\Table\SummaryTableDefinition;
use Dms\Core\Table\Builder\Column;
use Dms\Core\Util\IClock;
use Dms\Package\ContactUs\Core\ContactEnquiry;
use Dms\Package\ContactUs\Core\IContactEnquiryRepository;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ContactEnquiryModule extends CrudModule
{
    /**
     * @var IClock
     */
    private $clock;

    public function __construct(IContactEnquiryRepository $dataSource, IAuthSystem $authSystem, IClock $clock)
    {
        $this->clock = $clock;
        parent::__construct($dataSource, $authSystem);
    }

    /**
     * Defines the structure of this module.
     *
     * @param CrudModuleDefinition $module
     */
    protected function defineCrudModule(CrudModuleDefinition $module)
    {
        $module->name('contact-enquiries');

        $module->metadata([
            'icon' => 'comment',
        ]);

        $module->labelObjects()->fromCallback(function (ContactEnquiry $contactEnquiry) {
            return $contactEnquiry->name . ' (' . $contactEnquiry->email->asString() . ') - ' . $contactEnquiry->createdAt->format(Date::DISPLAY_FORMAT);
        });

        $module->crudForm(function (CrudFormDefinition $form) {
            $form->section('Details', [
                $form->field(
                    Field::create('email', 'Email')->email()->required()
                )->bindToProperty(ContactEnquiry::EMAIL),
                //
                $form->field(
                    Field::create('name', 'Name')->string()->required()
                )->bindToProperty(ContactEnquiry::NAME),
                //
                $form->field(
                    Field::create('subject', 'Subject')->string()->required()
                )->bindToProperty(ContactEnquiry::SUBJECT),
                //
                $form->field(
                    Field::create('message', 'Message')->string()->multiline()->required()
                )->bindToProperty(ContactEnquiry::MESSAGE),
            ]);

            if ($form->isCreateForm()) {
                $form->onSubmit(function (ContactEnquiry $contactEnquiry) {
                    $contactEnquiry->createdAt = new DateTime($this->clock->utcNow());
                });
            } else {
                $form->continueSection([
                    $form->field(
                        Field::create('created_at', 'Created At')->dateTime()->required()->readonly()
                    )->bindToProperty(ContactEnquiry::CREATED_AT),
                ]);
            }
        });

        $module->removeAction()->deleteFromDataSource();

        $module->summaryTable(function (SummaryTableDefinition $table) {
            $table->column(Column::name('from')->label('From')->components([
                Field::create('name', 'Name')->string(),
                Field::create('email', 'Email')->email(),
            ]));

            $table->mapProperty(ContactEnquiry::EMAIL)->toComponent('from.email');
            $table->mapProperty(ContactEnquiry::NAME)->toComponent('from.name');
            $table->mapProperty(ContactEnquiry::CREATED_AT)->to(Field::create('created_at', 'Created At')->dateTime());

            $table->view('all', 'All')
                ->asDefault()
                ->loadAll()
                ->orderByDesc('created_at');
        });
    }
}