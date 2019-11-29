<?php
    require "fpdf.php";
    
    $db = new PDO('mysql:host=localhost;dbname=dkut_revenue_system;','root','');
    
    class myPDF extends FPDF{
        function header(){
            $rand = rand(101,199);
            $serial =" #REVS".$rand;
            //$serial = 'Serial: 0010'.rand(123,999);
            $this->Image('logo.png',10,6);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'SMART REVENUE SYSTEM',0,0,'C');
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Cell(276, 10, 'P.O BOX 456 - 10100',0,0,'C');
            $this->Ln();
            $this->Cell(276, 10, 'Nyeri, Kenya',0,0,'C');
            $this->Ln(20);
            $this->Cell(276, 10, 'User Permit '.$serial,0,0,'L');
            $this->Ln(10);
        }
        function footer(){
            $this->SetY(-26);
            $this->SetFont('Arial','',8);
            $this->Ln();
            $this->Cell(0,10,'Batian family medical clinic',0,0,'C');
            $this->Ln();
            $this->Cell(0,10,'Page',0,0,'C');
        }

        function docHeader(){
            $this->SetFont('Times','',12);
            $this->Cell(10,10,'id#',1,0,'C');
            $this->Cell(40,10,'first name',1,0,'C');
            $this->Cell(40,10,'last name',1,0,'C');
            $this->Cell(40,10,'Phone #',1,0,'C');
            $this->Cell(70,10,'Email Address',1,0,'C');
            $this->Cell(40,10,'Current Street',1,0,'C');
            $this->Cell(40,10,'Current Package',1,0,'C');
            $this->Ln();
        }
        function docs($db){
            $this->SetFont('Times','',12);

            if (isset($_GET['id']) ){
                $id = $_GET['id'];
                //$nextpay = $_GET['nextpay'];
            }
            $stmt = $db->query("SELECT *FROM member WHERE mobile_number='$id' ORDER BY id");
            while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                $this->Cell(10,10,$data->id,1,0,'L');
                $this->Cell(40,10,$data->firstname,1,0,'L');
                $this->Cell(40,10,$data->lastname,1,0,'L');
                $this->Cell(40,10,$data->mobile_number,1,0,'L');
                $this->Cell(70,10,$data->email,1,0,'L');
                $this->Cell(40,10,$data->street,1,0,'L');
                $this->Cell(40,10,$data->package,1,0,'L');
                $this->Ln();
            }
        }

        function headerTable(){
            $this->SetFont('Times','',12);
            $this->Cell(20,10,'Tr. id#',1,0,'C');
            $this->Cell(25,10,'Amount #',1,0,'C');
            $this->Cell(38,10,'mpesa receipt #',1,0,'C');
            $this->Cell(38,10,'transaction date',1,0,'C');
            $this->Cell(38,10,'phone number',1,0,'C');
            $this->Cell(20,10,'State',1,0,'C');
            $this->Ln();
        }
    

        function space(){
            $this->Ln(10);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'WORK PERMIT | LICENSE AS PER REVENUE COLLECTION',0,0,'L');
            $this->Ln(10);
        }
        
        function additioalinfo2(){
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'Seal',0,0,'C');
            $this->getY();
            $this->Image('cleared.png',100,150);
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Ln(20);
        }
    }  

    $pdf = new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L','A4',0);
    $pdf->docHeader();
    $pdf->docs($db);
    $pdf->space();
    $pdf->additioalinfo2();
    $pdf->output();
?>  1