<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Lending;
use Illuminate\Http\Request;

class LendingController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $status = $request->input('status');

        $lendings = Lending::with('asset')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('borrower', 'like', "%{$q}%")
                        ->orWhere('department', 'like', "%{$q}%")
                        ->orWhere('notes', 'like', "%{$q}%")
                        ->orWhereHas('asset', fn ($a) => $a->where('name', 'like', "%{$q}%")
                            ->orWhere('code', 'like', "%{$q}%")
                            ->orWhere('brand', 'like', "%{$q}%"));
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('lendings.index', compact('lendings', 'q', 'status'));
    }

    public function create()
    {
        $assets = Asset::orderBy('category')->orderBy('name')->get();

        return view('lendings.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'borrower' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'lend_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:lend_date',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'active';
        $validated['return_date'] = null;

        Lending::create($validated);

        return redirect()->route('lendings.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function show(Lending $lending)
    {
        $lending->load('asset');

        return view('lendings.show', compact('lending'));
    }

    public function edit(Lending $lending)
    {
        $assets = Asset::orderBy('category')->orderBy('name')->get();

        return view('lendings.edit', compact('lending', 'assets'));
    }

    public function update(Request $request, Lending $lending)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'borrower' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'lend_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:lend_date',
            'return_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,returned',
        ]);

        $lending->update($validated);

        return redirect()->route('lendings.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy(Lending $lending)
    {
        $lending->delete();

        return redirect()->route('lendings.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function returnForm(Lending $lending)
    {
        return view('lendings.return', compact('lending'));
    }

    public function returnStore(Request $request, Lending $lending)
    {
        $validated = $request->validate([
            'return_date' => 'required|date',
        ]);

        $lending->update([
            'return_date' => $validated['return_date'],
            'status' => 'returned',
        ]);

        return redirect()->route('lendings.index')->with('success', 'Pengembalian berhasil dicatat.');
    }
}
