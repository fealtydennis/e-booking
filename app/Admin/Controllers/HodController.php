<?php

namespace App\Admin\Controllers;

use \App\Models\Hod;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class HodController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Hod';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Hod());

        $grid->column('id', __('Id'));
        $grid->column('employee_id', __('HOD Name'));
        $grid->column('company_id', __('Company'));
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
        $show = new Show(Hod::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('employee_id', __('HOD Name'));
        $show->field('company_id', __('Company'));
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
        $form = new Form(new Hod());

        $form->select('employee_id', __('HOD Name'));
        $form->select('company_id', __('Company'));

        return $form;
    }
}
