<form class="form-horizontal">

<!-- Task Name -->
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">{{ $filter['name']['label'] }}</label>
        <div class="col-sm-6">
            <input type="text" name="name" id="name" class="form-control filterData" value="{{ $filter['name']['value'] }}">
        </div>
    </div>
    <!-- Task Name -->
    <div class="form-group">
        <label for="email" class="col-sm-3 control-label">{{ $filter['email']['label'] }}</label>
        <div class="col-sm-6">
            <input type="text" name="email" id="email" class="form-control filterData" value="{{ $filter['email']['value'] }}">
        </div>
    </div>
</form>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
        <button class="btn btn-primary" onclick="applyFilter();">
            Search
        </button>
        <button type="submit" class="btn btn-danger" onclick="resetFilter();">
            Reset filter
        </button>
    </div>
</div>
