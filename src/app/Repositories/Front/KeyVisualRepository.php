<?php
namespace App\Repositories\Front;
use App\Models\Admin\KeyVisual;
class KeyVisualRepository
{
    protected $keyVisual;
    public function __construct(KeyVisual $keyVisual)
    {
        $this->keyVisual = $keyVisual;
    }
    public function getById($id)
    {
        return $this->keyVisual->find($id);
    }
    public function getByQuery($query)
    {
        return $query->get();
    }
}