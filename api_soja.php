<?php
header('Content-Type: application/json');

$conexao = mysqli_connect ('localhost', 'root', '','api');

//////validar token de acesso - Start

$recToken = @$_GET['token'];
$recAcao = @$_GET['acao'];



////validacao da chave de acesso///

if($recToken != md5('ivan-ivan@gmail.com')){
  echo '{"error":"token invalido"}';
  exit();
}

/////validacao metodo existencia/////
if($recAcao == ""){
  echo "Método não encontrado";
  exit();
}

if($recAcao == 'buscar'){

$query = "SELECT * FROM cotacao";
         $result = mysqli_query($conexao, $query);

      while($rows = $result -> fetch_assoc()){

      $array_result[$rows['id_cotacao']]['cultura']    = $rows['cultura'];
      $array_result[$rows['id_cotacao']]['municipio']    = $rows['municipio'];
      $array_result[$rows['id_cotacao']]['uf']    = $rows['uf'];
      $array_result[$rows['id_cotacao']]['data']    = $rows['data'];
      $array_result[$rows['id_cotacao']]['valor']    = $rows['valor'];

      }
}elseif($recAcao == 'buscar_com_filtro'){

      $recMunicipio = @$_GET['municipio'];
      $recData = @$_GET['data'];
      $recEstado = @$_GET['estado'];
      $recIndex = @$_GET['index'];
      $recLimited = @$_GET['limited'];

      $select = "SELECT * FROM cotacao   WHERE 1 ";



      $resultConsultaTotal = mysqli_query($conexao, $select);

      $resultSelectTotal = mysqli_num_rows($resultConsultaTotal);
    //echo $resultSelectTotal;
      
if($recEstado !=""){
        $select.= " and  estado = '".$recEstado."' ";
} 
if($recData !=""){
        $select.= " and  data= '".$recData."' ";
} 
if($recMunicipio !=""){
        $select.= " and  municipio = '".$recMunicipio."' ";
} 
     $select.="order by id_cotacao";
    //////////////////////////////////////
       $result = mysqli_query($conexao, $select);

      $resultSelectFiltro = mysqli_num_rows($result);
    //echo $resultSelectFiltro;


    //$array_result['total'] = $rows[$dat]; 
     $array_result['total']                                  =  (int)$resultSelectTotal;
     $array_result['filtro']                                 = (int)$resultSelectFiltro; 
     $array_result['index']                                  =  (int)$recIndex;
     $array_result['limited']                                = (int)$recLimited;    


     $coutLimited=0;  
     $coutIndex=0; 

      while($rows = $result -> fetch_assoc()){
    $coutIndex++;
          $array_resultA['data'][$rows['id_cotacao']]['pos']        = $coutIndex;
          $array_resultA['data'][$rows['id_cotacao']]['id_cotacao'] = $rows['id_cotacao']; 
          $array_resultA['data'][$rows['id_cotacao']]['cultura']    = $rows['cultura'];
          $array_resultA['data'][$rows['id_cotacao']]['municipio']  = $rows['municipio'];
          $array_resultA['data'][$rows['id_cotacao']]['estado']     = $rows['estado'];
          $array_resultA['data'][$rows['id_cotacao']]['data']       = $rows['data'];
          $array_resultA['data'][$rows['id_cotacao']]['valor']      = $rows['valor'];
    }

    foreach ($array_resultA['data'] as $key => $value) {
       
       if ( $array_resultA['data'][$key]['pos'] >= $recIndex ) {
        $coutLimited++;
        
          $array_result['data'][$key]['id_cotacao'] = $value['id_cotacao']; 
          $array_result['data'][$key]['cultura']    = $value['cultura'];
          $array_result['data'][$key]['municipio']  = $value['municipio'];
          $array_result['data'][$key]['estado']     = $value['estado'];
          $array_result['data'][$key]['data']       = $value['data'];
          $array_result['data'][$key]['valor']      = $value['valor'];



      }
      if ($coutLimited == $recLimited  and $recLimited != 0)  {break;}
    }
    }else{
    echo "Método inválido";
    exit();
    }

    echo json_encode($array_result, true);
?>
