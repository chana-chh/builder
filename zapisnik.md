# Slim3 app builder

## TODO

- prebaciti navigaciju u navbar-u na desnu stranu (jebeni bootstrap5 neki flex)
- nazivi ruta: snake ili kebab?
- modeli su prilicno gotovi
- nazivi direktorijuma za poglede?

## OVAKO NEKAKO KENJANJE ...

public function napraviKontroler(string $tabela, array $kolone, array $povezano)
    {  

        $model_klasa = ucfirst(strtolower($tabela));
        $dodatni_modeli = "";
        if ($povezano) {
            foreach ($povezano as $pov) {
                $dodatni_modeli .= 'use App\Models\\'.$pov.';';
            }
        }

            str_replace('#model_klasa#', $model_klasa, $kontroler_sablon);
            str_replace('#dodatni_modeli#', $dodatni_modeli, $kontroler_sablon);
            str_replace('#tabela#', $tabela, $kontroler_sablon);

                $kontroler_sablon = '
                namespace App\Controllers;

                use App\Classes\Auth;
                use App\Classes\Logger;
                use App\Models\Korisnik;
                use App\Models\#model_klasa#;
                #dodatni_modeli#



                class #model_klasa#Controller extends Controller
                {
                    public function getLista($request, $response)
                    {
                        $model = new #model_klasa#();
                        $#tabela# = $model->paginate($this->page());

                        $this->render($response, ''#tabela#/lista.twig'', compact(''#tabela#''));
                    }
                    
                    public function postDodavanje($request, $response)
                    {

                        $data = $this->data();

                        $validation_rules = [
                            ''naziv'' => [
                                ''required'' => true,
                                ''maxlen'' => 50,
                                ''unique'' => ''sif_os.naziv''
                            ]
                        ];

                        $data[''korisnik_id''] = $this->auth->user()->id;

                        $this->validator->validate($data, $validation_rules);

                        if ($this->validator->hasErrors()) {
                            $this->flash->addMessage(''danger'', ''Došlo je do greške prilikom dodavanja podataka.'');
                            return $response->withRedirect($this->router->pathFor(''#tabela#''));
                        } else {
                            $this->flash->addMessage(''success'', ''Podatak je uspešno dodat.'');
                            $model = new #model_klasa#();
                            $model->insert($data);

                            $id_#tabela# = $model->lastId();
                            $#tabela# = $model->find($id_#tabela#);
                            $this->log($this::DODAVANJE, $#tabela#, ''naziv'');
                            return $response->withRedirect($this->router->pathFor(''#tabela#''));
                        }
                    }

                    public function postBrisanje($request, $response)
                    {
                        $id_os = (int)$request->getParam(''idBrisanje'');
                        $model = new #model_klasa#();
                        $#tabela# = $model->find($id_#tabela#);
                        $success = $model->deleteOne($id_#tabela#);

                        if ($success) {
                            $this->flash->addMessage(''success'', "Podatak je uspešno obrisan.");
                            $this->log($this::BRISANJE, $#tabela#, ''naziv'', $#tabela#);
                            return $response->withRedirect($this->router->pathFor(''#tabela#''));
                        } else {
                            $this->flash->addMessage(''danger'', "Došlo je do greške prilikom brisanja podataka.");
                            return $response->withRedirect($this->router->pathFor(''#tabela#''));
                        }
                    }

                    public function postDetalj($request, $response)
                    {
                        $data = $request->getParams();
                        $cName = $this->csrf->getTokenName();
                        $cValue = $this->csrf->getTokenValue();

                        $id = $data[''id''];
                        $model = new Os();
                        $os = $model->find($id);
                        $ar = ["cname" => $cName, "cvalue"=>$cValue, "os"=>$os];

                        return $response->withJson($ar);
                    }

                    public function postIzmena($request, $response)
                    {
                        $data = $this->data();
                        $id = $data[''idIzmena''];
                        unset($data[''idIzmena'']);

                        $datam = [
                            "naziv" => $data[''nazivModal'']
                        ];

                        $validation_rules = [
                            ''naziv'' => [
                                ''required'' => true,
                                ''maxlen'' => 50,
                                ''unique'' => ''sif_os.naziv#id:'' . $id,
                            ]
                            ];

                        $this->validator->validate($datam, $validation_rules);

                        if ($this->validator->hasErrors()) {
                            $this->flash->addMessage(''danger'', ''Došlo je do greške prilikom izmene podataka OS.'');
                            return $response->withRedirect($this->router->pathFor(''os''));
                        } else {
                            $this->flash->addMessage(''success'', ''Podaci OS su uspešno izmenjeni.'');
                            $model = new Os();
                            $stari = $model->find($id);
                            $model->update($datam, $id);
                            $os = $model->find($id);
                            $this->log($this::IZMENA, $os, ''naziv'', $stari);
                            return $response->withRedirect($this->router->pathFor(''os''));
                        }
                    }
                }';

}
