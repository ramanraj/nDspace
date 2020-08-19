<?php

// Draw terms in Beal's Conjecture
// Ramanraj K 2020-05-09

$pf; // array to store prime factors

// function to return prime factors

function IsPrime($n){
  // list divisors
  for($x=2; $x<$n; $x++){
    if($n %$x ==0){
      $d = $n / $x;
      echo "<h3>$n is divisible by $x</h3>";
      echo "<p>$n / $x = $d</p>";
      // return 0;
    }
  }
  return 1;
}

function primeFactors($n) {
  // return primeFactors of $n
  $pf = []; 
    while($n % 2 == 0)     { 
      $pf[] = 2;
      $n = $n / 2; 
    } 
    for ($i = 3; $i <= sqrt($n);  $i = $i + 2)  { 
        while ($n % $i == 0)  { 
	    $pf[] = $i;
            $n = $n / $i; 
        } 
    } 
    if ($n > 2) {
      $pf[] = $i;
    }
    return $pf;
}

// initialise variables
if(!empty($_POST)){
  
  $box_size = $_POST['box_size'];
  $power_n = $_POST['power_n'];
  $Acolor = $_POST['Acolor'];
  $Bcolor = $_POST['Bcolor'];
  // $Ccolor = $_POST['Ccolor'];
  
  $A = $_POST['varA'];
  $B = $_POST['varB'];
  $C = $_POST['varC'];
  $x = $_POST['varx'];
  $y = $_POST['vary'];
  $z = $_POST['varz'];
  $selectExample = $_POST['selectExample'];
  
} else {
  $box_size=1;
  $power_n=2;
  $Acolor = '#f20c5f'; //red
  $Bcolor = '#f2f10c'; //green
  // $Ccolor = '#3811de'; //blue; #e8cf1f = yellow
  $A = 3;
  $B = 6;
  $C = 3;
  $x = 3;
  $y = 3;
  $z = 5;
  $changeSelection = "
<script language=\"javascript\">
    document.frmBealTerms.selectExample.options[1].selected = true;
</script>
";
}

$drawBealHeader = <<<EOT
<html>
<head>
<title>Geometry of terms in Beal's Conjecture</title>
<link rel="stylesheet" type="text/css"
href="../x3dom/x3dom.css">
</link>
<script type="text/javascript"
src="../x3dom/x3dom.js">
</script>
</head>
   <body onload=openDetails()>
   <h3>Geometry of terms in Beal's Conjecture</h3>
   <p>- Ramanraj K</p>
  <p><i>31<sup>st</sup> May, 2020</i></p>
  <h4>Beal's Conjecture states that if A<sup>x</sup> + B<sup>y</sup> = C<sup>z</sup>, where A, B, C, x, y and z are positive integers and x, y and z are all greater than 2, then A, B and C must have a common prime factor. The geometry of the terms are drawn here using x3d.</h4>
<p>The equation in the Conjecture is derived directly from the identity A<sup>x</sup> + (A-1)A<sup>x</sup> = A<sup>(x+1)</sup> where A=2, and in all other cases where A>2, may be derived directly or by repeated substitution. It may also be noted that A, B and C must have a common prime factor or a set of common prime factors, and the greatest prime factor must be common. Further, at least one of the terms A, B and C would have either 2 to 3 as a prime factor. The common prime factors are divided by their cubes to set the scale of the subcube, and the  remainder is used to render the geometry of the terms. Pythagoras, Fermat, Beal, and Galois are all on the same page here. Scroll down to view the visualization.  </p>
EOT;

$drawBealForm = <<<EOT
  <form name="frmBealTerms" id="frmBealTerms" action="draw-beal.php" method=post>
  <p>Select example:
  <select name="selectExample" size=1 onChange="showExample()" >
                <option value=0>--Select an example--</option>
		<option value=1>3^3 + 6^3 = 3^5</option>
		<option value=2>7^7 + 49^3 = 98^3</option>
		<option value=3>8^4 + 16^3 = 2^13</option>     
		<option value=4>8^5 + 32^3 = 16^4</option>
		<option value=5>9^3 + 18^3 = 9^4</option>
		<option value=6>16^5 + 32^4 = 8^7</option>
		<option value=7>17^4 + 34^4 = 17^5</option>
		<option value=8>19^4 + 38^3 = 57^3</option>
		<option value=9>27^3 + 54^3 = 3^11</option>
		<option value=10>28^3 + 84^3 = 28^4</option>
		<option value=11>34^5 + 51^4 = 85^4</option>
		<option value=12>7^3 + 7^4 = 14^3</option>  
                <option value=13>54873^3 + 2085174^3 = 54873^4</option>
                <option value=14>1001^3 + 10010^3 = 1001^4</option>
                <option value=15>2^3 + 2^3 = 2^4</option>
                <option value=16>2^4 + 2^4 = 2^5</option>
                <option value=17>2^5 + 2^5 = 2^6</option>
                <option value=18>2^6 + 2^6 = 2^7</option>
                <option value=19>2^7 + 2^7 = 2^8</option>
                <option value=20>2^8 + 2^8 = 2^9</option>
                <option value=21>2^9 + 2^9 = 2^10</option>
                <option value=99>Reset form to do fresh calculation</option>
	        </select>
		<p><b>(or)</b> Enter integer values that satisfy Beal's Conjecture and submit:
						    
EOT;
$note1 = $_SERVER['PHP_INT_MAX'];


$drawBealForm1 = "
<table border=1 id=\"btbl\">
<tr><th>A<sup>x</sup><input type=number size=20 name=\"varA\" value=\"$A\"><sup><input type=number name=\"varx\" value=\"$x\"></sup> <b>+</b>
<th>B<sup>y</sup><input type=number size=20 name=\"varB\" value=\"$B\"><sup><input type=number name=\"vary\" value=\"$y\"></sup> <b>=</b>
<th>C<sup>z</sup><input type=number size=20 name=\"varC\" value=\"$C\"><sup><input type=number name=\"varz\" value=\"$z\"></sup>

<td rowspan=2> <input name=\"submit_frm\" id=\"submit_frm\"type=\"submit\">
<tr><th>Color Term #1: <input type=\"color\" id=\"Acolor\" name=\"Acolor\" value=\"$Acolor\">
<th>Color Term #2: <input type=\"color\" id=\"Bcolor\" name=\"Bcolor\" value=\"$Bcolor\">
<th><!-- Color Term #3: <input type=\"color\" id=\"Ccolor\" name=\"Ccolor\" value=\"$Ccolor\"> -->
<!--
<tr><td><details id=detA onclick=\"toggleDetails()\">Details</details><td><details id=detB onclick=\"toggleDetails()\">Details</details><td><details id=detC onclick=\"toggleDetails()\">Details</details><td>
-->
<tr><td><details id=detA \">Details</details><td><details id=detB \">Details</details><td><details id=detC \">Details</details><td>
<script language=javascript>
detOpenState = false;
function openDetails() {
    document.getElementById(\"detA\").open = true;
    document.getElementById(\"detB\").open = true;
    document.getElementById(\"detC\").open = true;
}

function closeDetails() {
    
    document.getElementById(\"detA\").open = false;
    document.getElementById(\"detB\").open = false;
    document.getElementById(\"detC\").open = false;
}
function toggleDetails(){

    if (detOpenState == false){
        openDetails();
    } else {
        closeDetails();
    }
    detOpenState = !detOpenState;
}
</script>
</table>
<!--
<table border=1>
   <tr><th>Box size<td><input type=text size=5 name=box_size value=\"$box_size\">
   <tr><th>Exponent<td><input type=text size=5 name=power_n value=\"$power_n\">
</table>
  
   <input name=\"submit_frm\" id=\"submit_frm\"type=\"submit\">

-->
   </form>
<script language=\"javascript\">

function tryBCS1(){
	//3^3 + 6^3 = 3^5
	resetForm();
	document.frmBealTerms.varA.value = \"3\";
	document.frmBealTerms.varB.value = \"6\";
	document.frmBealTerms.varC.value = \"3\";
	document.frmBealTerms.varx.value = \"3\";
	document.frmBealTerms.vary.value = \"3\";
	document.frmBealTerms.varz.value = \"5\";
        document.frmBealTerms.selectExample.options[1].selected = true;
	doCalculation();
}
function tryBCS2(){
	//7^7 + 49^3 = 98^3                                                     
	resetForm();
	document.frmBealTerms.varA.value = \"7\";
	document.frmBealTerms.varB.value = \"49\";
	document.frmBealTerms.varC.value = \"98\";
	document.frmBealTerms.varx.value = \"7\";
	document.frmBealTerms.vary.value = \"3\";
	document.frmBealTerms.varz.value = \"3\";
        document.frmBealTerms.selectExample.options[2].selected = true;
	doCalculation();
}
function tryBCS3(){
	// 8^4 + 16^3 = 2^13                                                    
	resetForm();
	document.frmBealTerms.varA.value = \"8\";
	document.frmBealTerms.varB.value = \"16\";
	document.frmBealTerms.varC.value = \"2\";
	document.frmBealTerms.varx.value = \"4\";
	document.frmBealTerms.vary.value = \"3\";
	document.frmBealTerms.varz.value = \"13\";
        document.frmBealTerms.selectExample.options[3].selected = true;
	doCalculation();
}
 

function tryBCS4(){
	//                                               
	resetForm();
	document.frmBealTerms.varA.value = \"8\";
	document.frmBealTerms.varB.value = \"32\";
	document.frmBealTerms.varC.value = \"16\";
	document.frmBealTerms.varx.value = \"5\";
	document.frmBealTerms.vary.value = \"3\";
	document.frmBealTerms.varz.value = \"4\";
        document.frmBealTerms.selectExample.options[4].selected = true;
	doCalculation();
}
function tryBCS5(){
	//                                               
	resetForm();
	document.frmBealTerms.varA.value = \"9\";
	document.frmBealTerms.varB.value = \"18\";
	document.frmBealTerms.varC.value = \"9\";
	document.frmBealTerms.varx.value = \"3\";
	document.frmBealTerms.vary.value = \"3\";
	document.frmBealTerms.varz.value = \"4\";
        document.frmBealTerms.selectExample.options[5].selected = true;
	doCalculation();
}
function tryBCS6(){
	//                                               
	resetForm();
	document.frmBealTerms.varA.value = \"16\";
	document.frmBealTerms.varB.value = \"32\";
	document.frmBealTerms.varC.value = \"8\";
	document.frmBealTerms.varx.value = \"5\";
	document.frmBealTerms.vary.value = \"4\";
	document.frmBealTerms.varz.value = \"7\";
        document.frmBealTerms.selectExample.options[6].selected = true;
	doCalculation();
}
function tryBCS7(){
	//                                               
	resetForm();
	document.frmBealTerms.varA.value = \"17\";
	document.frmBealTerms.varB.value = \"34\";
	document.frmBealTerms.varC.value = \"17\";
	document.frmBealTerms.varx.value = \"4\";
	document.frmBealTerms.vary.value = \"4\";
	document.frmBealTerms.varz.value = \"5\";
        document.frmBealTerms.selectExample.options[7].selected = true;
	doCalculation();
}
function tryBCS8(){
	//                                               
	resetForm();
	document.frmBealTerms.varA.value = \"19\";
	document.frmBealTerms.varB.value = \"38\";
	document.frmBealTerms.varC.value = \"57\";
	document.frmBealTerms.varx.value = \"4\";
	document.frmBealTerms.vary.value = \"3\";
	document.frmBealTerms.varz.value = \"3\";
        document.frmBealTerms.selectExample.options[8].selected = true;
	doCalculation();
}function tryBCS9(){
	//                                               
	resetForm();
	document.frmBealTerms.varA.value = \"27\";
	document.frmBealTerms.varB.value = \"54\";
	document.frmBealTerms.varC.value = \"3\";
	document.frmBealTerms.varx.value = \"3\";
	document.frmBealTerms.vary.value = \"3\";
	document.frmBealTerms.varz.value = \"11\";
        document.frmBealTerms.selectExample.options[9].selected = true;
	doCalculation();
}
function tryBCS10(){
	//                                               
	resetForm();
	document.frmBealTerms.varA.value = \"28\";
	document.frmBealTerms.varB.value = \"84\";
	document.frmBealTerms.varC.value = \"28\";
	document.frmBealTerms.varx.value = \"3\";
	document.frmBealTerms.vary.value = \"3\";
	document.frmBealTerms.varz.value = \"4\";
        document.frmBealTerms.selectExample.options[10].selected = true;
	doCalculation();
}
function tryBCS11(){
	//                                               
	resetForm();
	document.frmBealTerms.varA.value = \"34\";
	document.frmBealTerms.varB.value = \"51\";
	document.frmBealTerms.varC.value = \"85\";
	document.frmBealTerms.varx.value = \"5\";
	document.frmBealTerms.vary.value = \"4\";
	document.frmBealTerms.varz.value = \"4\";
        document.frmBealTerms.selectExample.options[11].selected = true;
	doCalculation();
}
function tryBCS12(){
	//                                               
	resetForm();
	document.frmBealTerms.varA.value = \"7\";
	document.frmBealTerms.varB.value = \"7\";
	document.frmBealTerms.varC.value = \"14\";
	document.frmBealTerms.varx.value = \"3\";
	document.frmBealTerms.vary.value = \"4\";
	document.frmBealTerms.varz.value = \"3\";
        document.frmBealTerms.selectExample.options[12].selected = true;
	doCalculation();
}

function tryBCS13(){
	//54873^3 + 2085174^3 = 54873^4                                                
	resetForm();
	document.frmBealTerms.varA.value = \"54873\";
	document.frmBealTerms.varB.value = \"2085174\";
	document.frmBealTerms.varC.value = \"54873\";
	document.frmBealTerms.varx.value = \"3\";
	document.frmBealTerms.vary.value = \"3\";
	document.frmBealTerms.varz.value = \"4\";
        document.frmBealTerms.selectExample.options[13].selected = true;
	doCalculation();
}

function tryBCS14(){
	//1001^3 + 10010^3 = 1001^4                                             
	resetForm();
	document.frmBealTerms.varA.value = \"1001\";
	document.frmBealTerms.varB.value = \"10010\";
	document.frmBealTerms.varC.value = \"1001\";
	document.frmBealTerms.varx.value = \"3\";
	document.frmBealTerms.vary.value = \"3\";
	document.frmBealTerms.varz.value = \"4\";
        document.frmBealTerms.selectExample.options[14].selected = true;
	doCalculation();
}

function tryBCS15(){
	//2^3 + 2^3 = 2^4                                           
	resetForm();
	document.frmBealTerms.varA.value = \"2\";
	document.frmBealTerms.varB.value = \"2\";
	document.frmBealTerms.varC.value = \"2\";
	document.frmBealTerms.varx.value = \"3\";
	document.frmBealTerms.vary.value = \"3\";
	document.frmBealTerms.varz.value = \"4\";
        document.frmBealTerms.selectExample.options[15].selected = true;
	doCalculation();
}

function tryBCS16(){
	//2^4 + 2^4 = 2^5                                         
	resetForm();
	document.frmBealTerms.varA.value = \"2\";
	document.frmBealTerms.varB.value = \"2\";
	document.frmBealTerms.varC.value = \"2\";
	document.frmBealTerms.varx.value = \"4\";
	document.frmBealTerms.vary.value = \"4\";
	document.frmBealTerms.varz.value = \"5\";
        document.frmBealTerms.selectExample.options[16].selected = true;
	doCalculation();
}function tryBCS17(){
	//2^5 + 2^5 = 2^6                                        
	resetForm();
	document.frmBealTerms.varA.value = \"2\";
	document.frmBealTerms.varB.value = \"2\";
	document.frmBealTerms.varC.value = \"2\";
	document.frmBealTerms.varx.value = \"5\";
	document.frmBealTerms.vary.value = \"5\";
	document.frmBealTerms.varz.value = \"6\";
        document.frmBealTerms.selectExample.options[17].selected = true;
	doCalculation();
}function tryBCS18(){
	//2^6 + 2^6 = 2^7                                          
	resetForm();
	document.frmBealTerms.varA.value = \"2\";
	document.frmBealTerms.varB.value = \"2\";
	document.frmBealTerms.varC.value = \"2\";
	document.frmBealTerms.varx.value = \"6\";
	document.frmBealTerms.vary.value = \"6\";
	document.frmBealTerms.varz.value = \"7\";
        document.frmBealTerms.selectExample.options[18].selected = true;
	doCalculation();
}function tryBCS19(){
	//2^7 + 2^7 = 2^8                                         
	resetForm();
	document.frmBealTerms.varA.value = \"2\";
	document.frmBealTerms.varB.value = \"2\";
	document.frmBealTerms.varC.value = \"2\";
	document.frmBealTerms.varx.value = \"7\";
	document.frmBealTerms.vary.value = \"7\";
	document.frmBealTerms.varz.value = \"8\";
        document.frmBealTerms.selectExample.options[19].selected = true;
	doCalculation();
}function tryBCS20(){
	//2^8 + 2^8 = 2^9                                        
	resetForm();
	document.frmBealTerms.varA.value = \"2\";
	document.frmBealTerms.varB.value = \"2\";
	document.frmBealTerms.varC.value = \"2\";
	document.frmBealTerms.varx.value = \"8\";
	document.frmBealTerms.vary.value = \"8\";
	document.frmBealTerms.varz.value = \"9\";
        document.frmBealTerms.selectExample.options[20].selected = true;
	doCalculation();
}function tryBCS21(){
	//2^9 + 2^9 = 2^10                                 
	resetForm();
	document.frmBealTerms.varA.value = \"2\";
	document.frmBealTerms.varB.value = \"2\";
	document.frmBealTerms.varC.value = \"2\";
	document.frmBealTerms.varx.value = \"9\";
	document.frmBealTerms.vary.value = \"9\";
	document.frmBealTerms.varz.value = \"10\";
        document.frmBealTerms.selectExample.options[21].selected = true;
	doCalculation();
}


function resetForm(){
    //reset form
    document.frmBealTerms.varA.value = \"\";
    document.frmBealTerms.varB.value = \"\";
    document.frmBealTerms.varC.value = \"\";
    document.frmBealTerms.varx.value = \"\";
    document.frmBealTerms.vary.value = \"\";
    document.frmBealTerms.varz.value = \"\";
}

function doCalculation(){
    document.getElementById('submit_frm').click();
}

function showExample(){
    // SAMPLE CASES FOR STUDY
    i = document.frmBealTerms.selectExample.selectedIndex;
    msg = document.frmBealTerms.selectExample.options[i].value;
    if (msg==0) resetForm();
    if (msg==1) tryBCS1();
    if (msg==2) tryBCS2();
    if (msg==3) tryBCS3();
    if (msg==4) tryBCS4();
    if (msg==5) tryBCS5();
    if (msg==6) tryBCS6();
    if (msg==7) tryBCS7();
    if (msg==8) tryBCS8();
    if (msg==9) tryBCS9();
    if (msg==10) tryBCS10();
    if (msg==11) tryBCS11();
    if (msg==12) tryBCS12();
    if (msg==13) tryBCS13();
    if (msg==14) tryBCS14();
    if (msg==15) tryBCS15();
    if (msg==16) tryBCS16();
    if (msg==17) tryBCS17();
    if (msg==18) tryBCS18();
    if (msg==19) tryBCS19();
    if (msg==20) tryBCS20();
    if (msg==21) tryBCS21();
    if (msg==99) resetForm();
}
</script>
  ";
echo $drawBealHeader;
echo $drawBealForm;
echo $drawBealForm1;
$devmsg[] = $note1;
if (empty($_POST)){  
  echo $changeSelection;
}
/*
$devmsg[] = "<p>PHP_INT_SIZE:";
$devmsg[] = var_dump(
  PHP_INT_SIZE
);
$devmsg[] = "<p>PHP_INT_MAX:";
$devmsg[] = var_dump(
PHP_INT_MAX
	 );
*/
/*
PHP_INT_MAX
FactorInteger[9223372036854775807]
{{7, 2}, {73, 1}, {127, 1}, {337, 1}, {92737, 1}, {649657, 1}}
2.09715199999999999992420877485225598017100764442631593... × 10^6
= 2097151
Therefore, 54873^3 + 2085174^3 = 54873^4 
Factors of 54873^4 = 3^8 * 7^4 * 13^4 * 67^4

 */
$changeSelection = "
<script language=\"javascript\">
    document.frmBealTerms.selectExample.options[$selectExample].selected = true;
</script>
";
echo $changeSelection;

$box_size=1;
$power_n=2;
$favcolor = '#51a131';
$savecolor = '';

$t1 = pow($A,$x);
$t2 = pow($B,$y);
$t3 = pow($C,$z);


if (!is_int($t3)){
  echo "$C<sup>$z</sup> = $t3, and beyond scope of this script";
  exit;
}

// preliminary geometry
$cedgeA = pow($t1, (1/3));
$cedgeB = pow($t2, (1/3));
$cedgeC = pow($t3, (1/3));
//$detA[] = $cedgeA;
//$detB[] = $cedgeB;
//$detC[] = $cedgeC;

$rndA = round($cedgeA);
$rndB = round($cedgeB);
$rndC = round($cedgeC);

$modA = pow($rndA, 3);
$modB = pow($rndB, 3);
$modC = pow($rndC, 3);

//$detA[] = $modA;
//$detB[] = $modB;
//$detC[] = $modC;
if ($modA == $t1){
    $detA[] = "<h3>Cube</h3>";
} else {
    $detA[] = "<h3>Cuboid</h3>";
}
if ($modB == $t2){
    $detB[] = "<h3>Cube</h3>";
}else {
    $detB[] = "<h3>Cuboid</h3>";
}
if ($modC == $t3){
    $detC[] = "<h3>Cube</h3>";
}else {
    $detC[] = "<h3>Cuboid</h3>";
}

//echo "<p>$A<sup>$x</sup> = $t1</p>";
//echo "<p>$B<sup>$y</sup> = $t2</p>";
//echo "<p>$C<sup>$z</sup> = $t3</p>";
$detA[] = "<p>$A<sup>$x</sup> = $t1</p>";
$detB[] = "<p>$B<sup>$y</sup> = $t2</p>";
$detC[] = "<p>$C<sup>$z</sup> = $t3</p>";

$lhs = $t1 + $t2;
if ($lhs == $t3){
  // integers satisfy beal's conjecture
  echo "<h3>$A<sup>$x</sup> + $B<sup>$y</sup> = $C<sup>$z</sup> = $t1 + $t2 = $t3 </h3>";
} else {
  echo "<p>$A<sup>$x</sup> + $B<sup>$y</sup> = $lhs";
  echo "<p>$A<sup>$x</sup> + $B<sup>$y</sup> &#8800 $C<sup>$z</sup>";
  echo "<p>Try with valid integers that satisfy Beal's Conjecture</p>";
  exit;
}
// factorize terms
$Apf = primeFactors($t1);
$Bpf = primeFactors($t2);
$Cpf = primeFactors($t3);

$ApfC = array_count_values($Apf);
$BpfC = array_count_values($Bpf);
$CpfC = array_count_values($Cpf);

$txt = "<p>Prime factors of $t1: ";
foreach($Apf as $n){
  $txt .= "$n  ";
}
$txt .= " = ";
foreach($ApfC as $k => $n){
  $txt .= "$k<sup>$n</sup> ";
}
$detA[] = $txt;

$txt =  "<p>Prime factors of $t2: ";
foreach($Bpf as $n){
  $txt .= "$n  ";
}
$txt .= " = ";
foreach($BpfC as $k => $n){
  $txt .= "$k<sup>$n</sup> ";
}
$detB[] = $txt;

$txt = "<p>Prime factors of $t3: ";
foreach($Cpf as $n){
  $txt .= "$n  ";
}
$txt .= " = ";
foreach($CpfC as $k => $n){
  $txt .= "$k<sup>$n</sup> ";
}
$detC[] = $txt;
// $commonpf = array_intersect($Apf, $Bpf, $Cpf);
// array intersect

foreach ($ApfC as $k => $n){
  unset($exp);
  $exp['A'] = $n;
  $com = true;
  if (array_key_exists($k, $BpfC)){
      $exp['B'] = $BpfC[$k];
  } else {
      $exp['B'] = 0;
      $com = false;
  }
  if (array_key_exists($k, $CpfC)){
    $exp['C'] = $CpfC[$k];
  } else {
    $exp['C'] = 0;
    $com = false;
  }
  // $devmsg[] = var_dump($exp);
  if ($com == true){
   $mint = min($exp);
   $devmsg[] = "<h3>mint : $mint</h3>";
   $commonpfcount[$k] = $mint;
   for ($i=0; $i < $mint; $i++){
     $commonpf[] = $k;
   }
  }
}



$cntpfC['A'] = count($ApfC);
$cntpfC['B'] = count($BpfC);
$cntpfC['C'] = count($CpfC);

$maxprimes = max($cntpfC);
$minprimes = min($cntpfC);

$devmsg[] = "<h3>max primes := $maxprimes</h3>";
// $devmsg[] = var_dump($cntpfC);
$maxkey = array_search($maxprimes, $cntpfC);
$minkey = array_search($minprimes, $cntpfC);

$devmsg[] = "<p>maxkey : $maxkey";
$devmsg[] = "<p>minkey : $minkey";

// array intersect

$txt = "<p>Common Prime factors of $t1, $t2, $t3: ";
foreach($commonpf as $n){
  $txt .=  "$n  ";
}
$devmsg[] = $txt;
echo "$txt";
// bug in php :: if 7^7 in Apf, and 7^6 in Bpf and 7^6 in Cpf
// array_intersect($Apf, $Bpf, $Cpf) returns 7^7; fixed by changing
// order in function to array_intersect($Cpf, $Apf, $Bpf);

// $commonpfcount = array_count_values($commonpf);

$devmsg[] = " = commonpfcount k->n ; base->power = ";
$commonbaseproduct = 1;
$txt = "<p>Common prime factors: ";

foreach($commonpfcount as $k => $n){
  $txt1 .= "$k<sup>$n</sup> ";

  $commonbaseproduct = $commonbaseproduct * $k;
}
$devmsg[] = $txt . $txt1;
echo "= $txt1";

$devmsg[] = "<p>commonbaseproduct = $commonbaseproduct";
$txt = "<p>commonbaseproduct = $commonbaseproduct";
$devmsg[] = $txt;
$greatestcf = max($commonpf);
$txt = "<p>Greatest Common Prime factor of $t1, $t2, $t3: $greatestcf";
$commsg[] = $txt;
echo "$txt";
// $cpf = product of common prime factors of $t1, $t2 and $t3
$cpf = 1;
$commsg[] = "<p>Common prime factors: ";

foreach($commonpfcount as $k => $n){
  $commsg[] = "<p>$k<sup>$n</sup> ";
  $txt .= "$k<sup>$n</sup> ";
  $cpf = $cpf * ($k ** $n);
  
}
$commsg[] = $txt;

$devmsg[] = "<p>cpf [product of common prime factors]::= $cpf";
$cpf_cuberoot = pow($cpf, (1.0/3.0));
$devmsg[] = "<p>cpf_cuberoot (cuberoot of $cpf) =: $cpf_cuberoot";


$t1bycpf = $t1 / $cpf;
$t2bycpf = $t2 / $cpf;
$t3bycpf = $t3 / $cpf;

$devmsg[] = "<p>t1bycpf : t2bycpf : t3bycpf :: $t1bycpf : $t2bycpf : $t3bycpf";

// analyze product of common prime factors
if (($t1 == $cpf) && ($t2 == $cpf)){
  $devmsg[] = "<h3>product of common prime $cpf = $t1 =  $A<sup>$x</sup> = $t2 =  $B<sup>$y</sup>  </h3>";
  $cpfequal = 3;
} else {
  if ($t1 == $cpf){
    $devmsg[] = "<h3>product of common prime $cpf = $t1 =  $A<sup>$x</sup></h3>";
    $cpfequal = 1;
  } elseif ($t2 == $cpf){
    $devmsg[] = "<h3>product of common prime $cpf = $t2 =  $B<sup>$y</sup></h3>";
    $cpfequal = 2;
  } else {
    $devmsg[] = "<h3>product of common prime $cpf is unique !!! </h3>";
    $cpfequal = 0;
  }
}

// check if greatest common prime factor divides A, B and C without reminder

$Amodgcf = $A % $greatestcf;
$Bmodgcf = $B % $greatestcf;
$Cmodgcf = $C % $greatestcf;

$Adivgcf = intdiv($A, $greatestcf);
$Bdivgcf = intdiv($B, $greatestcf);
$Cdivgcf = intdiv($C, $greatestcf);



if (($Amodgcf == 0) && ($Bmodgcf == 0) && ($Cmodgcf == 0)){
  $Tmodgcf = 0;
  $devmsg[] = "<h3>Terms $A, $B, $C mod greatest common factor $greatestcf = $Tmodgcf = zero</h3>";
  $devmsg[] = "<h3>Terms $A/$greatestcf = $Adivgcf, $B/$greatestcf = $Bdivgcf, $C/$greatestcf = $Cdivgcf</h3>";
} else {
  $Tmodgcf = $Amodgcf + $Bmodgcf + $Cmodgcf ;
  $devmsg[] = "<h3>Terms $A, $B, $C mod greatest common factor $greatestcf = $Tmodgcf</h3>";
}

// root of cpf
// Array comdiv stores common primes base with power before division
// Array edgeA, edgeB and edge C store prime factors after division by 3 as newdiv and newmod
// If not a common prime factor, stored as base and power
$txt = "<p>Divide exponents by 3: edge = unique; edgecf = common";
$devmsg[] = $txt;
$tscale = 1;
$tx = 1;
$ty = 1;
$tz = 1;

foreach($ApfC as $tbase => $tpower){  
  $devmsg[] = "<p>tbase : tpower :: $tbase : $tpower";
  if (array_key_exists($tbase, $commonpfcount)){
    $tmod = $tpower % 3;
    $tintdiv = intdiv($tpower, 3);
    $edgecfA[$tbase]['newdiv'] = $tintdiv;
    $edgecfA[$tbase]['newmod'] = $tmod;
    $comdiv['A'][$tbase] = $tpower;
    $devmsg[] = "edgecfA[$tbase] tintdiv:tmod :: $tintdiv : $tmod";
    $tscale = $tscale * ($tbase ** $tintdiv);
    if ($tmod == 0){
      
    } elseif ($tmod == 1){
      $tx = $tx * $tbase;
    } elseif ($tmod == 2){ 
      $tx = $tx * $tbase;
      $ty = $ty * $tbase;
    }
    $devmsg[] = "<p>tscale:tx:ty:tz :: $tscale : $tx:$ty:$tz";
  } else {
    $edgeA[$tbase] = $tpower;
    $devmsg[] = "edgeA[$tbase]: $tpower";   
    $tx = $tx * ($tbase ** $tpower);
    
    $devmsg[] = "<p>tscale:tx:ty:tz :: $tscale : $tx:$ty:$tz";
  }
}
$tp = $tx * $ty * $tz;
if ($tp == 8){
  // cube root = 2
  $cuboidA['x'] = 2;
  $cuboidA['y'] = 2;
  $cuboidA['z'] = 2;
} elseif ($tp == 27){
  // cube root = 3
  $cuboidA['x'] = 3;
  $cuboidA['y'] = 3;
  $cuboidA['z'] = 3;
} else {
  $cuboidA['x'] = $tx;
  $cuboidA['y'] = $ty;
  $cuboidA['z'] = $tz;
  if (($tx > 27) || ($ty > 27) || ($tz > 27)){
  echo "<H3>Geometry may not be rendered correctly as length, width or height too large - supplement with imagination!</H3>";
  }
}


$devmsg[] = "<H3>array edgeA</H3>";
// $devmsg[] = var_dump($edgeA);
$devmsg[] = "<H3>array edgecfA</H3>";
// $devmsg[] = var_dump($edgecfA);

$tx = 1;
$ty = 1;
$tz = 1;

foreach($BpfC as $tbase => $tpower){  
  $devmsg[] = "<p>tbase : tpower :: $tbase : $tpower";
  if (array_key_exists($tbase, $commonpfcount)){
    $tmod = $tpower % 3;
    $tintdiv = intdiv($tpower, 3);
    $edgecfB[$tbase]['newdiv'] = $tintdiv;
    $edgecfB[$tbase]['newmod'] = $tmod;
    $comdiv['B'][$tbase] = $tpower;
    if ($tmod == 0){
    } elseif ($tmod == 1){
      $tx = $tx * $tbase;
    } elseif ($tmod == 2){ 
      $tx = $tx * $tbase;
      $ty = $ty * $tbase;
    }
    $devmsg[] = "<p>tscale:tx:ty:tz :: $tscale : $tx:$ty:$tz";
  } else {
    $edgeB[$tbase] = $tpower;
    $devmsg[] = "edgeB[$tbase]: $tpower";
    $tx = $tx * ($tbase ** $tpower);
    
    $devmsg[] = "<p>tscale:tx:ty:tz :: $tscale : $tx:$ty:$tz";
  }
}
$tp = $tx * $ty * $tz;
if ($tp == 8){
  // square root = 2
  $cuboidB['x'] = 2;
  $cuboidB['y'] = 2;
  $cuboidB['z'] = 2;
} elseif ($tp == 27){
  $cuboidB['x'] = 3;
  $cuboidB['y'] = 3;
  $cuboidB['z'] = 3;
} else {
  $cuboidB['x'] = $tx;
  $cuboidB['y'] = $ty;
  $cuboidB['z'] = $tz;
}

$devmsg[] = "<H3>array edgeB</H3>";
// $devmsg[] = var_dump($edgeB);
$devmsg[] = "<H3>array edgecfB</H3>";
// $devmsg[] = var_dump($edgecfB);
$tx = 1;
$ty = 1;
$tz = 1;
foreach($CpfC as $tbase => $tpower){  
  $devmsg[] = "<p>tbase : tpower :: $tbase : $tpower";
  if (array_key_exists($tbase, $commonpfcount)){
    $tmod = $tpower % 3;
    $tintdiv = intdiv($tpower, 3);
    $edgecfC[$tbase]['newdiv'] = $tintdiv;
    $edgecfC[$tbase]['newmod'] = $tmod;    
    $comdiv['C'][$tbase] = $tpower;
     if ($tmod == 0){
       if(($tbase == 2) && ($tintdiv > 1)){
	 $tx = 2;
	 $ty = 2;
	 $tz = 2;
       }
    } elseif ($tmod == 1){
      $tx = $tx * $tbase;
    } elseif ($tmod == 2){ 
      $tx = $tx * $tbase;
      $ty = $ty * $tbase;
    }
     $devmsg[] = "<p>tscale:tx:ty:tz :: $tscale : $tx:$ty:$tz";
     $devmsg[] = "edgecfC[$tbase] tintdiv:tmod :: $tintdiv : $tmod";
  } else {
    $edgeC[$tbase] = $tpower;
    $devmsg[] = "edgeC[$tbase]: $tpower";
    $tx = $tx * ($tbase ** $tpower);
    $devmsg[] = "<p>tscale:tx:ty:tz :: $tscale : $tx:$ty:$tz";
  }
}

$tp = $tx * $ty * $tz;
if ($tp == 8){
  // cube root = 2
  $cuboidC['x'] = 2;
  $cuboidC['y'] = 2;
  $cuboidC['z'] = 2;
} elseif ($tp == 27){
  // cube root = 3
  $cuboidC['x'] = 3;
  $cuboidC['y'] = 3;
  $cuboidC['z'] = 3;
} else {
  $cuboidC['x'] = $tx;
  $cuboidC['y'] = $ty;
  $cuboidC['z'] = $tz;
}

$cuboidA['scale'] = $tscale;
$cuboidB['scale'] = $tscale;
$cuboidC['scale'] = $tscale;

// verification
$testA = $cuboidA['x'] * $cuboidA['y'] * $cuboidA['z'] * ($tscale ** 3);
$cuboidA['volume'] = $testA;
if ($testA != $t1){
  $devmsg[] = "<h1>T1 volume does not match</h1>";
}
$testB = $cuboidB['x'] * $cuboidB['y'] * $cuboidB['z'] * ($tscale ** 3);
$cuboidB['volume'] = $testB;
if ($testB != $t2){
  $devmsg[] =  "<h1>T2 volume does not match</h1>";
}
$testC = $cuboidC['x'] * $cuboidC['y'] * $cuboidC['z'] * ($tscale ** 3);
$cuboidC['volume'] = $testC;
if ($testC != $t3){
  $devmsg[] =  "<h1>T3 volume does not match</h1>";
}

if ($testA > $testB){

    $minx = $cuboidB['x'];
    $miny = $cuboidB['y'];
    $minz = $cuboidB['z'];
    $minC = $Bcolor;
    $maxC = $Acolor;

} else {
    $minx = $cuboidA['x'];
    $miny = $cuboidA['y'];
    $minz = $cuboidA['z'];
    $minC = $Acolor;
    $maxC = $Bcolor;
}

$devmsg[] =  "<H3>array edgeC</H3>";
// $devmsg[] =  var_dump($edgeC);
$devmsg[] =  "<H3>array edgecfC</H3>";
// $devmsg[] =  var_dump($edgecfC);
$devmsg[] =  "<h3>array comdiv</h3>";
// $devmsg[] =  var_dump($comdiv);
foreach($comdiv as $k => $v){
  $devmsg[] = "<h4>Array comdiv key k :: $k</h4>";
  foreach($v as $kk => $vv){    
  $devmsg[] = "<p>kk : vv :: $kk : $vv";
  }
}
// draw terms
//// create functions and variables to draw
$x3d_tag_start = "<x3d id='b2p4' showlog=true>";

$x3d_scene = <<<EOT
  <scene>
  <!-- Draw cartesian co-ordinates -->
  <!-- Draw horizontal x-axis -->
  <!-- <OrthoViewpoint bind='false' centerOfRotation='0,0,0' description='""' fieldOfView='[-1,-1,1,1]' isActive='false' metadata='X3DMetadataObject' orientation='0,0,0,1' position='1,1,1' zFar='5000' zNear='0' ></OrthoViewpoint> -->
  
  
  
  <Viewpoint position="-7.97715 4.27205 6.77581" orientation="-0.58956 -0.80245 0.09220 0.81747" 
  zNear="4.22542" zFar="22.65220" centerOfRotation="1.56744 4.05338 -2.80484" fieldOfView="1.00000" description=""></Viewpoint>
  <!-- old values of edited params -->
  <!--
  width="1200px" height="1000px"
  <transform translation="1.5 1.525 -1.5">
  <transform translation="4.5 1.525 -1.5">
  <transform translation="7.5 1.525 -1.5">
  -->
EOT;

$x3d_tag_end = "
  </scene>
   </x3d>
";

function x3d_cubes($x, $y, $z, $term, $box_size, $minx=1, $miny=1, $minz=1, $minC='', $maxC=''){
  if (!empty($_POST)){
  $Acolor = $_POST['Acolor'];
  $Bcolor = $_POST['Bcolor'];
  $Ccolor = $_POST['Ccolor'];
  } else {
      $Acolor = '#f20c5f'; //red
  $Bcolor = '#f2f10c'; //green
  }
  switch ($term){
  case 'A':
    $favcolor=$Acolor;
    break;
  case 'B':
    $favcolor=$Bcolor;
    break;
  case 'C':
    $favcolor=$Ccolor;
    break;
  }

  if ($x > 27){
    $x = 27;
  }
  if ($y > 27){
    $y = 27;
  }
  if ($z > 27){
    $z = 27;
  }
  $savecolor = $favcolor;
  
  // $box_size = 1;
  $i=0;
  $j=0;
  $k=0;
  // draw cubes
  
	for ($k; $k < $x; $k++){
	  $j=0;
	  for ($j; $j < $y; $j++){
	    $i=0;   
	    for ($i; $i < $z; $i++){
	      if ($term == 'C'){
		if (($i < $minz) && ($j < $miny) && ($k < $minx)){
                  $favcolor = $minC; //'#51a131';
		} else {
                  $favcolor = $maxC; //$savecolor;
		}
	      }
	      $trans_i = $i * $box_size;
	      $trans_j = $j * $box_size;
	      $trans_k = $k * $box_size;
	      
	      // draw subcube 
	      $t = "
            <transform translation=\"$trans_i $trans_j $trans_k\">
             <shape>
              <appearance>
               <!-- <material  diffuseColor=\"$favcolor\"  transparency='0.5'></material> -->
	       <material  diffuseColor=\"$favcolor\"  transparency='0.25'></material>
              </appearance>
              <box size=\"$box_size $box_size $box_size\"></box>
              </shape>
            </transform>";
	      $ret = $ret . $t;

	      // draw subcube number
	      $counter = $counter + 1;
	      $trans_iv = ($i * $box_size) - 0.5;
	      $trans_jv = ($j * $box_size) - 0.5;
	      $trans_kv = ($k * $box_size) - 0.5;
	      
	      $txt =  "
              <transform translation=\"$trans_i $trans_j $trans_k\">
               <shape>	  
	        <appearance>
                 <material ambientIntensity='1' diffuseColor='black' shininess='1' specularColor='grey'></material>
	        </appearance>
	        <text string='$counter' solid='true'>
                <fontstyle family='arial' size='0.4'></fontstyle>
	        </text>
               </shape>
              </transform>";
	      $ret = $ret . $txt;

	      // draw subcube coordinate
	      /*
	      $trans_iv = ($i * $box_size) - 0.5;
	      $trans_jv = ($j * $box_size) + 0.1 ;
	      $trans_kv = ($k * $box_size) - 0.5;
	      $txt =  "
              <transform translation=\"$trans_iv $trans_jv $trans_kv\">
               <shape>	  
	        <appearance>
                 <material ambientIntensity='1' diffuseColor='black' shininess='1' specularColor='grey'></material>
	        </appearance>
	        <text string='($k,$j,$i)' solid='true'>
                <fontstyle family='arial' size='0.2'></fontstyle>
	        </text>
               </shape>
              </transform>";
	      $ret = $ret . $txt;
              */
	      // draw scale
	      
	      $scale_i = $trans_i - (1 * $box_size);
	      $scale_j = $trans_j - (1 * $box_size);
	      $scale_k = $trans_k - (1 * $box_size);
	      $scale_factor = 0.2;
	      
	      if (($i == 0) && ($j==0) ){
		// x axis
		$pscale_i = $trans_i -  (1 * $box_size);
		$pscale_j = $trans_j -  (1 * $box_size);
		$pscale_k = $trans_k ;
		 $t = "
            <transform translation=\"$pscale_i $pscale_j $pscale_k\" >
             <shape>
              <appearance>
	       <material  diffuseColor=\"blue\"  transparency='0.25'></material>
              </appearance>
              <box size=\"$scale_factor $scale_factor $box_size\"></box>
              <!-- <cylinder radius=\"0.1\" height=\"$cylen\"></cylinder> -->
              </shape>
            </transform>";
	      $ret = $ret . $t;

	      // draw cone at tip of axis
	      if ($k == ($x -1)){
		$conepos = $pscale_k + ($box_size/2) + 0.1;
	       $t = "
            <transform  rotation='1,1,1,2' translation=\"$pscale_i $pscale_j $conepos\">
             <shape>
              <appearance>
	       <material  diffuseColor=\"blue\"  transparency='0.25'></material>
              </appearance>
<Cone bottom='true' bottomRadius='$scale_factor' ccw='true' height='$scale_factor' lit='true' side='true' solid='true' subdivision='32' top='true' topRadius='0' ></Cone>
              </shape>
            </transform>";
	      $ret = $ret . $t;
	      }
	      
	      }
	      if (($k == 0) && ($j==0)){
		// y axis
		
		$pscale_i = $trans_i;
		$pscale_j = $trans_j -  (1 * $box_size);
		$pscale_k = $trans_k -  (1 * $box_size);
		 $t = "
            <transform translation=\"$pscale_i $pscale_j $pscale_k\">
             <shape>
              <appearance>
	       <material  diffuseColor=\"red\"  transparency='0.25'></material>
              </appearance>
              <box size=\"$box_size $scale_factor $scale_factor\"></box>
              </shape>
            </transform>";
	      $ret = $ret . $t;
	       // draw cone at tip of axis
	      if ($i == ($x - 1)){
		//	$conepos = $pscale_k + ($box_size/2) + 0.1;
			$conepos = $x -($box_size/2) + 0.1 ;
	       $t = "
            <transform  rotation='1,1,1,4' translation=\"$conepos $pscale_j $pscale_k\">
             <shape>
              <appearance>
	       <material  diffuseColor=\"red\"  transparency='0.25'></material>
              </appearance>
<Cone bottom='true' bottomRadius='$scale_factor' ccw='true' height='$scale_factor' lit='true' side='true' solid='true' subdivision='32' top='true' topRadius='0' ></Cone>
              </shape>
            </transform>";
	      $ret = $ret . $t;
	      }
	      }
	      if (($i == 0) && ($k==0)){
		// z axis
		$pscale_i = $trans_i -  (1 * $box_size);
		$pscale_j = $trans_j;
		$pscale_k = $trans_k -  (1 * $box_size);
		 $t = "
            <transform translation=\"$pscale_i $pscale_j $pscale_k\">
             <shape>
              <appearance>
	       <material  diffuseColor=\"green\"  transparency='0.25'></material>
              </appearance>
              <box size=\"$scale_factor $box_size $scale_factor\"></box>
              </shape>
            </transform>";
	      $ret = $ret . $t;
	      }
	       // draw cone at tip of zaxis
	      // fix this
	      if (($j == ($y - 1)) && (($i == 0) && ($k==0))){
		//	$conepos = $pscale_k + ($box_size/2) + 0.1;
			$conepos = $j -($box_size /2) + 1.1 ;
	       $t = "
            <transform  rotation='1,1,1,6' translation=\"$pscale_i $conepos $pscale_k\">
             <shape>
              <appearance>
	       <material  diffuseColor=\"green\"  transparency='0.25'></material>
              </appearance>
<Cone bottom='true' bottomRadius='$scale_factor' ccw='true' height='$scale_factor' lit='true' side='true' solid='true' subdivision='32' top='true' topRadius='0' ></Cone>
              </shape>
            </transform>";
	      $ret = $ret . $t;
	      }
	    }
	  }
	  /*
	    $kn = $k + 1;
	    $txt =  "<transform translation=\"$trans_i $trans_j $trans_k\">
	    <shape>	  
	    <appearance>
	    <material ambientIntensity='0.1' diffuseColor='black' shininess='0.5' specularColor='grey'></material>
	    </appearance>
	    <text string='$kn' solid='false'>
	    <fontstyle family='times' size='0.4'></fontstyle>
	    </text>
	    </shape>
	    </transform>";
	    $ret = $ret . $txt;
	  */
	  
	}
	return $ret;
}




// draw cubes


// final geometry
// term A
// Arrays cuboidA, cuboidB and cuboidC store cuboid geometry details
//  total (volume), x (length), y (length), z (length), if cube or cuboid
//

$countofcommonprimes = count($commonpfcount);
// if 2 is the only common prime factor of t1, t2 and t3



function scale(array $array, $min, $max): array {
    $lowest = min($array);
    $highest = max($array);

    return array_map(function ($elem) use ($lowest, $highest, $min, $max) {
        return ($max - $min) * ($elem - $lowest) / ($highest - $lowest) + $min;
    }, $array);
}

/// 2020-05-25

// calculate x, y and z for t1, t2 and t3



// post details of terms for reference

foreach ($detA as $v){
  $detAtxt .= "<p>$v";
}
foreach ($detB as $v){
  $detBtxt .= "<p>$v"; 
}
foreach ($detC as $v){
  $detCtxt .= "<p>$v";
}
/*
  <!--var tbl=document.getElementById('btbl');

      var tr=document.createElement('tr');
      tr.innerHTML ='<td>cell1</td><td>cell2</td><td>$txtt3</td>';
      tbl.appendChild(tr); -->
*/
$updateDetails = "
<script language=\"javascript\">
    document.getElementById(\"detA\").innerHTML = \"$detAtxt\";
    document.getElementById(\"detB\").innerHTML = \"$detBtxt\";
    document.getElementById(\"detC\").innerHTML = \"$detCtxt\";



  
</script>
";

echo $updateDetails;
$devmsg[] = "<p>Cuboid A";
//$devmsg[] = var_dump($cuboidA);
$devmsg[] = "<p>Cuboid B";
//$devmsg[] = var_dump($cuboidB);
$devmsg[] = "<p>Cuboid C";
//$devmsg[] = var_dump($cuboidC);

// exit for now


$ax = $cuboidA['x'];
$ay = $cuboidA['y'];
$az = $cuboidA['z'];
echo "<h3>TERM #1: $A<sup>$x</sup> = $t1 <br>SCALE 1:{$cuboidA['scale']} Length: $ax Width: $az Height: $ay</h3>";
$x3d_tag_start =  "<x3d id='term1'>";
echo $x3d_tag_start;
echo $x3d_scene;


$x3d_cube_tags = x3d_cubes($ax, $ay, $az, "A", 1);
echo $x3d_cube_tags;
echo $x3d_tag_end;



$bx = $cuboidB['x'];
$by = $cuboidB['y'];
$bz = $cuboidB['z'];
echo "<h3>TERM #2: $B<sup>$y</sup> = $t2 <br>SCALE 1:{$cuboidB['scale']} Length: $bx Width: $bz Height: $by</h3>";
$x3d_tag_start =  "<x3d id='term2'>";
echo $x3d_tag_start;
echo $x3d_scene;
$x3d_cube_tags = x3d_cubes($bx, $by, $bz, "B", 1);
echo $x3d_cube_tags;
echo $x3d_tag_end;

$cx = $cuboidC['x'];
$cy = $cuboidC['y'];
$cz = $cuboidC['z'];
echo "<h3>TERM #3: $C<sup>$z</sup> = $t3 <br>SCALE 1:{$cuboidC['scale']} Length: $cx Width: $cz Height: $cy</h3>";
$x3d_tag_start =  "<x3d id='term3'>";
echo $x3d_tag_start;
echo $x3d_scene;

$x3d_cube_tags = x3d_cubes($cx, $cy, $cz, "C", 1, $minx, $miny, $minz, $minC, $maxC);
echo $x3d_cube_tags;
echo $x3d_tag_end;

$fitall = "
<script language=\"javascript\">
      document.getElementById('term1').runtime.fitAll();
      document.getElementById('term2').runtime.fitAll();
      document.getElementById('term3').runtime.fitAll();
</script>
";
echo $fitall;
echo "<p>Note: If the length, width or height is too large, it may not be rendered correctly.</p>";
echo "<hr>";
?>
