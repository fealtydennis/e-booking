<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Approve;
use App\Admin\Actions\Decline;
use \App\Models\Booking;
use App\Models\Destination;
use App\Models\Employee;
use App\Notifications\BookingNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use OpenAdmin\Admin\Admin;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class BookingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Booking';


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Booking());

//        $grid->column('id', __('Id'));
        $grid->column('employee.employee_number', __('Employee Number'));
        $grid->column('employee.first_name', 'First Name');
        $grid->column('employee.last_name', 'Last Name');
        $grid->column('reason', __('Reason'));
        $grid->column('status', __('Status'));
        $grid->column('destination.name', __('Departure id'));
        $grid->column('destination.name', __('Destination id'));
        $grid->column('total_days', __('Total days'));
        $grid->column('start_date', __('Start date'));
        $grid->column('end_date', __('End date'));
        $grid->column('initiated_by', __('Initiated by'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));

        $grid->actions(function ($actions) {
            $actions->add(new Approve());
            $actions->add(new Decline());
        });

//        $grid->actions(function ($actions) {
//            $actions->add(new Decline());
//        });
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
        $show = new Show(Booking::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('employee_id', __('Employee id'));
        $show->field('reason', __('Reason'));
        $show->field('status', __('Status'));
        $show->field('departure_id', __('Departure id'));
        $show->field('destination_id', __('Destination id'));
        $show->field('total_days', __('Total days'));
        $show->field('start_date', __('Start date'));
        $show->field('end_date', __('End date'));
        $show->field('initiated_by', __('Initiated by'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
//        Admin::script('console.log("hello world");');

        $form = new Form(new Booking());

        $form->select('employee_id', __('Employee Name'))->options(Employee::all()->pluck('first_name','id'));
        $form->textarea('reason', __('Reason'));
//        $form->text('status', __('Status'))->default('pending');
        $form->select('departure_id', __('Departure Location'))->options(Destination::all()->pluck('name','id')->sortBy('name'));
        $form->select('destination_id', __('Destination Location'))->options(Destination::all()->pluck('name','id'));
        $form->dateRange('start_date', 'end_date', 'Date Range');
        $form->number('total_days', __('Total days'));
//        $form->date('start_date', __('Start date'))->default(date('Y-m-d'));
//        $form->date('end_date', __('End date'))->default(date('Y-m-d'));
//        $form->display('initiate_by','Initiated By')->auth()->user()->name;
//        $form->display(auth()->user()->name, 'Initiated By');
        $form->hidden('initiated_by', 'Initiated By')->defaultOnEmpty(auth()->user()->id);

        // callback after save
        $form->saved(function (Form $form) {
            $user = auth()->user();
            Notification::sendNow($user, new BookingNotification($form));
        });
        return $form;
    }
}
