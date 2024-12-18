<?php

namespace App\Repository\Person;

interface PersonRepositoryInterface
{
    public function all();

    public function find($id);

    public function search($request);

    public function findByIds($ids);

    public function findByCodes($request);

    public function getPaginate($data);

    public function getStudentsByClassId($classId);

    public function hasStudent();

    public function getListOrderBy($dataIndex);

    public function hasByIdentifi($identification);

    public function hasByEmail($email);

    public function searchByMentor($mentor);

    public function store($data);

    public function update($id, $data);

    public function delete($id);

    public function deleteMultiple(array $ids);
}
