<?php


namespace App\Http\Controllers\Admin;

use App\Models\StatusTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = User::orderBy('id','desc');
        if($request->type_id)
            $data=$data->where('type_id',$request->type_id);
        $data=$data->get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $types=StatusTypes::where('type',1)->get();
        return view('Admin.User.index',compact('types'));
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $User = new User;
        $User->name = $request->name;
        $User->phone = $request->phone;
        $User->email = $request->email;
        $User->note = $request->note;
        $User->address = $request->address;
        $User->type_id = $request->type_id;
        $User->save();
        return $this->apiResponseMessage(1,'تم اضافة العميل بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $User = User::find($id);
        return $User;
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $User = User::find($request->id);
        $User->name = $request->name;
        $User->phone = $request->phone;
        $User->email = $request->email;
        $User->note = $request->note;
        $User->address = $request->address;
        $User->type_id = $request->type_id;
        $User->save();
        return $this->apiResponseMessage(1,'تم تعديل العميل بنجاح',200);
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
            $Categories = User::whereIn('id', $ids)->get();
            foreach($Categories as $row){
                deleteFile('User',$row->icon);
                $row->delete();
            }
        } else {
            $User = User::find($id);
            if (is_null($User)) {
                return 5;
            }
            deleteFile('User',$User->icon);
            $User->delete();
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
        })->editColumn('type_id', function ($data) {
            $type_id='لا يوجد';
                if($data->type)
                    $type_id = '<button class="'.$data->type->btn_color.' waves-effect waves-light btn-rounded  statusBut" >'.$data->type->name.'</button>';
            return $type_id;
        })->rawColumns(['action' => 'action', 'type_id' => 'type_id','checkBox'=>'checkBox'])->make(true);
    }
}
