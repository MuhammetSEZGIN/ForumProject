<x-layouts.layout>
    <x-slot name="navbar">
        <x-navbar/>
    </x-slot>
    <x-slot name="body">
        <div class="d-flex flex-column justify-content-center align-items-center vh-100">
            <div class="mb-3"> <!-- Margin added to create space between forms -->
                <form method="POST" action="{{route('login')}}">
                    @csrf
                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="form2Example1" name="name" class="form-control" value="{{old('name')}}" required />
                        <label class="form-label" for="form2Example1">Kullanıcı Adı</label>
                    </div>
                    <x-error-text name="name"/>

                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" id="form2Example2" name="password" class="form-control"  required />
                        <label class="form-label" for="form2Example2">Password</label>
                    </div>
                    <x-error-text name="password"/>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary w-100 " style="margin-bottom: 20px">Giriş Yap</button>

                    <!-- Register buttons -->
                    <div class="text-center">
                        <p>Kaydolmadın mı hirbo <a href="{{route("register")}}">Kaydol</a></p>
                    </div>
                </form>
            </div>

        </div>

        <x-toast message="test mesaj"/>
    </x-slot>
</x-layouts.layout>
