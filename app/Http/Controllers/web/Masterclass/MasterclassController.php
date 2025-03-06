<?php
namespace App\Http\Controllers\web\Masterclass;

use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;

class MasterclassController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Masterclass/Index'); // Dit wijst naar resources/js/Pages/Masterclass/Index.jsx
    }
}
