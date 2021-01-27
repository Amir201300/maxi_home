@extends('Admin.includes.layouts.master')

@section('title')
    {{$product->name}}
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-5 align-self-center">
                    <h4 class="page-title">تفاصيل المنتج</h4>
                    <div class="d-flex align-items-center">

                    </div>
                </div>
                <div class="col-7 align-self-center">
                    <div class="d-flex no-block justify-content-end align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <!-- Column -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{$product->name}}</h3>
                            <h6 class="card-subtitle">تمت الاضافة في {{$product->created_at}}</h6>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="white-box text-center"><img width="270"
                                                                            src="{{getImageUrl('Product',$product->image)}}"
                                                                            class="img-responsive"></div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-6">
                                    <h4 class="box-title m-t-40">وصف المنتج</h4>
                                    <p>{{$product->desc ? $product->desc : 'لا يوجد'}}</p>
                                    <h2 class="m-t-40">{{$product->price}} {{getCurrency()}}</h2>
                                    <h3 class="box-title m-t-40">{{$product->cat ? $product->cat->name : ''}}</h3>
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-check text-success"></i> عدد مرات الشراء : 5</li>
                                        <li><i class="fa fa-check text-success"></i> الكمية الكلية المتاحة
                                            : {{$product->quantity}}</li>
                                        <li><i class="fa fa-check text-success"></i> تاريخ النزول
                                            : {{$product->created_at}}</li>
                                    </ul>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <button style="position: relative;top: 62px;left: -1000px;" class="btn btn-dark" id="titleOfText" data-toggle="modal" onclick="addFunction()">
                                        اضافة كمية جديدة
                                    </button>
                                    <h3 class="box-title m-t-40">بيان الكمية بالفروع</h3>
                                    <div class="table-responsive">
                                        <table class="table" id="datatable">
                                            <thead>
                                            <tr>
                                                <th>اسم الفرع</th>
                                                <th>الكمية</th>
                                                <th>اختيارات</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
    {{--        <footer class="footer text-center">--}}
    {{--            All Rights Reserved by AdminBite admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.--}}
    {{--        </footer>--}}
    <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    @include('Admin.Product.QuantityForm')

@endsection

@section('script')
    @include('Admin.Product.QuantityScript')
@endsection
