<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statistic;

class StatisticController extends Controller
{
    /**
     * Display a listing of site statistics.
     */
    public function index()
    {
        $statistics = Statistic::orderBy('group')->orderBy('sort_order')->get();
        return view('admin.statistics.index', compact('statistics'));
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $statistic = Statistic::findOrFail($id);
        return view('admin.statistics.edit', compact('statistic'));
    }

    /**
     * Update the statistic record.
     */
    public function update(Request $request, $id)
    {
        $statistic = Statistic::findOrFail($id);

        $request->validate([
            'value' => 'required|string|max:50',
            'label' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'color_class' => 'nullable|string|max:255',
        ]);

        $statistic->update([
            'value' => $request->value,
            'label' => $request->label,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order,
            'color_class' => $request->color_class,
        ]);

        return redirect()->route('admin.statistics.index')->with('success', 'Statistik berhasil diperbarui.');
    }
}
