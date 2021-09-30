<?php

namespace App\Http\Controllers;

use App\Models\DensityList;
use Html2Text\Html2Text;
use Illuminate\Http\Request;

class WordDensityController extends Controller
{
    public function index()
    {
        $wordDensities = DensityList::latest()->paginate(4);

        return view('density-list.index', compact('wordDensities'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }

    public function create()
    {
        return view('density-list.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'notes' => 'required|json',
        ]);

        DensityList::create($request->all());

        return redirect()->route('lists.index')
            ->with('success','Item created successfully.');
    }

    public function show(DensityList $list)
    {
        return view('density-list.show', compact('list'));
    }

    public function edit(DensityList $list)
    {
        return view('density-list.edit', compact('list'));
    }

    public function update(Request $request, DensityList $wordDensity)
    {
        $request->validate([
            'url' => 'required|url',
            'notes' => 'required|json',
        ]);

        $wordDensity->update($request->all());

        return redirect()->route('lists.index')
            ->with('success','Item updated successfully');
    }

    public function destroy(DensityList $list)
    {
        $list->delete();

        return redirect()->route('lists.index')
            ->with('success','Item deleted successfully');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $url = $request->get('url');
        $html = file_get_contents($url);
        $converter = new Html2Text(html_entity_decode($html));
        $text = $converter->getText();
        $text = strtolower($text);
        $totalWordCount = str_word_count($text);
        $wordsAndOccurrence  = array_count_values(str_word_count($text, 1));
        arsort($wordsAndOccurrence);
        $highDensities = count($wordsAndOccurrence) > 20 ?
            array_slice($wordsAndOccurrence, 0, 20) : $wordsAndOccurrence;
        $wordDensities = [];
        foreach ($highDensities as $key => $value) {
            $wordDensities[$key] = ($value / $totalWordCount);
        }

        DensityList::create([
            'url' => $url,
            'notes' => json_encode($wordDensities)
        ]);

        return redirect('/')->with([
            'url' => $url,
            'wordDensities' => json_encode($wordDensities)
        ]);
    }
}
