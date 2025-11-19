<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
use Carbon\Carbon;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::orderBy('date', 'desc')->get();
        return response()->json([
            'success' => true,
            'holidays' => $holidays
        ]);
    }

    public function list()
    {
        $holidays = Holiday::orderBy('date', 'desc')->get();
        return response()->json([
            'success' => true,
            'holidays' => $holidays
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|date|unique:holidays,date',
                'reason' => 'required|string|max:255',
                'description' => 'nullable|string',
                'no_classes' => 'boolean'
            ]);

            $holiday = Holiday::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Feriado guardado correctamente',
                'holiday' => $holiday
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el feriado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $holiday = Holiday::findOrFail($id);
            return response()->json([
                'success' => true,
                'holiday' => $holiday
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Feriado no encontrado'
            ], 404);
        }
    }

    public function update(Request $request, $id)
{
    try {
        \Log::info('🔄 Actualizando feriado ID: ' . $id, $request->all());
        
        $holiday = Holiday::findOrFail($id);
        
        $validated = $request->validate([
            'date' => 'required|date|unique:holidays,date,' . $id,
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string',
            'no_classes' => 'boolean'
        ]);

        $holiday->update($validated);

        \Log::info('✅ Feriado actualizado correctamente', $holiday->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Feriado actualizado correctamente',
            'holiday' => $holiday
        ]);

    } catch (\Exception $e) {
        \Log::error('❌ Error al actualizar feriado: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el feriado: ' . $e->getMessage()
        ], 500);
    }
}

    public function destroy($id)
    {
        try {
            $holiday = Holiday::findOrFail($id);
            $holidayData = $holiday; // Guardar datos antes de eliminar
            
            $holiday->delete();

            return response()->json([
                'success' => true,
                'message' => 'Feriado eliminado correctamente',
                'holiday' => $holidayData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el feriado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function check(Request $request)
    {
        $date = $request->query('date');
        
        $holiday = Holiday::where('date', $date)->first();
        
        return response()->json([
            'is_holiday' => !is_null($holiday),
            'holiday' => $holiday
        ]);
    }
}