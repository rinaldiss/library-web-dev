<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Magazine;
use App\Models\Regulation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::count();
        $magazines = Magazine::count();
        $regulations = Regulation::count();
        return view('pages.admin.dashboard', compact('books', 'magazines', 'regulations'));
    }
}
