<?php

namespace MrzKit\LaravelExt\Crud;

use Illuminate\Database\Eloquent\Model;

interface ModelContract
{
    /**
     * @desc 设置模型
     * @param Model $model
     * @return mixed
     */
    function setModel(Model $model);

    /**
     * @desc 获取模型
     * @return Model
     */
    function getModel() : Model;

}
