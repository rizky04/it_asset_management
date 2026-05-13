<?php

namespace App\Http\Controllers;

use App\Models\Handover;
use Illuminate\Http\Request;

class HandoverController extends Controller
{
    public function index()
    {
        $handovers = Handover::latest()->paginate(15);

        return view('handovers.index', compact('handovers'));
    }

    public function create()
    {
        $handover = new Handover();
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
            'doc_number' => 'required|string|unique:handovers,doc_number,' . $handover->id,
            'type' => 'required|in:laptop,add_on',
            'handover_date' => 'required|date',
            'from_name' => 'required|string|max:255',
            'from_position' => 'nullable|string|max:255',
            'from_department' => 'nullable|string|max:255',
            'dept_head' => 'nullable|string|max:255',
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

    public function destroy(Handover $handover)
    {
        $handover->delete();

        return redirect()->route('handovers.index')->with('success', 'Serah terima berhasil dihapus.');
    }
}
