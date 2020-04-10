<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}">
    <div class="row center-block">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8">
            <div style="color: red">已选行业明细:<span id="checkable-output"></span></div>
        </div>
    </div>
    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>
    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        <div id="csp-bootstrap-tree"></div>
        <input type="hidden" name="{{$id}}" id="{{$id}}">
        @include('admin::form.help-block')
    </div>
    <div class="col-sm-12">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8">
            <div style="color: red">行业关联关键词:<span id="keywords-output"></span></div>
        </div>
    </div>
</div>