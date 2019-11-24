<?php
    require "fpdf.php";
    
    $db = new PDO('mysql:host=localhost;dbname=dkut_scheduling_system;','root','');
    //$reg = 'C025-02-0029/2015'; 
    
    class myPDF extends FPDF{
        function header(){
            $serial = 'Serial: 0010'.rand(123,999);
            $this->Image('logo.png',10,6);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'BATIAN FAMILY MEDICAL CLINIC',0,0,'C');
            $this->Ln();
            $this->SetFont('Times','',12);
            $this->Cell(276, 10, 'P.O BOX 1590 -10100',0,0,'C');
            $this->Ln();
            $this->Cell(276, 10, 'NyeriTown',0,0,'C');
            $this->Ln(20);
            $this->Cell(276, 10, 'Registered Specialists',0,0,'L');
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
            $this->Cell(70,10,'Email',1,0,'C');
            $this->Cell(40,10,'Category',1,0,'C');
            $this->Ln();
        }
        function docs($db){
            $this->SetFont('Times','',12);

            $stmt = $db->query("SELECT *FROM doctors ORDER BY id");
            while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                $this->Cell(10,10,$data->id,1,0,'L');
                $this->Cell(40,10,$data->fname,1,0,'L');
                $this->Cell(40,10,$data->lname,1,0,'L');
                $this->Cell(70,10,$data->email,1,0,'L');
                $this->Cell(40,10,$data->categoryname,1,0,'L');
                $this->Ln();
            }
        }

        function headerTable(){
            $this->SetFont('Times','',12);
            $this->Cell(20,10,'id#',1,0,'C');
            $this->Cell(20,10,'schedule #',1,0,'C');
            $this->Cell(20,10,'patient #',1,0,'C');
            $this->Cell(20,10,'Specialist #',1,0,'C');
            $this->Cell(30,10,'Status',1,0,'C');
            $this->Cell(120,10,'Doc Remarks',1,0,'C');
            $this->Ln();
        }
        function viewUsers($db){
            $this->SetFont('Times','',12);

            $stmt = $db->query("SELECT *FROM sessions ORDER BY id");
            while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                $this->Cell(20,10,$data->id,1,0,'L');
                $this->Cell(20,10,$data->schedule_id,1,0,'L');
                $this->Cell(20,10,$data->patid,1,0,'L');
                $this->Cell(20,10,$data->docid,1,0,'L');
                $this->Cell(30,10,$data->status,1,0,'L');
                $this->Cell(120,10,$data->docremarks,1,0,'L');
                $this->Ln();
            }
        }

        function space(){
            $this->Ln(10);
            $this->SetFont('Arial','B',14);
            $this->Cell(276,5,'ALL SESSIONS AND THEIR STATUS WITH REGARDS TO ALLOCATED SPECIALISTS',0,0,'L');
            $this->Ln(10);
        }
    }  

    $pdf = new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L','A4',0);
    $pdf->docHeader();
    $pdf->docs($db);
    $pdf->space();
    $pdf->headerTable();
    $pdf->viewUsers($db);
    $pdf->output();
?>