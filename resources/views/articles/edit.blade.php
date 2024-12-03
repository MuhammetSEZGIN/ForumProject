<x-layouts.layout>
    <x-slot name="navbar">
        <x-navbar></x-navbar>
    </x-slot>
    <x-slot name="body">
        <!-- Include stylesheet -->
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <!-- Create the editor container -->
        <form method="POST" action="{{route("editArticle", ['id'=>$article->articleID])}}" id="identifier">
            @csrf
            @method('PATCH')

            <div class="container pt-5">
                <div class="row">
                    <div class="col-8">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text" id="inputGroup-sizing-default">Makale Başlığı</span>
                            <input type="text" class="form-control" value="{{$article->title}}" name="title"
                                   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Kategoriler</label>
                            <select class="form-select" id="inputGroupSelect01" name="categoryID">
                                <option selected
                                        value="{{$article->category[0]->categoryID}}">{{$article->category[0]->categoryName}}</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->categoryID}}">{{$category->categoryName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center h-50">
                    <div class="col">
                        <div id="editor"></div>
                    </div>
                </div>
                <div class="row p-5 ">
                    <div class="col-8">
                        <x-error-text name="title"></x-error-text>
                        <textarea name="text" style="display:none" id="hiddenArea"></textarea>
                    </div>

                    <div class="col d-flex justify-content-end">
                        <x-modal-button class="btn btn-success" id="{{$article->articleID}}">
                            <x-slot name="modalTitleText">Save</x-slot>
                            <x-slot name="modalButtonText">Save</x-slot>
                            <x-slot name="modalBodyText">Değişiklikleri kaydetmek ister misiniz?</x-slot>
                            </x-modal-button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Include the Quill library -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <!-- Initialize Quill editor -->
        <script>
            var quill = new Quill('#editor', {
                theme: 'snow'
            });

            $("#identifier").on("submit", function () {
                // Quill editor içeriğini alıp textarea'ya aktaralım
                $("#hiddenArea").val(quill.root.innerHTML);
            });

        </script>


    </x-slot>

</x-layouts.layout>

