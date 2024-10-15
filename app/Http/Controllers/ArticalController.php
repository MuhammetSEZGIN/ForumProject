<?php

namespace App\Http\Controllers;

class ArticalController extends Controller
{
    public function index()
    {
        return view('articles.index');
    }
    public function show()
    {
        return view('articles.show');
    }
    public function create()
    {
        return view('articles.create');
    }
    public function edit()
    {
        return view('articles.edit');
    }
    public function update()
    {
        return redirect('articles.update');
    }
    public function delete()
    {

    }

}
