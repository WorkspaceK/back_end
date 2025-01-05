<?php

namespace App\Repository\Degree;

interface DegreeRepositoryInterface
{
    public function all();

    public function find($id);

    public function findByIds(array $ids);

    public function findByCodes($request);

    public function getByBaseCode($data);

    public function getByBaseName($data);

    public function getPaginate($data);

    public function store($data);

    public function update($id, $data);

    public function delete($id);

    public function massDelete(array $ids);

    public function hasByCode($data);

    public function hasByName($data);

}
