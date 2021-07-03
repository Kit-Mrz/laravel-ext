<?php

namespace MrzKit\LaravelExt\Partition;

interface PartitionContract
{
    /**
     * @desc 获取分区数
     * @return int
     */
    public function getPartitionCount() : int;

    /**
     * @desc 获取分区配置
     * @return array
     */
    public function getPartitionConfig() : array;

    /**
     * @desc 获取分区实例
     * @return Partition
     */
    public function getPartitionInstance() : Partition;
}
