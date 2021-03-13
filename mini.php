<script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<?php

 
       date_default_timezone_set('America/Sao_Paulo');

$curl = curl_init();

curl_setopt_array($curl, array(
  
  CURLOPT_URL => 'https://www.noticiasagricolas.com.br/cotacoes/soja/soja-mercado-fisico-sindicatos-e-cooperativas',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_SSL_VERIFYHOST => false

));

$response = curl_exec($curl);

curl_close($curl);

//echo $response;

/// Para pegar  a primeira posicao //
$mystring     = $response;
$findmeInicio = '<table class="cot-fisicas">';

$posInicio = strpos($mystring, $findmeInicio);

$findmeFinal = '</table>';
$posFinal = strpos($mystring, $findmeFinal);

$quant    = $posFinal - $posInicio;

$newtable = substr ($mystring , $posInicio, $quant);
echo $newtable;


$findmeInicio1 ='<div class="fechamento">';

$posInicio1 = strpos($mystring, $findmeInicio1);
//echo $posInicio1;
 $date = substr($mystring, $posInicio1, 46);
$corta=var_export(substr($date, 36, 12), true).PHP_EOL;

$corta1 = substr($corta,1,10);
$formatAme=DateTime::createFromFormat('d/m/Y', $corta1)->format("Y-m-d");
//$date = substr($mystring, -250, $posInicio1);
//$corta1 = date('d-m-Y'); // Formato Brasileiro: dia/mes/Ano
 

echo $formatAme;
//echo date('Y-m-d', strtotime($corta1)); // Convertendo para o padrão americano


 
  
?>
<script language="javascript">

var indices = [];

//Pega os indices
$('.cot-fisicas thead tr th').each(function() {
  indices.push($(this).text());
});

var arrayItens = [];

//Pecorre todos os produtos
$('.cot-fisicas tbody tr').each(function( index ) {

var obj = {};

//Controle o objeto
$(this).find('td').each(function( index ) {
	obj[indices[index]] = $(this).text();
});

//Adiciona no arrray de objetos
arrayItens.push(obj);

});




//Mostra dados pegos no console
console.log(arrayItens);


var usuario = {arrayItens}
  
var dados = JSON.stringify(usuario);



    var title = "<?php echo date('Y-m-d', strtotime($formatAme));  ?>";
    console.log(title);

//Envia para o php
$.ajax({
  type: "POST",
  url: "controle/insere.php",
  data: {data: dados,envioData:title },
  success: function(respostaDoPhp){
    //alert('Deu tudo certo');
  },
});



</script>