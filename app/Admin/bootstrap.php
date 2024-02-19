<?php

/**
 * Open-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * OpenAdmin\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * OpenAdmin\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use OpenAdmin\Admin\Admin;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Grid\Displayers\Actions\Actions;

//Admin::$favicon(asset{{'images/Logo Transparency.png'}});
//$favicon = ;
//Admin::$favicon('./images/Logo Transparency.png');

OpenAdmin\Admin\Form::forget(['editor']);




Grid::init(function (Grid $grid){

//    $user = auth()->user();
//    if(!$user->isAdministrator()){
//       return $grid->disableActions();
//    } else{
//        $grid->disableActions(false);
//    }


});
