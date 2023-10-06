@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Subscriber Login</div>
                    <div class="card-body">
                        <form id="login-form">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">{{ __('Username') }}</label>
                                <input id="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div id="success-message" class="alert alert-success mt-3" style="display: none;"></div>

                        <div id="error-message" class="alert alert-danger mt-3" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const loginForm = document.getElementById('login-form');
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(loginForm);

            try {
                const response = await axios.post('{{ route('login') }}', formData);
                if (response.status === 200 && response.data.token) {
                    successMessage.textContent = response.data.message;
                    successMessage.style.display = 'block';
                    errorMessage.style.display = 'none';
                    const token = response.data.token;
                    localStorage.setItem('access_token', token);
                    axios.get('{{ route('blogs.index') }}', {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }).then((protectedResponse) => {
                        if (protectedResponse.status === 200) {
                            window.location.href = '{{ route('blogs.index') }}';
                        } else {
                            console.log(protectedResponse.data);
                        }
                    });
                } else {
                    errorMessage.textContent = response.data.message;
                    errorMessage.style.display = 'block';
                }
            } catch (error) {
                errorMessage.textContent = error.response.data.message;
                errorMessage.style.display = 'block';
            }
        });
    </script>
@endsection
