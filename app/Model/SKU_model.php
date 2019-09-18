<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SKU_model extends Model
{
    //数据库连接
    protected $connection = 'jiuyue_shop';
    protected $table = 'goods_huopin';
    /**
     * 指示模型是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 主键
     */
    protected $primaryKey = 'huopin_id';

    /**
     *如果你想让所有属性都可以批量赋值， 你可以将 $guarded 定义成一个空数组：
     * /**
     *
     * 不可以批量赋值的属性。 如果为空就是都可以批量赋值
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * 模型日期列的存储格式。
     *
     * @var string
     */

    /*protected $dateFormat = 'U';*/



    /*const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';*/


    /**
     * 模型的默认属性值。
     *
     * @var array
     */

    /*protected $attributes = [
        'delayed' => false,
    ];*/
}
