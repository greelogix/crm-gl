@php
// $user = auth_user();
$user = Auth::user();
@endphp
<header>
    <nav class="bg-gray-800 p-4 flex justify-between items-center">
        <a href="" class="text-white text-start text-2xl font-bold hover:text-yellow-400 transition-colors no-underline">
            Dashboard
        </a>
        <div class="text-end">
            <img src="{{ Storage::url( $user->image ?? 'image/default-profile.jpg') }}" class="rounded-lg border rounded-circle" alt="" style=" position:absolute; right: 140px; top: 24px; height: 35px; width: 35px;">
            <button class="dropdown-toggle text-white" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                {{  $user->name }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item cursor-pointer" data-bs-toggle="modal" data-bs-target="#profileModal">Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>


<!-- Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-lg shadow-lg">
            <div class="modal-header bg-blue-500 text-white rounded-t-lg">
                <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="flex space-x-4">
                    <!-- Profile details side -->
                    <div class=" p-4 bg-gray-50 rounded-lg shadow-sm">
                        <h6 class="text-xl font-semibold mb-4">Profile Details</h6>
                        <img src="{{ Storage::url( $user->image ?? 'image/default-profile.jpg') }}" id="preview" alt="Profile Image" class="w-full h-48 object-cover mb-4 rounded-lg border rounded-circle w-100"  style="width: 90%;">
                        <p><strong class="font-medium">Name:</strong>{{ $user->name}}</p>
                        <p><strong class="font-medium">Email:</strong>{{ $user->email}}</p>
                    </div>
                    
                    <!-- Edit Profile side -->
                    <div class="flex-1 p-4 bg-gray-50 rounded-lg shadow-sm">
                        <div class="d-flex justify-content-between">
                            <h6 class="text-xl font-semibold mb-4">Edit Profile</h6>
                            <i class="fa-solid fa-pen-to-square cursor-pointer" data-toggle="tooltip" data-placement="top" title="Click here to edit your profile" id="edit-icon"></i>
                        </div>
                        <form action="{{ route('profile.update', [ $user->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium">Name</label>
                                <input type="text" class="form-control mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg" id="name" name="name" @error('name') is-invalid @enderror value="{{ old('name',  $user->name) }}" readonly>
                                @error('name')
                                <span class="text-danger">
                                            {{$message}}
                                        </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium">Email</label>
                                <input type="email" class="form-control mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg" id="email" name="email" @error('email') is-invalid @enderror value="{{ old('email',  $user->email) }}" readonly>
                                @error('email')
                                <span class="text-danger">
                                            {{$message}}
                                        </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="image" class="block text-sm font-medium">Profile Image</label>
                                <input type="file" class="form-control mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg" @error('image') is-invalid @enderror  id="image" name="image" readonly>
                                @error('image')
                                <span class="text-danger">
                                            {{$message}}
                                        </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium">Password</label>
                                <input type="password" class="form-control mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg" id="password" name="password" @error('password') is-invalid @enderror value="{{ old('password')}}" readonly>
                                @error('password')
                                <span class="text-danger">
                                            {{$message}}
                                        </span>
                                @enderror
                            </div>
                            <button type="submit" id="updatebtn" class="w-1/4 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300 mx-auto block d-none">Update</button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#edit-icon').click(function() {
            $('#name, #email, #password').removeAttr('readonly');
            $('#updatebtn').removeClass('d-none');
        });
        $('#profileModal').on('hidden.bs.modal', function () {
            $('#name, #email, #password').attr('readonly', 'readonly');
            $('#updatebtn').addClass('d-none');
        });

        $('#image').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

