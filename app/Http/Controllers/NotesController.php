<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notes;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notes = $user->notes()->where('archived', false)->get();

        return view('home.index', [
            "notes" => $notes,
        ]);
    }

    public function archived()
    {
        $user = Auth::user();
        $archivedNotes = $user->notes()->where('archived', true)->get();

        return view('home.archived', [
            "notes" => $archivedNotes,
        ]);
    }

    public function makeArchived(Notes $note)
    {
        $note->update(['archived' => true]);
        return redirect('/');
    }

    public function unArchive(Notes $note)
    {
        $note->update(['archived' => false]);
        return redirect('archived');
    }

    public function show(Notes $note)
    {
        return view('details.index', [
            "note" => $note,
        ]);
    }

    public function create()
    {
        return view('home.create');
    }

    public function newnote(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'max:255',
        ]);

        $user = Auth::user();
        $note = new Notes($validatedData);
        $user->notes()->save($note);

        return redirect('/')->with('success', 'New Note has been added');
    }

    public function destroy(Notes $note)
    {
        $note->delete();
        return redirect('/')->with('success', 'Note has been deleted');
    }

    public function edit(Notes $note)
    {
        return view('home.edit', [
            "note" => $note,
        ]);
    }

    public function update(Request $request, Notes $note)
    {
        $rules = [
            'title' => 'required|max:255',
            'content' => 'max:255',
        ];

        $updatedData = $request->validate($rules);
        $note->update($updatedData);
        return redirect('/')->with('success', 'Note has been updated');
    }
}