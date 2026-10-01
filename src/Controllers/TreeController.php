<?php

namespace App\Controllers;

use App\Models\Family;
use App\Models\Person;
use App\Models\User;
use App\Plot\Plot;
use PXP\Auth\Auth;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;
use PXP\Lib\Notification;

class TreeController extends Controller
{
    public function tree(): Response
    {
        if (request('start') === 'random') {
            $start = Person::all()->sample()->first();
        } else {
            $start = Person::findOrNull(request('start'))
                ?? Auth::user()?->person()
                ?? Person::all()->sample()->first();
        }

        $plot = new Plot($start);

        return view('tree', compact('start', 'plot'));
    }

    public function info(): Response
    {
        return view('info', [
            'families' => Family::all(),
            'people' => Person::all(),
        ]);
    }

    public function share(): Response
    {
        $data = request()->validate(fn ($req) => [
            $req->person_id->int(),
            $req->email->string()->email(),
            $req->password->string()->min(8),
        ]);

        $person = Person::find($data->person_id);

        if ($user = $person->user()) {
            Notification::info("Benutzer '$user->name' existiert bereits.");

            return Redirect::route('tree');
        }

        $user = User::make(o(
            identifier: $data->email,
            name: $person->name(),
            secret: $data->password,
        ));

        $user->person_id = $data->person_id;
        $user->save();

        return Redirect::route('tree');
    }
}
