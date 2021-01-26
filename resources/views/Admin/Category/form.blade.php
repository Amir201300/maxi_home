<div class="modal fade" id="exampleModal" tabindex="-1" id="formModel" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الاسم</label>
                                <input type="text" id="name" name="name" required class="form-control" >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">البريد الالكتروني</label>
                                <input type="email" id="email" name="email" required class="form-control"   >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">كلمة السر</label>
                                <input type="text" id="password" name="password"  class="form-control" >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الهاتف</label>
                                <input type="number" id="phone" name="phone" class="form-control"  required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">النوع</label>
                                <select  id="gender" name="gender" class="form-control" >
                                    <option value="1">ذكر</option>
                                    <option value="2">انثى</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">حالة التفعيل</label>
                                <select  id="status" name="status" class="form-control" >
                                    <option value="1">مفعل</option>
                                    <option value="0">غير مفعل</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-email">الصورة</label>
                                <input type="file" id="image" name="image" class="form-control"   >
                            </div>
                        </div>

                    </div>
                </div>
                <div id="err"></div>
                <input type="hidden" name="id" id="id">
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> اغلاق</button>
                    <button type="submit" id="save" class="btn btn-info"><i class="ti-save"></i> حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
