<?php

namespace Cirel\LaravelBasicsAuxs\Auxs;

use Exception;

class SeederFunction
{
    /**
     * @throws Exception
     */
    public static function seed($model, $array)
    {
        foreach ($array as $item) {
            $model = new $model;
            $model->fill($item);
            if (!$model->save()) {
                $name = get_class($model);
                throw new Exception("Fail seed {$name} data {}");
            }
        }
    }
}
