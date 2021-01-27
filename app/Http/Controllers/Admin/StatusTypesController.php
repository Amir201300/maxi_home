<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StatusTypes;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class StatusTypesController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = StatusTypes::where('type',$request->type)->get();
        return $this->mainFunction($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $type=$request->type;
        $title=$type== 1 ? 'العملاء' : 'الموردرون';
        return view('Admin.StatusTypes.index',compact('type','title'));
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $StatusTypes = new StatusTypes;
        $StatusTypes->note = $request->note;
        $StatusTypes->btn_color = $request->btn_color;
        $StatusTypes->name = $request->name;
        $StatusTypes->type = $request->type;
        $StatusTypes->save();
        return $this->apiResponseMessage(1,'تم اضافة النوع بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $StatusTypes = StatusTypes::find($id);
        return $StatusTypes;
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $StatusTypes = StatusTypes::find($request->id);
        $StatusTypes->note = $request->note;
        $StatusTypes->btn_color = $request->btn_color;
        $StatusTypes->name = $request->name;
        $StatusTypes->save();
        return $this->apiResponseMessage(1,'تم تعديل النوع بنجاح',200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function destroy($id,Request $request)
    {
        if ($request->type == 2) {
            $ids = explode(',', $id);
            $Categories = StatusTypes::whereIn('id', $ids)->get();
            foreach($Categories as $row){
                deleteFile('StatusTypes',$row->icon);
                $row->delete();
            }
        } else {
            $StatusTypes = StatusTypes::find($id);
            if (is_null($StatusTypes)) {
                return 5;
            }
            deleteFile('StatusTypes',$StatusTypes->icon);
            $StatusTypes->delete();
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function mainFunction($data)
    {
        return Datatables::of($data)->addColumn('action', function ($data) {
            $options = '<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="editFunction(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_' . $data->id . '" style="display:none"></i><i class="fas fa-edit"></i></button>';
            $options .= '<button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-danger waves-effect btn-circle waves-light"><i class=" fas fa-trash"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->addColumn('btn_color', function ($data) {
            $btn_color = '<button class="'.$data->btn_color.'">'.$data->name.'</button>';
            return $btn_color;
        })->rawColumns(['action' => 'action', 'btn_color' => 'btn_color','checkBox'=>'checkBox'])->make(true);
    }
}
