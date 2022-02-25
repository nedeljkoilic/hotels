<?php
if (isset($_GET['hotel']) && isset($_GET['dateod']) && isset($_GET['datedo'])) {
$naziv_hotela = $_GET['hotel'];
$date_do = $_GET['datedo'];
$date_od = $_GET['dateod'];
}
if($_GET['hotel']=='Default select' || $_GET['dateod']=="" || $_GET['datedo']=="")
{
  echo 'Neregularan unos';
  exit();    
}
echo '
<table class="table table-dark table-striped" style="width: 100%;">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ime i prezime </th>
                    <th scope="col">datum prijave</th>
                    <th scope="col">datum odjave</th>
                    <th scope="col">Naziv hotela</th>
                    <th scope="col">tip sobe</th>
                    <th scope="col">broj soba</th>
                    <th scope="col">ukupna cijena</th>
                  </tr>
                </thead>
                <tbody>';
                  

                require_once "../../connection.php";
$sql = "SELECT r.od, r.do, k.IME, k.PREZIME, ts.vrsta_sobe, h.NAZIV, r.do-r.od as broj_dana, ts.koeficijent, h.dnevna_cijena FROM `rezervacija` r join korisnik k on k.ID_KORISNIK=r.ID_KORISNIK join hotel h on h.ID_HOTEL=r.ID_HOTEL join tip_sobe ts on ts.ID_TIP_SOBE=r.ID_TIP_SOBE where h.NAZIV = '".$naziv_hotela."' and r.od>'".$date_od."' and r.do<'".$date_do."'";
if ($result = $mysqli->query($sql)) {
    while ( $row = $result->fetch_row()) {
   $datum_prijave = $row[0];
   $datum_odjave = $row[1];
   $ime_korisnika = $row[2];
   $prezime_korisnika = $row[3];
   $vrsta_sobe = $row[4];
   $br_dana = $row[6];
   $koef = $row[7];
   $cijena = $row[8];
echo ' <tr>
<th scope="row">1</th>
<td>'.$ime_korisnika.$prezime_korisnika.'</td>
<td>'.$datum_prijave.'</td>
<td>'.$datum_odjave.'</td>
<td>'.$naziv_hotela.'</td>
<td>'.$vrsta_sobe.'</td>
<td>1</td>
<td>'.($br_dana*$cijena*$koef).'EUR</td>
</tr>';

    }
     
 }
 echo '</tbody>
 </table>';
?>