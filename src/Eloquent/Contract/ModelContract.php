<?php

namespace MrzKit\LaravelExt\Eloquent\Contract;

interface ModelContract
{
    /**
     * @desc 设置模型
     * @param $model
     * @return mixed
     */
    function setModel($model);

    /**
     * @desc 获取模型
     * @return mixed
     */
    function getModel();
}

