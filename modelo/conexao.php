<?php
/* arquivo de conexao com o banco de dados*/
//CONECTAR COM O SERVIDOR

if( $_SERVER['HTTP_HOST']== 'localhost'){

	$okdb = mysqli_connect('localhost','root', '','api');///nome do host,nome do usuario, senha mysqly, nome do banco de dados

}else if($_SERVER['HTTP_HOST']== 'estoque.rf.gd'){ ///site do servidor

	$okdb = mysqli_connect('sql108.epizy.com', 'epiz_26899676', 'W66XUqMmnfR', 'epiz_26899676_estoque');///nome do host,nome do usuario, senha mysqly, nome do banco de dados

}
//echo $_SERVER['HTTP_HOST'];

if (!$okdb) {
die('Problemas ao selecionar a base de dados!!!');
}else{

	echo '';
};

//CONECTAR COM O SERVIDOR
?>