<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function allData()
    {
        $data = Category::get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('Admin.Category.index');
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
                'img' => 'required|image|max:2000',
            ],
            [
                'img.required' =>'من فضلك ادخل صورة القسم',
                'img.image' =>'من فضلك ادخل صورة صالحة'
            ]
        );
        $Category = new Category;
        if($request->img)
            $Category->icon = saveImage('Category',$request->img);
        $Category->name_ar = $request->name_ar;
        $Category->name_en = $request->name_en;
        $Category->save();
        return $this->apiResponseMessage(1,'تم اضافة القسم بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $Category = Category::find($id);
        return $Category;
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
                'img' => 'image|max:2000',
            ],
            [
                'img.required' =>'من فضلك ادخل صورة القسم',
                'img.image' =>'من فضلك ادخل صورة صالحة'
            ]
        );
        $Category = Category::find($request->id);
        if ($request->img) {
            deleteFile('Category',$Category->icon);
            $Category->icon=saveImage('Category',$request->img);
        }
        $Category->name_ar = $request->name_ar;
        $Category->name_en = $request->name_en;
        $Category->save();
        return $this->apiResponseMessage(1,'تم تعديل القسم بنجاح',200);
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
            $Categories = Category::whereIn('id', $ids)->get();
            foreach($Categories as $row){
                deleteFile('Category',$row->icon);
                $row->delete();
            }
        } else {
            $Category = Category::find($id);
            if (is_null($Category)) {
                return 5;
            }
            deleteFile('Category',$Category->icon);
            $Category->delete();
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
            if($data->id !=1)
                $options .= '<button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-danger waves-effect btn-circle waves-light"><i class=" fas fa-trash"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('image', function ($data) {
            $image = '<a href="'. getImageUrl('Category',$data->icon).'" target="_blank">'
            .'<img  src="'. getImageUrl('Category',$data->icon) . '" width="50px" height="50px"></a>';
            return $image;
        })->rawColumns(['action' => 'action', 'image' => 'image','checkBox'=>'checkBox'])->make(true);
    }
}
