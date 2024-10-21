<x-layout>
    <x-slot name="navbar">
        <x-navbar/>
    </x-slot>
    <x-slot name="body">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <form method="POST" action="{{route('register')}}" >
                @csrf

                <div class="container form-container">
                    <div class="row">
                        <div class="col-12">
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="form2Example1" name="name" class="form-control" value="{{old('name')}}" required />
                                <label class="form-label" for="form2Example1">Kullanıcı Adı</label>
                            </div>
                            <x-error-text name="name"/>
                        </div>
                    </div> <div class="row">
                        <div class="col-12">
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="form2Example1" name="email" class="form-control" value="{{old('name')}}" required />
                                <label class="form-label" for="form2Example1">E-mail</label>
                            </div>
                            <x-error-text name="name"/>
                        </div>
                    </div> <div class="row">
                        <div class="col-12">
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="form2Example2" name="password" class="form-control"  required />
                                <label class="form-label" for="form2Example2">Şifre</label>
                            </div>
                            <x-error-text name="password"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="form2Example2" name="password_confirmation" class="form-control"  required />
                                <label class="form-label" for="form2Example2">Şifre Tekrarı</label>
                            </div>
                            <x-error-text name="password_confirmation"/>
                        </div>
                        <button type="submit" class="btn btn-primary">Kaydol</button>

                    </div>
                </div>
            </form>
    </x-slot>

</x-layout>




{{--@if($errors->any())
    @foreach($errors->all() as $error)
          <x-error-text>{{$error}}</x-error-text>

        @endforeach
    @endif--}}


