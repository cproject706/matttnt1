<!-- // sample only not active -->

<?php
require('fpdf/fpdf.php');

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();


$pdf->SetFillColor(255, 204, 0); 
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 15, 'CONFIRMATION', 0, 1, 'L', true); 
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(190, 7, 'Paid & Booked: Matt Travel & Tours', 0, 1, 'R');

// Add Lead Guest Information
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Dear', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Candice Valerie Medina', 0, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 5, "Thank you for your reservation at MATT TRAVEL & TOURS. Kindly please save and present this voucher upon arrival. Should you require further assistance, please do not hesitate to contact your agent anytime.");
$pdf->Ln(10);

// Lead Guest Details Table
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(255, 204, 0); 
$pdf->Cell(95, 7, 'LEAD GUEST', 0, 0);
$pdf->Cell(95, 7, 'COMPLETE LIST OF GUEST', 0, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(45, 7, 'BOOKING #', 0, 0);
$pdf->Cell(50, 7, ': ES-PGPH51633-444', 0, 0);
$pdf->Cell(45, 7, '1. Jesse Philip Medina - 50', 0, 1);

$pdf->Cell(45, 7, 'Guest Name', 0, 0);
$pdf->Cell(50, 7, ': Candice Valerie Medina', 0, 0);
$pdf->Cell(45, 7, '2. Candice Valerie Medina - 48', 0, 1);

$pdf->Cell(45, 7, 'Contact Number', 0, 0);
$pdf->Cell(50, 7, ': 9453367171', 0, 0);
$pdf->Cell(45, 7, '3. Gabrielle Anne Medina - 22', 0, 1);

$pdf->Cell(45, 7, 'Remaining Balance', 0, 0);
$pdf->Cell(50, 7, ': 13029.00', 0, 0);
$pdf->Cell(45, 7, '4. Audrey Medina - 21', 0, 1);

$pdf->Ln(5);
$pdf->Cell(45, 7, '', 0, 0); 
$pdf->Cell(50, 7, '', 0, 0);
$pdf->Cell(45, 7, '5. Maxine Jessica Medina - 17', 0, 1);
$pdf->Cell(45, 7, '', 0, 0);
$pdf->Cell(50, 7, '', 0, 0);
$pdf->Cell(45, 7, '6. Samantha Medina - 14', 0, 1);
$pdf->Cell(45, 7, '', 0, 0);
$pdf->Cell(50, 7, '', 0, 0);
$pdf->Cell(45, 7, '7. Jace Philip Medina - 5', 0, 1);

$pdf->Ln(10); 


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(95, 7, 'HOTEL INFORMATION', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(45, 7, 'Accommodation', 0, 0);
$pdf->Cell(50, 7, ': The MangYan Grand Hotel', 0, 1);

$pdf->Cell(45, 7, 'Location', 0, 0);
$pdf->Cell(50, 7, ': Whitebeach, Puerto Galera', 0, 1);

$pdf->Cell(45, 7, 'Check In', 0, 0);
$pdf->Cell(50, 7, ': June 1, 2024, 1:00 PM', 0, 1);

$pdf->Cell(45, 7, 'Check Out', 0, 0);
$pdf->Cell(50, 7, ': June 2, 2024, 11:00 AM', 0, 1);

$pdf->Cell(45, 7, 'Adults', 0, 0);
$pdf->Cell(50, 7, ': 6', 0, 1);

$pdf->Cell(45, 7, 'Senior(s)', 0, 0);
$pdf->Cell(50, 7, ': 1', 0, 1);

$pdf->Cell(45, 7, 'Kids (4-10 y/o)', 0, 0);
$pdf->Cell(50, 7, ': 1', 0, 1);

$pdf->Cell(45, 7, 'Infant (1-3 y/o)', 0, 0);
$pdf->Cell(50, 7, ': 1', 0, 1);

$pdf->Cell(45, 7, 'Room Type', 0, 0);
$pdf->Cell(50, 7, ': Fully Air-conditioned Room', 0, 1);

$pdf->Cell(45, 7, 'Meal Type', 0, 0);
$pdf->Cell(50, 7, ': 1 Day Complimentary Breakfast', 0, 1);

$pdf->Ln(10);


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(95, 7, 'TOURS / ACTIVITIES', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(45, 7, 'Tour Type', 0, 0);
$pdf->Cell(50, 7, ': Island Hopping + Muelle Bay', 0, 1);

$pdf->Cell(45, 7, 'Coordinator', 0, 0);
$pdf->Cell(50, 7, ':', 0, 1);

$pdf->Cell(45, 7, 'Adult(s)', 0, 0);
$pdf->Cell(50, 7, ': 6', 0, 1);

$pdf->Cell(45, 7, 'Kid(s)', 0, 0);
$pdf->Cell(50, 7, ': 1', 0, 1);

$pdf->Cell(45, 7, 'Infant (1-3)', 0, 0);
$pdf->Cell(50, 7, ':', 0, 1);


$pdf->Ln(10); 
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Amendments Policy', 0, 1);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(0, 5, "Amendments to a booking will be handled on a case-by-case basis and will be dependent upon room availability. Changes may be possible at the same hotel, but changing hotels will always involve penalties outlined in this cancellation policy. The cancellation policy will apply for any changes in the reservation: change of pax, shortening of stay, change of date, reduction in the number of rooms, or change of room type. Cancellations or changes of reservation must be requested through email.");

$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Contact Us: +639560273169 | info.pgph@gmail.com', 0, 1, 'C');

// Output the PDF
$pdf->Output('D', 'booking_summary.pdf'); // 'D' for download
?>
