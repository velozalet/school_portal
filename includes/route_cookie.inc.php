<?	// Cookie User	
if($visit_counter==0): echo "Welcome first time, Guest!";  
else: 				   echo "You coming to us: $visit_counter times  <br>"; 
					   echo "Your last visit: $last_visit"; 
endif;