<?php include 'include/top.php';?>
<?php
$mandar = $_POST['mandar'] ?? "";
$msg = "";

if(!empty($mandar)){
    $marca_cod = $_POST['marca_cod'] ?? "";
    $marca_nome = $_POST['marca_nome'] ?? "";
    $link = $_POST['link'] ?? "";
    // Salvando o caminho do arquivo no banco de dados
    $sql = "{CALL pr_criar_marca(?,?,?,?)}";
    $parametros = array($marca_cod, $marca_nome, $link, $cod);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    if(sqlsrv_has_rows($stmt)){
        $row = sqlsrv_fetch_array($stmt);
        if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
            echo "<script>window.location.href='pg_mc_002.php'</script>";
        }else{
            echo "<script>window.alert('".$row['msg']."')</script>";
        }
    }
        
}
?>

<div class="container">
    <h1>Cadastrar Marca</h1>
    <form action="pg_mc_001.php" method="post" enctype="multipart/form-data">
        <label>Código: <br>
            <input type="text" name="marca_cod" id="marca_cod">                
        </label>
        <label>Nome da Marca: <br>
            <input type="text" name="marca_nome" id="marca_nome">                
        </label>
        <label>Link do arquivo: <br>
            <input type="text" name="link" id="link">                
        </label>
        <input type="hidden" name="mandar" value="yes">
        <input type="submit" value="Cadastrar">
    </form>
</div>

<?php include 'include/footer.php';?>
