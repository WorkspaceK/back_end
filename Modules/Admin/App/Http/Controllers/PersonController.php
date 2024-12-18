<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PersonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\App\Http\Requests\PersonRequest;

class PersonController extends Controller
{
    private $personService;

    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    public function index()
    {
        try {
            if (!$data = $this->personService->get_all()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
    public function get_by_page(PersonRequest $request)
    {
        try {
            if (!$data = $this->personService->get_by_page($request->all())) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function search(PersonRequest $request)
    {
        try {
            if (!$search = $this->personService->search($request->all())) return response()->json("Bad request!", 404);
            return response()->json($search);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function hasByIdentifi($code)
    {
        try {
            if (!$search = $this->personService->hasByIdentifi($code)) return response()->json("Bad request!", 404);
            return response()->json($search);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function hasByEmail($name)
    {
        try {
            if (!$search = $this->personService->hasByEmail($name)) return response()->json("Bad request!", 404);
            return response()->json($search);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function getClassList(PersonRequest $request)
    {
        try {
            if (!$data = $this->personService->getAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function showClassListByCode(PersonRequest $request)
    {
        try {
            try {
                if (!$data = $this->personService->getListByCodes($request->all())) return response()->json("Bad request!", 404);
                return response()->json($data);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
            }
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function showStudentList($personId)
    {
        try {
            if (!$students = $this->personService->getStudentsByClassId($personId)) return response()->json("Bad request!", 404);
            return response()->json($students);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function hasStudentList()
    {
        try {
            if (!$data = $this->personService->hasStudents())  return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            if (!$person = $this->personService->find($id)) return response()->json("Bad request!", 404);
            return response()->json($person);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(PersonRequest $request)
    {
        try {
            return $this->personService->store($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }

    }

    public function update($id, PersonRequest $request)
    {
        try {
            if (!$this->personService->update($id, $request->all())) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Update success']);
//            return response()->json($d)
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus($id, PersonRequest $request)
    {
        try {
            if (!$this->personService->updateStatus($id, $request->all())) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Update success']);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if(!$this->personService->delete($id)) return response()->json("Bad request!", 404);
            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteMultiple(PersonRequest $request)
    {
        try {
            if(!$data = $this->personService->deleteMultiple($request->all())) {
                return response()->json(['message' => 'Deleted failed'], 404);
            }
            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function record($id)
    {
        try {
            if (!$record = $this->personService->record($id)) return response()->json("Bad request!", 404);
            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function recordMultiple(PersonRequest $request)
    {
        try {
            if (!$record = $this->personService->recordMulti($request->all())) return response()->json("Bad request!", 404);
            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function importExcelData(PersonRequest $request)
    {
        try{
            $request->validate([
                'file' => 'required|mimes:xlsx,csv',
            ]);
            if (!$import = Excel::import(new ClassesImport, $request->file('file'))) return response()->json("Bad request!", 404);
            return response()->json(['data'=>'Users imported successfully.', $import]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function exportCsv(ExportRequest $request)
    {
        return $this->personService->exportItemsToCsv($request->all());
    }

    public function exportXlsx(ExportRequest $request)
    {
        try {
            return $this->personService->exportItemsToXlsx($request->all());
        } catch (\Exception $e) {
            return response()->json(500);
        }
    }

//    public function search(PersonRequest $request)
//    {
//        try {
//            $data = $request->all();
//            if (empty($data)) {
//                if (!$search = $this->personService->getAll()) return abort(404);
//            } else {
//                if (!$search = $this->personService->search($request->all())) return abort(404);
//            }
//            return response()->json($search);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }

    //recycle
    public function recycle(PersonRequest $request)
    {
        try {
            if (!$data = $this->personService->onlyTrashed($request->all())) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function showRecycled($id)
    {
        try {
            if (!$data = $this->personService->onlyTrashedById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        try {
            if (!$data = $this->personService->restoreById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restoreMultiple($ids)
    {
        try {
            if (!$data = $this->personService->restoreByIds($ids)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function restoreAll()
    {
        try {
            if (!$data = $this->personService->restoreAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDelete($id)
    {
        try {
            if (!$data = $this->personService->forceDeleteById($id)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDeleteMultiple($ids)
    {
        try {
            if (!$data = $this->personService->forceDeleteByIds($ids)) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function forceDeleteAll()
    {
        try {
            if (!$data = $this->personService->forceDeleteAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
}
