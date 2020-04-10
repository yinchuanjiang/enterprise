<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}">
    <div class="row center-block">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8">
            <div style="color: red">已选应用领域:<span id="checkable-output"></span></div>
        </div>
    </div>
    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>
    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        <div id="csp-bootstrap-tree"></div>
        <input type="hidden" name="{{$id}}" id="{{$id}}">
        @include('admin::form.help-block')
    </div>
</div>