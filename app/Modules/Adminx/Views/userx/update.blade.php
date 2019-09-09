@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Userx
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                @include('common.errors')


                <!-- New/Update User Form -->
                    <form action="{{ $actionRoute }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <!-- Task Name -->
                        <div class="form-group">
                            <label for="userx-name" class="col-sm-3 control-label">User name</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="userx-name" class="form-control" value="{{ $user->name }}">
                            </div>
                        </div>
                    <!-- Task Name -->
                        <div class="form-group">
                            <label for="userx-email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-6">
                                <input type="text" name="email" id="userx-email" class="form-control" value="{{$user->email }}">
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
                </div>
            </div>

        </div>
    </div>
@endsection
