<?php

namespace App\Http\Controllers;

use App\Repositories\NotesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{
    protected $notes_repository;

    public function __construct()
    {
        $this->notes_repository = new NotesRepository();
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array('title' => 'required', 'description' => 'required'));
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            if (!empty($data['id']) && $data['id'] > 0) {
                $this->notes_repository->update($data, $data['id']);
            } else {
                $this->notes_repository->store($data);
            }

            DB::commit();
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Note has been added.',
                    'data'    => [
                        'notes_container' => view('layouts.notes')->render()
                    ]
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->notes_repository->delete($id);

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Note has been deleted.',
                    'data'    => [
                        'notes_container' => view('layouts.notes')->render()
                    ]
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }
}
