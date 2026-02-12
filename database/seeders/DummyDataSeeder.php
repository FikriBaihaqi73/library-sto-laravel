<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $user = \App\Models\User::create([
            'name' => 'Admin Library',
            'email' => 'admin@library.com',
            'password' => bcrypt('password'),
        ]);

        // Create Staff User
        \App\Models\User::create([
            'name' => 'Staff Library',
            'email' => 'staff@library.com',
            'password' => bcrypt('password'),
        ]);

        // Create Dummy Books
        $books = [
            [
                'title' => 'The Great Gatsby',
                'isbn' => '9780743273565',
                'author' => 'F. Scott Fitzgerald',
                'stock_system' => 10,
                'category' => 'Fiction',
            ],
            [
                'title' => 'Clean Code',
                'isbn' => '9780132350884',
                'author' => 'Robert C. Martin',
                'stock_system' => 5,
                'category' => 'Programming',
            ],
            [
                'title' => 'Laravel Up & Running',
                'isbn' => '9781492041214',
                'author' => 'Matt Stauffer',
                'stock_system' => 8,
                'category' => 'Programming',
            ],
             [
                'title' => 'Atomic Habits',
                'isbn' => '9780735211292',
                'author' => 'James Clear',
                'stock_system' => 15,
                'category' => 'Self-Help',
            ],
            [
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'isbn' => '9780590353427',
                'author' => 'J.K. Rowling',
                'stock_system' => 20,
                'category' => 'Fiction',
            ],
            [
                'title' => 'Thinking, Fast and Slow',
                'isbn' => '9780374275631',
                'author' => 'Daniel Kahneman',
                'stock_system' => 12,
                'category' => 'Psychology',
            ],
            [
                'title' => 'Zero to One',
                'isbn' => '9780804139298',
                'author' => 'Peter Thiel',
                'stock_system' => 7,
                'category' => 'Business',
            ],
        ];

        foreach ($books as $book) {
            \App\Models\Book::create($book);
        }
        
        // Stock opnames removed to start fresh
    }
}
