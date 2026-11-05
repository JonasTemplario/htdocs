<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Array</title>

    <head>

        <?php
        // Variaves são case sensitivy
        // uma constante não pode ser alterada depois

        define('MOTO', 'SUZUKI 750R');
        define('ANO', '2016');
        $dono = 'João Miguel';
        $preco = '27.000,00';
        // criar um array
        $opcionais = array(
            'protetor_dianteiro' => "Sim",
            'protetor_traseiro' => 'Sim',
            'alarme' => 'presencial',
            'kilometragem' => 150000,
        );

        ?>
        <!-- Para fins de teste -->

    <body>
        <h1>Modelo da Moto: <?php echo MOTO;
                            echo ' SuperTop'; ?></h1>
        <h2>Ano: <?php echo ANO; ?></h2>
        <p>O vendedor desta moto é: <?php echo $dono; ?></p>
        <p> Valor R$ <?php echo $preco; ?>
            <hr><br>
            <!-- Usar uma instrução para mostrar o conteúdo do Array -->
            <?php print_r($opcionais) ?>
            <br>
            <hr><br>

            <!-- Maneira correta de imprimir um array é usar uma Estrutura de Repetição -->
            <?php
            foreach ($opcionais as $key => $valor) {
                echo '<li>';
                echo $key . ' - ' . $valor;
                echo '<li>';
            }
            echo '<br><hr><br>';
            echo $opcionais['protetor_traseiro'];
            ?>
            <br>
            <hr><br>
            <?php
            $marcas_carro = array('Chevrolet', 'Honda', 'Ford', 'Jeep', 'Volkswagen');

            $marcas_carro[] = 'Ferrari';
            $marcas_carro[2] = 'Bugatti';
            $marcas_carro[0] = 'Tesla';

            print_r($marcas_carro);
            echo '<br><hr><br>';
            var_dump($marcas_carro);
            echo '<br><hr><br>';
            var_dump($opcionais);
            echo '<br><hr><br>';

            $lista_frutas = ['Melão', 'Banana', 'Morango', 'Maçã'];
            var_dump($lista_frutas);
            ?>
    </body>