<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait CanRefreshTable
{
    public function shouldRefreshTableView()
    {
        if (request()->has('components')) {
            foreach (request('components') as $component) {
                $callMethods = array_unique(array_column($component['calls'], 'method'));

                if (in_array('gotoPage', $callMethods) || in_array('previousPage', $callMethods) || in_array('nextPage', $callMethods)) {
                    return true;
                }

                if (array_key_exists('tableRecordsPerPage', $component['updates'])) {
                    return true;
                }
            }
        }

        return false;
    }
}
