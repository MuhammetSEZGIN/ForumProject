<x-layout>
    <x-slot name="navbar">
        <x-navbar></x-navbar>
    </x-slot>
    <x-slot name="body">
        <!-- Include stylesheet -->
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <style>
            #editor {
                height: 375px;
                margin-top: 30px;
            }
            .textContainer {
                margin: 10%;
            }
        </style>
        <!-- Create the editor container -->
        <form method="POST" action="{{route("addArticle")}}" id="identifier">
            @csrf

            <div class="textContainer">
            <div class="input-group input-group-lg">
                <span class="input-group-text" id="inputGroup-sizing-default">Makale Başlığı</span>
                <input type="text" class="form-control" name="title" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01">Kategoriler</label>
                <select class="form-select" id="inputGroupSelect01" name="categoryID">
                    <option selected value="{{$categories[0]->categoryID}}">{{$categories[0]->categoryName}}</option>
                    @foreach($categories as $category)
                        <option  value="{{$category->categoryID}}">{{$category->categoryName}}</option>
                    @endforeach
                </select>
            </div>
                <div id="editor">
                </div>
                <x-error-text name="title"></x-error-text>

                <input type="hidden" name="authorID" value="{{\Illuminate\Support\Facades\Auth::getUser()["id"]}}">
                <textarea name="text" style="display:none" id="hiddenArea"></textarea>
            <input type="submit" value="Save" />
        </div>
        </form>

        <!-- Include the Quill library -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <!-- Initialize Quill editor -->
        <script>
            var quill = new Quill('#editor', {
                theme: 'snow'
            });

            $("#identifier").on("submit", function() {
                // Quill editor içeriğini alıp textarea'ya aktaralım

                $("#hiddenArea").val(quill.root.innerHTML);
            });
        </script>



    </x-slot>

</x-layout>

