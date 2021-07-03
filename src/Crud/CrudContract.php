<?php

namespace MrzKit\LaravelExt\Crud;

interface CrudContract
{
    /**
     * @desc 增
     * @param array $creatData
     * @return mixed
     */
    public function creat(array $creatData);

    /**
     * @desc 查
     * @return mixed
     */
    public function retrieve();

    /**
     * @desc 改
     * @param int $id
     * @param array $updateData
     * @return mixed
     */
    public function update(int $id, array $updateData);

    /**
     * @desc 改(改软删)
     * @param int $id
     * @param array $updateData
     * @return mixed
     */
    public function withTrashedUpdate(int $id, array $updateData);

    /**
     * @desc 删
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * @desc 详情
     * @param int $id
     * @param array $defaultFields 查询字段
     * @return mixed
     */
    public function detail(int $id, array $defaultFields = []);

    /**
     * @desc 详情(查软删)
     * @param int $id
     * @param array $defaultFields 查询字段
     * @return mixed
     */
    public function withTrashedDetail(int $id, array $defaultFields = []);
}
