
<div class="container-access">
    <div class="form">
        <div class="form-head">
            <h3>@if ($state=='Edit' ) Edit @else Create @endif user</h3>
        </div>

        <form action="{{ url('/user/') }}" method="POST">

            <div class="form-body">
                <div>
                    <input type="number" name="identification" placeholder="Id" value="{{isset($data->user->identification)?$data->user->identification:''}}" required>
                    @error('identification') <p>{{ $message }}</p> @enderror
                </div>
                <div>
                    <input type="text" name="firstname" placeholder="Firstname" value="{{isset($data->user->firstname)?$data->user->firstname:''}}" required>
                    @error('firstname') <p>{{ $message }}</p> @enderror
                </div>
                <div>
                    <input type="text" name="lastname" placeholder="Lastname" value="{{isset($data->user->lastname)?$data->user->lastname:''}}" required>
                    @error('lastname') <p>{{ $message }}</p> @enderror
                </div>
                <div>
                    <input type="text" name="username" placeholder="Username" value="{{isset($data->user->username)?$data->user->username:''}}" required>
                    @error('username') <p>{{ $message }}</p> @enderror
                </div>
                <div>
                    <input type="password" name="password" placeholder="Password" value="{{isset($data->user->password)?$data->user->password:''}}" required>
                    @error('password') <p>{{ $message }}</p> @enderror
                </div>
                <div>
                    <input type="number" name="phone_number" placeholder="Phone" value="{{isset($data->user->phone_number)?$data->user->phone_number:''}}">
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email" value="{{isset($data->user->email)?$data->user->email:''}}">
                </div>
                <div>
                    <select class="form-control-sm input-form" name="role_id" required>
                        <option value="" disabled selected>Select role</option>
                        @foreach ( $data->roles as $role )
                        <option value="{{$role->id_role}}" @if(isset($data->user) && (int)$role->id_role === (int) $data->user->role_id ) selected='selected' @endif>{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                    @error('role_id') <p>{{ $message }}</p> @enderror
                </div>
                <div>
                    <select class="form-control-sm input-form" name="department_id" required>
                        <option value="" disabled selected>Select department</option>
                        @foreach ( $data->departments as $department )
                        <option value="{{$department->id_department}}" @if(isset($data->user) && (int)$department->id_department === (int) $data->user->department_id ) selected='selected' @endif>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <p>{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="form-footer">
                <button type="submit" class="button">
                    @if ($state=='Edit' ) Update @else Save @endif
                </button>
                <a class="button a-btn" href="{{ url('user') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>
