<?php

namespace App\Controllers;

use App\Models\Izbor;
use App\Models\Skelet;

class SkeletController extends Controller
{
    public function getSkelet($request, $response)
    {
        $model = new Izbor();
        $izbor = $model->find(1);
        $modelS = new Skelet();
        $skelet = $modelS->all();

        $this->render($response, 'skelet.twig', compact('izbor', 'skelet'));
    }

    public function getPregled($request, $response, $args)
    {
        $id = $args['id'];
        $model = new Izbor();
        $izbor = $model->find(1);

        $modelS = new Skelet();
        $skelet = $modelS->find($id);

        $this->render($response, 'pregled.twig', compact('izbor', 'skelet'));
    }
}
