<div class="modal fade bd-example-modal-lg" id="formModel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formSubmit">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="titleOfModel"><i class="ti-marker-alt m-r-10"></i> Add new </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">العميل</label>
                                <select id="user_id" name="user_id" class="form-control"   >
                                    @foreach($users as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">موظف المبيعات</label>
                                <select id="sales_id" name="sales_id" class="form-control"   >
                                    @foreach($admins as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">نوع الدفع</label>
                                <select id="invoice_type " name="invoice_type " class="form-control"   >
                                        <option value="1">كاش</option>
                                        <option value="2">تقسيط</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">نوع الخصم ان وجد</label>
                                <select id="discount_type " name="discount_type " class="form-control"   >
                                    <option value="1">قيمة</option>
                                    <option value="2">نسبة</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">الخصم</label>
                                <input type="number" step="0.01" id="discount" name="discount" class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">نسبة الضرايب</label>
                                <input type="number" step="0.01" id="tax" name="tax" class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">قيمة المشال</label>
                                <input type="number" step="0.01" id="cortex_cost" name="cortex_cost" class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">قيمة التوصيل</label>
                                <input type="number" step="0.01" id="delivery_cost" name="delivery_cost" class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">مقدم التعاقد</label>
                                <input type="number" step="0.01" id="deposit" name="deposit" class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">تاريخ التسليم</label>
                                <input type="date"  id="delivery_date" name="delivery_date" class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">حالة الفاتورة</label>
                                <select id="invoice_status " name="invoice_status " class="form-control"   >
                                    <option value="1">مدفوعه</option>
                                    <option value="2">غير مدفوعه</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-email">ملاحظات</label>
                                <textarea   id="note" name="note" class="form-control"   rows="4">
                                </textarea>
                            </div>
                        </div>


                    </div>
                </div>
                <div id="err"></div>
                <input type="hidden" name="id" id="id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">اغلاق</button>
                    <button type="submit" id="save" class="btn btn-success"><i class="ti-save"></i> حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
