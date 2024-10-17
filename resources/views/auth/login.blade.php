<x-layout>
    <x-slot name="navbar">
        <x-navbar/>
    </x-slot>
    <x-slot name="body">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <form method="POST" action="{{route('login')}}">
                @csrf
                <div class="container form-container">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">User Name</label>
                            <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="7" r="4" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}" required />
                                <x-error-text name="name"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Password</label>
                            <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="7" r="4" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span>
                                <input type="password" name="password" class="form-control"  required />
                                <x-error-text name="password"/>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>

                </div>
            </form>
            <a  href="{{route('register')}}" class="btn btn-primary">Register</a>

        </div>
    </x-slot>
</x-layout>





