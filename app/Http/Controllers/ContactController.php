<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Contact::with('user')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $fields = $request->validate([
            "name" => "required|min:2|max:20",
            "address" => "nullable|max:100",
            "phone" => "required|numeric",
            "email" => "nullable|email|max:100"

        ]);
        $fields['user_id'] = auth()->id();
        $contact = $request->user()->contacts()->create($fields);

        return ['contact' => $contact, 'user' => $contact->user];
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return ['contact' => $contact, 'user' => $contact->user];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $fields = $request->validate([
            "name" => "nullable|min:2|max:20",
            "phone" => "nullable|numeric",
            "address" => "nullable|max:100",
            "email" => "nullable|email|max:100",
        ]);

        $contact->update($fields);

        return ['contact' => $contact, 'user' => $contact->user];
    }

   



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return ['message' => 'The contact was deleted'];
    }
}
