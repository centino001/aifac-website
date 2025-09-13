<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Projects;

Route::get('/', Home::class);
Route::get('/projects', Projects::class);
