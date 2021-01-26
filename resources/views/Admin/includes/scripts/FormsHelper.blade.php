<script>
function addFunction() {
save_method = 'add';

$('#save').text('حفظ');

$('#titleOfModel').text($('#titleOfText').text());

$('#formSubmit')[0].reset();

$('#exampleModal').modal();
}
</script>

{-- Custom function t add or update --}}
<script>
    function saveOrUpdate(url){
        $("#save").attr("disabled", true);

        Toset('الطلب قيد التتنفيد','info','يتم تنفيذ طلبك الان',false);
        var id = $('#id').val();

        var formData = new FormData($('#formSubmit')[0]);

        $.ajax({
            url: url,
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status == 1) {

                    $("#save").attr("disabled", true);

                    $.toast().reset('all');
                    swal(data.message, {
                        icon: "success",
                    });
                    table.ajax.reload();
                    $("#formModel").modal('toggle');
                    $("#save").attr("disabled", false);
                    $('#err').slideUp(200);
                }
            },
            error: function (y) {
                var error = y.responseJSON.errors;
                $('#err').empty();
                $.toast().reset('all');
                for (var i in error) {
                    for (var k in error[i]) {
                        var message = error[i][k];
                        $('#err').append("<li style='color:red'>" + message + "</li>");
                    }
                }
                $("#save").attr("disabled", false);
                $('#err').slideDown(200);
            }
        });
    }
</script>