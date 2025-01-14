<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Signup</title>
    <style>
        .gradient-custom-2 {
            background: #fccb90;
            background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
        }
        @media (min-width: 768px) {
            .gradient-form {
                height: 100vh !important;
            }
        }
        @media (min-width: 769px) {
            .gradient-custom-2 {
                border-top-right-radius: .3rem;
                border-bottom-right-radius: .3rem;
            }
        }
    </style>
</head>
<body>
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <!-- Left Section -->
                            <div id="form-section" class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <img src="{{ asset('logo/greelogix.png') }}" style="width: 120px;" alt="logo">
                                        <h4 id="form-title" class="mt-1 mb-5 pb-1">Create your account</h4>
                                    </div>
                                    <!-- Signup Form -->
                                    <form id="signup-form" action="{{ route('auth.signup') }}" method="POST">
                                      @csrf
                                      <div class="form-outline mb-4">
                                          <label class="form-label" for="signup-name">Name</label>
                                          <input 
                                              type="text" 
                                              id="signup-name" 
                                              class="form-control required shadow-none @error('name') is-invalid @enderror" 
                                              name="name" 
                                              placeholder="Full Name" 
                                              value="{{ old('name') }}"
                                          />
                                          @error('name')
                                          <div class="invalid-feedback">
                                              {{ $message }}
                                          </div>
                                          @enderror
                                      </div>
                                  
                                      <div class="form-outline mb-4">
                                          <label class="form-label" for="signup-email">Email</label>
                                          <input 
                                              type="email" 
                                              id="signup-email" 
                                              class="form-control required shadow-none @error('email') is-invalid @enderror" 
                                              name="email" 
                                              placeholder="Email Address" 
                                              value="{{ old('email') }}"
                                          />
                                          @error('email')
                                          <div class="invalid-feedback">
                                              {{ $message }}
                                          </div>
                                          @enderror
                                      </div>
                                  
                                      <div class="form-outline mb-4">
                                          <label class="form-label" for="signup-password">Password</label>
                                          <input 
                                              type="password" 
                                              id="signup-password" 
                                              class="form-control required shadow-none @error('password') is-invalid @enderror" 
                                              name="password" 
                                              placeholder="Password"
                                          />
                                          @error('password')
                                          <div class="invalid-feedback">
                                              {{ $message }}
                                          </div>
                                          @enderror
                                      </div>
                                  
                                      <div class="form-outline mb-4">
                                          <label class="form-label" for="confirm-password">Confirm Password</label>
                                          <input 
                                              type="password" 
                                              id="confirm-password" 
                                              class="form-control required shadow-none @error('password_confirmation') is-invalid @enderror" 
                                              name="password_confirmation" 
                                              placeholder="Confirm Password"
                                          />
                                          @error('password_confirmation')
                                          <div class="invalid-feedback">
                                              {{ $message }}
                                          </div>
                                          @enderror
                                      </div>
                                  
                                      <div class="text-center pt-1 mb-5 pb-1">
                                          <button type="submit" class="btn btn-primary btn-block gradient-custom-2 mb-3 shadow-none">Sign up</button>
                                          <div>
                                              <a id="switch-to-login" href="{{route('login')}}">Login</a>
                                          </div>
                                      </div>
                                  </form>
                                  
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4 text-center">CRM Greelogix company</h4>
                                    <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right", 
        "timeOut": "5000",
    }

    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif
        $('body').on('input', '.required', function () {
            $(this).css('border', '');
            $(this).removeClass('is-invalid');
        });
    });
    </script>
</body>
</html>
