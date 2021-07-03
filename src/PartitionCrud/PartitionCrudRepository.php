<?php

namespace MrzKit\LaravelExt\PartitionCrud;

use MrzKit\LaravelExt\Partition\PartitionModel;

class PartitionCrudRepository implements ModelContract, PartitionCrudContract
{
    /**
     * @var PartitionModel 模型
     */
    protected $model;

    /**
     * @desc 获取模型
     * @return PartitionModel
     */
    public function getModel() : PartitionModel
    {
        return $this->model;
    }

    /**
     * @desc 设置模型
     * @param PartitionModel $model
     * @return $this
     */
    public function setModel(PartitionModel $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @desc 增
     * @param int $partitionFactor 分表因子
     * @param array $creatData 新增数据
     * @return mixed|PartitionModel
     */
    public function partitionCreat(int $partitionFactor, array $creatData)
    {
        $model = clone $this->getModel()->partition($partitionFactor);

        $model->fill($creatData)->save();

        return $model;
    }

    /**
     * @desc 增
     * @param int $partitionFactor 分表因子
     * @param array $creatData 新增数据
     * @return PartitionModel
     * @throws \Throwable
     */
    public function partitionCreatOrFail(int $partitionFactor, array $creatData)
    {
        $model = clone $this->getModel()->partition($partitionFactor);

        $model->fill($creatData)->saveOrFail();

        return $model;
    }

    /**
     * @desc 查
     * @param int $partitionFactor 分表因子
     * @param int $page 页码
     * @param int $perPage 每页数
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function partitionRetrieve(int $partitionFactor, int $page = 1, int $perPage = 20)
    {
        $query = $this->getModel()->partition($partitionFactor)->newQuery();

        $rows = $query->orderByDesc($this->getModel()->getKeyName())->paginate($perPage, ['*'], 'page', $page);

        return $rows;
    }

    /**
     * @desc 改
     * @param int $partitionFactor 分表因子
     * @param int $id 主键
     * @param array $updateData 更新的数据
     * @return int|mixed
     */
    public function partitionUpdate(int $partitionFactor, int $id, array $updateData)
    {
        $query = $this->getModel()->partition($partitionFactor)->newQuery();

        $updated = $query->where($this->getModel()->getKeyName(), $id)->update($updateData);

        return $updated;
    }

    /**
     * @desc 改(改软删)
     * @param int $partitionFactor 分表因子
     * @param int $id 主键
     * @param array $updateData 更新的数据
     * @return int|mixed
     */
    public function partitionWithTrashedUpdate(int $partitionFactor, int $id, array $updateData)
    {
        $query = $this->getModel()->partition($partitionFactor)->newQuery();

        $updated = $query->where($this->getModel()->getKeyName(), $id)->withTrashed()->update($updateData);

        return $updated;
    }

    /**
     * @desc 删
     * @param int $partitionFactor 分表因子
     * @param int $id 主键
     * @return mixed
     */
    public function partitionDelete(int $partitionFactor, int $id)
    {
        $query = $this->getModel()->partition($partitionFactor)->newQuery();

        $deleted = $query->where($this->getModel()->getKeyName(), $id)->delete();

        return $deleted;
    }

    /**
     * @desc 详情
     * @param int $partitionFactor 分表因子
     * @param int $id 主键
     * @param array $fields 查询字段
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed|object|null
     */
    public function partitionDetail(int $partitionFactor, int $id, array $fields = [])
    {
        $query = $this->getModel()->partition($partitionFactor)->newQuery();

        $row = $query->select($fields)->where($this->getModel()->getKeyName(), $id)->first();

        return $row;
    }

    /**
     * @desc 详情(查软删)
     * @param int $partitionFactor 分表因子
     * @param int $id 主键
     * @param array $fields 查询字段
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed|object|null
     */
    public function partitionWithTrashedDetail(int $partitionFactor, int $id, array $fields = [])
    {
        $query = $this->getModel()->partition($partitionFactor)->newQuery();

        $row = $query->select($fields)->where($this->getModel()->getKeyName(), $id)->withTrashed()->first();

        return $row;
    }
}
