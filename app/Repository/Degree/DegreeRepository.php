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
        $paginate = $data->orderBy($request['field'], $request['order'])->withCount('persons')->paginate($request['size']);
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

    public function getByIds($ids)
    {
        return $this->degreeModel->whereIn('id', $ids)->get();
    }

    public function findByCodes(array $codes)
    {
        return $this->degreeModel->whereIn('code', $codes)->get();
    }

    public function getByBaseCode($data)
    {
        return $this->degreeModel->whereRaw('LOWER(code) like ?', ['%' . strtolower($data) . '%'])->get();
    }

    public function getByBaseName($data)
    {
        return $this->degreeModel->whereRaw('LOWER(name) like ?', ['%' . strtolower($data) . '%'])->get();
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

    public function hasByCode($data)
    {
        return $this->degreeModel->where('code', $data)->exists();
    }

    public function hasByName($data)
    {
        return $this->degreeModel->where('name', $data)->exists();
    }

    public function import($data)
    {
        return $this->degreeModel->get();
    }

    //recycle
    public function onlyTrashed($request)
    {
        $data = $this->degreeModel->onlyTrashed();
        if (!empty($request['last_name']))
        {
            $data = $data->whereRaw('LOWER(last_name) like ?', ['%' . strtolower($request['last_name']) . '%']);
        }
        $paginate = $data->orderBy($request['field'], $request['order'])->withCount('persons')->paginate($request['size']);
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

    public function onlyTrashedById($id)
    {
        return $this->degreeModel->onlyTrashed()->where('id', $id)->first();
    }

    public function withTrashedById($id)
    {
        return $this->degreeModel->withTrashed()->where('id', $id)->first();
    }

    public function restoreAll()
    {
        return $this->degreeModel->onlyTrashed()->restore();
    }

    public function restoreByIds($ids)
    {
        return $this->degreeModel->onlyTrashed()->whereIn('id', $ids)->restore($ids);
    }

    public function restoreById($id)
    {
        return $this->degreeModel->where('id', $id)->restore($id);
    }

    public function forceDeleteById($id)
    {
        return $this->degreeModel->onlyTrashed()->where('id', $id)->forceDelete($id);
    }

    public function forceDeleteByIds($ids)
    {
        return $this->degreeModel->onlyTrashed()->whereIn('id', $ids)->forceDelete($ids);
    }

    public function forceDeleteAll()
    {
        return $this->degreeModel->onlyTrashed()->forceDelete();
    }
}
