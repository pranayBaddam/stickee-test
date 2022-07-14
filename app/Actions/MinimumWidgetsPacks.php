<?php

namespace App\Actions;

class MinimumWidgetsPacks
{
    /**
     * Calculate the minimum widget packs required for the widgets order.
     *
     *
     *
     * @param array $widgetsPacks
     * @param int $totalWidgets
     * @return array
     */
    public function handle(array $widgetsPacks, int $totalWidgets): array
    {
        //It will hold minimum widget packs count for the number of widgets.
        $minPacks = array_fill(0, $totalWidgets, 0);
        $mapWidgets = array_fill(0, $totalWidgets, 0);

        // Looping through total number of widgets ordered.
        for($widget = 1; $widget <= $totalWidgets; $widget++) {
            $minPacks[$widget] = PHP_INT_MAX;
            $mapWidgets[$widget] = -1;

            // Looping through each widget packs for widget number
            foreach ($widgetsPacks as $pack) {
                /**
                 * If pack count is greater than widget number
                 * then calculate the wastage and store pack, count and wastage
                 * compare wastage and count with other packs, store minimum pack.
                 */
                if($pack > $widget) {
                    $intWastage = $pack - $widget;
                    if(is_array($mapWidgets[$widget])) {
                        if($intWastage <= $mapWidgets[$widget]['wastage']) {
                            $minSubPacks = (int) ceil($widget/$pack);
                            if($minSubPacks <= $mapWidgets[$widget]['count']) {
                                $minPacks[$widget] = $minSubPacks;
                                $mapWidgets[$widget] = array(
                                    'packs' => array($pack),
                                    'count' => $minSubPacks,
                                    'wastage' => $intWastage
                                );
                            }
                        }
                    }
                    else{
                        $minPacks[$widget] = (int) ceil($widget/$pack);
                        $mapWidgets[$widget] = array(
                            'packs' => array($pack),
                            'count' => $minPacks[$widget],
                            'wastage' => $intWastage
                        );
                    }
                    continue;
                }

                /**
                 * If widget number greater than pack,
                 * then check for all of it's sub nodes to find minimum count required for too meet the order.
                 * using 'Dynamic Programming' approach to get already calculated count, instead of calculating again
                 */
                $minSubPacks = $minPacks[$widget - $pack];
                if($minSubPacks != PHP_INT_MAX && $minSubPacks + 1 <= $minPacks[$widget]) {
                    // if values exist widget number, compare it with other packages to find the minimum count.
                    if(is_array($mapWidgets[$widget])) {
                        $intWastage =  is_array($mapWidgets[$widget - $pack]) ? $mapWidgets[$widget - $pack]['wastage']:$widget - $pack;
                        // Checking the wastage and count is less than or equal with already calculated other pack.
                        if($intWastage <= $mapWidgets[$widget]['wastage']) {
                            $minSubPacks = is_array($mapWidgets[$widget - $pack]) ? $minSubPacks + 1: (int) intval($widget/$pack);
                            if($minSubPacks <= $mapWidgets[$widget]['count']) {
                                $minPacks[$widget] = $minSubPacks;
                                $mapWidgets[$widget] = array(
                                    'packs' => is_array($mapWidgets[$widget - $pack]) ?  array_merge(array($pack) , $mapWidgets[$widget - $pack]['packs']) : array($pack),
                                    'count' => $minSubPacks,
                                    'wastage' => $intWastage
                                );
                            }
                        }
                    }
                    else{
                        // If no pack is existed for widget number, then aad widget pack to minimum count and store pack, count and wastage.
                        $minPacks[$widget] = $minSubPacks + 1;
                        $mapWidgets[$widget] = array(
                            'packs' => is_array($mapWidgets[$widget - $pack]) ?  array_merge(array($pack) , $mapWidgets[$widget - $pack]['packs']) : array($pack),
                            'count' => $minPacks[$widget],
                            'wastage' => is_array($mapWidgets[$widget - $pack]) ? $mapWidgets[$widget - $pack]['wastage'] : $widget%$pack,
                        );
                    }
                }

            }
        }

        // return the minimum packs, count and wastage to meet the total widgets order.
        return $mapWidgets[$totalWidgets];
    }
}
