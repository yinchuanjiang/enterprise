<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}">

    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}} col-sm-10">

        @include('admin::form.error')

        <input type="text" name="{{$name}}" class="{{$class}}" value="{{ old($column, $value) }}"/>
        @include('admin::form.help-block')
    </div>
</div>