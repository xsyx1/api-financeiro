<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 02/03/2018
 * Time: 10:33
 */

namespace Modules\Financeiro\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class Banco extends BaseEnum
{
	use ToArray, Hydrator;

	public const BB = 0;
	public const AMAZONIA = 1;
	public const NORDESTE = 2;
	public const AZTECA = 3;
	public const BANESTES = 4;
	public const ALFA = 5;
	public const SANTANDER = 6;
	public const PARA = 7;
	public const CARGILL = 8;
	public const RS  = 9;
	public const BVA = 10;
	public const OPPORTUNITY  = 11;
	public const SERGIPE = 12;
	public const HIPERCARD = 13;
	public const IBI  = 14;
	public const LEMON = 15;
	public const MORGAN = 16;
	public const BPN = 17;
	public const BRB = 18;
	public const RURAL_MAIS = 19;
	public const POPULAR = 20;
	public const J_SAFRA = 21;
	public const CR2 = 22;
	public const KDB = 23;
	public const INTERMEDIUM = 24;
	public const JBS = 25;
	public const CONCORDIA = 26;
	public const BMF = 27;
	public const CAIXA = 28;
	public const BBM = 29;
	public const NOSSA_CAIXA = 30;
	public const UBS_PACTUAL = 31;
	public const MATONE = 32;
	public const ARBI = 33;
	public const DIBENS = 34;
	public const JOHN_DEERE = 35;
	public const BONSUCESSO = 36;
	public const CALYON = 37;
	public const FIBRA = 38;
	public const BRASCAN = 39;
	public const CRUZEIRO = 40;
	public const UNICARD = 41;
	public const GE_CAPITAL = 42;
	public const BRADESCO = 43;
	public const CLASSICO = 44;
	public const MAXIMA = 45;
	public const ABC = 46;
	public const BOAVISTA_INTERATLANTICO = 47;
	public const INVESTCRED = 48;
	public const SCHAHIN = 49;
	public const PARANA = 50;
	public const CACIQUE = 51;
	public const FATOR = 52;
	public const CEDULA = 53;
	public const NACION_ARGENTINA = 54;
	public const BMG = 55;
	public const ITAU = 56;
	public const ABN = 57;
	public const SOCIETE = 58;
	public const WESTLB = 59;
	public const JP_MORGAN = 60;
	public const MERCANTIL = 61;
	public const FINASA = 62;
	public const HSBC = 63;
	public const UNIBANCO_UNIAO = 64;
	public const CAPITAL = 65;
	public const SAFRA = 66;
	public const RURAL = 67;
	public const TOKYO_MITSUBISHI = 68;
	public const SUMITOMO = 69;
	public const CITIBANK_NA = 70;
	public const DEUTSCHE = 71;
	public const JPMORGANCHASE = 72;
	public const ING = 74;
	public const URUGUAY = 75;
	public const BUENOS_AIRES = 76;
	public const CREDIT = 77;
	public const LUSO = 78;
	public const INDUSTRIAL = 79;
	public const VR = 80;
	public const PAULISTA = 81;
	public const GUANABARA = 82;
	public const PECUNIA = 83;
	public const PANAMERICANO = 84;
	public const FICSA = 85;
	public const INTERCAP = 86;
	public const RENDIMENTO = 87;
	public const TRIANGULO = 88;
	public const SOFISA = 89;
	public const ROSPER = 90;
	public const PINE = 91;
	public const INDUSVAL = 92;
	public const RENNER = 93;
	public const VOTORANTIM = 94;
	public const DAYCOVAL = 95;
	public const BANIF = 96;
	public const CREDIBEL = 97;
	public const GERDAU = 98;
	public const POTTENCIAL = 99;
	public const MORADA = 100;
	public const BGN = 101;
	public const BARCLAYS = 102;
	public const RIBEIRAO_PRETO = 103;
	public const EMBLEMA = 104;
	public const CITIBANK_SA = 105;
	public const MODAL = 106;
	public const RABOBANK = 107;
	public const COOPERATIVO_SICREDI = 108;
	public const SIMPLES = 109;
	public const DRESDNER = 110;
	public const BNP = 111;
	public const NBC = 112;
	public const BANCOOB = 113;
	public const KEB = 114;
	
	private $id;
	public $codFebraban;
	private $nome;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::BB => [self::BB, "001", "BANCO DO BRASIL S.A."],
		self::AMAZONIA => [self::AMAZONIA, "003", "BANCO DA AMAZONIA S.A."],
		self::NORDESTE => [self::NORDESTE, "004", "BANCO DO NORDESTE DO BRASIL S.A."],
		self::AZTECA => [self::AZTECA, "019", "BANCO AZTECA DO BRASIL S.A."],
		self::BANESTES => [self::BANESTES, "021", "BANESTES S.A. BANCO DO ESTADO DO ESPIRITO SANTO"],
		self::ALFA => [self::ALFA, "025", "BANCO ALFA S.A"],
		self::SANTANDER => [self::SANTANDER, "033", "BANCO SANTANDER BANESPA S.A."],
		self::PARA => [self::PARA, "037", "BANCO DO ESTADO DO PARÁ S.A."],
		self::CARGILL => [self::CARGILL, "040", "BANCO CARGILL S.A."],
		self::RS  => [self::RS , "041", "BANCO DO ESTADO DO RIO GRANDE DO SUL S.A."],
		self::BVA => [self::BVA,"044", "BANCO BVA S.A."],
		self::OPPORTUNITY  => [self::OPPORTUNITY , "045", "BANCO OPPORTUNITY S.A."],
		self::SERGIPE => [self::SERGIPE, "047", "BANCO DO ESTADO DE SERGIPE S.A."],
		self::HIPERCARD => [self::HIPERCARD, "062", "HIPERCARD BANCO MÚLTIPLO S.A."],
		self::IBI  => [self::IBI , "063", "BANCO IBI S.A. - BANCO MÚLTIPLO"],
		self::LEMON => [self::LEMON, "065", "BANCO LEMON S.A."],
		self::MORGAN => [self::MORGAN, "066", "BANCO MORGAN STANLEY S.A."],
		self::BPN => [self::BPN, "069", "BPN BRASIL BANCO MÚLTIPLO S.A."],
		self::BRB => [self::BRB, "070", "BRB - BANCO DE BRASILIA S.A."],
		self::RURAL_MAIS => [self::RURAL_MAIS, "072", "BANCO RURAL MAIS S.A."],
		self::POPULAR => [self::POPULAR, "073", "BB BANCO POPULAR DO BRASIL S.A."],
		self::J_SAFRA => [self::J_SAFRA, "074", "BANCO J. SAFRA S.A."],
		self::CR2 => [self::CR2, "075", "BANCO CR2 S/A"],
		self::KDB => [self::KDB, "076", "BANCO KDB DO BRASIL S.A."],
		self::INTERMEDIUM => [self::INTERMEDIUM, "077", "BANCO INTERMEDIUM S/A"],
		self::JBS => [self::JBS, "079", "JBS BANCO S/A"],
		self::CONCORDIA => [self::CONCORDIA, "081", "CONCÓRDIA BANCO S.A."],
		self::BMF => [self::BMF, "096", "BANCO BM&F DE SERVIÇOS DE LIQUIDAÇÃO E CUSTÓDIA S.A."],
		self::CAIXA => [self::CAIXA, "104", "CAIXA ECONOMICA FEDERAL"],
		self::BBM => [self::BBM, "107", "BANCO BBM S/A"],
		self::NOSSA_CAIXA => [self::NOSSA_CAIXA, "151", "BANCO NOSSA CAIXA S.A."],
		self::UBS_PACTUAL => [self::UBS_PACTUAL, "208", "BANCO UBS PACTUAL S.A."],
		self::MATONE => [self::MATONE, "212", "BANCO MATONE S.A."],
		self::ARBI => [self::ARBI, "213", "BANCO ARBI S.A."],
		self::DIBENS => [self::DIBENS, "214", "BANCO DIBENS S.A."],
		self::JOHN_DEERE => [self::JOHN_DEERE, "217", "BANCO JOHN DEERE S.A."],
		self::BONSUCESSO => [self::BONSUCESSO, "218", "BANCO BONSUCESSO S.A."],
		self::CALYON => [self::CALYON, "222", "BANCO CALYON BRASIL S.A."],
		self::FIBRA => [self::FIBRA, "224", "BANCO FIBRA S.A."],
		self::BRASCAN => [self::BRASCAN, "225", "BANCO BRASCAN S.A."],
		self::CRUZEIRO => [self::CRUZEIRO, "229", "BANCO CRUZEIRO DO SUL S.A."],
		self::UNICARD => [self::UNICARD, "230", "UNICARD BANCO MÚLTIPLO S.A."],
		self::GE_CAPITAL => [self::GE_CAPITAL, "233", "BANCO GE CAPITAL S.A."],
		self::BRADESCO => [self::BRADESCO, "237", "BANCO BRADESCO S.A."],
		self::CLASSICO => [self::CLASSICO, "241", "BANCO CLASSICO S.A."],
		self::MAXIMA => [self::MAXIMA, "243", "BANCO MÁXIMA S.A."],
		self::ABC => [self::ABC, "246", "BANCO ABC BRASIL S.A."],
		self::BOAVISTA_INTERATLANTICO => [self::BOAVISTA_INTERATLANTICO, "248", "BANCO BOAVISTA INTERATLANTICO S.A."],
		self::INVESTCRED => [self::INVESTCRED, "249", "BANCO INVESTCRED UNIBANCO S.A."],
		self::SCHAHIN => [self::SCHAHIN, "250", "BANCO SCHAHIN S.A."],
		self::PARANA => [self::PARANA, "254", "PARANÁ BANCO S.A."],
		self::CACIQUE => [self::CACIQUE, "263", "BANCO CACIQUE S.A."],
		self::FATOR => [self::FATOR, "265", "BANCO FATOR S.A."],
		self::CEDULA => [self::CEDULA, "266", "BANCO CEDULA S.A."],
		self::NACION_ARGENTINA => [self::NACION_ARGENTINA, "300", "BANCO DE LA NACION ARGENTINA"],
		self::BMG => [self::BMG, "318", "BANCO BMG S.A."],
		self::ITAU => [self::ITAU, "341", "BANCO ITAÚ S.A."],
		self::ABN => [self::ABN, "356", "BANCO ABN AMRO REAL S.A."],
		self::SOCIETE => [self::SOCIETE, "366", "BANCO SOCIETE GENERALE BRASIL S.A."],
		self::WESTLB => [self::WESTLB, "370", "BANCO WESTLB DO BRASIL S.A."],
		self::JP_MORGAN => [self::JP_MORGAN, "376", "BANCO J.P. MORGAN S.A."],
		self::MERCANTIL => [self::MERCANTIL, "389", "BANCO MERCANTIL DO BRASIL S.A."],
		self::FINASA => [self::FINASA, "394", "BANCO FINASA BMC S.A."],
		self::HSBC => [self::HSBC, "399", "HSBC BANK BRASIL S.A. - BANCO MULTIPLO"],
		self::UNIBANCO_UNIAO => [self::UNIBANCO_UNIAO, "409", "UNIBANCO-UNIAO DE BANCOS BRASILEIROS S.A."],
		self::CAPITAL => [self::CAPITAL, "412", "BANCO CAPITAL S.A."],
		self::SAFRA => [self::SAFRA, "422", "BANCO SAFRA S.A."],
		self::RURAL => [self::RURAL, "453", "BANCO RURAL S.A."],
		self::TOKYO_MITSUBISHI => [self::TOKYO_MITSUBISHI, "456", "BANCO DE TOKYO-MITSUBISHI UFJ BRASIL S/A"],
		self::SUMITOMO => [self::SUMITOMO, "464", "BANCO SUMITOMO MITSUI BRASILEIRO S.A."],
		self::CITIBANK_NA => [self::CITIBANK_NA, "477", "CITIBANK N.A."],
		self::DEUTSCHE => [self::DEUTSCHE, "487", "DEUTSCHE BANK S.A. - BANCO ALEMAO"],
		self::JPMORGANCHASE => [self::JPMORGANCHASE, "488", "JPMORGAN CHASE BANK, NATIONAL ASSOCIATION"],
		self::ING => [self::ING, "492", "ING BANK N.V."],
		self::URUGUAY => [self::URUGUAY, "494", "BANCO DE LA REPUBLICA ORIENTAL DEL URUGUAY"],
		self::BUENOS_AIRES => [self::BUENOS_AIRES, "495", "BANCO DE LA PROVINCIA DE BUENOS AIRES"],
		self::CREDIT => [self::CREDIT, "505", "BANCO CREDIT SUISSE (BRASIL) S.A."],
		self::LUSO => [self::LUSO, "600", "BANCO LUSO BRASILEIRO S.A."],
		self::INDUSTRIAL => [self::INDUSTRIAL, "604", "BANCO INDUSTRIAL DO BRASIL S.A."],
		self::VR => [self::VR, "610", "BANCO VR S.A."],
		self::PAULISTA => [self::PAULISTA, "611", "BANCO PAULISTA S.A."],
		self::GUANABARA => [self::GUANABARA, "612", "BANCO GUANABARA S.A."],
		self::PECUNIA => [self::PECUNIA, "613", "BANCO PECUNIA S.A."],
		self::PANAMERICANO => [self::PANAMERICANO, "623", "BANCO PANAMERICANO S.A."],
		self::FICSA => [self::FICSA, "626", "BANCO FICSA S.A."],
		self::INTERCAP => [self::INTERCAP, "630", "BANCO INTERCAP S.A."],
		self::RENDIMENTO => [self::RENDIMENTO, "633", "BANCO RENDIMENTO S.A."],
		self::TRIANGULO => [self::TRIANGULO, "634", "BANCO TRIANGULO S.A."],
		self::SOFISA => [self::SOFISA, "637", "BANCO SOFISA S.A."],
		self::ROSPER => [self::ROSPER, "638", "BANCO PROSPER S.A."],
		self::PINE => [self::PINE, "643", "BANCO PINE S.A."],
		self::INDUSVAL => [self::INDUSVAL, "653", "BANCO INDUSVAL S.A."],
		self::RENNER => [self::RENNER, "654", "BANCO A.J. RENNER S.A."],
		self::VOTORANTIM => [self::VOTORANTIM, "655", "BANCO VOTORANTIM S.A."],
		self::DAYCOVAL => [self::DAYCOVAL, "707", "BANCO DAYCOVAL S.A."],
		self::BANIF => [self::BANIF, "719", "BANIF - BANCO INTERNACIONAL DO FUNCHAL (BRASIL), S.A."],
		self::CREDIBEL => [self::CREDIBEL, "721", "BANCO CREDIBEL S.A."],
		self::GERDAU => [self::GERDAU, "734", "BANCO GERDAU S.A"],
		self::POTTENCIAL => [self::POTTENCIAL, "735", "BANCO POTTENCIAL S.A."],
		self::MORADA => [self::MORADA, "738", "BANCO MORADA S.A."],
		self::BGN => [self::BGN, "739", "BANCO BGN S.A."],
		self::BARCLAYS => [self::BARCLAYS, "740", "BANCO BARCLAYS S.A."],
		self::RIBEIRAO_PRETO => [self::RIBEIRAO_PRETO, "741", "BANCO RIBEIRAO PRETO S.A."],
		self::EMBLEMA => [self::EMBLEMA, "743", "BANCO EMBLEMA S.A."],
		self::CITIBANK_SA => [self::CITIBANK_SA, "745", "BANCO CITIBANK S.A."],
		self::MODAL => [self::MODAL, "746", "BANCO MODAL S.A."],
		self::RABOBANK => [self::RABOBANK, "747", "BANCO RABOBANK INTERNATIONAL BRASIL S.A."],
		self::COOPERATIVO_SICREDI => [self::COOPERATIVO_SICREDI, "748", "BANCO COOPERATIVO SICREDI S.A."],
		self::SIMPLES => [self::SIMPLES, "749", "BANCO SIMPLES S.A."],
		self::DRESDNER => [self::DRESDNER, "751", "DRESDNER BANK BRASIL S.A. BANCO MULTIPLO"],
		self::BNP => [self::BNP, "752", "BANCO BNP PARIBAS BRASIL S.A."],
		self::NBC => [self::NBC, "753", "NBC BANK BRASIL S. A. - BANCO MÚLTIPLO"],
		self::BANCOOB => [self::BANCOOB, "756", "BANCO COOPERATIVO DO BRASIL S.A. - BANCOOB"],
		self::KEB => [self::KEB, "757", "BANCO KEB DO BRASIL S.A."],
	];

	public static function labels()
	{
		return array_map(function ($item) {
			return [
				'id' => $item[0],
				'codFebraban' => $item[1],
				'nome' => $item[2],
			];
		}, static::$typeLabels);
	}

}