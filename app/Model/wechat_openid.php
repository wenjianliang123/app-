<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class wechat_openid extends Model
{
    //数据库连接
    protected $connection = 'mysql_shop';
    protected $table = 'wechat_openid';
    /**
     * 指示模型是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 主键
     */
    protected $primaryKey = 'id';
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
