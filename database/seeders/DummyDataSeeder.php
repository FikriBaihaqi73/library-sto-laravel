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
            'role' => 'admin',
            'email' => 'admin@library.com',
            'password' => bcrypt('password'),
        ]);

        // Create Staff User
        \App\Models\User::create([
            'name' => 'Staff Library',
            'role' => 'staff',
            'email' => 'staff@library.com',
            'password' => bcrypt('password'),
        ]);

        // Create Dummy Books
        \App\Models\Book::create([
            'title' => 'The Great Gatsby',
            'isbn' => '9780743273565',
            'author' => 'F. Scott Fitzgerald',
            'cover_url' => 'https://m.media-amazon.com/images/I/81fHk+ti2WL._SL1500_.jpg',
            'category' => 'Fiction',
        ]);

        \App\Models\Book::create([
            'title' => 'The Pragmatic Programmer',
            'isbn' => '9780201616224',
            'author' => 'Andrew Hunt',
            'cover_url' => 'https://m.media-amazon.com/images/I/41as+WafrFL._SL500_.jpg',
            'category' => 'Programming',
        ]);

        \App\Models\Book::create([
            'title' => 'Clean Code',
            'isbn' => '9780132350884',
            'author' => 'Robert C. Martin',
            'cover_url' => 'https://m.media-amazon.com/images/I/41jEbK-jG+L._SL500_.jpg',
            'category' => 'Programming',
        ]);

        \App\Models\Book::create([
            'title' => 'Atomic Habits',
            'isbn' => '9780735211292',
            'author' => 'James Clear',
            'cover_url' => 'https://m.media-amazon.com/images/I/81wgcld4wxL._SL1500_.jpg',
            'category' => 'Self-Help',
        ]);

         \App\Models\Book::create([
            'title' => 'The Psychology of Money',
            'isbn' => '9780857197689',
            'author' => 'Morgan Housel',
            'cover_url' => 'https://m.media-amazon.com/images/I/81cpDaCJJyL._SL1500_.jpg',
            'category' => 'Finance',
        ]);

         \App\Models\Book::create([
            'title' => 'Deep Work',
            'isbn' => '9781455586691',
            'author' => 'Cal Newport',
            'cover_url' => 'https://m.media-amazon.com/images/I/11J3QM0-NBL._SL500_.jpg',
            'category' => 'Productivity',
        ]);

         \App\Models\Book::create([
            'title' => 'Rich Dad Poor Dad',
            'isbn' => '9781612680194',
            'author' => 'Robert Kiyosaki',
            'cover_url' => 'https://m.media-amazon.com/images/I/81bsw6fnUiL._SL1500_.jpg',
            'category' => 'Finance',
        ]);
        
        // Stock opnames removed to start fresh
    }
}
