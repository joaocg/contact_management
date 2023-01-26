<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(5);

        return view('contacts.index',compact('contacts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'required|max:9|unique:contacts,contact',
            'email' => 'required|email|unique:contacts,email'
        ]);

        Contact::create($request->all());

        return redirect()->route('contacts.index')
            ->with('success','Contact created successfully.');
    }


    /**
     * @param Contact $contact
     * \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return view('contacts.show',compact('contact'));
    }


    /**
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit',compact('contact'));
    }

    /**
     * @param Request $request
     * @param Contact $contact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'required|max:9',
            'email' => 'unique:users,email,'.$contact->id
        ]);

        $contact->update($request->all());

        return redirect()->route('contacts.index')
            ->with('success','Contact updated successfully');
    }

    /**
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success','Contact deleted successfully');
    }
}
