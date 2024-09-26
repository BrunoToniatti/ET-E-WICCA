<?php include 'include/top.php';?>
<?php
$mandar = $_POST['mandar'] ?? "";
$msg = "";

if(!empty($mandar)){
    $banner_desc = $_POST['banner_desc'] ?? "";
    $banner_alerta = $_POST['banner_alerta'] ?? "";
    $banner_titulo = $_POST['banner_titulo'] ?? "";
    $banner_botao_texto = $_POST['banner_botao_texto'] ?? "";
    $banner_foto = $_POST['banner_foto'] ?? "";

    $sql = "{CALL pr_criar_banner(?,?,?,?,?,?)}";
    $parametros = array($banner_desc, $banner_alerta, $banner_titulo, $banner_botao_texto, $banner_foto, $cod);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    if($stmt){
        $row = sqlsrv_fetch_array($stmt);
        if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
        }else{
            echo "<script>window.alert('".$row['msg']."')</script>";
        }
    }else{
        echo "<script>window.alert('Erro ao cadastrar foto')</script>";
    }
}
?>

<div class="container">
    <h1>Cadastrar Marca</h1>
    <form action="pg_bn_001.php" method="post" enctype="multipart/form-data">
        <div class="formulario">
            <label>Banner Descrição: <br>
                <input type="text" name="banner_desc" id="banner_desc">                
            </label>
            <label>Banner Alerta: <br>
                <input type="text" name="banner_alerta" id="banner_alerta">                
            </label>
            <label>Banner Titulo: <br>
                <input type="text" name="banner_titulo" id="banner_titulo">                
            </label>
            <label>Banner Botão: <br>
                <input type="text" name="banner_botao_texto" id="banner_botao_texto">                
            </label>
            <label>Banner Foto: <br>
                <input type="text" name="banner_foto" id="banner_foto">                
            </label>
            <input type="hidden" name="mandar" value="yes">
            <input type="submit" value="Cadastrar">
        </div>
    </form>
</div>

<?php include 'include/footer.php';?>
