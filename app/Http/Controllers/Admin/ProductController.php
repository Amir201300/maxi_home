<?php


namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\ProductStore;
use App\Models\StatusTypes;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = Product::orderBy('id','desc');
        if($request->cat_id)
            $data=$data->where('cat_id',$request->cat_id);
        $data=$data->get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cats=Category::get();
        return view('Admin.Product.index',compact('cats'));
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $Product = new Product;
        $Product->name = $request->name;
        $Product->cat_id = $request->cat_id;
        $Product->desc = $request->desc;
        $Product->quantity = 0;
        $Product->price = $request->price;
        if($request->image)
            $Product->image=saveImage('Product',$request->image);
        $Product->save();
        return $this->apiResponseMessage(1,'تم اضافة المنتج بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $Product = Product::find($id);
        return $Product;
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $Product = Product::find($request->id);
        $Product->name = $request->name;
        $Product->cat_id = $request->cat_id;
        $Product->desc = $request->desc;
        $Product->price = $request->price;
        if($request->image){
            deleteFile('Product',$Product->image);
            $Product->image=saveImage('Product',$request->image);
        }
        $Product->save();
        return $this->apiResponseMessage(1,'تم تعديل المنتج بنجاح',200);
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
            $Categories = Product::whereIn('id', $ids)->get();
            foreach($Categories as $row){
                deleteFile('Product',$row->icon);
                $row->delete();
            }
        } else {
            $Product = Product::find($id);
            if (is_null($Product)) {
                return 5;
            }
            deleteFile('Product',$Product->icon);
            $Product->delete();
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProduct ($id){
        $product=Product::find($id);
        $stores=Store::all();
        return view('Admin.Product.showProduct',compact('product','stores'));
    }

    public function updateQuantity($product_id){
        $newQuantity = ProductStore::where('product_id', $product_id)->sum('quantity');
        $product=Product::find($product_id);
        $product->quantity=$newQuantity;
        $product->save();
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
            $options .= ' <button type="button" onclick="showProduct('. $data->id .')" class="btn btn-success waves-effect btn-circle waves-light" title="تفاصيل المنتج"><i class=" fas fa-eye"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('cat_id', function ($data) {
            $type_id='لا يوجد';
            if($data->cat)
                $type_id = $data->cat->name;
            return $type_id;
        })->editColumn('image', function ($data) {
            $image = '<a href="'. getImageUrl('Product',$data->image).'" target="_blank">'
                .'<img  src="'. getImageUrl('Product',$data->image) . '" width="50px" height="50px"></a>';
            return $image;
        })->rawColumns(['action' => 'action', 'image' => 'image','checkBox'=>'checkBox'])->make(true);
    }
}
