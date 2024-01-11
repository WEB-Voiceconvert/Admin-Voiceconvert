<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Berita;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Gallery;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ClientController extends Controller
{
    public function allProducts(Request $request)
    {
        try {
            if ($request->sort == 'oldest') {
                $data = Product::orderBy('created_at');
            } else {
                $data = Product::orderByDesc('created_at');
            }

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Products fetched successfully.',
                ],
                'data' => $data->with('images')->get(),
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Not found.',
                ],
            ], 404);
        }
    }

    public function getProduct($id)
    {
        try {
            $data = Product::where('id', $id)->with('images')->first();

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Product fetched successfully.',
                ],
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Not found.',
                ],
            ], 404);
        }
    }

    public function allAlats()
    {
        try {
            $data = Alat::all();

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Alats fetched successfully.',
                ],
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Not found.',
                ],
            ], 404);
        }
    }

    public function getAlat($id)
    {
        try {
            $data = Alat::findOrFail($id);

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Alat fetched successfully.',
                ],
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Not found.',
                ],
            ], 404);
        }
    }

    public function allBeritas(Request $request)
    {
        try {
            if ($request->sort == 'oldest') {
                $data = Berita::orderBy('created_at');
            } else {
                $data = Berita::orderByDesc('created_at');
            }
            if (isset($request->id_alat)) {
                $data = $data->where('id_alat', $request->id_alat);
            }

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Berita fetched successfully.',
                ],
                'data' => $data->with('voices')->get(),
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Not found.',
                ],
            ], 404);
        }
    }

    public function getBerita($id)
    {
        try {
            $data = Berita::with('voices')->where('id', $id)->first();

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Berita fetched successfully.',
                ],
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Not found.',
                ],
            ], 404);
        }
    }

    public function allEvents(Request $request)
    {
        try {
            if ($request->sort == 'oldest') {
                $data = Event::orderBy('created_at');
            } else {
                $data = Event::orderByDesc('created_at');
            }
            if (isset($request->category)) {
                $data = $data->where('id_category', $request->category);
            }
            if (isset($request->id_alat)) {
                $data = $data->where('id_alat', $request->id_alat);
            }

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Events fetched successfully.',
                ],
                'data' => $data->with('voices')->get(),
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Not found.',
                ],
            ], 404);
        }
    }

    public function allEventCategories()
    {
        try {
            $data = EventCategory::all();

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Event Category fetched successfully.',
                ],
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Not found.',
                ],
            ], 404);
        }
    }

    public function getEvent($id)
    {
        try {
            $data = Event::with('voices')->where('id', $id)->first();

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Event fetched successfully.',
                ],
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Not found.',
                ],
            ], 404);
        }
    }

    public function allGalleries(Request $request)
    {
        try {
            if ($request->sort == 'oldest') {
                $data = Gallery::orderBy('created_at');
            } else {
                $data = Gallery::orderByDesc('created_at');
            }

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Galleries fetched successfully.',
                ],
                'data' => $data->with('images')->get(),
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Not found.',
                ],
            ], 404);
        }
    }

    public function getGallery($id)
    {
        try {
            $data = Gallery::where('id', $id)->with('images')->first();

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Gallery fetched successfully.',
                ],
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'Not found.',
                ],
            ], 404);
        }
    }
}
