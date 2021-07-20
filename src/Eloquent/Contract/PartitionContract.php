<?php

namespace MrzKit\LaravelExt\Eloquent\Contract;

use MrzKit\LaravelExt\Eloquent\Partition\Partition;

interface PartitionContract
{
    /**
     * @desc 获取分表数
     * @return int
     */
    public function getPartitionCount() : int;

    /**
     * @desc 获取分表配置
     * @return array
     */
    public function getPartitionConfig() : array;

    /**
     * @desc 获取分表实例
     * @return Partition
     */
    public function getPartitionInstance() : Partition;
}
