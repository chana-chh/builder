<?php

namespace App\Controllers;

use App\Models\Tabela;

class TabelaController extends Controller
{
    public function getTabela($request, $response)
    {
        $query = [];
        parse_str($request->getUri()->getQuery(), $query);
        $page = isset($query['page']) ? (int)$query['page'] : 1;

        $m = new Tabela();
        $data = $m->paginate($page);

        $this->render($response, 'tabela.twig', compact('data'));
    }

    public function postTabela($request, $response)
    {
        $data = $request->getParams();
        // $this->addCsrfToken($data);
        $m = new Tabela();
        $where = "";
        $search = $data['search'];
        if (!empty($search)) {
            $where = " WHERE ";
            foreach ($data['columns'] as $col) {
                $where .= "{$col} LIKE '%{$search}%' OR ";
            }
            $where = rtrim($where, " OR ");
        }
        $order = "";
        if (!empty($data['sortColumn'])) {
            $direction = !empty($data['sortColumn']) ? $data['sortOrder'] : 'ASC';
            $order = " ORDER BY {$data['sortColumn']} {$direction}";
        }
        $sql = "SELECT * FROM tabela{$where}{$order};";
        $pgn = $m->paginate($data['page'], 'strana', $sql, null, $data['perPage']);
        $tbody = $this->renderPartial('tables/tbl.twig', compact('pgn'));
        $data['links']= $pgn['links'];
        $data['tbody']= $tbody;
        return json_encode($data);
    }
}
