<?php

namespace MrzKit\LaravelExt\Crud;

use Illuminate\Database\Eloquent\Model;

class CrudRepository implements ModelContract, CrudContract
{
    /**
     * @var Model 模型
     */
    protected $model;

    /**
     * @desc 获取模型
     * @return Model
     */
    public function getModel() : Model
    {
        return $this->model;
    }

    /**
     * @desc 设置模型
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @desc 增
     * @param array $creatData 新增数据
     * @return Model
     */
    public function creat(array $creatData)
    {
        $model = clone $this->getModel();

        $model->fill($creatData)->save();

        return $model;
    }

    /**
     * @desc 添加失败会抛出异常
     * @param array $creatData
     * @return Model
     * @throws \Throwable
     */
    public function creatOrFail(array $creatData)
    {
        $model = clone $this->getModel();

        $model->fill($creatData)->saveOrFail();

        return $model;
    }

    /**
     * @desc 查
     * @param null $page 页码
     * @param int $perPage 每页数
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function retrieve(int $page = 1, int $perPage = 20)
    {
        $query = $this->getModel()->newQuery();

        $rows = $query->orderByDesc($this->getModel()->getKeyName())->paginate($perPage, ['*'], 'page', $page);

        return $rows;
    }

    /**
     * @desc 改
     * @param int $id 主键
     * @param array $updateData
     * @return int|mixed 更新的数据
     */
    public function update(int $id, array $updateData)
    {
        $query = $this->getModel()->newQuery();

        $updated = $query->where($this->getModel()->getKeyName(), $id)->update($updateData);

        return $updated;
    }

    /**
     * @desc 改
     * @param int $id 主键
     * @param array $updateData 更新的数据
     * @return mixed
     */
    public function withTrashedUpdate(int $id, array $updateData)
    {
        $query = $this->getModel()->newQuery();

        $updated = $query->where($this->getModel()->getKeyName(), $id)->withTrashed()->update($updateData);

        return $updated;
    }

    /**
     * @desc 删
     * @param int $id 主键
     * @return mixed
     */
    public function delete(int $id)
    {
        $query = $this->getModel()->newQuery();

        $num = $query->where($this->getModel()->getKeyName(), $id)->delete();

        return $num;
    }

    /**
     * @desc 详情
     * @param int $id 主键
     * @param array|string[] $fields 查询字段
     * @return \Illuminate\Database\Eloquent\Builder|Model|mixed|object|null
     */
    public function detail(int $id, array $fields = ['id'])
    {
        $query = $this->getModel()->newQuery();

        $row = $query->select($fields)->where($this->getModel()->getKeyName(), $id)->first();

        return $row;
    }

    /**
     * @desc 详情(查软删)
     * @param int $id 主键
     * @param array $fields 查询字段
     * @return \Illuminate\Database\Eloquent\Builder|Model|mixed|object|null
     */
    public function withTrashedDetail(int $id, array $fields = [])
    {
        $query = $this->getModel()->newQuery();

        $row = $query->select($fields)->where($this->getModel()->getKeyName(), $id)->withTrashed()->first();

        return $row;
    }
}
