<html>
<body>
<h3>Kaprekar's Constant 6174 for four digit numbers and
 Mega Constants 97508421 and 63317664 for eight digit numbers</h3> 
<p><i>Version 2</i></p>
<p>- Ramanraj K</p>
<p><i>25<sup>th</sup> August, 2020</i></p> 


<h4>Introduction:</h4> 


<p>Kaprekar's Constant is the four digit number 6174 that is the final result obtained when any four digit number with at least two different digits is taken, its digits rearranged in descending order and ascending order to obtain two four digit numbers, and the greater number is substracted from the lesser number, and this is repeated. Within 7 steps, the final result 6174 is obtained.<sup><a href=#ref01>1</a></sup><sup><a href=#ref02> 2</a></sup>
   <h3>Constants for eight digit numbers:</h3>
<p>6174 can be written as the sum of the first three degrees of 18:
18^3 + 18^2 + 18^1 = 5832 + 324 + 18 = 6174.

<p>It was tested to see if the pattern would repeat at the sum of the first six degrees of 18:
   
<p>18^1 + 18^2 + 18^3 + 18^4 + 18^5 + 18^6 = 36012942

   <p>When the above rules are applied to 36012942, the final result 97508421 is obtained in the following two steps:
   <pre>
96432210 - 01223469 = 95208741

98754210 - 01245789 = 97508421
   </pre>
 Apparently, 97508421 seems to be the equivalent of 6174 for 8 digit numbers.
   The final constant results  97508421 and 63317664 have earlier been given by Yutaka Nishiyama in the article titled "The Weirdness of Number 6174", though the method used to arrive at 63317664 is not apparent.<sup><a href=#ref03>3</a></sup><sup><a href=#ref04> 4</a></sup> 
   <p>Except the 8 digit numbers made from the two constants respectively and the above said root, no others appear to arrive at the final result.
   <p>It was earlier observed as follows:
   <p>"The 8 digit numbers with the digits 12457890, 76664331 and 96432210 in it including each at least once in any order, will terminate with 97508421 or  63317664 in one or two steps, and in all other cases, the 8 digit numbers appear to loop beyond 1,00,000 steps and may terminate afer a nearly infinite number of steps. This may be tested in the form given below.
   <p>This property is significant from a geometric point of view taking into view the rearrangement, reflection and subtraction repeated until a final result is obtained. The output for eight digit numbers that does not terminate in a step or two appear to go on like a beam of light.<sup><a href=#ref05>5</a></sup>"
   <p>It was not observed earlier that the results loop after a few steps, and that is the reason why the 8 digit numbers appear to loop infinitely.
   <p>This may be extremely significant as its relatable to physical properties like imaginary lines of force in magnetism. Two positive and negative forces that come in contact in this fashion would be forced to remain in that state forever and ever. The mathematics here is very straight forward and gives a very good basis for infinte attaction that defies logic.
   
   <h3>Form to trace steps of four or eight digit numbers:</h3>
<?php
if (!empty($_POST)){
 $kap = $_POST['kap'];
} else {
$kap = 1234;
}
$frm = "
<form method=post action=6174_v2.php>
<p>Enter a four digit or eight digit number and submit:
<p><input type=number name=kap value=$kap min=1 max=99999999>
<input type=submit>
</form>";
echo $frm;


$max_steps = 100000; // set loop limit - change if desired
$kaplen = strlen($kap);
$kapstart = $kap;
$kap4 = 6174;
$kap8 = 97508421;
$kap8_2 = 63317664;
$ctr = 0;
$kapar;


for ($i=0; $i <$max_steps; $i++){
  echo "<h3>$kap</h3>";
 
  if (in_array($kap, $kapar)) {
    $kapar[] = $kap;
    echo "<p>Loops at step $ctr";
    foreach($kapar as $k){
      echo "<p>$k ";
    }
    exit;
    
  }
  $kapar[] = $kap;
  $kaplen = strlen($kap);
  if ($kaplen < 4){    
    $kap = str_pad($kap, "4", "0", STR_PAD_LEFT);
  } elseif (($kaplen > 4) & ($kaplen < 8)) {
    $kap = str_pad($kap, "8", "0", STR_PAD_LEFT);
  }
  // echo "<p>pad: $kap</p><br>";
    $kar = str_split($kap);
    rsort($kar);


    foreach($kar as $k){
        $newkar .= $k;
   
    }
    $newkarrev = str_split($newkar);
    sort($newkarrev);
    foreach($newkarrev as $k){
        $karrev .= $k;
    
    }

    $kap = (int)$newkar - (int)$karrev;
    echo "<p>$newkar - $karrev = $kap";

    $newkar = '';
    $karrev = '';
    $newkarrev = '';
    unset($kar);
    unset($newkarrev);
    $ctr++;
    
    if ($ctr == 1 ){
      $plural = '';
    } else {
      $plural = 's';
    }
    if ($kap == 0){
        echo "<p>error</p>";
        break;
    }
    if ($kaplen == 4){
       if ($kap == $kap4){
          echo "<h3>Reached in $ctr step" . "$plural</h3>";
          break;
       }
    } elseif ($kaplen == 8){
       if ($kap == $kap8){
          $msg = "<h3>Reached $kap8 in $ctr step" . "$plural </h3>";
	  echo $msg;
          break; 
        } elseif ($kap == $kap8_2){
          $msg = "<h3>Reached $kap8_2 in $ctr step" . "$plural </h3>";
	  echo $msg;
          break;      
        } elseif ($kap == $kapstart){
          // if this does happen
          $msg = "<h3>Reached $kapstart in $ctr step" . "$plural </h3>";
	  echo $msg;
          break;
        }
    }

}
if ($ctr == $max_steps){
  echo "<p>Did not terminate after $max_steps steps ..</p>";
}

?>
<hr>
<h3>References:</h3>
<p>[<sup>1</sup>] <a id=ref01 href=https://en.wikipedia.org/wiki/6174_(number)>https://en.wikipedia.org/wiki/6174_(number)</a>

  <p>[<sup>2</sup>] <a id=ref02>Whatsapp forwarded message from Dr Arvind Srinivsan:</a> <details> 
<pre> Why is the number 6174, discovered by an Indian
mathematician, called the magic number?

By looking at the number you will not feel anything weird, but has
pleasantly mesmerized several learned mathematicians no ends. From the
year 1949 till now, this number has remained a puzzle for all around
the world.

Indian mathematician Dattatreya Ramchandra Kaprekar loved
experimenting with numbers. In the process of one of his experiments,
he discovered a bizarre coincidence and during a 'Mathematics
Conference' held in erstwhile Madras in the year 1949, Kaprekar
introduced this number to the world. 

However, almost all renowned mathematicians of the era mocked his
discovery. Some Indian mathematicians rejected his work and termed his
theory childish.

In time, discussions of this discovery slowly started gaining foothold
both in India and abroad. Martin Garder, America's best-selling author
with deep interest in mathematics wrote an article about him in
'Scientific America', a popular science magazine. Today, Kaprekar is
regarded a mathematical wizard and his discovery is slowly gaining
traction. Intrigued Mathematicians all over the world are engrossed in
researching this baffling reality.

To understand why this number is so magical let's look at some
interesting facts. For example, choose any number of 4 digits keeping
in mind that no digit is repeated.

Let's take 1234 for example.
Write the number in descending order: 4321
Now write in ascending order: 1234
Now subtract the smaller number from the larger number: 4321 - 1234 = 3087
Now the result again in decreasing and increasing orders.

Let's try it:
3087
Place the digits in decreasing order: 8730
Now place them in ascending order: 0378
Now subtract the smaller number from the larger number: 8730 - 0378 = 8352
Repeat the above procedures with the number found in the result.

8532 - 2358 = 6174
Let us repeat this process with 6174.

7641 - 1467 = 6174 We've reached a dead end and there is no point
repeating the process since we will get the only one result: 6174

If you think this is just a coincidence repeat this process with any
other number. Voila! Your final result will be 6174. Yahoo!

This formula is called Kaprekar's Constant.

In a computer based experiment, a gentleman called Nishiyama
discovered that the Kaprekar process reached 6174 in a maximum of
seven stages.  According to Nishiyama, 'If you do not reach 6174 even
after repeating the process seven times, then you must have made a
mistake and you should try again.

Amazing, isn't it?
</details>
  <p>[<sup>3</sup>] <a id=ref03 href=https://plus.maths.org/content/os/issue38/features/nishiyama/index>https://plus.maths.org/content/os/issue38/features/nishiyama/index</a>
<p>[<sup>4</sup>] <a id=ref04 href=https://www.researchgate.net/profile/Yutaka_Nishiyama2/publication/259604856_The_weirdness_of_number_6174/links/0c96052ce2575a69a2000000/The-weirdness-of-number-6174.pdf>https://www.researchgate.net/profile/Yutaka_Nishiyama2/publication/259604856_The_weirdness_of_number_6174/links/0c96052ce2575a69a2000000/The-weirdness-of-number-6174.pdf</a>
 <p>[<sup>5</sup>] <a id=ref05>  Assuming a ray has 8 constitutent parts, it appears as though the parts are rearranged in ascending and descending orders, subtracted, and proceed further if not stopped by the constants. The ray may reflect and proceed in this fashion. In the East, 8 is associated with preternatural powers, where 5th is prapthi and 6th is prakamya and this property is relatable to them.</a>
</html>