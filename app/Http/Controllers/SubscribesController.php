<?php

namespace App\Http\Controllers;

use Newsletter;
use App\Http\Requests\StoreSubscribe;
use App\Subscribe;
use Illuminate\Database\QueryException;

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
        static::syncWithMailchimp();

        try {
            $data = [
                'title'      => 'Feliratkozások listája',
                'subscribes' => Subscribe::orderBy('created_at', 'desc')->paginate(10),
            ];

            return view('subscribes.list', $data);
        } catch (\Exception $ex) {
            return response()->with('error', $ex->getMessage());
        }
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
        try {
            if (! $request->filled('email')) throw new \Exception('Az e-mail cím megadása kötelező');

            $errors = [];
            $email  = $request->input('email');
            $FNAME  = $request->filled('first_name') ? $request->input('first_name') : '';
            $LNAME  = $request->filled('last_name')  ? $request->input('last_name')  : '';
            $userId = $request->filled('user_id')    ? $request->input('user_id')    : auth()->user()->id;

            // Feliratkozás Mailchimpben
            if (! Newsletter::isSubscribed($email)) {
                Newsletter::subscribeOrUpdate($email, compact(['FNAME', 'LNAME']), 'subscribers');

                if (Newsletter::lastActionSucceeded()) \Log::info("{$email} feliratkoztatása a Mailchimpben sikeres.");
                $errors[] = Newsletter::getLastError();
            } else $errors[] = $email . ' e-mail cím már fel van iratkozva a Mailchimpben.';

            // Feliratkozás rekord létrehozása a lokális adatbázisban
            $subscribes = new Subscribe();
            $subscribes->last_name  = $LNAME ?? null;
            $subscribes->first_name = $FNAME ?? null;
            $subscribes->email      = $email;
           #$subscribes->fk_id_user = $userId;
            $subscribes->save()
                ? \Log::info("{$email} feliratkozásának mentése lokálisan sikeres.")
                : $errors[] = "{$email} feliratkozásának mentése lokálisan sikertelen.";

            // Hibakezelés
            if ($this->errorHandling('Feliratkozás hibalista', $errors)) {
                return redirect('/subscribes')->with('error', $errors);
                // throw new \Exception($errors);
            }

            return redirect('/subscribes')->with('success', 'Sikeres feliratkozás. :)');
        } catch (QueryException $ex) {
            \Log::error($ex->getMessage());
            return response()->with('error', $ex->getMessage());
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return response()->with('error', $ex->getMessage());
        }
    }

    /**
     * Adott feliratkozás megjelenítése
     *
     * @param  string $email
     * @return \Illuminate\Http\Response
     */
    public function show(string $email)
    {
        try {
            $data = [
                'title' => 'Feliratkozás megjelenítése',
                'subscriber' => Subscribe::find($email),
            ];

            return view('subscribes.show', $data);
        } catch (QueryException $ex) {
            \Log::error($ex->getMessage());
            return response()->with('error', $ex->getMessage());
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return response()->with('error', $ex->getMessage());
        }
    }

    /**
     * Feliratkozás módosítása form
     *
     * @param  string $email
     * @return \Illuminate\Http\Response
     */
    public function edit(string $email)
    {
        try {
            $data = [
                'title' => 'Feliratkozás módosítása',
                'subscriber' => Subscribe::findOrFail($email),
            ];

            return view('subscribes.edit', $data);
        } catch (QueryException $ex) {
            \Log::error($ex->getMessage());
            return response()->with('error', $ex->getMessage());
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return response()->with('error', $ex->getMessage());
        }
    }

    /**
     * Feliratkozás módosítása
     *
     * @param  StoreSubscribe $request
     * @param  string $email
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSubscribe $request, string $email)
    {
        try {
            if (! $email) throw new \Exception('Az e-mail cím megadása kötelező');

            $errors = [];
            $email  = $request->input('email');
            $FNAME  = $request->filled('first_name') ? $request->input('first_name') : '';
            $LNAME  = $request->filled('last_name')  ? $request->input('last_name')  : '';
            $userId = $request->filled('user_id')    ? $request->input('user_id')    : auth()->user()->id;

            // Feliratkozás adatainak módosítása Mailchimpben
            if (Newsletter::isSubscribed($email)) {
                Newsletter::subscribeOrUpdate($email, compact(['FNAME', 'LNAME']), 'subscribers');

                if (Newsletter::lastActionSucceeded()) \Log::info("{$email} adatainak módosítása a Mailchimpben sikeres.");
                $errors[] = Newsletter::getLastError();
            }

            // Feliratkozás adatainak módosítása a lokális adatbázisban
            if ($subscriber = Subscribe::find($email)) {
                $subscriber->last_name  = $LNAME ?? null;
                $subscriber->first_name = $FNAME ?? null;
                $subscriber->email      = $email;
               #$subscriber->fk_id_user = $userId;
                $subscriber->save()
                    ? \Log::info("{$email} feliratkozásának módosítása lokálisan sikeres.")
                    : $errors[] = "{$email} feliratkozásának módosítása lokálisan sikertelen.";
            } else $errors[] = "{$email} nem található a lokális feliratkozási listában.";

            // Hibakezelés
            if ($this->errorHandling('Módosítás hibalista', $errors)) {
                return redirect('/subscribes/' . $email)->with('error', $errors);
                // throw new \Exception($errors);
            }

            return redirect('/subscribes/' . $email)->with('success', 'A feliratkozási adatok módosítása sikeres.');
        } catch (QueryException $ex) {
            \Log::error($ex->getMessage());
            return response()->with('error', $ex->getMessage());
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return response()->with('error', $ex->getMessage());
        }
    }

    /**
     * Feliratkozás törlése
     *
     * @param  string $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $email)
    {
        try {
            $subscriber = Subscribe::findOrFail($email);
            $errors = [];

            // Leiratkozás Mailchimpben
            if (Newsletter::isSubscribed($email)) {
                Newsletter::unsubscribe($email, 'subscribers');

                if (Newsletter::lastActionSucceeded()) \Log::info("{$email} leiratkozása a Mailchimpben sikeres.");
                $errors[] = Newsletter::getLastError();
            } else {
                $errors[] = "Nem található feliratkozó {$email} e-mail címmel a Mailchimp kiszolgálón.";
            }

            // Feliratkozás eltávolítása a lokális adatbázisból
            if ($subscriber instanceof Subscribe) {
                $subscriber->delete()
                    ? \Log::info("{$email} feliratkozásának törlése lokálisan sikeres.")
                    : $errors[] = "{$email} feliratkozásának törlése lokálisan sikertelen.";
            } else {
                $errors[] = "Nem található feliratkozó {$email} e-mail címmel a lokális listában.";
            }

            // Hibakezelés
            if ($this->errorHandling('Leiratkozás hibalista', $errors)) {
                return redirect('/subscribes')->with('error', $errors);
                // throw new \Exception($errors);
            }

            return redirect('/subscribes')->with('success', 'Sikeres leiratkozás.');
        } catch (QueryException $ex) {
            \Log::error($ex->getMessage());
            return response()->with('error', $ex->getMessage());
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return response()->with('error', $ex->getMessage());
        }
    }

    /**
     * E-mail létezésének ellenőrzése a Mailchimp kontaktok között
     * 
     * @param string $email
     */
    public static function contactExists($email)
    {
        $mailchimp = Newsletter::getApi();
        $listId = env('MAILCHIMP_LIST_ID');
        $subscriberHash = $mailchimp::subscriberHash($email);

        $response = $mailChimp->get("lists/{$listId}/members/{$subscriberHash}");

        return isset($response) ? true : false;
    }

    /**
     * Példa az API funkciók bővítésére
     * 
     * @param string $email
     */
    public static function reSubscribe(string $email)
    {
        $mailchimp = Newsletter::getApi();
        $listId = env('MAILCHIMP_LIST_ID');
        $subscriberHash = $mailchimp::subscriberHash($email);

        $response = $mailchimp->patch("lists/{$listId}/members/{$subscriberHash}", ['status' => 'subscribed', 'email_type' => 'html']);

        return $mailchimp->success() ? $response : $mailchimp->getLastError();
    }

    /**
     * Feliratkozások szinkronizálása
     */
    public static function syncWithMailchimp()
    {
        // A lokális adatbázis- és a Mailchimp érintett mezőneveinek megfeleltetése
        $fieldPairs = [
            'email'       => 'email_address',
            'last_name'   => 'LNAME',
            'first_name'  => 'FNAME',
        ];

        $memberList = Newsletter::getMembers('subscribers');

        // Mailchimp kontaktok importálása / frissítése a lokális listában
        foreach ($memberList['members'] as $member) {
            $email = $member['email_address'];

            if ($member['status'] === 'subscribed') {
                $subscriberData = compact('email') + [
                    'last_name'  => $member['merge_fields']['LNAME'],
                    'first_name' => $member['merge_fields']['FNAME'],
                ];

                Subscribe::updateOrCreate(compact('email'), $subscriberData)
                    ? \Log::info("{$email} lokális feliratkoztatása a szinkronizálás során sikeres.")
                    : \Log::error(Newsletter::getLastError());
            } elseif ($subscriber = Subscribe::find($email)) {
                    $subscriber->delete()
                        ? \Log::info("{$email} feliratkozásának lokális törlése a szinkronizálás során sikeres.")
                        : \Log::error("{$email} feliratkozásának lokális törlése a szinkronizálás során sikertelen.");
            }
        }

        // Lokális feliratkozások exportálása / frissítése a Mailchimp listában
        foreach (Subscribe::all(array_keys($fieldPairs)) as $subscriber) {
            if (! Newsletter::isSubscribed($subscriber->email)) {
                Newsletter::subscribeOrUpdate($subscriber->email, array_combine($fieldPairs, $subscriber->toArray()), 'subscribers');

                Newsletter::lastActionSucceeded()
                    ? \Log::info("{$subscriber->email} feliratkoztatása Mailchimpben a szinkronizálás során sikeres.")
                    : \Log::error(Newsletter::getLastError());
            }
        }
    }

    /**
     * Hibakezelés
     * 
     * @param string $errorLog
     * @param array  $errors
     * @return array|null
     */
    protected function errorHandling(string $errorLog, array $errors)
    {
        if ($errors = array_filter($errors)) {
            sort($errors);
            foreach ($errors as $i => $error) $errorLog .= "\r\n#" . ($i+1) . ' ' . $error;

            \Log::error($errorLog);
            return $errors;
        } else{
            return null;
        }
    }
}
