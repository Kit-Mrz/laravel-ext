<?php

namespace MrzKit\LaravelExt\Partition;

use Illuminate\Database\Eloquent\Model;

abstract class PartitionModel extends Model implements PartitionContract
{
    /**
     * @desc 获取分区数
     * @return int
     */
    public function getPartitionCount() : int
    {
        return 64;
    }

    /**
     * @desc 获取分区实例
     * @return Partition
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getPartitionInstance() : Partition
    {
        app()->singletonIf(Partition::class);

        return app()->make(Partition::class);
    }

    /**
     * @desc
     * @param int $id
     * @return $this
     */
    public function partition(int $id)
    {
        $partitionCount = $this->getPartitionCount();

        $partitionConfig = $this->getPartitionConfig();

        $partition = $this->getPartitionInstance();

        $partitionPos = $partition->setPartitionCount($partitionCount)->setPartitionFactor($id)
            ->setPartitionConfig($partitionConfig)->calculatePartition();

        $tableName = $this->getTable();

        $tableName = preg_replace('/_\d+$/', '', $tableName);

        $tableName = $tableName . "_{$partitionPos}";

        $this->setTable($tableName);

        return $this;
    }
}
