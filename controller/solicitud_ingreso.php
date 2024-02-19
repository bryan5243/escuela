<?php


require_once '../fpdf/fpdf.php';
require_once '../model/conexion.php';



class MiPDF extends FPDF
{
    function Header()
    {

        // Posicionar la imagen al costado izquierdo y hacerla un 30% más pequeña
        $this->Image('../img/logo23.png', 10, 10, 40); // Ajusta las coordenadas y el porcentaje según sea necesario

        // Texto al lado de la imagen
        $this->SetFont('Arial', 'B', 15);
        $this->SetX(48); // Ajusta la posición horizontal del texto según sea necesario
        $this->Cell(140, 15, iconv('UTF-8', 'ISO-8859-1', 'ESCUELA DE EDUCACIÓN BÁSICA PARTICULAR'), 0, 0, 'C');
        $this->Ln(2);

        // Establecer el fondo rojo
        $this->SetFillColor(236, 29, 23);
        $this->Rect(50, $this->GetY() + 8, 137, 8, 'F'); // Ajusta los valores según el tamaño y posición del fondo

        // Establecer la fuente y el texto
        $this->SetFont('Arial', 'B', 15);
        $this->SetX(50); // Ajusta la posición horizontal del texto según sea necesario
        $this->SetTextColor(0, 0, 0); // Establecer el color del texto en blanco para que sea legible en fondo rojo
        $this->Cell(137, 25, iconv('UTF-8', 'ISO-8859-1', '"LAS ÁGUILAS DEL SABER"'), 0, 0, 'C');
        // Restaurar el color original
        $this->SetTextColor(0, 0, 0);
        $this->Ln(9);


        $this->SetFont('Arial', 'B', 10);
        $this->SetX(50); // Ajusta la posición horizontal del texto según sea necesario
        $this->Cell(137, 20, iconv('UTF-8', 'ISO-8859-1', 'RESOLUCIÓN: DEO-DPE: 109-2009'), 0, 0, 'C');
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(50); // Ajusta la posición horizontal del texto según sea necesario
        $this->Cell(137, 20, iconv('UTF-8', 'ISO-8859-1', 'AMIE:07H01462'), 0, 0, 'C');
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(50); // Ajusta la posición horizontal del texto según sea necesario
        $this->Cell(137, 20, iconv('UTF-8', 'ISO-8859-1', 'EL CAMBIO-MACHALA-ECUADOR'), 0, 0, 'C');

        $this->Ln(8);
        $this->SetFont('Arial', 'B', 16);
        $this->SetX(50); // Ajusta la posición horizontal del texto según sea necesario
        $this->Cell(137, 20, iconv('UTF-8', 'ISO-8859-1', 'SOLICITUD DE INGRESO '), 0, 0, 'C');
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

        $this->SetFont('Arial', 'B', 10);
        $this->SetY(265);
        $this->SetTextColor(236, 29, 23);
        $this->SetX(50); // Establecer el color del texto en blanco para que sea legible en fondo rojo
        $this->Cell(0, 20, iconv('UTF-8', 'ISO-8859-1', 'CDLA.MARIO MINUCHE CALLE ELOY ALFARO Y TRECERA SUR'), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 10);
        $this->SetY(270);
        $this->SetX(100);
        $this->SetTextColor(236, 29, 23);
        $this->SetX(123); // Establecer el color del texto en blanco para que sea legible en fondo rojo
        $this->Cell(0, 20, iconv('UTF-8', 'ISO-8859-1', ($reporte['correo'])), 0, 0, 'C');

        $this->SetY(275);
        $this->SetX(100);
        $this->SetTextColor(236, 29, 23);
        $this->SetX(132);
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
    // Aquí puedes agregar el resto de tu lógica para generar el reporte

    $fechaGenerada = false;
    // Meses en español
    $mesesEnEspanol = [
        'January' => 'enero',
        'February' => 'febrero',
        'March' => 'marzo',
        'April' => 'abril',
        'May' => 'mayo',
        'June' => 'junio',
        'July' => 'julio',
        'August' => 'agosto',
        'September' => 'septiembre',
        'October' => 'octubre',
        'November' => 'noviembre',
        'December' => 'diciembre'
    ];
    if (!$fechaGenerada) {


        $sql = "SELECT created_at 
        FROM matricula 
        WHERE id_estudiante = :estudianteId
        ORDER BY created_at DESC
        LIMIT 1;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':estudianteId', $estudianteId, PDO::PARAM_INT);
        $stmt->execute();
        $fecha = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fecha) {
            $row = $fecha;
            $fechaActual = new DateTime($row['created_at']);
            $fechaActual->setTimeZone(new DateTimeZone('Europe/Berlin'));

            $dia = $fechaActual->format('d');
            $mes = $mesesEnEspanol[$fechaActual->format('F')];
            $ano = $fechaActual->format('Y');

            // Establecer la configuración local para obtener el mes en español
            $pdf->Ln(25);
            $pdf->SetX(90); // Ajusta la posición horizontal del texto según sea necesario
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', ("El Cambio, $dia de $mes del $ano")), 0, 1, 'C');
            $fechaGenerada = true;
        } else {
            echo "Error al ejecutar la consulta: ";
        }
    }


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

    $pdf->Ln(0);
    $pdf->SetX(35);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1', ($reporte['titulo'] . ".")), 0, 1, 'L');



    $pdf->Ln(0);
    $pdf->SetX(35); // Ajusta la posición horizontal del texto según sea necesario
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 5, iconv('UTF-8', 'ISO-8859-1', '' . mb_strtoupper($reporte['rector'])), 0, 1, 'L');


    $pdf->Ln(0);
    $pdf->SetX(35); // Ajusta la posición horizontal del texto según sea necesario
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1', '' . mb_strtoupper($reporte['genero']) . ' DE LA ESCUELA.'), 0, 1, 'L');


    $pdf->Ln(0);
    $pdf->SetX(35); // Ajusta la posición horizontal del texto según sea necesario
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, iconv('UTF-8', 'ISO-8859-1', ("CIUDAD.")), 0, 1, 'L');






    $sql = "SELECT 
    e.cedula as cedula_estudiante,
    e.nombres,
    e.apellidos,
    g.grado,
    p.apellidos_nombres as apellidos_representante,
    p.cedula,
    pe.estado
    FROM estudiante e
    JOIN persona p ON e.Id = p.id_estudiante
    JOIN rol r ON  p.Id= r.id_persona  
    JOIN matricula m on e.Id=m.id_estudiante
    JOIN grado g on g.id=m.id_grado
    JOIN periodo pe on m.id_periodo=pe.Id
    WHERE r.rol = 'representante' AND pe.estado=1 AND e.Id=:estudianteId";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':estudianteId', $estudianteId, PDO::PARAM_INT);
    $stmt->execute();
    $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

    $pdf->Ln(10);
    $pdf->SetX(35);
    $pdf->SetFont('Arial', '', 12); // Configura la fuente en negrita

    $texto = "Yo, " . $solicitud['apellidos_representante'] . " con cédula de ciudadanía N° " . $solicitud['cedula'] . ", Representante Legal del Estudiante  " . $solicitud['nombres'] . "  " . $solicitud['apellidos'] . ", con cedula de ciudadanía N°"
        . $solicitud['cedula_estudiante'] . " ante usted respetuosamente solicito.";

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 145;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 7, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');

    // Restablece la posición y a la siguiente línea después de la última MultiCell
    $pdf->SetY($posicion_y_actual);

    // Continúa desde la última posición Y
    $pdf->SetX($pdf->GetX() + $ancho_maximo);





    $pdf->Ln(30);
    $pdf->SetX(35);
    $pdf->SetFont('Arial', '', 12); // Configura la fuente en negrita
    // Obtén el año actual


    // Consulta SQL para obtener el periodo académico actual
    $sql = "SELECT periodo FROM periodo WHERE estado = 1";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obtener el resultado
    $periodo_actual = $stmt->fetchColumn();


    // Calcula el siguiente año sumando 1 al año actual
    $siguiente_ano = $periodo_actual+ 1;

    // Combina los años en el formato deseado
    $ano_lectivo = $periodo_actual . '-' . $siguiente_ano;
    // Ahora puedes usar $ano_lectivo en tu texto
    $texto = 'Se digne autorizar el ingreso a la Escuela De Educación Básica Particular "Las Águilas Del Saber", en calidad de alumno de ' . $solicitud['grado'] .
        ' a mí representado, para el Año Lectivo ' . $ano_lectivo . '.';

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 145;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 7, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');

    // Restablece la posición y a la siguiente línea después de la última MultiCell
    $pdf->SetY($posicion_y_actual);

    // Continúa desde la última posición Y
    $pdf->SetX($pdf->GetX() + $ancho_maximo);


    $pdf->Ln(25);
    $pdf->SetX(35);
    $pdf->SetFont('Arial', '', 12); // Configura la fuente en negrita

    $texto = "Por lo cual me permito adjuntar la documentación requerida.";

    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 145;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 7, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');

    // Restablece la posición y a la siguiente línea después de la última MultiCell
    $pdf->SetY($posicion_y_actual);

    // Continúa desde la última posición Y
    $pdf->SetX($pdf->GetX() + $ancho_maximo);


    // Asegúrate de tener la instancia del objeto $pdf
    $pdf->ln(20);

    // Calcula el centro de la página en el eje X
    $centroX = ($pdf->GetPageWidth() - 130) / 2;

    // Establece la posición X para centrar el texto
    $pdf->SetX($centroX);

    // Ahora puedes usar esa posición X para imprimir los textos centrados
    $pdf->SetFont('Arial', '', 14);
    $pdf->Cell(130, 20, iconv('UTF-8', 'ISO-8859-1', 'Atentamente'), 0, 0, 'C');

    $pdf->ln(20);
    $pdf->SetX($centroX);

    $pdf->Cell(130, 20, iconv('UTF-8', 'ISO-8859-1', 'Firma:..........................'), 0, 0, 'C');

    $pdf->ln(10);
    $pdf->SetX($centroX);

    $pdf->Cell(130, 20, iconv('UTF-8', 'ISO-8859-1', 'CI:................................'), 0, 0, 'C');

    $pdf->Output();
}


// Check if the 'generar_reporte' POST parameter is set
if (isset($_POST['generar_solicitud'])) {
    $estudianteId = $_POST['generar_solicitud'];
    generateReport($estudianteId);
}
$conn = null;
