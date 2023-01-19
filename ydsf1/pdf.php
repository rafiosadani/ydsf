<?php
    require_once 'vendor/autoload.php';
    
    $html = '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>PDF</title>
        <style>
            .table{
                font-size: 0.5em;
            }
            table, th, td {
                border: 0.3px solid black;
            }
        </style>
    </head>
    
    <body>
        <div style="background-image: url(';$html .="'img/ydsf.jpeg'";$html .= ');
        background-repeat: no-repeat;background-size: cover;height: 1280px;">
            <div style="font-size: 0.8em;padding-top: 20%;padding-left: 10%">
                <p>Yth Bpk/Ibu
                terhormat Sunan</p>
                <p>Kenjeran no 28</p>
                <p>Surabaya</p>
            </div>
            <div style="padding-right: 7%;margin-top: 19.5%;">
            <table  cellspacing="0" cellpadding="4" align="right" width = "330px">
                <tr>
                    <th class="table">No Reff</th>
                    <th class="table">Tanggal</th>
                    <th class="table">Program</th>
                    <th class="table">Jumlah</th>
                </tr>
                <tr>
                    <td class="table">5630393</td>
                    <td class="table">02-01-2018</td>
                    <td class="table">Kerjasama Pesantren Anak Sholeh Gontor</td>
                    <td class="table">Rp. 50.000,00</td>
                </tr>
                <tr>
                    <td class="table">5630393</td>
                    <td class="table">02-01-2018</td>
                    <td class="table">Rumah Cinta Yatim</td>
                    <td class="table">Rp. 50.000,00</td>
                </tr>
                <tr>
                    <td class="table" colspan="4" border="none">Total : Rp. 750.000,00</td>
                </tr>
            </table>
        </div>
        </div>
    </body>
    
    </html>';
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    return $mpdf->Output('doc.pdf', 'S');
?>