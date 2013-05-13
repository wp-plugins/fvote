<?php

function create_fVote($atts) {

$polly=$_POST;
//print_r($polly);

//if(is_single() || is_page()){
 
 ob_start();


    
$poll_subject=$atts[subject];
$poll_remarks=$atts[remarks];
$question=$atts[question];
$thanks=$atts[thanks];
$button=$atts[button];

$fgh=$atts[subject];
$hgf=$atts[remarks];

$vote_subject = explode("," , $poll_subject);
$vote_remarks = explode("," , $poll_remarks);
     
     if (isset($_POST['submit']))
     {
     $f=count($vote_subject);
     $j=count($vote_remarks);
     
     echo "<h4>".$thanks."</h4>";
     //echo "results of your vote:";
     $i=0;
     $ergebnis="";
     while ( list ( $key, $val ) = each ( $polly ) ){
     $ergebnis = $ergebnis. $key ."=". $val. ",";
     }
     

     	
     	global $wpdb;
        $table_name = $wpdb->prefix . "fVote";
     	
     	global $wpdb;
     	$wpdb->insert( $table_name , array('vote' => $ergebnis, 'question' => $question,  'subjects' => $fgh,  'remarks' => $hgf));
     	
     	//echo "<h4>".$ergebnis."</h4>";
     }
     else{
          $i=0;
     $f=count($vote_subject);
     
     echo "<b>".$question."</b>";
?>
<form name="fVote" action="<?php get_permalink();?>" method="POST" class="fVote-form" enctype="multipart/form-data">
<?php
     //echo "<form action=\"".get_permalink()."\" method=\"GET\">";
 	echo "<table>";
     
     while ($i<$f){
     
     echo "<tr>";
     echo "<td>".$vote_subject[$i]."&nbsp;</td>";
     //echo "<td>";
     $g=0;
     $j=count($vote_remarks);
     while ($g<$j)
     	{	
     		echo "<td><input type=\"radio\" name=\"".$vote_subject[$i]."\" value=\"".$vote_remarks[$g]."\"></td><td><label for=\"".$vote_subject[$i]."\">".$vote_remarks[$g]."</label></td>";
     		$g++;
     	}
    
    
    
    
    //echo "</td>";
    //echo "<td>".$i."";
    echo "</tr>";
    
    $i++;	
     }
  	
  	 echo "<tr><td colspan=".($g*2+1)."><center><INPUT TYPE=\"submit\" name=\"submit\" value=\"".$button."\" /></center></td></tr>";
     echo "</table>";
     echo "</form> ";   }
     
     $output_string=ob_get_contents();;
ob_end_clean();   
  return $output_string;
//}else{}
}





add_shortcode('fVote', 'create_fVote');



function fVote_results ($atts){

//if(is_single() || is_page()){ 
 ob_start();
    global $wpdb;
    
    $table_name = $wpdb->prefix . "fVote";

$question=$atts[question];
$votes=$atts[total_votes];
$answered_question = $wpdb->get_col("SELECT vote FROM ".$table_name." WHERE question='".$question."'");
$subjects = $wpdb->get_results("SELECT subjects FROM ".$table_name." WHERE question='".$question."' limit 1");
$remarks = $wpdb->get_results("SELECT remarks FROM ".$table_name." WHERE question='".$question."' limit 1");


$vote_subject = explode("," , $subjects[0]->subjects);
$vote_remarks = explode("," , $remarks[0]->remarks);
$count_remarks_numbers = array();
echo "<br /><b>".$question."</b><table>";

//print_r($count_remarks_numbers);
$j =0;
$vs = count($vote_subject);
$vr = count($vote_remarks);
$h=0;
	while($j<$vs){
	
echo "<tr";
if($j%2==0) {echo " style=\"background: lightgray\" ";}
echo "><th>".$vote_subject[$j]."</th><td>";

$sc="";
            		foreach($answered_question as $answer){
            		
            			$value_pairs = explode(',', $answer);
            			$subject = explode ("=", $value_pairs[$j]);
            			//echo "<br><br>schleife =".$h."<br>";
            			$h++;
            			$c=0;
            			
            			
            			while($c<$vr)
            			{ 
            			
            			if($vote_remarks[$c]==$subject[1]){
						//echo "<b>$vote_remarks[$c]</b> -";
						$sc=$vote_remarks[$c]." ".$sc;
						
            			}else{}
            			//$count_remarks_numbers[$j] = array($vote_subject[$j], $vote_remarks[$c]); 	
            		    $c++;  }
                           	
                    	
            		}
          
            	$j++;
            	//print_r($count_remarks_numbers);
            	$results = explode(" ", $sc);
            	
            	$ergebnis=array_count_values($results);
            	array_pop($ergebnis);
            	$max_values=count($results)-1;
            	while ( list ( $key, $val ) = each ( $ergebnis ) )
				{
				   $percentage=(int) $val / (int) $max_values *100;
				   $percentage=round($percentage, 2);
 				   echo $key . ' ' . $percentage . '% </td><td>';
				}
            	
            	echo "</td></tr>";
            	
            	}
            	echo "</table>".$votes.": ".$h."";

     $output_string=ob_get_contents();;
ob_end_clean();   
  return $output_string;
//}else{}
}


add_shortcode('fVote_results', 'fVote_results');
/*
ini_set('display_errors', 'On');
error_reporting(E_ALL);*/

?>