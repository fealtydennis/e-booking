<?php

namespace App\Admin\Controllers;

use App\Models\Employee;
use \App\Models\EmployeeApprover;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class EmployeeApproverController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'EmployeeApprover';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EmployeeApprover());

        $grid->column('id', __('Id'));
        $grid->column('employee.first_name', __('Employee'));
        $grid->column('approver_id', __('Approver'));
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
        $show = new Show(EmployeeApprover::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('employee.first_name', __('Employee'));
        $show->field('approver_id', __('Approver'));
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
        $form = new Form(new EmployeeApprover());

        $form->select('employee_id', __('Employee'))->options(Employee::all()->pluck('first_name','id'));
        $form->select('approver_id', __('Approver'))->options(Employee::all()->pluck('first_name','id'));


        return $form;
    }
}
