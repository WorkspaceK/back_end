<?php

namespace App\Repository\Degree;

interface DegreeRepositoryInterface
{
    public function all();

    public function find($id);

    public function findByIds($ids);

    public function findByCodes(array $codes);

    public function getByBaseCode($data);

    public function getByBaseName($data);

    public function getPaginate($data);

    public function store($data);

    public function update($id, $data);

    public function delete($id);

    public function massDelete(array $ids);

    public function hasByCode($data);

    public function hasByName($data);

    //recycle
    public function onlyTrashed($request);
    public function onlyTrashedById($id);

    public function withTrashedById($id);

    public function restoreById($id);

    public function restoreByIds($ids);

    public function restoreAll($id);

    public function forceDeleteById($id);

    public function forceDeleteByIds($ids);

    public function forceDeleteAll($id);

}
