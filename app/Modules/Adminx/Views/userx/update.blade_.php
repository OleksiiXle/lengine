@extends('Adminx::layouts.app')

@section('content')
    <div class="xHeader">
        <div class="row">
            <div class="col-md-6" align="left">
                <b>header left</b>
            </div>
            <div class="col-md-6" align="right" >
                <b>header right</b>
            </div>
        </div>
    </div>
    <div class="xContent">
        <div class="xCard">
            @include('common.errors')
            <!-- New/Update User Form -->
                <form action="{{ $actionRoute }}" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <!-- Forms fields -->
                <div class="row">
                    <div class="col-md-11">
                        <div class="form-group">
                            <label for="userx-name" class="control-label">User name</label>
                            <input type="text" name="name" id="userx-name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="userx-email" class="control-label">Email</label>
                            <input type="text" name="email" id="userx-email" class="form-control" value="{{$user->email }}">
                            <p class="help-block-error"></p>
                        </div>
                    </div>
                </div>
                <!-- Forms buttons -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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

                    </div>
                </div>
                </form>
        </div>
    </div>
@endsection
