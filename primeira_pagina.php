<?php include 'include/top.php'?>
<?php
$sql = "{CALL pr_ler_dashboard}";
$stmt = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($stmt);
?>
<style>
    .estoque{
        text-align: center;
        width: 30%;
    }
    .estoque ul{
        text-align: left;
        font-size: 20px;
    }
    
    ul{
        list-style: none;
    }

    li a{
        text-decoration: none;
    }
</style>
<div class="container">
    <?php if(($acesso == 1) || ($acesso == 2)){ ?>
        <div class="estoque">
            <h1>ESTOQUE</h1>
            <ul>
                <li>
                <?php if($row['times_nao_cad'] > 0) {?>
                    <a href="pg_tm_004.php">
                    <?php }?>Times não cadastrados <span><?=$row['times_nao_cad']?></span>
                    <?php if($row['times_nao_cad'] >  0) {?></a><?php }?>
                </li>
            </ul>    
        </div>
    <?php }?>
</div>
<?php include 'include/footer.php'?>