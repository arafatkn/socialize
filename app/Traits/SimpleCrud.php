<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait SimpleCrud
{
    protected function getModel()
    {
        return new ($this->model);
    }

    protected function getWithAll()
    {
        return $this->withAll ?? [];
    }

    protected function getWithOne()
    {
        return $this->withOne ?? [];
    }

    public function index()
    {
        return $this->getModel()->with($this->getWithAll())->paginate();
    }

    public function show($id)
    {
        $data = $this->getModel()->with($this->getWithOne())->findOrFail($id);
        return $data;
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->createRules);

        $model = $this->getModel();
        $model->fill($data);

        if ($model->save()) {
            return response()->json([
                'message' => 'Item has been added successfully.',
            ]);
        }

        return response()->json([
            'message' => 'Something is wrong here...',
        ], 503);
    }

    public function update($id, Request $request)
    {
        $data = $request->validate($this->updateRules);

        $model = $this->getModel()->findOrFail($id);
        $model->fill($data);

        if ($model->save()) {
            return response()->json([
                'message' => 'Item has been updated successfully.',
            ]);
        }

        return response()->json([
            'message' => 'Something is wrong here...',
        ], 503);
    }

    public function destroy($id)
    {
        if ($this->getModel()->where('id', $id)->delete()) {
            return response()->json([
                'message' => 'Item has been removed successfully.',
            ]);
        }

        return response()->json([
            'message' => 'Unable to delete.',
        ]);
    }
}
