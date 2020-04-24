<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Üdvözlő oldal megjelenítése
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        $title = 'Üdvözlő oldal';
        return view('pages.welcome')->with(compact('title'));
    }

    /**
     * Kezdőoldal megjelenítése
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return redirect('/subscribes');
    }

    /**
     * Kapcsolat oldal megjelenítése
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        $data = [
            'title' => 'Kapcsolat',
            'info'  => [
                ['title' => 'Címünk',     'value' => '1024 Budapest, Margit krt. 5/b',],
                ['title' => 'Telefon',    'value' => '(1) 796-8199',],
                ['title' => 'E-mail cím', 'value' => 'szerk@444.hu',],
            ],
        ];
        return view('pages.contact', $data);
    }
}
