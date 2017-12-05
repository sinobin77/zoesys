<?php

namespace App\Admin\Controllers;

use App\Models\Corporation;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CorporationController extends Controller
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
        return Admin::grid(Corporation::class, function (Grid $grid) {

            $grid->corp_id('ID')->sortable();

            $grid->corp_name('协议名称');
            $grid->corp_contacts('协议联系人');
            $grid->corp_contact_number('协议联系人电话');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Corporation::class, function (Form $form) {

            $form->display('corp_id', 'ID');

            $form->text('corp_name', '协议名称');
            $form->text('corp_contacts', '协议联系人');
            $form->mobile('corp_contact_number', '协议联系人电话');
        });
    }
}
