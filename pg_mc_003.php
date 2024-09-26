<?php include 'include/top.php';?>
<?php
$cabecalho = 'marcas';
$marca_cod = $_GET['marca_cod'] ?? '';
$pg = 'pg_mc_003';

$tipo = $_POST['tipo'] ?? "";

if(!empty($tipo)){
    $marca_nome = $_POST['marca_nome'] ?? '';
    $status_cod = $_POST['status_cod'] ?? '';

    $query = "{CALL pr_man_marca(?,?,?,?)}";
    $query_param = array($tipo, $marca_cod, $marca_nome, $status_cod);
    $stmt_query = sqlsrv_query($conn, $query, $query_param);
    
    if($stmt_query === false){
        die(print_r(sqlsrv_errors(), true));
    }
    
    if($row_query = sqlsrv_fetch_array($stmt_query, SQLSRV_FETCH_ASSOC)){
        echo "<script>console.log('".$row_query['msg']."')</script>";
        if($row_query['cad']){
            echo "<script>window.alert('".$row_query['msg']."')</script>";
            if($tipo == 2){
                echo "<script>window.alert('".$row_query['msg']."')</script>";
                echo "<script>window.location.href='pg_mc_002.php';</script>";
            }
        }
    } else {
        echo "<script>console.log('Nenhum dado retornado.')</script>";
    }
}
?>
<div class="container">
    <?php include 'include/cabecalho.php';?>
    <form action="<?=$_SERVER['PHP_SELF']?>?marca_cod=<?=$marca_cod?>" method="post">
        <div class="formulario">
            <label>Código: <br>
                <input type="text" name="marca_cod" id="marca_cod" class="codigo" value="<?=$row['marca_cod']?>" disabled>
            </label>
            <label>Nome: <br>
                <input type="text" name="marca_nome" id="marca_nome" value="<?=$row['marca_nome']?>">
            </label>
            <label>Status <br>
                <select name="status_cod" class="select">
                    <option value="<?=$row['status_cod']?>"><?=$row['status_nome']?></option>
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                </select>
            </label>
            <input type="hidden" name="tipo" value="1">
        </div>
        <div class="botoes">
                <input type="submit" value="Atualizar" class="atualizar" style="width: 150px !important; height: 40px !important;">
            </form>
				<form action="<?=$_SERVER['PHP_SELF']?>?marca_cod=<?=$marca_cod?>" method="post">
                    <input type="hidden" name="tipo" value="2">
					<input type="submit" value="Apagar" class="apagar" style="margin-top: -55px !important; width: 150px !important; height: 40px !important;">
				</form>
            </div>
</div>
<?php include 'include/footer.php';?>