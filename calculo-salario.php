<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cálculo de Salário</title>
    <link rel="stylesheet" href="css/styles.css"> 
</head>
<body>
    <h2>Formulário de Cálculo de Salário</h2>
    <form action="" method="post">
        <label for="nome">Nome do Vendedor:</label><br>
        <input type="text" id="nome" name="nome" required><br>
        <label for="meta_semanal">Meta Semanal (em reais):</label><br>
        <input type="text" id="meta_semanal" name="meta_semanal" required onkeyup="formatarMoeda(this)"><br>
        <label for="meta_mensal">Meta Mensal (em reais):</label><br>
        <input type="text" id="meta_mensal" name="meta_mensal" required onkeyup="formatarMoeda(this)"><br><br>
        <button type="submit">Calcular Salário</button>
    </form>

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_vendedor = $_POST['nome'];
    
    // Remover caracteres não numéricos e converter vírgulas para ponto nas metas semanal e mensal
    $meta_semanal = str_replace(array('.', ' R$', ','), '', $_POST['meta_semanal']);
    $meta_mensal = str_replace(array('.', ' R$', ','), '', $_POST['meta_mensal']);

    // Converter as metas para números
    $meta_semanal = floatval($meta_semanal);
    $meta_mensal = floatval($meta_mensal);

    // Definir salário mínimo
    $salario_minimo = 1412.00;

    // Calcular bônus e excedentes
    $bonus_semanal = ($meta_semanal * 0.01);
    $excedente_semanal = max(0, ($meta_semanal - 20000) * 0.05);
    $excedente_mensal = max(0, ($meta_mensal - 80000) * 0.10);

    // Calcular salário final
    if ($meta_semanal >= 20000) {
        $salario_final = $salario_minimo + $bonus_semanal + $excedente_semanal + $excedente_mensal;
    } else {
        $salario_final = $salario_minimo + $bonus_semanal;
    }

    echo "<div class='resultado'>";
    echo "<h3>Resultado do Cálculo</h3>";
    echo "Nome do Vendedor: " . $nome_vendedor . "<br>";
    echo "Salário Final: R$ " . number_format($salario_final, 2, ',', '.');
    echo "</div>";
}
    ?>

<script>
        function formatarMoeda(elemento) {
            var valor = elemento.value.replace(/\D/g, ''); // Remove tudo o que não é dígito
            valor = (parseInt(valor) / 100).toFixed(2).toString().replace('.', ',');
            elemento.value = 'R$ ' + valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>
</body>
</html>
