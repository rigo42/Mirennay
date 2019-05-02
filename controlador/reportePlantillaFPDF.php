<?php 
	/**
	 * Autor Rigoberto Villa
	 */
	require('controlador/fpdf/fpdf.php');

	class reportePlantillaFPDF{

		 public $fpdf;
		
		function __construct(){
			$this->fpdf = new FPDF();
		}

		public function inicio(){
			$this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();
            $this->fpdf->SetFont('Times','',12);
            $this->fpdf->SetFont('Arial','B',12);
		}

		public function titulo($titulo){
			 $this->fpdf->Cell(100,10,$titulo,0,0,'C');
		}

		// Cabecera de página
	    public function Header(){
	        // Logo
	        $this->fpdf->Image('libreria/img/M.png',10,8,20);
	        // Arial bold 15
	        $this->fpdf->SetFont('Arial','B',12);
	        // Movernos a la derecha
	        $this->fpdf->Cell(60);
	        // Salto de línea
	        $this->fpdf->Ln(20);
	    }

	    // Pie de página
	    public function Footer(){
	        // Posición: a 1,5 cm del final
	        $this->fpdf->SetY(-15);
	        // Arial italic 8
	        $this->fpdf->SetFont('Arial','I',8);
	        // Número de página
	        $this->fpdf->Cell(0,10,'Page '.$this->fpdf->PageNo().'/{nb}',0,0,'C');
	    }
	}
 ?>