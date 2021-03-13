<?php     


       date_default_timezone_set('America/Bahia');
       include('../modelo/conexao.php');///conexao com o banco de dados

$usuario = $_POST['data'];
$data = $_POST['envioData'];

//var_dump($usuario);
//echo $data;

$dados = json_decode($usuario, true); 


  $execQuery = " INSERT INTO cotacao
                               		(                              	
                                 	  cultura,
                                    praca,
                             		    municipio,
                                    estado,
                             		    data,
                                  	valor
                              		)VALUES";
             
    foreach ($dados['arrayItens'] as $value) {

///seprar estado de municipio start

$valuePraca = explode("/",$value['Praça'] );

///seprar estado de municipio start

if(is_numeric(substr(@$valuePraca[1],0,2))){
 $value['praca']      = $value['Praça'];
 $value['minicipio']  = $valuePraca[0];
 $value['Estado']     = 'ND';
}else{
  $value['praca']     = $value['Praça'];
  $value['municipio'] = $valuePraca[0];
  $value['Estado']    = substr(@$valuePraca[1],0,2);
}




                $select ="SELECT * FROM cotacao WHERE data ='".$data."' AND praca='". $value['praca']."'";
                  //echo $select; 
                $resultConsulta = mysqli_query($okdb, $select);

                $resultSelect = mysqli_num_rows($resultConsulta);
                // echo $resultSelect;
                  //var_dump($result_consult);

        if($resultSelect > 0){


                 $update = "    UPDATE cotacao SET 
                                      valor='".(float)str_replace(',','.' , $value['Preço (R$/sc 60kg)'])."'
                                                                          
                                     WHERE data ='".$data."' AND praca='". $value['praca']."'";
                                   
                               //$update = substr($update, 0, -2);
                  echo $update;
                  $result = mysqli_query($okdb,$update)or die(false);
        }else{
                      $execQuery .= "(
                    								    'soja',
                                        '".$value['praca']."',
                    		                '".$value['municipio']."',
                                        '".$value['Estado']."',
                               		      '".$data."',
                                        '".(float)str_replace(',','.' , $value['Preço (R$/sc 60kg)'])."'
                             		      ),";
        }
                                                                      
    	 ///executera a QUERY end
    }
     $execQuery = substr($execQuery, 0, -1);

                    echo $execQuery;
                       $result = mysqli_query($okdb,$execQuery)or die(false);
                       
?>  
                 
          