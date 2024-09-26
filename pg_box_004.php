<?php include 'include/top.php';?>
<?php
$pg		    = 'pg_box_004';
$box_cod    = $_GET['box_cod'] ?? "";
$cabecalho  = 'box';
$listarPgC = "";

$tipo = $_POST['tipo'] ?? "" ;
if(!empty($tipo)){
    $box_nome = $_POST['box_nome'];
    $status_cod = $_POST['status_cod'];
    $sql = "{CALL pr_man_box(?,?,?,?)}";
    $paramentros = array($tipo, $box_cod, $box_nome, $status_cod);
    $stmt = sqlsrv_query($conn, $sql, $paramentros);
    if(sqlsrv_has_rows($stmt)){
        $row = sqlsrv_fetch_array($stmt);
        if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
            if($tipo == 2){
                echo "<script>window.location.href='pg_box_002.php';</script>";
            }
        }
    }
}
?>

<div class="container">
<?php include 'include/cabecalho.php';?>
<form action="<?=$_SERVER['PHP_SELF']?>?box_cod=<?=$box_cod?>" method="post" class="cadastrar">
	<div class="formulario">
	    <label>Código: <br>
	    	<input type="text" class="codigo" value="<?=$row['box_cod']?>" name="box_cod" id="box_cod" maxlength="3" disabled>
	    </label>
	    <label>Box Nome: <br>
	    	<input type="text" name="box_nome" value="<?=$row['box_nome']?>" id="box_nome">
	    </label>
        <label>Status <br>
        <select name="status_cod" class="select">
            <option value="1">Ativo</option>
            <option value="2">Inativo</option>
        </select>
        </label>
	</div>
    <br>
        <input type="hidden" name="tipo" value="1">
        <br>
            <div class="botoes">
                <input type="submit" value="Atualizar" class="atualizar" style="width: 150px !important; height: 40px !important;">
            </form>
				<form action="<?=$_SERVER['PHP_SELF']?>?box_cod=<?=$box_cod?>" method="post">
                    <input type="hidden" name="tipo" value="2">
					<input type="submit" value="Apagar" class="apagar" style="margin-top: -55px !important; width: 150px !important; height: 40px !important;">
				</form>
        </div>
</form>	
</div>
<?php include 'include/footer.php';?>