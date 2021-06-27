<?php

namespace MrzKit\LaravelExt\Crud;

use Illuminate\Database\Eloquent\Model;

abstract class CrudRepository implements CrudContract, ModelContract
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
     * @param array $creatData
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
     * @desc 简单检索
     * @param null $page 页码
     * @param int $perPage 每页的数据条数
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function retrieve(int $page = 1, int $perPage = 20)
    {
        $query = $this->getModel()->newQuery();

        $list = $query->orderByDesc($this->getModel()->getKeyName())->paginate($perPage, ['*'], 'page', $page);

        return $list;
    }

    /**
     * @desc 更新数据
     * @param int $id ID主键
     * @param array $updateData
     * @return int|mixed 更新的数据
     */
    public function update(int $id, array $updateData)
    {
        $query = $this->getModel()->newQuery();

        $num = $query->where($this->getModel()->getKeyName(), $id)->update($updateData);

        return $num;
    }

    /**
     * @desc 删除
     * @param int $id ID主键
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
     * @param int $id
     * @param array|string[] $defaultFields 查询字段
     * @return \Illuminate\Database\Eloquent\Builder|Model|mixed|object|null
     */
    public function detail(int $id, array $defaultFields = ['id'])
    {
        $query = $this->getModel()->newQuery();

        $row = $query->select($defaultFields)->where($this->getModel()->getKeyName(), $id)->first();

        return $row;
    }

    /**
     * @desc 详情
     * @param int $id
     * @param array|string[] $defaultFields 查看的字段
     * @return \Illuminate\Database\Eloquent\Builder|Model|mixed|object|null
     */
    public function detailWithTrashed(int $id, array $defaultFields = ['id'])
    {
        $query = $this->getModel()->newQuery();

        $row = $query->select($defaultFields)->where($this->getModel()->getKeyName(), $id)->withTrashed()->first();

        return $row;
    }
}
