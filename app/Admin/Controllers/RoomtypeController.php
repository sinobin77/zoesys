<?php

namespace App\Admin\Controllers;

use App\Models\Roomtype;
use App\Models\Hotel;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RoomtypeController extends Controller
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
        return Admin::grid(Roomtype::class, function (Grid $grid) {

            $grid->roomtype_id('ID')->sortable();

            $grid->hotel('所属酒店')->display(function ($comments) {
                return $comments['hotel_name'];
            });

            $grid->roomtype_code('房型代码');
            $grid->roomtype_name('房型名称');

            $grid->room_url()->display(function ($name) {
                return "<img src='$name' width='100px' height='80px'>";
            });

            //$grid->room_url('图片');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Roomtype::class, function (Form $form) {

            $form->display('roomtype_id', 'ID');

            $form->text('roomtype_code', '房型代码');

            $form->text('roomtype_name', '房型名称');

            //$form->text('hotel_id','所属酒店')->default(1);

            $form->radio('hotel_id','所属酒店')->options([1 => 1])->default(1);

            $form->image('room_url')->uniqueName();
        });
    }
}
