<?php


require_once '../fpdf/fpdf.php';
require_once '../model/conexion.php';



class MiPDF extends FPDF
{
    function Header()
    {

        // Posicionar la imagen al costado izquierdo y hacerla un 30% más pequeña
        $this->Image('../img/logo23.png', 160, 8,20); // Ajusta las coordenadas y el porcentaje según sea necesario

       
        $this->Image('../img/logoedu.png', 20, 10,30);
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



    $this->SetFont('Arial', '', 9);

    $this->ln(2);
        $this->SetX(20);

        $texto = "Los estudiante de Educación Inicial hasta Primer año de Educación General Básica,deberán transladarse a la institucion educativa,sin excepción,acompañados de su madre,padre y/o representante legal o de una persona debidamente autorizada y registrada ante las maximas autoridades de la institucion educativa.";

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

        $this->SetFont('Arial', 'B', 9);
        $this->SetY(275);
        $this->SetTextColor(236, 29, 23);
        $this->SetX(90); // Establecer el color del texto en blanco para que sea legible en fondo rojo
        $this->Cell(0, 20, iconv('UTF-8', 'ISO-8859-1', 'CDLA.MARIO MINUCHE CALLE ELOY ALFARO Y TRECERA SUR'), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 9);
        $this->SetY(280);
        $this->SetX(150);
        $this->SetTextColor(236, 29, 23);
        $this->SetX(157); // Establecer el color del texto en blanco para que sea legible en fondo rojo
        $this->Cell(0, 20, iconv('UTF-8', 'ISO-8859-1', '07h1462@gmail.com'), 0, 0, 'C');
        $this->SetY(284);
        $this->SetX(100);
        $this->SetTextColor(236, 29, 23);
        $this->SetX(165);
        // Establecer el color del texto en blanco para que sea legible en fondo rojo
        $this->Cell(0, 20, iconv('UTF-8', 'ISO-8859-1', '+593 969998542 '), 0, 0, 'C');

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

        $texto = "Nombre del estudiante: ". mb_strtoupper($estudianteDatos['apellidos'])." ". mb_strtoupper($estudianteDatos['nombres']);

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

    $pdf->ln(0);
        $pdf->SetX(20);

        $texto = "Nombre del representante legal: ". mb_strtoupper($representanteDatos['apellidos_nombres']);

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
    
    $pdf->ln(2);
    
    $pdf->SetX(20);
    
    // Itera sobre los responsables y muestra la información en el PDF
    foreach ($responsables as $index => $responsable) {
        $pdf->SetX(20);

        $texto = ($index + 1) . "_".$responsable['nombre']."   Teléfono: ".$responsable['telefono']."   Parentesco: ".$responsable['parentesco'];
        
        // Establece la posición y actual
        $posicion_y_actual = $pdf->GetY();
    
        // Ajusta el ancho máximo antes de cambiar de línea
        $ancho_maximo = 175;
    
        // Divide el texto en líneas según el ancho máximo
        $pdf->MultiCell($ancho_maximo, 2, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');
        
        // Agrega un salto de línea entre cada responsable
        $pdf->ln(5);
    }


      
    $pdf->SetFont('Arial', 'B', 9);

    $pdf->ln(15);
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

        $texto = "El Estudiante se transladara solo a la institución:      Si(  )      No(  )";
        
    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');


    
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


     
    $pdf->SetFont('Arial', 'B', 9);

    $pdf->ln(10);
        $pdf->SetX(20);

        $texto = "F)Número cedula de la madre,padre y/o representante legal del estudiante y un numero de contacto en caso de retraso o inasistencia injustificada del mismo, y del número ceular de la persona responsable del traslado.;";
        
    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');



    $pdf->SetFont('Arial', '', 9);

    $pdf->ln(2);
        $pdf->SetX(20);

        $texto = "Número de cedula del representante legal: " .$representanteDatos['cedula'];
        
    // Establece la posición y actual
    $posicion_y_actual = $pdf->GetY();

    // Ajusta el ancho máximo antes de cambiar de línea
    $ancho_maximo = 175;

    // Divide el texto en líneas según el ancho máximo
    $pdf->MultiCell($ancho_maximo, 5, iconv('UTF-8', 'ISO-8859-1', $texto), 0, 'J');


    $pdf->ln(40);

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

