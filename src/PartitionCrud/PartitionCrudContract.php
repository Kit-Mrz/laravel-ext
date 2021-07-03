<?php

namespace MrzKit\LaravelExt\PartitionCrud;

interface PartitionCrudContract
{
    /**
     * @desc 增
     * @param int $partitionFactor 分表因子
     * @param array $creatData 新增数据
     * @return mixed
     */
    public function partitionCreat(int $partitionFactor, array $creatData);

    /**
     * @desc 查
     * @param int $partitionFactor 分表因子
     * @return mixed
     */
    public function partitionRetrieve(int $partitionFactor);

    /**
     * @desc 改
     * @param int $partitionFactor 分表因子
     * @param int $id 主键
     * @param array $updateData 更新的数据
     * @return mixed
     */
    public function partitionUpdate(int $partitionFactor, int $id, array $updateData);

    /**
     * @desc 改(改软删)
     * @param int $partitionFactor 分表因子
     * @param int $id 主键
     * @param array $updateData 更新的数据
     * @return mixed
     */
    public function partitionWithTrashedUpdate(int $partitionFactor, int $id, array $updateData);

    /**
     * @desc 删
     * @param int $partitionFactor 分表因子
     * @param int $id 主键
     * @return mixed
     */
    public function partitionDelete(int $partitionFactor, int $id);

    /**
     * @desc 详情
     * @param int $partitionFactor 分表因子
     * @param int $id 主键
     * @param array $fields 查询字段
     * @return mixed
     */
    public function partitionDetail(int $partitionFactor, int $id, array $fields = []);

    /**
     * @desc 详情(查软删)
     * @param int $partitionFactor 分表因子
     * @param int $id 主键
     * @param array $fields 查询字段
     * @return mixed
     */
    public function partitionWithTrashedDetail(int $partitionFactor, int $id, array $fields = []);
}

