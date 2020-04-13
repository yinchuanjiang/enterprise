<!doctype html>
<html lang="en">
<header>
    <link rel="stylesheet" href="/vendor/laravel-admin-ext/cascade/bootstrap-treeview.min.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/AdminLTE/plugins/iCheck/all.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/AdminLTE/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/bootstrap-fileinput/css/fileinput.min.css?v=4.5.2">
    <link rel="stylesheet" href="/vendor/laravel-admin/AdminLTE/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/AdminLTE/plugins/ionslider/ion.rangeSlider.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/AdminLTE/plugins/ionslider/ion.rangeSlider.skinNice.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="/vendor/laravel-admin-ext/cascade/bootstrap-treeview.min.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/AdminLTE/dist/css/skins/skin-blue-light.min.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/laravel-admin/laravel-admin.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/nprogress/nprogress.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/sweetalert2/dist/sweetalert2.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/nestable/nestable.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/toastr/build/toastr.min.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/bootstrap3-editable/css/bootstrap-editable.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/google-fonts/fonts.css">
    <link rel="stylesheet" href="/vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css">
    <script src="/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js"></script>
</header>
<body>
<table class="table table-hover" id="push">
    <thead>
    <tr>
        <th class="column-__row_selector__">
            <input type="checkbox" class="checkbox-master">
        </th>
        <th class="column-policy_title">用户名</th>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td class="column-__row_selector__">
                <input type="checkbox" class="user-checkbox" data-id="{{$user->user_id}}">
            </td>
            <td class="column-policy_id">
                {{$user->user_name.'('.\App\Models\Enum\UserEnum::getTypeName($user->yser_type).')'}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{$users->links()}}
</body>
<script src="/vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js"></script>
<script>
    function reSetData(_checkbox) {
        var userId = new Set();
        _checkbox.each(function () {
            // 判断是否选中
            var delFlag = $(this).is(":checked");
            if (delFlag) {
                userId.add($(this).attr('data-id'));
            }
        });
        window.localStorage.setItem('userId', Array.from(userId).toString());
    }
    $(function () {
        window.localStorage.setItem('userId', Array.from(new Set()).toString());

        $('input[type="checkbox"].user-checkbox, input[type="radio"].user-checkbox').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        });
        $('input[type="checkbox"].checkbox-master, input[type="radio"].checkbox-master').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        });


        _checkboxMaster = $(".checkbox-master");
        _checkbox = $("tbody").find("[type='checkbox']").not("[disabled]");
        _checkboxMaster.on("ifClicked", function (e) {
            // 当前状态已选中，点击后应取消选择
            if (e.target.checked) {
                _checkbox.iCheck("uncheck");
            }

            // 当前状态未选中，点击后应全选
            else {
                _checkbox.iCheck("check");
            }
            reSetData(_checkbox);
        });

        $('input').on('ifChecked', function(event){
            reSetData(_checkbox);
        });

        $('input').on('ifUnchecked', function(event){
            reSetData(_checkbox);
        });

    })
</script>
</html>