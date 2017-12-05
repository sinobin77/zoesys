<?php

namespace App\Admin\Controllers;

use App\Models\Reserveroom;
use App\Models\Corporation;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ReserveroomController extends Controller
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
        return Admin::grid(Reserveroom::class, function (Grid $grid) {

            $grid->rese_room_id('ID')->sortable();

            $grid->agreement_type('客源协议类型')->display(function(){

            });

//
//            $grid->roomtype_id('房型')->display(function($roomtype_id) {
//                return Roomtype::find($roomtype_id)->roomtype_name;
//            });


            $grid->rese_man('预订方');
            $grid->roomtype_id('客房类型');
            $grid->room_number('预定间数');
            $grid->original_rate('原价');
            $grid->room_rate('当前房价');
            $grid->arrivel_date('到店日期');
            $grid->departure_date('离店日期');
            $grid->contacts('联系人');
            $grid->contact_number('联系人电话');
            $grid->rese_user_id('操作人员');
            $grid->rese_at('预定时日');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Reserveroom::class, function (Form $form) {

            $form->display('rese_room_id', 'ID');

            $arr = ['WX' => '微信', 'VIP' => '会员', 'CP' => '协议单位'];

            $form->select('agreement_type','客源协议类型')->options($arr);

            $form->select('rese_man', '预定方')->options(Corporation::all()->pluck('corp_name', 'corp_id'));

            // $form->text('roomtype_id', '客房类型');
            $form->datetime('arrivel_date', '到店日期')->format('YYYY-MM-DD')->default(date('Y-m-d',strtotime('+1 day')));
            $form->datetime('departure_date', '离店日期')->format('YYYY-MM-DD')->default(date('Y-m-d',strtotime('+2 day')));

            $form->select('roomtype_id', '客房类型')->options([1 => '新街口-标准单人房', 2 => '新街口-商务套房', 3 => '新街口-贵宾套房',4 => '新街口-双人房']);
            $form->number('room_number', '预定间数')->default(1);
            $form->currency('original_rate', '原价')->symbol('￥')->default('888');
            $form->currency('room_rate', '当前房价')->symbol('￥')->default('688');
            $form->text('contacts', '联系人');
            $form->mobile('contact_number', '联系人电话');
            //$form->text('rese_user_id', '操作人员')->default(0);
            //$form->datetime('rese_at', '预定时日')->format('YYYY-MM-DD');
        });
    }
}
