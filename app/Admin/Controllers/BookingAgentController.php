<?php

namespace App\Admin\Controllers;

use \App\Models\BookingAgent;
use App\Models\Destination;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class BookingAgentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'BookingAgent';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BookingAgent());

        $grid->column('id', __('Id'));
        $grid->column('first_name', __('First Name'));
        $grid->column('middle_name', __('Middle Name'));
        $grid->column('last_name', __('Last Name'));
        $grid->column('ticket', __('Invoice'));
        $grid->column('ticket_number', __('Ticket Number'));
        $grid->column('airline', __('Airline'));
        $grid->column('destination_id', __('Destination'));
        $grid->column('departure_id', __('Departure'));
        $grid->column('start_date', __('Start Date'));
        $grid->column('end_date', __('End Date'));
        $grid->column('invoice_number', __('Invoice Number'));
        $grid->column('Mode of Payment', __('Mode of Payment'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(BookingAgent::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('first_name', __('First Name'));
        $show->field('middle_name', __('Middle Name'));
        $show->field('last_name', __('Last Name'));
        $show->field('ticket', __('Invoice'));
        $show->field('ticket_number', __('Ticket Number'));
        $show->field('airline', __('Airline'));
        $show->field('destination_id', __('Destination'));
        $show->field('departure_id', __('Departure'));
        $show->field('start_date', __('Start Date'));
        $show->field('end_date', __('End Date'));
        $show->field('invoice_number', __('Invoice Number'));
        $show->field('Mode of Payment', __('Mode of Payment'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new BookingAgent());

        $form->text('first_name', __('First Name'));
        $form->text('middle_name', __('Middle Name'));
        $form->text('last_name', __('Last Name'));
        $form->file('ticket', __('Invoice'));
        $form->text('ticket_number', __('Ticket Number'));
        $form->text('airline', __('Airline'));
        $form->select('destination_id', __('Destination'))->options(Destination::all()->pluck('name','id'));
        $form->select('departure_id', __('Departure'))->options(Destination::all()->pluck('name','id'));
        $form->date('start_date', __('Start Date'));
        $form->date('end_date', __('End Date'));
        $form->text('invoice_number', __('Invoice Number'));
        $form->text('Mode of Payment', __('Mode of Payment'));

        return $form;
    }
}
