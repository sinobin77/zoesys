<?php

namespace App\Admin\Controllers;

use App\Models\Hotel;

use App\Organization;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class HotelController extends Controller
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

            $content->header('酒店');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    public function doo(){
        return 12;
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
        return Admin::grid(Hotel::class, function (Grid $grid) {

            $grid->hotel_id('ID')->sortable();

            $grid->organization('所属组织')->display(function ($comments) {
                return $comments['org_name'];
            });

//            $grid->org_id()->display(function($org_id) {
//                return Organization::find($org_id)->org_name;
//            });

            $grid->hotel_code('分店代码');

            $grid->hotel_name('分店名称');

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Hotel::class, function (Form $form) {

            //$form->display('org_id', 'ID');
            $form->display('hotel_id', 'ID');
            //$form->text('org_id','所属组织')->default(1);

            $form->radio('org_id','所属组织')->options([1 => 1])->default(1);

            $form->text('hotel_code', '分店代码');
            $form->text('hotel_name','分店名称');
            $form->text('hotel_setting','分店信息');
            $form->radio('is_default','是否为默认分店')->options([0=> '不显示' , 1 => '指定显示'])->default(0);

        });
    }
}
