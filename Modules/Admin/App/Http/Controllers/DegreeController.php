<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DegreeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\App\Http\Requests\DegreeRequest;

class DegreeController extends Controller
{private $personService;

    public function __construct(DegreeService $personService)
    {
        $this->personService = $personService;
    }

    public function getAll()
    {
        try {
            if (!$data = $this->personService->getAll()) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
    public function getByPage(DegreeRequest $request)
    {
        try {
            if (!$data = $this->personService->getByPage($request->all())) return response()->json("Bad request!", 404);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(DegreeRequest $request)
    {
        try {
            return $this->personService->store($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }

    }

    public function getById($id)
    {
        try {
            if (!$person = $this->personService->find($id)) return response()->json("Bad request!", 404);
            return response()->json($person);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function update($id, DegreeRequest $request)
    {
        try {
            if (!$this->personService->update($id, $request->all())) return response()->json("Bad request!", 404);
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

    public function massDelete(DegreeRequest $request)
    {
        try {
            if(!$this->personService->massDelete($request->all())) {
                return response()->json(['message' => 'Deleted failed'], 404);
            }
            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function copy($id)
    {
        try {
            if (!$record = $this->personService->copy($id)) return response()->json("Bad request!", 404);
            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function massCopy(DegreeRequest $request)
    {
        try {
            if (!$record = $this->personService->massCopy($request->all())) return response()->json("Bad request!", 404);
            return response()->json($record);

//            if(!$this->personService->mass_delete($request->all())) {
//                return response()->json(['message' => 'Deleted failed'], 404);
//            }
//            return response()->json(['message' => 'Deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

//    public function import_data(DegreeRequest $request)
//    {
//        try{
//            $request->validate([
//                'file' => 'required|mimes:xlsx,csv',
//            ]);
//            if (!$import = Excel::import(new ClassesImport, $request->file('file'))) return response()->json("Bad request!", 404);
//            return response()->json(['data'=>'Users imported successfully.', $import]);
//        }catch(\Exception $e){
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }

//    public function export_by_id(ExportRequest $request)
//    {
//        return $this->personService->exportItemsToCsv($request->all());
//    }
//
//    public function exportXlsx(ExportRequest $request)
//    {
//        try {
//            return $this->personService->exportItemsToXlsx($request->all());
//        } catch (\Exception $e) {
//            return response()->json(500);
//        }
//    }

    public function getByIds(DegreeRequest $request)
    {
        try {
            return $this->personService->getListById($request->all());
        } catch (\Exception $e) {
            return response()->json(500);
        }
    }

//
//    //recycle
//    public function recycle(DegreeRequest $request)
//    {
//        try {
//            if (!$data = $this->personService->onlyTrashed($request->all())) return response()->json("Bad request!", 404);
//            return response()->json($data);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }
//
//    public function showRecycled($id)
//    {
//        try {
//            if (!$data = $this->personService->onlyTrashedById($id)) return response()->json("Bad request!", 404);
//            return response()->json($data);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }
//
//    public function restore($id)
//    {
//        try {
//            if (!$data = $this->personService->restoreById($id)) return response()->json("Bad request!", 404);
//            return response()->json($data);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }
//
//    public function restoreMultiple($ids)
//    {
//        try {
//            if (!$data = $this->personService->restoreByIds($ids)) return response()->json("Bad request!", 404);
//            return response()->json($data);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }
//
//    public function restoreAll()
//    {
//        try {
//            if (!$data = $this->personService->restoreAll()) return response()->json("Bad request!", 404);
//            return response()->json($data);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }
//
//    public function forceDelete($id)
//    {
//        try {
//            if (!$data = $this->personService->forceDeleteById($id)) return response()->json("Bad request!", 404);
//            return response()->json($data);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }
//
//    public function forceDeleteMultiple($ids)
//    {
//        try {
//            if (!$data = $this->personService->forceDeleteByIds($ids)) return response()->json("Bad request!", 404);
//            return response()->json($data);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }
//
//    public function forceDeleteAll()
//    {
//        try {
//            if (!$data = $this->personService->forceDeleteAll()) return response()->json("Bad request!", 404);
//            return response()->json($data);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
//        }
//    }
}
