<?php
//this file get pdf from computer and upload to the serever using database dmsdata and creating unique directory
//updating process to 3 and changing file name from merged pdf to user given filename
        include("db_con.php");
        
        $userid=$_POST['id'];
        $groupid=$_POST['groupId'];
        
        $date=date("Y-m-d h:i:sa");
        
        
        if(isset($_FILES['theFile']))
        {   
             
         $file = $_FILES['theFile']['name'];
         $file_loc = $_FILES['theFile']['tmp_name'];
        
         //changing and creating directory
         $useriddirectory =$userid;
         $groupiddirectory=$groupid;
 
        //Check if the directory already exists.
        if(!is_dir("Merged/".$useriddirectory)){
            //Directory does not exist, so lets create it.
            mkdir("Merged/".$useriddirectory, 0755);
                   
        }
         if(!is_dir("Merged/".$useriddirectory."/".$groupiddirectory)){
                    //Directory does not exist, so lets create it.
                    mkdir("Merged/".$useriddirectory."/".$groupiddirectory, 0755);
                    echo "Maded";
                }
        
         $folder="Merged/".$useriddirectory."/".$groupiddirectory."/";
         
         
         
         /* new file size in KB */
         //$new_size = $file_size/1024;  
         /* new file size in KB */
         
         /* make file name in lower case */
         $new_file_name = strtolower($file);
         /* make file name in lower case */
         
         $final_file=str_replace(' ','-',$new_file_name);
         
                 if(move_uploaded_file($file_loc,$folder.$final_file))
                 {
                        
                        $sql="Select * from DMSdata where UserID='$userid' and GroupID='$groupid'";
                        $run=mysqli_query($con,$sql);
                        if($run)
                        {
                            if(mysqli_num_rows($run)>0)
                            {
                               
                               while($data=mysqli_fetch_assoc($run))
                               {
                               
                                 rename( "Merged/".$userid."/".$groupid."/merged.pdf", "Merged/".$userid."/".$groupid."/".$data['FileName'].".pdf");
                                 
                               }
                                $process=3;
                                $sql="UPDATE DMSdata SET Process = '$process' WHERE UserID='$userid' and GroupID='$groupid'";
                                mysqli_query($con,$sql);
                            }
                              
                        }
                        else
                        {
                            
                            echo "error occured";
                        }
                      
                  
                 }
                 else
                 {
                  
                  echo "Error.Please try again";
                                
                 }
         }
        
        $con->close(); 
?>