<?php

// This file is part of the Certificate module for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * letter_embedded certificate type
 *
 * @package    mod
 * @subpackage certificate
 * @copyright  Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from view.php
}

$pdf = new TCPDF($certificate->orientation, 'pt', 'Letter', true, 'UTF-8', false);

$pdf->SetTitle($certificate->name);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->SetAutoPageBreak(false, 0);

// Define variables
// Landscape
if ($certificate->orientation == 'L') {
    $x = 28;
    $y = 125;
    $sealx = 590;
    $sealy = 425;
    $sigx = 130;
    $sigy = 440;
    $custx = 133;
    $custy = 440;
    $wmarkx = 100;
    $wmarky = 90;
    $wmarkw = 600;
    $wmarkh = 420;
    $brdrx = 0;
    $brdry = 0;
    $brdrw = 792;
    $brdrh = 612;
    $codey = 505;
} else { // Portrait
    $x = 28;
    $y = 170;
    $sealx = 440;
    $sealy = 590;
    $sigx = 85;
    $sigy = 580;
    $custx = 88;
    $custy = 580;
    $wmarkx = 78;
    $wmarky = 130;
    $wmarkw = 450;
    $wmarkh = 480;
    $brdrx = 10;
    $brdry = 10;
    $brdrw = 594;
    $brdrh = 771;
    $codey = 660;
}

// Add images and lines
certificate_print_image($pdf, $certificate, CERT_IMAGE_BORDER, $brdrx, $brdry, $brdrw, $brdrh);
certificate_draw_frame_letter($pdf, $certificate);
// Set alpha to semi-transparency
$pdf->SetAlpha(0.1);
certificate_print_image($pdf, $certificate, CERT_IMAGE_WATERMARK, $wmarkx, $wmarky, $wmarkw, $wmarkh);
$pdf->SetAlpha(1);
certificate_print_image($pdf, $certificate, CERT_IMAGE_SEAL, $sealx, $sealy, '', '');
certificate_print_image($pdf, $certificate, CERT_IMAGE_SIGNATURE, $sigx, $sigy, '', '');

// Add text
/*
$pdf->SetTextColor(0, 0, 120);
certificate_print_text($pdf, $x, $y, 'C', 'freesans', '', 30, get_string('title', 'certificate'));
$pdf->SetTextColor(0, 0, 0);
certificate_print_text($pdf, $x, $y + 55, 'C', 'freeserif', '', 20, get_string('certify', 'certificate'));
certificate_print_text($pdf, $x, $y + 105, 'C', 'freeserif', '', 30, fullname($USER));
certificate_print_text($pdf, $x, $y + 155, 'C', 'freeserif', '', 20, get_string('statement', 'certificate'));
certificate_print_text($pdf, $x, $y + 205, 'C', 'freeserif', '', 20, $course->fullname);
certificate_print_text($pdf, $x, $y + 255, 'C', 'freeserif', '', 14, certificate_get_date($certificate, $certrecord, $course));
certificate_print_text($pdf, $x, $y + 283, 'C', 'freeserif', '', 10, certificate_get_grade($certificate, $course));
certificate_print_text($pdf, $x, $y + 311, 'C', 'freeserif', '', 10, certificate_get_outcome($certificate, $course));
*/
$con = mysql_connect("localhost","root","shiva") or die ('unable to connect DB');
mysql_select_db('OTC', $con);
$query = "select organizer, invigilator from mdl_user where id=".$USER->id;

$result = mysql_query($query);
$row = mysql_fetch_array($result);
if(!$row || $row['organizer'] == '' || $row['invigilator'] == ''){
	echo "<center><h3>You are viewing this page because you may not filled the feedback form or your organiser may not submitted the participants details.</h3><br /><a href='/OTC'>Back</a></center>";
	exit;
}

$studentname = '<p>This is to certify that <b>'.fullname($USER).'</b> has successfully completed the '.$course->fullname.' organized at <b>'.$USER->institution.'</b> by <b>'.$row['organizer'].'</b> with course material provided by the Talk To A Teacher project at IIT Bombay.<br><br>Passing an online exam, conducted remotely from IIT Bombay, is a pre-requisite for completing this workshop. <b>'.$row['invigilator'].'</b> at <b>'.$USER->institution.'</b> invigilated this examination. This workshop is offered by the <b>Spoken Tutorial project, IIT Bombay, funded by National Mission on Education through ICT, MHRD, Govt of India.</b><br><br>'.certificate_get_date($certificate, $certrecord, $course).'</p>';

certificate_print_text($pdf, $x+70, $y + 70, 'J', 'freeserif', '', 18, $studentname);

if ($certificate->printhours) {
    certificate_print_text($pdf, $x, $y + 339, 'C', 'freeserif', '', 10, get_string('credithours', 'certificate') . ': ' . $certificate->printhours);
}
certificate_print_text($pdf, $x, $codey, 'C', 'freeserif', '', 10, certificate_get_code($certificate, $certrecord));
$i = 0;
if ($certificate->printteacher) {
    $context = get_context_instance(CONTEXT_MODULE, $cm->id);
    if ($teachers = get_users_by_capability($context, 'mod/certificate:printteacher', '', $sort = 'u.lastname ASC', '', '', '', '', false)) {
        foreach ($teachers as $teacher) {
            $i++;
            certificate_print_text($pdf, $sigx, $sigy + ($i * 12), 'L', 'freeserif', '', 12, fullname($teacher));
        }
    }
}

certificate_print_text($pdf, $custx, $custy, 'L', null, null, null, $certificate->customtext);
?>
