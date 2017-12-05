<?php

namespace App\Admin\Controllers;

use App\Models\Room;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RoomController extends Controller
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
        return Admin::grid(Room::class, function (Grid $grid) {

            $grid->room_id('ID')->sortable();

            $grid->roomtype('房型')->display(function ($comments) {
               // var_dump($comments);
                return $comments['roomtype_name'];

                //return "<span class='label label-warning'>{$count}</span>";
            });

            $grid->room_code('房间代码');

            $grid->room_name('房间名称');

            $grid->room_area('房间大小');

            $grid->room_pic_url()->display(function ($name) {
                return "<img src='$name' width='100px' height='80px'>";
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Room::class, function (Form $form) {

            $form->display('room_id', 'ID');

            //$form->text('hotel_id', '所属酒店')->default(1);

            $form->radio('hotel_id','所属酒店')->options([1 => 1])->default(1);

            $form->radio('roomtype_id','房间类型')->options([1 => 1])->default(1);

            //$form->text('roomtype_id', '房间类型')->default(1);

            $form->text('room_code','房间代码');

            $form->text('room_name','房间名称');

            $form->text('room_area','房间大小');

            $form->image('room_pic_url')->uniqueName();
        });
    }
}
