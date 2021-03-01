<?php

namespace App\Controllers;

// use App\Models\Tabela;
// use \DateTime;

class KalendarController extends Controller
{
    public function getKalendar($request, $response)
    {
        $nazivi_dana = [
            "Ponedeljak",
            "Utorak",
            "Sreda",
            "Četvrtak",
            "Petak",
            "Subota",
            "Nedelja"];
        $nazivi_dana_skraceno = [
            "Pon",
            "Uto",
            "Sre",
            "Čet",
            "Pet",
            "Sub",
            "Ned"];

        $nazivi_meseci = [
            "Januar",
            "Februar",
            "Mart",
            "April",
            "Maj",
            "Jun",
            "Jul",
            "Avgust",
            "Septembar",
            "Oktobar",
            "Novembar",
            "Decembar",
        ];
        $nazivi_meseci_skraceno = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "Maj",
            "Jun",
            "Jul",
            "Avg",
            "Sep",
            "Okt",
            "Nov",
            "Dec",
        ];

        $dt = new \DateTime("1970-06-04 10:05:00");
        $now = new \DateTime();
        $date = new \DateTimeImmutable('2019-12-31'); // 31 februar postaje 3 mart
        $datep2m = $date->add(new \DateInterval("P4M"));



        // $dt->format("j"); // dan u mesecu
        // $dt->format("N"); // 1-ponedeljak, 7-nedelja
        // $dt->format("z"); // dan u godini
        // $dt->format("W"); // sedmica u godini
        // $dt->format("n"); // mesec u godini
        // $dt->format("t"); // ukupan broj dana u mesecu
        // $dt->format("Y"); // godina

        // Kalendarske funkcije
        $days_in_month = cal_days_in_month(0, 6, 1970); // broj dana u mesecu 0/CAL_GREGORIAN=gregorijanski, 6=mesec, 1970=godina

        // dd("WTF");

        $this->render($response, 'kalendar.twig'); // , compact('data')
    }

    public function postKalendar($request, $response)
    {
        // $data = $request->getParams();
        // $this->addCsrfToken($data);
        // $m = new Tabela();
        // $where = "";
        // $search = $data['search'];
        // if (!empty($search)) {
        //     $where = " WHERE ";
        //     foreach ($data['columns'] as $col) {
        //         $where .= "{$col} LIKE '%{$search}%' OR ";
        //     }
        //     $where = rtrim($where, " OR ");
        // }
        // $order = "";
        // if (!empty($data['sortColumn'])) {
        //     $direction = !empty($data['sortColumn']) ? $data['sortOrder'] : 'ASC';
        //     $order = " ORDER BY {$data['sortColumn']} {$direction}";
        // }
        // $sql = "SELECT * FROM tabela{$where}{$order};";
        // $pgn = $m->paginate($data['page'], 'strana', $sql, null, $data['perPage']);
        // $tbody = $this->renderPartial('tables/tbl.twig', compact('pgn'));
        // $data['links']= $pgn['links'];
        // $data['tbody']= $tbody;
        // return json_encode($data);
    }
}
