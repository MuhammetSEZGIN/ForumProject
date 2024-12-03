@props(["messages" => []])

<p class="fs-3 text-center mt-5 ">Yorumlar</p>
<section style="background-color: #ffffff;">
    <div class="container my-5 py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12 col-lg-10 col-xl-8">
                <div class="card">

                    <!-- Yorumlar döngüsü -->
                    @foreach($messages->comments as $message)
                        <div class="card-body">
                            <div class="d-flex flex-start align-items-center">

                                <div>
                                    <h6 class="fw-bold text-primary mb-1">{{ $message->user->name }}</h6>
                                    <p class="text-muted small mb-0">
                                        {{ $message->created_at }}
                                    </p>
                                </div>
                            </div>
                            <p class="mt-3 mb-4 pb-2">
                                {{ $message->content }}
                            </p>

                        </div>
                    @endforeach

                    <!-- Yorum gönderme formu -->
                    <form method="POST" action="{{route('sendComment')}}" >
                       @csrf

                        <input type="hidden"  name="articleID" value="{{$messages->articleID}}">
                        <input type="hidden"  name="userID" value="{{\Illuminate\Support\Facades\Auth::getUser()["id"]??1}}">

                        <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                            <div class="d-flex flex-start w-100">

                                <div data-mdb-input-init class="form-outline w-100">
                                    <textarea class="form-control" name="content" id="textAreaExample" rows="4" style="background: #fff;" required ></textarea>
                                    <label class="form-label" for="textAreaExample">Message</label>
                                </div>

                            </div>
                            <x-error-text name="content"></x-error-text>
                            <x-modal-button id="0">
                                <x-slot name="modalTitleText">Yorum Gönder</x-slot>
                                <x-slot name="modalButtonText">Gönder</x-slot>
                                <x-slot name="modalBodyText">Yorumu göndermek ister misiniz?.</x-slot>
                            </x-modal-button>
                          {{--  <div class="float-end mt-2 pt-1">
                                <button type="submit"  class="btn btn-primary btn-sm">Gönder</button>
                            </div>--}}
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</section>
