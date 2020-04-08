<?php

use CspCascade\Http\Controllers\CspCascadeController;

Route::get('cascade', CspCascadeController::class.'@index');