@extends('Adminx::layouts.app')

@section('content')
    <div class="container">
        <div>
            @widget('gridx', ['params' => 'qwerty1'])
            lokoko
            @widget('gridx', ['params' => 'qwerty2'])
            @widget('gridx', ['params' => 'qwerty3'])
        </div>

    <!-- Current Tasks -->
        @if (count($users) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    Users
                </div>
                <div>
                    <a class="btn btn-success" href="{{ url('adminx/userx/update/0') }}">
                        Add new
                    </a>

                </div>

                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <thead>
                        <th>Name</th>
                        <th>Email</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="table-text"><div>{{ $user->name }}</div></td>
                                <td class="table-text"><div>{{ $user->email }}</div></td>
                                <td class="table-text"><div>{{ $user->created_at }}</div></td>
                                <td class="table-text"><div>{{ $user->text_test }}</div></td>

                                <!-- Update Button -->
                                <td>
                                    <a class="btn btn-primary" href="{{ url('adminx/userx/update/' . $user->id) }}">
                                        Update
                                    </a>

                                </td>
                                <!-- Delete Button -->
                                <td>
                                    <a class="btn btn-danger"
                                       href="{{ url('adminx/userx/delete/' . $user->id) }}"
                                       method="POST"
                                    >
                                        Delete
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <?php echo $users->render(); ?>
                </div>
            </div>
        @endif

    </div>
@endsection
