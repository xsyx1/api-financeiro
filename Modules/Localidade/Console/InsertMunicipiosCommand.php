<?php

namespace Modules\Localidade\Console;

use Illuminate\Console\Command;
use Modules\Localidade\Repositories\CidadeRepository;
use Modules\Localidade\Repositories\EstadoRepository;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InsertMunicipiosCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inserir:municipios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para fazer inserção dos dados municipios';

    /**
     * @var $estadoRepository
     */
    protected $estadoRepository;

    /**
     * @var $cidadeRepository
     */
    protected $cidadeRepository;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(
        CidadeRepository $cidadeRepository,
        EstadoRepository $estadoRepository
    ) {
        $this->cidadeRepository = $cidadeRepository;
        $this->estadoRepository = $estadoRepository;
        $this->inserir();
    }
    private function inserir()
    {
        $startTime = microtime(true);
        $municipiosJson = file_get_contents(public_path('imports/json/ibge-municipios-23-05-2022.json'));
        $municipios = json_decode($municipiosJson);
        $qtd_inserts = 0;
        $qtd_update = 0;
        $qtd_estados_update = 0;
        \DB::beginTransaction();
        foreach ($municipios as $municipio) {
            $estado = $this->estadoRepository->skipPresenter(true)->findWhere([
                ['uf', 'ilike', $municipio->microrregiao->mesorregiao->UF->sigla]
            ])->first();
            if($estado->cod_ibje == null){
                $estado->cod_ibje = $municipio->microrregiao->mesorregiao->UF->id;
                $estado->save();
                $qtd_estados_update++;
            }

            $cidade = $this->cidadeRepository->skipPresenter(true)->findWhere([
                ['estado_id', '=', $estado->id],
                ['nome', 'ilike', $municipio->nome]
            ])->first();
            if (!is_null($cidade) && $cidade->cod_ibje == null) {
                $cidade->cod_ibje = (int) $municipio->id;
                $cidade->save();
                $qtd_update++;
            }
            if (is_null($cidade)) {
                $cidade = $this->cidadeRepository->skipPresenter(true)->create([
                    'nome' => (string) $municipio->nome,
                    'estado_id' => (int) $estado->id,
                    'cod_ibje' => (int) $municipio->id,
                    'capital' => false,
                ]);
                $qtd_inserts++;
            }
        };
        $total = round(microtime(true) - $startTime, 2);
        echo 'Time ' . $total .
            's, Quantidade de cidades registro inseridos = ' . $qtd_inserts .
            ', quantidade de cidades atualizados = ' . $qtd_update . 
            ' Quantidade de estados Atualizados = '. $qtd_estados_update ;
        \DB::commit();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            //   ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
