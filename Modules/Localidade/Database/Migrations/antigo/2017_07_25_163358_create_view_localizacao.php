<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewLocalizacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW public._localidades (
                                    id,
                                    estado_id,
                                    uf,
                                    titulo,
                                    titulo_bairro,
                                    capital,
                                    endereco,
                                    enderecotable_id)
                                AS
                                 SELECT cidades.id,
                                    cidades.estado_id,
                                    estados.uf,
                                    concat_ws(' - '::text, cidades.titulo::text, estados.uf) AS titulo,
                                    bairros.titulo AS titulo_bairro,
                                    cidades.capital,
                                    enderecos.endereco,
                                    enderecos.enderecotable_id
                                   FROM cidades
                                     JOIN enderecos ON cidades.id = enderecos.cidade_id AND enderecos.enderecotable_type::text = 'Modules\Anuncio\Models\Anuncio'::text
                                     LEFT JOIN estados ON enderecos.estado_id = estados.id
                                     LEFT JOIN bairros ON enderecos.bairro_id = bairros.id
                                  WHERE cidades.deleted_at IS NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW companiesView");
    }
}
