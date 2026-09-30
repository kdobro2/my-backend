<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/places', function () {
    $path = storage_path('app/places.json');
    if (!file_exists($path)) {
        return response()->json([]);
    }

    $places = json_decode(file_get_contents($path), true) ?? [];
    
    return response()->json($places);
});

Route::get('/places/{id}', function (int $id) {
    $path = storage_path('app/places.json');

    if (!file_exists($path)) {
        return response()->json([
            'message' => 'Place not found'
        ], 404);
    }

    $places = json_decode(file_get_contents($path), true) ?? [];

    foreach ($places as $place) {
        if ((int) $place['id'] === $id) {
            return response()->json($place);
        }
    }

    return response()->json([
        'message' => 'Place not found'
    ], 404);
});

Route::post('/places/{id}/edit', function (Request $request, int $id) {
    $path = storage_path('app/places.json');

    $places = file_exists($path)
        ? json_decode(file_get_contents($path), true) ?? []
        : [];

    foreach ($places as $index => $place) {
        if ((int) $place['id'] === $id) {
            $places[$index] = [
                'id' => $id,
                'name' => $request->input('name'),
                'category' => $request->input('category'),
                'cost' => $request->input('cost'),
                'added' => $request->input('added'),
                'beenThere' => (bool) $request->input('beenThere'),
            ];

            file_put_contents(
                $path,
                json_encode($places, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );

            return response()->json($places[$index]);
        }
    }

    return response()->json([
        'message' => 'Place not found'
    ], 404);
});

Route::post('/places/{id}/been-there', function (Request $request, int $id) {
    $path = storage_path('app/places.json');

    $places = file_exists($path)
        ? json_decode(file_get_contents($path), true) ?? []
        : [];

    foreach ($places as $index => $place) {
        if ((int) $place['id'] === $id) {
            $places[$index]['beenThere'] = (bool) $request->input('beenThere');

            file_put_contents(
                $path,
                json_encode($places, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );

            return response()->json($places[$index]);
        }
    }

    return response()->json([
        'message' => 'Place not found'
    ], 404);
});

Route::delete('/places/{id}', function (int $id) {
    $path = storage_path('app/places.json');

    $places = file_exists($path)
        ? json_decode(file_get_contents($path), true) ?? []
        : [];

    foreach ($places as $index => $place) {
        if ((int) $place['id'] === $id) {
            $deleted = $places[$index];

            unset($places[$index]);

            $places = array_values($places);

            file_put_contents(
                $path,
                json_encode($places, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );

            return response()->json($deleted);
        }
    }

    return response()->json([
        'message' => 'Place not found'
    ], 404);
});