<?php


namespace App\Http\Controllers\Admin;

use App\Models\AdminType;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Yajra\DataTables\DataTables;
use Auth, File ,Hash;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = Admin::orderBy('id','desc');
        if($request->type_idF)
            $data=$data->where('type_id',$request->type_idF);
        if($request->store_idF)
            $data=$data->where('store_id',$request->store_idF);
        $data=$data->get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $types=AdminType::get();
        $stores=Store::get();
        return view('Admin.Admin.index',compact('types','stores'));
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'username' => 'required|unique:admin|min:3',
            ],
            [
                'username.required' => 'من فضلك ادخل اسم المستخدم',
                'username.unique' => 'هذا الاسم مسجل لدينا لمستخدم اخر',
                'username.min' => 'يجب ان لا يقل عدد حروف اسم المستخدم عن ثلاثة احرف'
            ]

        );
        $Admin = new Admin;
        $Admin->name = $request->name;
        $Admin->phone = $request->phone;
        $Admin->email = $request->email;
        $Admin->username = $request->username;
        $Admin->password = Hash::make($request->password);
        $Admin->address = $request->address;
        $Admin->type_id = $request->type_id;
        $Admin->salary = $request->salary;
        $Admin->commission = $request->commission;
        $Admin->discount_percentage = $request->discount_percentage;
        $Admin->superAdmin = $request->superAdmin;
        $Admin->store_id  = $request->store_id ;
        if($request->image)
            $Admin->image=saveImage('Admin',$request->image);
        $Admin->save();
        $Admin->roles()->attach(1);
        return $this->apiResponseMessage(1,'تم اضافة الموظف بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $Admin = Admin::find($id);
        return $Admin;
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'username' => 'required|unique:admin,username,'.$request->id.'|min:3',
            ],
            [
                'username.required' => 'من فضلك ادخل اسم المستخدم',
                'username.unique' => 'هذا الاسم مسجل لدينا لمستخدم اخر',
                'username.min' => 'يجب ان لا يقل عدد حروف اسم المستخدم عن ثلاثة احرف'
            ]

        );
        $Admin = Admin::find($request->id);
        $Admin->name = $request->name;
        $Admin->phone = $request->phone;
        $Admin->email = $request->email;
        $Admin->username = $request->username;
        if($request->password)
            $Admin->password = Hash::make($request->password);
        $Admin->address = $request->address;
        $Admin->type_id = $request->type_id;
        $Admin->salary = $request->salary;
        $Admin->commission = $request->commission;
        $Admin->discount_percentage = $request->discount_percentage;
        $Admin->superAdmin = $request->superAdmin;
        $Admin->store_id  = $request->store_id ;
        if($request->image){
            deleteFile('Admin',$Admin->image);
            $Admin->image=saveImage('Admin',$request->image);
        }
        $Admin->save();
        return $this->apiResponseMessage(1,'تم تعديل الموظف بنجاح',200);
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
            $Categories = Admin::whereIn('id', $ids)->get();
            foreach($Categories as $row){
                deleteFile('Admin',$row->icon);
                $row->delete();
            }
        } else {
            $Admin = Admin::find($id);
            if (is_null($Admin)) {
                return 5;
            }
            deleteFile('Admin',$Admin->icon);
            $Admin->delete();
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
           if($data->id != 1)
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
                $type_id = $data->type->name;
            return $type_id;
        })->editColumn('store_id', function ($data) {
            $store_id='الكل';
            if($data->store)
                $store_id =$data->store->name;
            return $store_id;
        })->editColumn('image', function ($data) {
            $image = '<a href="'. getImageUrl('Admin',$data->image).'" target="_blank">'
                .'<img  src="'. getImageUrl('Admin',$data->image) . '" width="50px" height="50px"></a>';
            return $image;
        })->rawColumns(['action' => 'action', 'type_id' => 'type_id','checkBox'=>'checkBox','image'=>'image'])->make(true);
    }
}
