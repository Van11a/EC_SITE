<?php
namespace App\Repositories\Admin;
use App\Models\Admin\KeyVisual;
class KeyVisualRepository
{
    protected $keyVisual;

    public function __construct(KeyVisual $keyVisual)
    {
        $this->keyVisual = $keyVisual;
    }

    public function getAll()
    {
        return $this->keyVisual->paginate(10);
    }

    public function create(array $data)
    {
        return $this->keyVisual->create($data);
    }

    public function update(KeyVisual $keyVisual, array $data)
    {
        return $keyVisual->update($data);
    }

    public function delete(KeyVisual $keyVisual)
    {

        return $keyVisual->delete();
    }
}