<?php

namespace MrzKit\LaravelExt\Eloquent\Repos;

use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Support\Facades\DB;
use MrzKit\LaravelExt\Eloquent\Branch\PartitionModel;
use MrzKit\LaravelExt\Eloquent\Contract\ModelContract;
use MrzKit\LaravelExt\Eloquent\Contract\PartitionRepoContract;

abstract class PartitionRepo implements ModelContract, PartitionRepoContract
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
    public function setModel($model)
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

    /**
     * @desc 分表批量添加
     * @param int $partitionFactor 分表因子
     * @param array $storeData
     * @return bool
     */
    public function partitionStores(int $partitionFactor, array $storeData)
    {
        $model = $this->getModel()->partition($partitionFactor);

        $tableName = $model->getTable();

        $totallyGuarded = $model->totallyGuarded();

        $insertData = [];

        foreach ($storeData as $index => $item) {
            $tempData = [];
            foreach ($model->fillableFromArray($item) as $key => $val) {
                if ($model->isFillable($key)) {
                    $tempData[$key] = $val;
                } elseif ($totallyGuarded) {
                    throw new MassAssignmentException(sprintf(
                                                          'Add [%s] to fillable property to allow mass assignment on [%s].',
                                                          $index, get_class($this)
                                                      ));
                }
            }

            if ( !empty($tempData)) {
                $insertData[] = $tempData;
            }
        }

        $inserted = false;

        if ( !empty($insertData)) {
            $inserted = DB::table($tableName)->insert($insertData);
        }

        return $inserted;
    }
}
