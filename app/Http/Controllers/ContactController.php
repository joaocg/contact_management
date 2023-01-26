<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{

    /**
     * @return Response
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(5);

        return view('contacts.index',compact('contacts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * @return Response
     */
    public function create()
    {
        $verifyAuth = $this->loadAuthChecker();;
        if($verifyAuth instanceof RedirectResponse){
            return $verifyAuth;
        }

        return view('contacts.create');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $verifyAuth = $this->loadAuthChecker();;
        if($verifyAuth instanceof RedirectResponse){
            return $verifyAuth;
        }
        $request->validate([
            'name' => 'required|min:5',
            'contact' => 'required|min:9|max:9|unique:contacts,contact',
            'email' => 'required|email|unique:contacts,email'
        ]);

        Contact::create($request->all());

        return redirect()->route('contacts.index')
            ->with('success','Contact created successfully.');
    }


    /**
     * @param Contact $contact
     * @return Response
     */
    public function show(Contact $contact)
    {
        $verifyAuth = $this->loadAuthChecker();;
        if($verifyAuth instanceof RedirectResponse){
            return $verifyAuth;
        }
        return view('contacts.show',compact('contact'));
    }


    /**
     * @param Contact $contact
     * @return Response
     */
    public function edit(Contact $contact)
    {
        $verifyAuth = $this->loadAuthChecker();;
        if($verifyAuth instanceof \Illuminate\Http\RedirectResponse){
            return $verifyAuth;
        }

        return view('contacts.edit',compact('contact'));
    }

    /**
     * @param Request $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function update(Request $request, Contact $contact)
    {
        $verifyAuth = $this->loadAuthChecker();;
        if($verifyAuth instanceof RedirectResponse){
            return $verifyAuth;
        }

        $request->validate([
            'name' => 'required|min:5',
            'contact' => 'required|min:9|max:9|unique:contacts,contact',
            'email' => 'unique:users,email,'.$contact->id
        ]);

        $contact->update($request->all());

        return redirect()->route('contacts.index')
            ->with('success','Contact updated successfully');
    }

    /**
     * @param Contact $contact
     * @return Response
     */
    public function destroy(Contact $contact)
    {
        $verifyAuth = $this->loadAuthChecker();;
        if($verifyAuth instanceof RedirectResponse){
            return $verifyAuth;
        }

        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success','Contact deleted successfully');
    }

    /**
     * @return RedirectResponse
     */
    private function loadAuthChecker(){

        if(Auth::check() === false)
        {
            return redirect()->route('contacts.index')
                ->with('error','Not permission!');
        }

        return true;
    }
}
