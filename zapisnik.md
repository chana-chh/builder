# Slim3 app builder

## TODO

- prebaciti navigaciju u navbar-u na desnu stranu (jebeni bootstrap5 neki flex)
- nazivi ruta: snake ili kebab?
- modeli su prilicno gotovi
- nazivi direktorijuma za poglede?
- ORDER BY, razmisliti kako i sta

## Kontroler

<?php

namespace App\Controllers;

use App\Classes\Auth;
use App\Classes\Logger;
use App\Models\Korisnik;
#namespace#
class #tabelav#Controller extends Controller
{
    public function get#tabelav#($request, $response)
    {
        $query = [];
        parse_str($request->getUri()->getQuery(), $query);
        $page = isset($query['page']) ? (int)$query['page'] : 1;

        $model = new #tabelav#();
        $#tabelam#_lista = $model->paginate($page, 'page', 
            "SELECT * FROM {$model->getTable()}");

        #ostali#
        $this->render($response, '#tabelam#/lista.twig', compact('#tabelam#_lista'#pplus#));
    }

     public function postPretraga($request, $response)
    {
        $_SESSION['DATA_#ttabelav#_PRETRAGA'] = $request->getParams();

        return $response->withRedirect($this->router->pathFor('#tabelam#.pretraga'));
    }

     public function getPretraga($request, $response)
    {
        $data = $_SESSION['DATA_#ttabelav#_PRETRAGA'];
        array_shift($data);
        array_shift($data);

        if (#empty#)) {
            return $response->withRedirect($this->router->pathFor('#tabelam#'));
        }

        #sanitize#

        $query = [];
        parse_str($request->getUri()->getQuery(), $query);
        $page = isset($query['page']) ? (int)$query['page'] : 1;

        $where = " WHERE ";
        $params = [];

        #ifwhere#

        $where = $where === " WHERE " ? "" : $where;
        $model = new #tabelav#();
        $sql = "SELECT * FROM {$model->getTable()}{$where}";
        $#tabelam#_lista = $model->paginate($page, 'page', $sql, $params);

        #ostali#
        $this->render($response, '#tabelam#/lista.twig', compact('#tabelam#_lista', 'data'#pplus#));
    }
}

## Kontroler kraj