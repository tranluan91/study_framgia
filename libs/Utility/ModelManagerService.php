<?php

namespace Libs\Utility;

trait ModelManagerService {
    /**
     * Generate Model
     */
    public function initModel($model_name) {
        if (!empty($this->{$model_name}))   return $this->{$model_name};
        $class_name = "\\Models\\".$model_name;
        $this->{$model_name} = new $class_name();
        return $this->{$model_name};
    }
}