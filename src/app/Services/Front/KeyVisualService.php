<?php
namespace App\Services\Front;
use App\Models\Admin\KeyVisual;
use App\Repositories\Front\KeyVisualRepository;
class KeyVisualService
{
    private $keyVisualRepository;
    public function __construct(KeyVisualRepository $keyVisualRepository)
    {
        $this->keyVisualRepository = $keyVisualRepository;
    }
    public function displayKeyVisualsOnTheTopPage()
    {
        $now_date = date('Y-m-d H:i:s');
        $query = KeyVisual::where('deleted_at', NULL)->where('is_display', 1)->orderByRaw('CAST(display_order as SIGNED) ASC');
        $query->where(function($query) use ($now_date) {
            $query->where(function($query) {
                $query->where('public_start_date', NULL)->where('public_end_date', NULL);
            })->Orwhere(function($query) use ($now_date) {
                $query->where('public_start_date','<=', $now_date)->where('public_end_date', NULL);
            })->Orwhere(function($query) use ($now_date) {
                $query->where('public_start_date', NULL)->where('public_end_date', '>=', $now_date);
            })->Orwhere(function($query) use ($now_date) {
                $query->where('public_start_date', '<=', $now_date)->where('public_end_date', '>=', $now_date);
            });
        });
        return $this->keyVisualRepository->getByQuery($query);
    }
}