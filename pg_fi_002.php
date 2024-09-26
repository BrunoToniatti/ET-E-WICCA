<?php include 'include/top.php';?>
<?php
    $select = $conn->query("call pr_ler_tipos_pagamento();");
    $lista = "";
    if($select->num_rows > 0){
        while($row = $select->fetch_assoc()){
            $lista .= "<tr>";
            $lista .= "<td>".$row['pagamento_id']."</td>";
            $lista .= "<td>".$row['pagamento_nome']."</td>";
            $lista .= "<td>".$row['pagamento_funcao']."</td>";            
            $lista .= "</tr>";
			
			//pagamento_id, pagamento_nome, dt_criacao, pagamento_funcao
        }
    }
?>
<div class="container">
    <h1>LISTAR TIPOS DE PAGAMENTOS</h1>
    <br>
    <br>
    <table>
        <thead>
            <th>#</th>
            <th>FORMA DE PAGAMENTO</th>
            <th>FUNÇÃO DO PAGAMENTO</th>
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>