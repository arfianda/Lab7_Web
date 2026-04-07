<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about(): string
    {
        return view('about_new', [
            'title' => 'About',
            'content' => 'Ini adalah halaman about praktikum CodeIgniter 4.'
        ]);
    }

    public function contact(): string
    {
        return view('contact_new', [
            'title' => 'Kontak',
        ]);
    }

    public function faqs(): string
    {
        return view('faqs', [
            'title' => 'Halaman FAQs',
        ]);
    }

    public function tos(): string
    {
        return view('tos', [
            'title' => 'Halaman Term of Services',
        ]);
    }
}
