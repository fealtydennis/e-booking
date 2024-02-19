<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\action;
use App\Admin\Actions\Approve;
use App\Admin\Actions\Decline;
use App\Admin\Actions\Replicate;
use App\Models\BookingAgent;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Gender;
use App\Models\IdType;
use App\Models\TravelMode;
use App\Models\TravelPurpose;
use App\Models\User;
use OpenAdmin\Admin\Grid\Displayers\Actions\DropdownActions;
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
//    use HookExample;

    public function initHooks()
    {
        $this->hook('alterForm', function ($scope, $form) {
            $form = $this->addFormLogic($form);

            return $form;
        });
    }
//    public function addFormLogic($form)
//    {
//
//
//        return $form;
//    }
    protected $title = 'Booking';


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
//        return view('booking');
        $grid = new Grid(new Booking());

//        $grid->column('id', __('Id'));
        $grid->column('employee.employee_number', __('Employee Number'));
        $grid->column('fullname', __('Full Name'));
        $grid->column('employee.first_name', 'First Name');
        $grid->column('employee.last_name', 'Last Name');
        $grid->column('reason', __('Reason'));
        $grid->column('status', __('Status'));
//        $grid->column('destination.name', __('Departure Name'));
        $grid->column('departure_id')->display(function ($destination) {
            return Destination::find($destination)->name;
        });
        $grid->column('destination_id')->display(function ($destination) {
            return Destination::find($destination)->name;
        });
        $grid->column('total_days', __('Total days'));
        $grid->column('start_date', __('Start date'));
        $grid->column('end_date', __('End date'));
        $grid->column('initiated_by', __('Initiated by'));
        $grid->column('company.name', __('Company Name'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
//
        $user = auth()->user();
        if ($user->isApprover()) {
            $grid->disableActions(false);//
            $grid->actions(function ($actions) {
                $actions->add(new Approve());
                $actions->add(new Decline());
                $actions->add(new Replicate());
            });
        }
        elseif ($user->isAdministrator()){
            $grid->disableActions(false);
        }else{
            $grid->disableActions();
        }


//        $grid->setActionClass(DropdownActions::class);


        $grid->filter(function ($filter) {

            // Sets the range query for the created_at field
            $filter->between('created_at', 'Created Time')->datetime();
            $filter->like('status', 'status');
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
        $show = new Show(Booking::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('employee_id', __('Employee id'));
        $show->field('reason', __('Reason'));
        $show->field('status', __('Status'));
        $show->field('destination.name', __('Departure Name'));
        $show->field('destination.name', __('Destination Name'));
        $show->field('total_days', __('Total days'));
        $show->field('start_date', __('Start date'));
        $show->field('end_date', __('End date'));
//        $show->field('user.name', __('Initiated by'));
        $show->field('user.name', __('Approver'));
        $show->field('company.name', __('Company'));
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
//        dd($form->multipleSelect('employee_id'));

        $user = auth()->user();
        $employee = $user->employee;
        if ($user->isBookingAgent()) {
            $form->radio('traveller_option', 'Traveller Options')
                ->options([
                    1 => 'Frequent Travellers',
                    2 => 'Infrequent Travellers',
                    3 => 'My Booking'
                ])
                ->when(1, function (Form $form) {
                    $form->select('employee_id', __('Employee Name'))->options(Employee::all()->pluck('first_name', 'id'));
                })
                ->when(2, function (Form $form) {
//            $form->hidden('initiated_by', 'Initiated By')->defaultOnEmpty(auth()->user()->id);
                    $form->hidden('employee_id', __('Employee Name'))->defaultOnEmpty('6');
                    $form->text('fullname');
                    $form->select('gender_id', 'Gender')->options(Gender::all()->pluck('name', 'id'));
                    $form->select('id_type_id', 'ID Type')->options(IdType::all()->pluck('name', 'id'));
                    $form->text('id_no', 'ID Number');
                    $form->text('passport_no', 'Passport Number');
                    $form->date('dob', 'DOB');
                    $form->email('email');
                    $form->text('primary_telephone', 'Phone Number');
                    $form->text('employee_number', 'Employee Number');
                    $form->select('department_id', 'Department')->options(Department::all()->pluck('name', 'id'));
                    $form->select('designation_id', 'Designation')->options(Designation::all()->pluck('name', 'id'));
//            $form->select('approver_id', __('Approver ID'))->options(Employee::all()->pluck('name','id')->sortBy('name'));
                })
                ->when(3, function (Form $form) use ($employee) {
                    $form->hidden('employee_id', 'Employee ID')->defaultOnEmpty($employee->id);
                });
        }
        if ($user->isAdministrator()) {
            $form->radio('traveller_option', 'Traveller Options')
                ->options([
                    1 => 'Frequent Travellers',
                    2 => 'Infrequent Travellers',
                    3 => 'My Booking'
                ])
                ->when(1, function (Form $form) {
                    $form->select('employee_id', __('Employee Name'))->options(Employee::all()->pluck('first_name', 'id'));
                })
                ->when(2, function (Form $form) {
//            $form->hidden('initiated_by', 'Initiated By')->defaultOnEmpty(auth()->user()->id);
                    $form->hidden('employee_id', __('Employee Name'))->defaultOnEmpty('6');
                    $form->text('fullname');
                    $form->select('gender_id', 'Gender')->options(Gender::all()->pluck('name', 'id'));
                    $form->select('id_type_id', 'ID Type')->options(IdType::all()->pluck('name', 'id'));
                    $form->text('id_no', 'ID Number');
                    $form->text('passport_no', 'Passport Number');
                    $form->date('dob', 'DOB');
                    $form->email('email');
                    $form->text('primary_telephone', 'Phone Number');
                    $form->text('employee_number', 'Employee Number');
                    $form->select('department_id', 'Department')->options(Department::all()->pluck('name', 'id'));
                    $form->select('designation_id', 'Designation')->options(Designation::all()->pluck('name', 'id'));
//            $form->select('approver_id', __('Approver ID'))->options(Employee::all()->pluck('name','id')->sortBy('name'));
                })
                ->when(3, function (Form $form) use ($employee) {
                    $form->hidden('employee_id', 'Employee ID')->defaultOnEmpty($employee->id);
                });
        }
        else{
            $form->hidden('traveller_option', __('Traveller Option'))->defaultOnEmpty('3');
            $form->hidden('employee_id', __('Employee Name'))->defaultOnEmpty($employee->id);
        }

        $form->textarea('reason', __('Reason'));
        $form->select('travel_mode_id', 'Travel Mode')
            ->options([
                1 => 'Road',
                2 => 'Air',
                3 => 'Rail',
            ])
            ->when(1, function (Form $form) {
                $form->select('departure_id_1', __('Departure Location'))->options(Destination::where('travel_mode_id', '1')->get()->sortBy('name')->pluck('name', 'id'));
                $form->select('destination_id_1', __('Destination Location'))->options(Destination::where('travel_mode_id', '1')->get()->sortBy('name')->pluck('name', 'id'));
            })
            ->when(2, function (Form $form) {
                $form->select('departure_id_2', __('Departure Location'))->options(Destination::where('travel_mode_id', '2')->get()->sortBy('name')->pluck('name', 'id'));
                $form->select('destination_id_2', __('Destination Location'))->options(Destination::where('travel_mode_id', '2')->get()->sortBy('name')->pluck('name', 'id'));
            })
            ->when(3, function (Form $form) {
                $form->select('departure_id_3', __('Departure Location'))->options(Destination::where('travel_mode_id', '3')->get()->sortBy('name')->pluck('name', 'id'));
                $form->select('destination_id_3', __('Destination Location'))->options(Destination::where('travel_mode_id', '3')->get()->sortBy('name')->pluck('name', 'id'));
            });

        $form->select('travel_purpose_id', __('Travel Purpose'))->options(TravelPurpose::all()->pluck('name', 'id')->sortBy('name'));

//        $form->dateRange('start_date', 'end_date', 'Date Range');
//        $form->$total_days;
        $form->date('start_date', 'Start Date');
        $form->date('end_date', 'End Date');
        $form->display('total_days', 'Total Days');
        $form->select('invoice_company_id', 'Invoicing Company')->options(Company::all()->pluck('name', 'id')->sortBy('name'));
        $form->hidden('initiated_by', 'Initiated By')->defaultOnEmpty(auth()->user()->id);


        // callback after save
        $form->saved(function (Form $form) {
            if ($form->input('employee_id')) {
                $employee = Employee::where('id', $form->input('employee_id'))->first();
            } else {
                $employee = Employee::where('user_id', auth()->user()->id)->first();
            }
//            dd($form);
            $approver = User::where('id', $employee->approver_id)->first();
//            dd($employee);
//            $user = auth()->user();
            Notification::sendNow($approver, new BookingNotification($form));

        });

        return $form;

    }


}
