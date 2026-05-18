<?php

namespace App\Http\Controllers;

use App\Models\Handover;
use Illuminate\Http\Request;

class HandoverController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $handovers = Handover::when($q, function ($query) use ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('doc_number', 'like', "%{$q}%")
                    ->orWhere('to_name', 'like', "%{$q}%")
                    ->orWhere('from_name', 'like', "%{$q}%")
                    ->orWhere('to_department', 'like', "%{$q}%")
                    ->orWhere('serial_number', 'like', "%{$q}%")
                    ->orWhere('merek', 'like', "%{$q}%")
                    ->orWhere('type_device', 'like', "%{$q}%");
            });
        })->latest('handover_date')->latest()->paginate(15)->withQueryString();

        return view('handovers.index', compact('handovers', 'q'));
    }

    public function create()
    {
        $handover = new Handover;
        $docNumber = $handover->generateDocNumber();

        return view('handovers.create', compact('docNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doc_number' => 'required|string|unique:handovers,doc_number',
            'type' => 'required|in:laptop,add_on',
            'handover_date' => 'required|date',
            'from_name' => 'required|string|max:255',
            'from_position' => 'nullable|string|max:255',
            'from_department' => 'nullable|string|max:255',
            'dept_head' => 'nullable|string|max:255',
            'hrd_name' => 'nullable|string|max:255',
            'to_name' => 'required|string|max:255',
            'to_position' => 'nullable|string|max:255',
            'to_department' => 'nullable|string|max:255',
            'to_address' => 'nullable|string|max:255',
            'device_label' => 'nullable|string|max:255',
            'merek' => 'nullable|string|max:255',
            'type_device' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'processor' => 'nullable|string|max:255',
            'storage' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'screen_size' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
            'office_sw' => 'nullable|string|max:255',
            'software_list' => 'nullable|array',
            'software_list.*' => 'nullable|string',
            'accessories_list' => 'nullable|array',
            'accessories_list.*' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['software_list'] = array_values(array_filter($validated['software_list'] ?? []));
        $validated['accessories_list'] = array_values(array_filter($validated['accessories_list'] ?? []));

        Handover::create($validated);

        return redirect()->route('handovers.index')->with('success', 'Serah terima berhasil dibuat.');
    }

    public function show(Handover $handover)
    {
        $handover->load('signatures');

        return view('handovers.show', compact('handover'));
    }

    public function edit(Handover $handover)
    {
        return view('handovers.edit', compact('handover'));
    }

    public function update(Request $request, Handover $handover)
    {
        $validated = $request->validate([
            'doc_number' => 'required|string|unique:handovers,doc_number,'.$handover->id,
            'type' => 'required|in:laptop,add_on',
            'handover_date' => 'required|date',
            'from_name' => 'required|string|max:255',
            'from_position' => 'nullable|string|max:255',
            'from_department' => 'nullable|string|max:255',
            'dept_head' => 'nullable|string|max:255',
            'hrd_name' => 'nullable|string|max:255',
            'to_name' => 'required|string|max:255',
            'to_position' => 'nullable|string|max:255',
            'to_department' => 'nullable|string|max:255',
            'to_address' => 'nullable|string|max:255',
            'device_label' => 'nullable|string|max:255',
            'merek' => 'nullable|string|max:255',
            'type_device' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'processor' => 'nullable|string|max:255',
            'storage' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'screen_size' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
            'office_sw' => 'nullable|string|max:255',
            'software_list' => 'nullable|array',
            'software_list.*' => 'nullable|string',
            'accessories_list' => 'nullable|array',
            'accessories_list.*' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['software_list'] = array_values(array_filter($validated['software_list'] ?? []));
        $validated['accessories_list'] = array_values(array_filter($validated['accessories_list'] ?? []));

        $handover->update($validated);

        return redirect()->route('handovers.show', $handover)->with('success', 'Serah terima berhasil diperbarui.');
    }

    /** Form konfirmasi pengembalian */
    public function returnForm(Handover $handover)
    {
        abort_if($handover->isReturned(), 404);

        return view('handovers.return', compact('handover'));
    }

    /** Simpan pengembalian */
    public function returnStore(Request $request, Handover $handover)
    {
        abort_if($handover->isReturned(), 404);

        $validated = $request->validate([
            'returned_by' => 'required|string|max:255',
            'returned_at' => 'required|date',
            'return_notes' => 'nullable|string',
        ]);

        $handover->update([
            'status' => 'returned',
            'returned_by' => $validated['returned_by'],
            'returned_at' => $validated['returned_at'],
            'return_notes' => $validated['return_notes'] ?? null,
        ]);

        return redirect()->route('handovers.show', $handover)
            ->with('success', 'Laptop berhasil dicatat sebagai dikembalikan.');
    }

    /** Buka form serah terima baru dengan spek ter-copy dari handover lama */
    public function redispatch(Handover $handover)
    {
        abort_if(! $handover->isReturned(), 404);

        $handover->load('signatures');
        $docNumber = $handover->generateDocNumber();

        return view('handovers.create', [
            'docNumber' => $docNumber,
            'prefill' => $handover,
        ]);
    }

    public function print(Handover $handover)
    {
        $handover->load('signatures');

        return view('handovers.print', compact('handover'));
    }

    public function destroy(Handover $handover)
    {
        $handover->delete();

        return redirect()->route('handovers.index')->with('success', 'Serah terima berhasil dihapus.');
    }
}
