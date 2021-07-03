<?php

namespace MrzKit\LaravelExt\PartitionCrud;

use MrzKit\LaravelExt\Partition\PartitionModel;

interface ModelContract
{
    /**
     * @desc 设置模型
     * @param PartitionModel $model
     * @return mixed
     */
    function setModel(PartitionModel $model);

    /**
     * @desc 获取模型
     * @return PartitionModel
     */
    function getModel() : PartitionModel;

}
