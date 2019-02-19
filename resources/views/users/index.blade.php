@extends('layouts.app')
@section('content')
    <div class="d-flex align-items-baseline mb-2">
        <h3 class="font-weight-bold flex-grow-1">Users</h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover datatable table-bordered">
                        <thead>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>DATE CREATED</th>
                        <th>DATE UPDATED</th>
                        <th>DATE INACTIVED</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at->toFormattedDateString()}}</td>
                                <td>{{$user->updated_at->toFormattedDateString()}}</td>
                                <td>{{$user->deactivated_at? $user->deactivated_at->toFormattedDateString(): ''}}</td>
                                <td>
                                    <button onclick="toggle_active({{$user}})"
                                            class="btn @if($user->deactivated_at) btn-outline-success @else btn-outline-danger @endif">
                                        <i
                                                class="fa @if($user->deactivated_at) fa-thumbs-o-up @else fa-thumbs-o-down @endif"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function toggle_active(user) {
            let confirm_button_text = user.deactivated_at ? 'Activate' : `Deactivate`
            let confirm_button_color = user.deactivated_at ? 'green' : `red`
            let title = user.deactivated_at ? ' User' : ` User`
            Swal.fire({
                title: confirm_button_text + title,
                type: "question",
                text: `${title}: ${user.name}`,
                confirmButtonColor: confirm_button_color,
                confirmButtonText: confirm_button_text,
                showCancelButton: true,
                preConfirm: () => {
                    axios.post(`users/toggle_active`, {user_id: user.id})
                        .then(window.location.reload(true))
                        .catch(e);
                }
            })
        }
    </script>
@endsection