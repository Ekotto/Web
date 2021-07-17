<?php

namespace App\Http\Controllers;
use App\Author;
use GrahamCampbell\Markdown\Facades\Markdown;
use App\Book;
use App\Category;
use Illuminate\Http\Request;

class BookshopHomeController extends Controller
{
    public function index()
    {
        # Home page Books
        $fitness_books = Book::with('category')->whereHas('category', function($query) {
            $query->where('slug', 'fitness'); })
            ->take(8)
            ->latestFirst()
            ->get();
        $health_books = Book::with('category', 'author', 'image')
            ->whereHas('category', function ($query){
                $query->where('slug', 'health'); })
            ->take(4)
            ->latestFirst()
            ->get();

         $health_books = Book::with('category', 'author', 'image')
            ->whereHas('category', function ($query){
                $query->where('slug', 'marketing'); })
            ->take(4)
            ->latestFirst()
            ->get();

         $society_books = Book::with('category', 'author', 'image')
            ->whereHas('category', function ($query){
                $query->where('slug', 'society'); })
            ->take(4)
            ->latestFirst()
            ->get();
        $discount_books = Book::with('category')
            ->where('discount_rate', '>', 0)
            ->orderBy('discount_rate', 'desc')
            ->take(6)
            ->get();
        return view('public.home', compact('fitness_books', 'discount_books', 'health_books'));
    }
    public function allBooks()
    {
        # ComposerServiceProvider load here
        $books = Book::with('author', 'image', 'category')
                    ->orderBy('id', 'DESC')
                    ->search(request('term')) #...Search Query
                    ->paginate(16);
        return view('public.book-page', compact('books'));
    }
    public function food()
    {
        # ComposerServiceProvider load here
        $discountTitle = "All discount books";
        $books = Book::with('author', 'image', 'category')
            ->orderBy('discount_rate', 'DESC')
            ->where('discount_rate', '>', 0)
            ->paginate(16);
        return view('public.book-page', compact('books', 'discountTitle'));


    }
    /*
     * Books filter by category
     */
    public function category(Category $category)
    {
        $categoryName = $category->name;
        $books = $category->books()
            ->with('category', 'author', 'image')
            ->orderBy('id','DESC')
            ->paginate(16);
        return view('public.book-page', compact('books', 'categoryName'));
    }
    /*
     * Books filter by author
     */
    public function author(Author $author)
    {
        $authorName = $author->name;
        $books = $author->books()
            ->with('category', 'author', 'image')
            ->orderBy('id', 'DESC')
            ->paginate(12);
        return view('public.book-page', compact('books', 'authorName'));
    }

    public function bookDetails($id)
    {
        $book = Book::findOrFail($id);
        $book_reviews = $book->reviews()->latest()->get();
        return view('public.book-details' , compact('book', 'book_reviews'));
    }
}
