@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            @if ($message_error = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message_error }}</p>
                </div>
            @endif


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Contacts') }}</div>

                    <div class="card-body">
                        <div class="float-end mb-3">
                            @auth
                                <a class="btn btn-success" href="{{ route('contacts.create') }}"> Add new contact</a>
                            @endauth
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                @auth
                                    <th width="300px"></th>
                                @endauth
                            </tr>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->contact }}</td>
                                    <td>{{ $contact->email }}</td>
                                    @auth
                                        <td>
                                            <form action="{{ route('contacts.destroy',$contact->id) }}" method="POST">

                                                <a class="btn btn-info btn-sm" href="{{ route('contacts.show',$contact->id) }}">Contact details</a>

                                                <a class="btn btn-primary btn-sm" href="{{ route('contacts.edit',$contact->id) }}">Edit contact</a>

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm">Delete contact</button>
                                            </form>
                                        </td>
                                    @endauth
                                </tr>
                            @endforeach
                        </table>

                        {!! $contacts->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


