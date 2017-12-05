<?php

namespace App\Admin\Controllers;

use App\Models\Roomratecalendar;

use App\Models\Roomtype;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RoomratecalendarController extends Controller
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
        return Admin::grid(Roomratecalendar::class, function (Grid $grid) {

            $grid->rate_cale_id('ID')->sortable();
            //$grid->roomtype_id('房型');
            $grid->roomtype_id('房型')->display(function($roomtype_id) {
                return Roomtype::find($roomtype_id)->roomtype_name;
            });

            $grid->rate_cale_code('房价日历编码');
            $grid->rate_cale_name('房价日历名称');
            $grid->precede('优先次序');
            $grid->start_date('开始日期');
            $grid->end_date('结束日期');
            $grid->original_rate('房价原价');

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Roomratecalendar::class, function (Form $form) {

            $form->display('rate_cale_id', 'ID');

            $form->select('roomtype_id', '房型')->options(
                [1 => '标准单人房', 2 => '商务套房', 3 => '贵宾套房',4 => '豪华套房']);

            //$form->text('roomtype_id', '房型');

            //$grid->title()->editable('select', [1 => 'option1', 2 => 'option2', 3 => 'option3']);

            $form->text('rate_cale_code', '房价日历编码');
            $form->text('rate_cale_name', '房价日历名称');
            $form->number('precede', '优先次序');

            $form->datetime('start_date','开始日期')->format('YYYY-MM-DD');
            $form->datetime('end_date','结束日期')->format('YYYY-MM-DD');

           // $form->text('start_date', '开始日期');
          //  $form->text('end_date', '结束日期');

            $form->currency('original_rate', '房价原价')->symbol('￥');

            //$form->text('original_rate', '房价原价');

        });
    }


}
