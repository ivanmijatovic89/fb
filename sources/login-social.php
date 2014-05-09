<?php

    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1); 

    include './includes/config.php';
    $db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
    if ($db->connect_errno) {
        echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    }
    $db->set_charset("utf8");
    $resultSettings = $db->query(getSettings()); 
    $settings = $resultSettings->fetch_assoc();

  function socialLogIn_deactivated($provider_uid){
      global $db;
      $query = sprintf("SELECT * FROM `users_deactivated` WHERE `provider_uid` = '%s' ", $provider_uid);
      $result = $db->query($query);
      // proveriti dal je nalog deaktiviran ako jeste nemoj prikazivati sta ? ? ?

      return ($result->num_rows == 0) ? 0 : 1;
   }

//---------------------------------------------------------------------------------------------

        if( isset($_REQUEST["provider"]) ){
        // the selected provider
        $provider_name = $_REQUEST["provider"];

        try{
         // initialize Hybrid_Auth with a given file
            $hybridauth = new Hybrid_Auth( $config );

            // try to authenticate with the selected provider
            $adapter = $hybridauth->authenticate( $provider_name );

            // then grab the user profile
            $user_profile = $adapter->getUserProfile();
            //print_r($user_profile);die('mijat');
            echo "<pre><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
            print_r($user_profile);
            print_r($_SESSION);
            echo "</pre>";
//       $user_profile->photoURL;      
// die();

        }
        catch( Exception $e ){
            echo "Error: please try again!";
            echo "Original error message: " . $e->getMessage();
        }



//---------------------------------------------------------------------------------------------
        $query = sprintf("SELECT * FROM `users` WHERE `provider_uid` = '%s' AND `provider` = '%s'", $user_profile->identifier , $provider_name );
        $result = $db->query($query);
   
        $user_exist =  ($result->num_rows == 0) ? 0 : 1;

        $r = $result->fetch_object();


 
    // // if user exist on database, then same as before
    if( $user_exist ){

        echo 'USER POSTOJI U BAZI'; // da li treba da se uloguje !?
        $_SESSION['username'] = $r->username; // username
        $_SESSION['password'] = md5($user_profile->identifier); 

        $log = new logIn();
        $log->db = $db;
        $log->url = $CONF['url'];
        $log->username = $r->username;
        $log->provider_uid    = $user_profile->identifier;
        $log->password = md5($user_profile->identifier);

        // update user profile photo
        define('DIRECTORY', 'uploads/avatars');
        $content = file_get_contents($user_profile->photoURL);
        $image_name = md5(uniqid()).'.jpg';
        file_put_contents(DIRECTORY.'/'.$image_name, $content);

        
        
        $query = sprintf("UPDATE `users` SET `image`='$image_name'  WHERE `provider_uid` = '%s' AND `provider` = '%s'", $user_profile->identifier , $provider_name );
        $result = $db->query($query);
        
        $TMPL['loginMsg'] = notificationBox('transparent', $LNG['error'], $log->socialIn(), 1);
        
        

    }elseif(socialLogIn_deactivated($user_profile->identifier) == 1 ){
      //selektuje deaktiviranog user-a
          $query = sprintf("SELECT * FROM `users_deactivated` WHERE `provider_uid` = '%s' ", $db->real_escape_string($user_profile->identifier));
          $result = $db->query($query);
          $row = $result->fetch_assoc();
        // uzme id od user-a
          $idu = $row['idu'];
        
        // ovo je da upishe u deactivate tabelu
          $query2 = move_user($row,'users'); 
          $result2 = $db->query($query2); 

        // izbrisem user-a iz tabele deactivated_users
          $query_delete =  sprintf("DELETE FROM `users_deactivated` WHERE `idu` = '%s' ",$idu);
          $result_delete = $db->query($query_delete);
       
        // uloguj korisnika 
    
        $_SESSION['username'] = $row['username']; // username
        $_SESSION['password'] = md5($row['provider_uid']);

        $log = new logIn();
        $log->db = $db;
        $log->url = $CONF['url']; 
        $log->username = $row['username'];
        $log->provider_uid    = $user_profile->identifier;
        $log->password = md5($user_profile->identifier);

        // UPLOAD USER PROFILE PHOTO
        define('DIRECTORY', 'uploads/avatars');
        $content = file_get_contents($user_profile->photoURL);
        $image_name = md5(uniqid()).'.jpg';
        file_put_contents(DIRECTORY.'/'.$image_name, $content);
        
        $query = sprintf("UPDATE `users` SET `image`='$image_name'  WHERE `provider_uid` = '%s' AND `provider` = '%s'", $user_profile->identifier , $provider_name );
        $result = $db->query($query);
        
        $TMPL['loginMsg'] = notificationBox('transparent', $LNG['error'], $log->socialIn(), 1);
        

           

          header("Location: ".$CONF['url']."/index.php?a=feed");
    }else{
      
        echo "User ne postoji u bazi<br>";

        define('DIRECTORY', 'uploads/avatars');
        $content = file_get_contents($user_profile->photoURL);
        $image_name = md5(uniqid()).'.jpg';
        file_put_contents(DIRECTORY.'/'.$image_name, $content);

        
        if($user_profile->gender=='male'){
            $gender = 1;
        }else{
            $gender = 0;
        }
        
        //---------------------------------------------------------------------------------------------
         $query = sprintf("INSERT into `users` 
        (

            `provider_uid`,
            `provider`,
            `first_name`,
            `last_name`,
            `gender`,
            `password`,
            

            `born`,
           
            `email`,
            `date`,
            `image`,
            `privacy`,
            `cover`, 
            `verified`, 
            `online`, 
            `notificationl`, 
            `notificationc`, 
            `notifications`, 
            `notificationd`, 
            `notificationf`, 
            `email_comment`, 
            `email_like`, 
            `email_new_friend`
         ) 
         VALUES 
         (
            '%s',
            '%s', 
            '%s', 
            '%s', 
            '%s', 

            '%s',
            '%s',
            
            '%s', 
            '%s', 
            '%s', 
            '%s', 
            'default.png', 
            '%s', 
            '%s', 
            '%s', 
            '%s', 
            '%s', 
            '%s', 
            '%s', 
            '%s', 
            '%s', 
            '%s'
         );",  
 
          $user_profile->identifier,
          $provider_name ,
          $user_profile->firstName,
          $user_profile->lastName,
          $gender,
          md5($user_profile->identifier),
          strtolower($user_profile->birthYear.'-'.$user_profile->birthMonth.'-'.$user_profile->birthDay),
          //strtolower($user_profile->identifier), 
          //md5($user_profile->identifier),        
          $user_profile->email, 
          date("Y-m-d H:i:s"), 
          $image_name,
          $settings['mprivacy'], 

          1,              
          time(), 
          $settings['notificationl'], 
          $settings['notificationc'], 
          $settings['notifications'], 
          $settings['notificationd'], 
          $settings['notificationf'], 
          $settings['email_comment'], 
          $settings['email_like'], 
          $settings['email_new_friend']
          );

        $db->query($query);
        // UBACI SESSION I URADI REDIREKCIJU !!!
         $_SESSION['provider_uid'] = $user_profile->identifier;
        // posle ovaga da radi redirkciju na stranicu za upisivanje username!!!
         header("Location: ".$CONF['url']."/index.php?a=choose-username");
 
    }

   

    } 
    function PageMain(){
        echo 'page main';
    }


    
