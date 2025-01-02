<?php

namespace App\Repository\Degree;

use App\Models\Degree;

class DegreeRepository
{
    private $degreeModel;

    public function __construct(Degree $degreeModel)
    {
        return $this->degreeModel = $degreeModel;
    }

    public function all()
    {
        return $this->degreeModel->all();
    }

    public function getByPage($request)
    {
        $data = $this->degreeModel;
        if (!empty($request['last_name']))
        {
            $data = $data->whereRaw('LOWER(last_name) like ?', ['%' . strtolower($request['last_name']) . '%']);
        }
        $paginate = $data->orderBy($request['field'], $request['order'])->paginate($request['size']);
        return [
            'page_info' => [
                'total_items' => $paginate->total(),
                'total_pages' => $paginate->lastPage(),
                'current' => $paginate->currentPage(),
                'size' => $paginate->perPage(),
            ],
            'records' => $paginate->items(),
        ];
    }

    public function find($id)
    {
        return $this->degreeModel->where('id', $id)->first();
    }

    public function findByIds(array $ids)
    {
        return $this->degreeModel->whereIn('id', $ids)->get();
    }

    public function findByCodes($request)
    {
        $data = $this->degreeModel->whereIn('code', $request['codes']);
        if (!empty($request['name']))
        {
            $data = $data->whereRaw('LOWER(name) like ?', ['%' . strtolower($request['name']) . '%']);
        }
        return $data->orderBy($request['field'], $request['sortOrder'])->withCount('students')->paginate($request['pageSize']);

    }

    public function getByBaseCode($baseCode)
    {
        return $this->degreeModel->whereRaw('LOWER(code) like ?', ['%' . strtolower($baseCode) . '%'])->get();
    }

    public function store($data)
    {

        return $this->degreeModel->insertGetId($data);
    }

    public function update($id, $data)
    {
        return $this->degreeModel->where('id', $id)->update($data);
    }

    public function delete($id)
    {

        return $this->degreeModel->destroy($id);
    }

    public function massDelete(array $ids)
    {
        return $this->degreeModel->whereIn('id', $ids)->delete();
    }
}
