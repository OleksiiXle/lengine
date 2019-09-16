<form class="form-horizontal">

<!-- Task Name -->
    <div class="form-group">
        <label for="filter_name" class="col-sm-3 control-label">{{ $filter['filter_name']['label'] }}</label>
        <div class="col-sm-6">
            <input type="text" name="filter_name" id="filter_name" class="form-control" value="{{ $filter['filter_name']['value'] }}">
        </div>
    </div>
    <!-- Task Name -->
    <div class="form-group">
        <label for="filter_email" class="col-sm-3 control-label">{{ $filter['filter_email']['label'] }}</label>
        <div class="col-sm-6">
            <input type="text" name="filter_email" id="filter_email" class="form-control" value="{{ $filter['filter_email']['value'] }}">
        </div>
    </div>

    <!-- Add/Update User Button -->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-primary">
                {{ (empty($user->id)) ? 'Add' : 'Update'  }}
            </button>
            <a class="btn btn-danger"
               href="{{ url('adminx/userx/') }}"
            >
                Go back
            </a>
        </div>
    </div>
</form>
