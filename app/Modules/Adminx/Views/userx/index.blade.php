@extends('Adminx::layouts.app')

@section('content')
    <div class="container">
        <div class="xContent">
            <div>
                @widget('gridx', ['generator' => $generator])
            </div>
        </div>
    </div>
@endsection
