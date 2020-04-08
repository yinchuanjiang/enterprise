<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}">
    <div class="row">
        <h2>已选行业</h2>
        <div id="checkable-output"></div>
    </div>
    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>
    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        <div id="csp-bootstrap-tree"></div>
        <input type="hidden" name="{{$id}}" id="{{$id}}">
        @include('admin::form.help-block')
    </div>
</div>