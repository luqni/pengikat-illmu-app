<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;


class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::latest()->paginate(10);
        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
        'title' => 'nullable|string|max:255',
        'content' => 'nullable|string',
        ]);


        Note::create($data);


        return redirect()->route('notes.index')->with('success', 'Note saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $data = $request->validate([
        'title' => 'nullable|string|max:255',
        'content' => 'nullable|string',
        ]);


        $note->update($data);


        return redirect()->route('notes.index')->with('success', 'Note updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return back()->with('success', 'Note deleted');
    }

    // OCR: menerima file image via AJAX, mengembalikan teks
    // public function ocr(Request $request)
    // {
    //     $request->validate([
    //     'image' => 'required|image|max:10240',
    //     ]);


    //     $path = $request->file('image')->store('uploads');
    //     $fullPath = Storage::path($path);


    //     // panggil tesseract
    //     $ocr = new TesseractOCR($fullPath);
    //     // jika mau set bahasa: $ocr->lang('ind');
    //     try {
    //     $text = $ocr->run();
    //     } catch (\Exception $e) {
    //     return response()->json(['error' => 'OCR failed: ' . $e->getMessage()], 500);
    //     }


    //     return response()->json(['text' => $text]);
    // }

    public function ocr(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $image = $request->file('image');

        $response = Http::attach(
            'file',
            file_get_contents($image),
            $image->getClientOriginalName()
        )->post('https://api.ocr.space/parse/image', [
            'apikey' => env('OCR_SPACE_KEY'),
            'language' => 'eng'
        ]);

        $result = $response->json();

        if (!empty($result['ParsedResults'][0]['ParsedText'])) {
            return response()->json([
                'text' => $result['ParsedResults'][0]['ParsedText']
            ]);
        }

        return response()->json([
            'error' => 'OCR failed'
        ], 400);
    }

}
