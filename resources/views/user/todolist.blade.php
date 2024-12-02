<x-layouts.layout>
    <x-slot name="navbar">
        <x-navbar/>
    </x-slot>
    <x-slot name="body">

        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card rounded-3">
                        <div class="card-body p-4">

                            <h4 class="text-center my-3 pb-3">To Do App</h4>

                            <form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2"
                                  action="{{route("addTodoList")}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="col-12">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="content" name="content" class="form-control" required/>
                                        <label class="form-label" for="form1">Enter a task here</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class=" btn btn-success btn-sm"> Ekle</button>
                                </div>

                            </form>

                            <table class="table mb-4">
                                <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Todo item</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                    <th scope="col">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=0;$i<count($todolists);$i++)
                                    <tr>
                                        <th scope="row">{{$i+1}}</th>
                                        <td>{{$todolists[$i]->content}}</td>
                                        <td>{{$todolists[$i]->status}}</td>
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                @if($todolists[$i]->status == "In Progress")
                                                    <form
                                                        action="{{route('todoStatusUpdate',['id'=>$todolists[$i]->id])}}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-primary btn-sm" type="submit">Bitti
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{route("deleteTodoList",$todolists[$i]->id)}}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-modal-button class="btn btn-danger btn-sm">
                                                        <x-slot name="modalTitleText">Sil</x-slot>
                                                        <x-slot name="modalButtonText">Sil</x-slot>
                                                        <x-slot name="modalBodyText">Elemanı silmek ister misiniz?
                                                        </x-slot>
                                                    </x-modal-button>
                                                </form>
                                            </div>

                                        </td>
                                        <td>{{ $todolists[$i]->created_at->format('d-m-Y H:i') }}</td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-slot>
</x-layouts.layout>
