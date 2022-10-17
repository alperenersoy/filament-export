<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait CanRefreshTable
{
    public function shouldRefreshTableView()
    {
        if (request()->has('updates')) {
            $updates = collect(request()->updates);

            $gotoPageCalls = $updates->filter(function ($item) {
                return $item['type'] === 'callMethod' && $item['payload']['method'] === 'gotoPage' ||
                    $item['type'] === 'callMethod' && $item['payload']['method'] === 'previousPage' ||
                    $item['type'] === 'callMethod' && $item['payload']['method'] === 'nextPage' ||
                    $item['type'] === 'syncInput' && $item['payload']['name'] === 'tableRecordsPerPage';
            });

            return $gotoPageCalls->count() > 0;
        }

        return false;
    }
}
