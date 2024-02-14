<?php


require_once '../fpdf/fpdf.php';
require_once '../model/conexion.php';



class MiPDF extends FPDF
{
    function Header()
    {

        // Posicionar la imagen al costado izquierdo y hacerla un 30% más pequeña
        $this->Image('../img/logo23.png', 160, 8, 20); // Ajusta las coordenadas y el porcentaje según sea necesario


        $this->Image('../img/logoedu.png', 20, 10, 30);
        $this->ln(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 20, iconv('UTF-8', 'ISO-8859-1', 'ACUERDO Nro. MINEDUC-MINEDUC-2018-00030-A'), 0, 0, 'C');
        $this->ln(15);
        $this->SetX(20);

        $texto = "FORMULARIO PARA RESGUARDAR LA SEGURIDAD FÍSICA DE LOS ESTUDIANTES DURANTE LA ENTRADA Y LA SALIDAD DE LA JORNADA ESCOLAR";

        // Establece la posición y actual
        $posicion_y_actual = $this->GetY();

        // Ajusta el ancho máximo antes de cambiar de línea
        $ancho_maximo = 175;

        // Divide el texto en líneas según el ancho máximo
        $this->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'C');


        $conn = conectarBaseDeDatos();

        $sql = "SELECT grado FROM grado ORDER BY grado DESC LIMIT 1;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $estudianteDatos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($estudianteDatos) {
            $grado = $estudianteDatos['grado'];

            // Verificar si contiene la palabra "primero" o "Inicial"
            if (strpos(strtolower($grado), 'primero') !== false) {
                $variableParaMostrarEnFpdf = 'Primer';
            } elseif (strpos(strtolower($grado), 'inicial') !== false) {
                $variableParaMostrarEnFpdf = 'Inicial';
            } else {
                $variableParaMostrarEnFpdf = $grado;
            }
        }

        $sql = "SELECT grado FROM grado ORDER BY grado ASC LIMIT 1;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $estudianteDatos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($estudianteDatos) {
            $grado = $estudianteDatos['grado'];

            // Verificar si contiene la palabra "primero" o "Inicial"
            if (strpos(strtolower($grado), 'primero') !== false) {
                $variableParaMostrarEnFpdf2 = 'Primer';
            } elseif (strpos(strtolower($grado), 'inicial') !== false) {
                $variableParaMostrarEnFpdf2 = 'Inicial';
            } else {
                $variableParaMostrarEnFpdf2 = $grado;
            }
        }


        $this->SetFont('Arial', '', 9);

        $this->ln(2);
        $this->SetX(20);

        $texto = "Los estudiante de Educación  $variableParaMostrarEnFpdf2 hasta $variableParaMostrarEnFpdf año de Educación General Básica,deberán transladarse a la institucion educativa,sin excepción,acompañados de su madre,padre y/o representante legal o de una persona debidamente autorizada y registrada ante las maximas autoridades de la institucion educativa.";

        // Establece la posición y actual
        $posicion_y_actual = $this->GetY();

        // Ajusta el ancho máximo antes de cambiar de línea
        $ancho_maximo = 175;

        // Divide el texto en líneas según el ancho máximo
        $this->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');


        $this->SetFont('Arial', '', 9);

        $this->ln(3);
        $this->SetX(20);

        $texto = "Antes del inicio de cada período escolar,las madres, padres y/o representantes legales de los estudiantes deberán notifcar a la maxima autoridad del establecimiento educativo,la modalidad de translado que utilizarán su representado,notificación que la realizará a través del respectivo formulario de registro, que reposará en cada institución, formulario que debera contener por lo menos la siguiente información.";

        // Establece la posición y actual
        $posicion_y_actual = $this->GetY();

        // Ajusta el ancho máximo antes de cambiar de línea
        $ancho_maximo = 175;

        // Divide el texto en líneas según el ancho máximo
        $this->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');
    }
    function Footer()
    {

        $conn = conectarBaseDeDatos();

        $sql = "SELECT
    titulo,
    rector,
    genero,
    correo,
    celular
    FROM
    reportes;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $reporte = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->SetFont('Arial', 'B', 9);
        $this->SetY(273);
        $this->SetTextColor(236, 29, 23);
        $this->SetX(90); // Establecer el color del texto en blanco para que sea legible en fondo rojo
        $this->Cell(0, 20, iconv('UTF-8', 'ISO-8859-1', 'CDLA.MARIO MINUCHE CALLE ELOY ALFARO Y TRECERA SUR'), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 9);
        $this->SetY(277);
        $this->SetX(150);
        $this->SetTextColor(236, 29, 23);
        $this->SetX(157); // Establecer el color del texto en blanco para que sea legible en fondo rojo
        $this->Cell(0, 20, iconv('UTF-8', 'ISO-8859-1', ($reporte['correo'])), 0, 0, 'C');
        $this->SetY(281);
        $this->SetX(100);
        $this->SetTextColor(236, 29, 23);
        $this->SetX(165);
        // Establecer el color del texto en blanco para que sea legible en fondo rojo
        $this->Cell(0, 20, iconv('UTF-8', 'ISO-8859-1', ($reporte['celular'])), 0, 0, 'C');
    }
}
function generateReport($estudianteId)
{
    $pdf = new MiPDF();

    // Agregar una nueva página
    $pdf->AddPage();

    $conn = conectarBaseDeDatos();


    $pdf->SetFont('Arial', 'B', 9);

    $pdf->ln(0);
    $pdf->SetX(20);

    $texto = "A)Datos personales del estudiante, madre , padre y/o representante legal;";

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');




    $sql = "SELECT * FROM estudiante WHERE id = :estudianteId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':estudianteId', $estudianteId, PDO::PARAM_INT);
    $stmt->execute();
    $estudianteDatos = $stmt->fetch(PDO::FETCH_ASSOC);



    $pdf->SetFont('Arial', '', 9);

    $pdf->ln(1);
    $pdf->SetX(20);

    $texto = "Nombre del estudiante: " . mb_strtoupper($estudianteDatos['apellidos']) . " " . mb_strtoupper($estudianteDatos['nombres']);

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');



    $sql = "SELECT 
    p.apellidos_nombres,
    p.cedula,
    p.direccion,
    p.ocupacion,
    p.telefono,
    p.correo,
    p.foto
    
    FROM persona p JOIN rol r on p.Id=r.id_persona
    JOIN estudiante e on e.Id=p.id_estudiante
    where r.rol='Representante' AND e.id = :estudianteId;  ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':estudianteId', $estudianteId, PDO::PARAM_INT);
    $stmt->execute();
    $representanteDatos = $stmt->fetch(PDO::FETCH_ASSOC);


    $pdf->SetFont('Arial', '', 9);

    $pdf->SetX(20);

    $texto = "Nombre del representante legal: " . mb_strtoupper($representanteDatos['apellidos_nombres']);

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');











    $pdf->SetFont('Arial', 'B', 9);

    $pdf->ln(2);
    $pdf->SetX(20);

    $texto = "B)Dirección del domicilio del estudiante (CROQUIS);";

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');


    $pdf->SetFont('Arial', 'B', 9);

    $pdf->ln(40);
    $pdf->SetX(20);

    $texto = "C)Datos personales de los responsables del traslado del estudiante a la institución educativa,asi como de su retiro una vez culminada de la jornada escolar, se podra registrar un máximo de tres (3)personas;";


    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');

    $pdf->SetFont('Arial', '', 9);

    $sql = "SELECT 
            r.nombre,
            r.telefono,
            r.parentesco
            FROM responsables r 
            JOIN estudiante e on e.Id=r.id_estudiante 
            WHERE r.id_estudiante= :estudianteId;";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':estudianteId', $estudianteId, PDO::PARAM_INT);
    $stmt->execute();
    $responsables = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pdf->ln(5);

    $pdf->SetX(20);

    // Itera sobre los responsables y muestra la información en el PDF
    foreach ($responsables as $index => $responsable) {
        // Establece la posición de inicio de las columnas
        $column1X = 20;
        $column2X = 100;
        $column3X = 150;

        $pdf->SetX($column1X);

        // Texto para la primera columna (Nombres)
        $texto1 = ($index + 1) . "._Nombres: " . $responsable['nombre'];
        $pdf->MultiCell($column2X - $column1X, 0, iconv('UTF-8', 'ISO-8859-1', $texto1), 0, 'J');

        // Texto para la segunda columna (Teléfono)
        $pdf->SetX($column2X);
        $texto2 = "Teléfono: " . $responsable['telefono'];
        $pdf->MultiCell($column3X - $column2X, 0, iconv('UTF-8', 'ISO-8859-1', $texto2), 0, 'J');

        // Texto para la tercera columna (Parentesco)
        $pdf->SetX($column3X);
        $texto3 = "Parentesco: " . $responsable['parentesco'];
        $pdf->MultiCell(0, 0, iconv('UTF-8', 'ISO-8859-1', $texto3), 0, 'J');

        // Agrega un salto de línea entre cada responsable
        $pdf->ln(5);
    }

    $sql5 = "SELECT 
    transporte,
    traslado,
    conductor,
    telefono_conductor
    FROM traslado t 
    JOIN estudiante e on e.Id=t.id_estudiante
    WHERE t.id_estudiante = :estudianteId;";

    $stmt = $conn->prepare($sql5);
    $stmt->bindParam(':estudianteId', $estudianteId, PDO::PARAM_INT);
    $stmt->execute();
    $transporte = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $pdf->SetFont('Arial', 'B', 9);

    $pdf->SetX(20);

    $texto = "D)Autorización escrita firmada por la madre,padre y/o representante legal, en el caso de que el estudiante se translade solo a la institucion educativa y a su domicilio;";

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');


    $pdf->SetFont('Arial', '', 9);

    $pdf->ln(2);
    $pdf->SetX(20);
    // Obtén el valor de traslado desde tu base de datos
    $valor_traslado = $transporte[0]['traslado'];

    // ...

    $texto_si = "El Estudiante se transladara solo a la institución:      Si(  )      No(  )";

    // Marca con una "X" según el valor obtenido
    if ($valor_traslado == 1) {
        $texto_si = str_replace("Si(  )", "Si(X)", $texto_si);
    } elseif ($valor_traslado == 0) {
        $texto_si = str_replace("No(  )", "No(X)", $texto_si);
    }

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto_si), 0, 'J');



    $pdf->SetFont('Arial', 'B', 9);

    $pdf->ln(2);
    $pdf->SetX(20);

    $texto = "E)Modalidad de transporte a través del cual el estudiante se transladará a la institución educativa(Transporte público,transporte privado,transporte escolar,sin transporte);";

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');




    $pdf->SetFont('Arial', '', 9);

    $pdf->SetX(20);

    $texto = "Transporte:  " . mb_strtoupper($transporte[0]['transporte']);

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');



    $pdf->SetFont('Arial', 'B', 9);

    $pdf->ln(2);
    $pdf->SetX(20);

    $texto = "F)Número cedula de la madre,padre y/o representante legal del estudiante y un numero de contacto en caso de retraso o inasistencia injustificada del mismo, y del número ceular de la persona responsable del traslado.;";

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');



    $pdf->SetFont('Arial', '', 9);

    $pdf->ln(1);
    $pdf->SetX(20);

    $texto = "Número de cedula del representante legal: " . $representanteDatos['cedula'];

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');

    // Verifica si existen registros de conductor y teléfono
    if (!empty($transporte[0]['conductor']) && !empty($transporte[0]['telefono_conductor'])) {
        $pdf->SetX(20);

        $texto_conductor = "Conductor: " . mb_strtoupper($transporte[0]['conductor']);
        // Muestra la información del conductor
        $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto_conductor), 0, 'J');

        $pdf->SetX(20);
        $texto_telefono = "Telefono del conductor: " . mb_strtoupper($transporte[0]['telefono_conductor']);
        $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto_telefono), 0, 'J');
    }
    $pdf->ln(28);

    // Calcula el centro de la página en el eje X
    $centroX = ($pdf->GetPageWidth() - 130) / 2;

    // Establece la posición X para centrar el texto
    $pdf->SetX($centroX);

    // Ahora puedes usar esa posición X para imprimir los textos centrados
    $pdf->Cell(130, 0, iconv('UTF-8', 'ISO-8859-1', '_________________________________'), 0, 0, 'C');

    // Añadir un salto de línea antes de la firma para separarla de la línea
    $pdf->Ln(5);

    // Establecer la posición X para centrar la firma
    $pdf->SetX($centroX);

    // Imprimir la firma del representante legal
    $pdf->Cell(130, 0, iconv('UTF-8', 'ISO-8859-1', 'Firma Representante Legal'), 0, 0, 'C');



    $pdf->Output();
}

// Check if the 'generar_acuerdo' POST parameter is set
if (isset($_POST['generar_acuerdo'])) {
    $estudianteId = $_POST['generar_acuerdo'];
    generateReport($estudianteId);
}
$conn = null;
