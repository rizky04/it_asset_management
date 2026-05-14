<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    private const CATEGORIES = [
        'AC', 'Access Point', 'CPU', 'Harddisk', 'Kursi', 'Lainnya',
        'Laptop', 'Lemari', 'Meja', 'Monitor', 'Papan Tulis', 'Printer',
        'Projector', 'Rak', 'Router', 'Server', 'Switch', 'TV', 'UPS',
    ];

    public function index(Request $request)
    {
        $q = $request->input('q');
        $category = $request->input('category');

        $assets = Asset::when($q, function ($query) use ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%")
                    ->orWhere('pic', 'like', "%{$q}%");
            });
        })
            ->when($category, fn ($query) => $query->where('category', $category))
            ->orderBy('category')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $categories = self::CATEGORIES;

        return view('assets.index', compact('assets', 'q', 'category', 'categories'));
    }

    public function create()
    {
        $categories = self::CATEGORIES;

        return view('assets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'material' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255|unique:assets,code',
            'qty' => 'required|integer|min:0',
            'good' => 'required|integer|min:0',
            'broken' => 'required|integer|min:0',
            'pic' => 'nullable|string|max:255',
            'for_sale' => 'boolean',
            'obsolete' => 'boolean',
        ]);

        $validated['for_sale'] = $request->boolean('for_sale');
        $validated['obsolete'] = $request->boolean('obsolete');

        Asset::create($validated);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function show(Asset $asset)
    {
        $asset->load('lendings');

        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $categories = self::CATEGORIES;

        return view('assets.edit', compact('asset', 'categories'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'material' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255|unique:assets,code,'.$asset->id,
            'qty' => 'required|integer|min:0',
            'good' => 'required|integer|min:0',
            'broken' => 'required|integer|min:0',
            'pic' => 'nullable|string|max:255',
            'for_sale' => 'boolean',
            'obsolete' => 'boolean',
        ]);

        $validated['for_sale'] = $request->boolean('for_sale');
        $validated['obsolete'] = $request->boolean('obsolete');

        $asset->update($validated);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus.');
    }
}
