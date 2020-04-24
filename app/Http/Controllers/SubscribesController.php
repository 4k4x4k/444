<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscribe;
use App\Subscribe;
#use Illuminate\Http\Request;
#use Illuminate\Support\Facades\{Session, Validator};

class SubscribesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Feliratkozások listájának megjelenítése
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title'      => 'Feliratkozások listája',
            'subscribes' => Subscribe::orderBy('created_at', 'desc')->paginate(10),
        ];

        return view('subscribes.list', $data);
    }

    /**
     * Új feliratkozás form
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Új feliratkozás létrehozása';
        return view('subscribes.create', compact('title'));
    }

    /**
     * Új feliratkozás létrehozása
     *
     * @param  StoreSubscribe $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscribe $request)
    {
        $subscribes = new Subscribe();
        $subscribes->name = $request->input('name');
        $subscribes->email = $request->input('email');
        if ($request->filled('user_id')) $subscribes->fk_id_user = (int) $request->input('user_id');
        $subscribes->save();

        return redirect('/subscribes')->with('success', 'Sikeres feliratkozás. :)');
    }

    /**
     * Adott feliratkozás megjelenítése
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $data = [
            'title'      => 'Feliratkozás megjelenítése',
            'subscriber' => Subscribe::find($id),
        ];

        return view('subscribes.show', $data);
    }

    /**
     * Feliratkozás módosítása form
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $data = [
            'title'      => 'Feliratkozás módosítása',
            'subscriber' => Subscribe::findOrFail($id),
        ];

        return view('subscribes.edit', $data);
    }

    /**
     * Feliratkozás módosítása
     *
     * @param  StoreSubscribe $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSubscribe $request, int $id)
    {
        $subscriber = Subscribe::findOrFail($id);
        $subscriber->name = $request->input('name');
        $subscriber->email = $request->input('email');
        if ($request->filled('user_id')) $subscriber->fk_id_user = (int) $request->input('user_id');
        $subscriber->save();

        return redirect('/subscribes/' . $id)->with('success', 'A feliratkozási adatok módosítása sikeres.');
    }

    /**
     * Feliratkozás törlése
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $subscriber = Subscribe::findOrFail($id);
        $subscriber->delete();

        return redirect('/subscribes')->with('success', 'Sikeres leiratkozás.');
    }
}
