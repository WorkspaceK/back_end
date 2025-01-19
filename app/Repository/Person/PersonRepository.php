<?php

namespace App\Repository\Person;

use App\Models\Person;

class PersonRepository
{
    private $personModel;

    public function __construct(Person $personModel)
    {
        return $this->personModel = $personModel;
    }

    public function all()
    {
        return $this->personModel->all();
    }

    public function getListUpdateOrderByDesc($dataSearch)
    {
        $data = $this->personModel;
        if (!empty($request['last_name']))
        {
            $data = $data->whereRaw('LOWER(last_name) like ?', ['%' . strtolower($request['last_name']) . '%']);
        }
        return $data->orderBy('updated_at', 'desc')->paginate($dataSearch['pageSize']);
    }

    public function get_by_page($request)
    {
        $data = $this->personModel;
        if (!empty($request['last_name']))
        {
            $data = $data->whereRaw('LOWER(last_name) like ?', ['%' . strtolower($request['last_name']) . '%']);
        }
//        if (!empty($request['first_name']))
//        {
//            $data = $data->whereRaw('LOWER(first_name) like ?', ['%' . strtolower($request['first_name']) . '%']);
//        }
//        if (!empty($request['identification']))
//        {
//            $data = $data->whereRaw('LOWER(identification) like ?', ['%' . strtolower($request['identification']) . '%']);
//        }
//         return $data->orderBy($request['field'], $request['order'])->paginate($request['size']);
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

    public function getByBaseIdentification($baseCode)
    {
        return $this->personModel->whereRaw('LOWER(identification) like ?', ['%' . strtolower($baseCode) . '%'])->get();
    }

    public function hasByIdentifi($identification)
    {
        return$this->personModel->where('identification', $identification)->exists();
    }

    public function hasByEmail($email)
    {
        return$this->personModel->where('email', $email)->exists();
    }

    public function searchByMentor($dataSearch)
    {
        $data = $this->personModel;
        if (!empty($dataSearch['code']))
        {
            $data = $data->where('mentor', 'like', '%'.$dataSearch['mentor'].'%');
        }
        return $data->orderBy('updated_at', 'desc')->paginate($dataSearch['pageSize']);
    }

    public function find($id)
    {
        return $this->personModel->where('id', $id)->first();
    }

    public function findByIds(array $ids)
    {
        return $this->personModel->whereIn('id', $ids)->get();
    }

    public function findByCodes($request)
    {
        $data = $this->personModel->whereIn('code', $request['codes']);
        if (!empty($request['name']))
        {
            $data = $data->whereRaw('LOWER(name) like ?', ['%' . strtolower($request['name']) . '%']);
        }
        return $data->orderBy($request['field'], $request['sortOrder'])->withCount('students')->paginate($request['pageSize']);

    }

    public function getStudentsByClassId($classId)
    {
        return $this->personModel->with('students')->find($classId);
    }

    public function hasStudent()
    {
        return $this->personModel->withCount('students')->get();
    }

    public function store($data)
    {

        return $this->personModel->insertGetId($data);
    }

    public function update($id, $data)
    {
        return $this->personModel->where('id', $id)->update($data);
    }

    public function delete($id)
    {

        return $this->personModel->destroy($id);
    }

    public function mass_delete(array $ids)
    {
        return $this->personModel->whereIn('id', $ids)->delete();
    }
}


