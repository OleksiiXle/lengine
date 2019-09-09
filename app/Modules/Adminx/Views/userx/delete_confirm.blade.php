@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Remove user
                </div>

                <div class="panel-body">


                <!-- New Task Form -->
                    <form action="{{ url('adminx/userx/delete/' . $user->id) }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <!-- User Name -->
                        <div class="form-group">
                            <label for="userx-name" class="col-sm-3 control-label">User name</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="userx-name" class="form-control" value="{{ $user->name }}" disabled>
                            </div>
                        </div>
                    <!-- User Email -->
                        <div class="form-group">
                            <label for="userx-email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-6">
                                <input type="text" name="email" id="userx-email" class="form-control" value="{{$user->email }}" disabled>
                            </div>
                        </div>

                        <!-- Delete confirm Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-primary">
                                    Delete confirm
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
