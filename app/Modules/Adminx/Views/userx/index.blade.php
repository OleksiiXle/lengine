@extends('Adminx::layouts.app')

@section('content')
    <div class="row xHeader">
        <div class="col-md-6" align="left">
        </div>
        <div class="col-md-6" align="right" >
            <a href="{{ url('adminx/userx/update/0') }}" class="btn btn-success">New User</a>
        </div>
    </div>
    <div class="row xContent">
        <div>
            <?php
            echo app('widget')->widget('gridx', ['generator' => $generator]);
            ?>
        </div>
    </div>
@endsection
