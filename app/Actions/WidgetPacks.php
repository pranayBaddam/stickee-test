<?php

namespace App\Actions;

use App\Actions\MinimumWidgetsPacks;

class WidgetPacks
{
    protected mixed $minimumWidgetsPacks;

    /**
     * @param array $packs
     */
    public function __construct(
        private array $packs = array(),
    ) {
        $this->minimumWidgetsPacks = new MinimumWidgetsPacks();
    }

    /**
     * Get all widget packs.
     *
     * @return array
     */
    public function getPacks(): array
    {
        return $this->packs;
    }

    /**
     * Add widget pack(s) to array. Parameter can be int|array
     *
     * @param mixed $pack
     * @return $this
     */
    public function setPack(mixed $pack): static
    {
        if(is_array($pack) && count($pack)) {
            $this->packs = array_unique(array_merge($this->packs, $pack));
        }
        else {
            $this->packs [] = $pack;
        }
        return $this;
    }

    /**
     * Delete widget pack(s). Parameter can be int|array
     *
     * @param mixed $pack
     * @return $this
     */
    public function deletePack(mixed $pack): static
    {
        if(is_array($pack) && count($pack)) {
            $this->packs = array_diff($this->packs, $pack);
        }
        else {
            $this->packs = array_diff($this->packs, [$pack]);
        }
        return $this;
    }

    /**
     * Calculate minimum number of widget packs required for the widgets order
     *
     * @param int $totalWidgets
     * @return array
     */
    public function calculateMinimumWidgetsPacks(int $totalWidgets): array
    {
        return $this->minimumWidgetsPacks->handle($this->getPacks(), $totalWidgets);
    }
}
