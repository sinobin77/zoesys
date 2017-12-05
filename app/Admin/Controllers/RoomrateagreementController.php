<?php

namespace App\Admin\Controllers;

use App\Models\Roomrateagreement;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RoomrateagreementController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Roomrateagreement::class, function (Grid $grid) {

            $grid->agreement_id('ID')->sortable();

            $grid->agreement_type('协议类型');
            $grid->agreement_party('协议方');
            $grid->expiry_date('有效期限');
            $grid->salesman_id('相关销售员');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Roomrateagreement::class, function (Form $form) {

            $form->display('agreement_id', 'ID');

            $form->text('agreement_type', '协议类型');
            $form->text('agreement_party', '协议方');

            $form->datetime('expiry_date','有效期限')->format('YYYY-MM-DD');

//            $form->text('expiry_date', 'expiry_date');
            $form->text('salesman_id', '相关销售员');
        });
    }
}
