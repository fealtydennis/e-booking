<?php

namespace App\Admin\Controllers;

use App\Models\Department;
use App\Models\Designation;
use \App\Models\Employee;
use App\Models\Gender;
use App\Models\IdType;
use App\Models\User;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use function Psy\sh;

class EmployeeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Employee';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Employee());

        $grid->column('id')->sortable();
//        $grid->column('user.name', __('name'));
        $grid->column('user_id')->display(function($user) {
            return User::find($user)->name;
        });
//        $grid->column('first_name', __('First Name'));
//        $grid->column('middle_name', __('Middle Name'));
        $grid->column('full_name')->display(function () {
            return $this->first_name.' '.$this->last_name;
        });
        $grid->column('last_name', __('Last Name'));
        $grid->column('gender.name', __('Gender'));
        $grid->column('id_type.name', __('ID Type'));
        $grid->column('id_no', __('ID Number'));
        $grid->column('passport_no', __('Passport Number'));
        $grid->column('dob', __('DOB'));
        $grid->column('user.username', __('Email'));
        $grid->column('primary_telephone', __('Phone Number'));
        $grid->column('employee_number', __('Employee Number'));
        $grid->column('department.name', __('Department'));
        $grid->column('designation.name', __('Designation'));
        $grid->column('user.name', __('Approver'));
        $grid->column('is_booking_agent', __('Booking Agent'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
        $grid->filter(function ($filter) {

            // Sets the range query for the created_at field
            $filter->between('created_at', 'Created Time')->datetime();
        });

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
        $show = new Show(Employee::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user.name', __('name'));
        $show->field('first_name', __('First Name'));
        $show->field('middle_name', __('Middle Name'));
        $show->field('last_name', __('Last Name'));
        $show->field('gender.name', __('Gender'));
        $show->field('id_type.name', __('ID Type'));
        $show->field('id_no', __('ID Number'));
        $show->field('passport_no', __('Passport Number'));
        $show->field('dob', __('DOB'));
        $show->field('user.username', __('Email'));
        $show->field('primary_telephone', __('Phone Number'));
        $show->field('employee_number', __('Employee Number'));
        $show->field('department.name', __('Department'));
        $show->field('designation.name', __('Designation'));
        $show->field('user.name', __('Approver'));
        $show->field('is_booking_agent', __('Booking Agent'));
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
        $form = new Form(new Employee());

        $form->select('user_id', __('name'))->options(User::all()->pluck('name','id'));
        $form->text('first_name', __('First Name'));
        $form->text('middle_name', __('Middle Name'));
        $form->text('last_name', __('Last Name'));
        $form->select('gender_id', __('Gender'))->options(Gender::all()->pluck('name','id'));
        $form->select('id_type_id', __('ID Type'))->options((IdType::all()->pluck('name', 'id')));
        $form->text('id_no', __('ID Number'));
        $form->text('passport_no', __('Passport Number'));
        $form->date('dob', __('DOB'));
        $form->select('email', __('Email'))->options(User::all()->pluck('username', 'id'));
        $form->text('primary_telephone', __('Phone Number'));
        $form->text('employee_number', __('Employee Number'));
        $form->select('department_id', __('Department'))->options(Department::all()->pluck('name','id'));
        $form->select('designation_id', __('Designation'))->options((Designation::all()->pluck('name', 'id')));
        $form->select('approver_id', __('Approver'))->options(User::all()->pluck('name', 'id'));
        $form->select('is_booking_agent', __('Booking Agent'));


        return $form;
    }
}
