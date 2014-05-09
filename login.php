    <?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
    // if page requested by submitting login form
    // then we keep the same login flow
    if( isset($_REQUEST["login"]) && isset($_REQUEST["password"]) ){
    $user_exist = get_user_by_login_and_password($_REQUEST["login"], $_REQUEST["password"]);
     
    // if user exist on database
    if( $user_exist ){
    // then create a session for the user whithin your application
    // and redirect him back to the profile or dashboard page or something :)
    $_SESSION["user_connected"] = true;
    redirect_to("http://www.example.com/user/home");
    }
    }
     
    // else, if login page request by clicking a provider button
    elseif( isset($_REQUEST["provider"]) ){
    // the selected provider
    $provider_name = $_REQUEST["provider"];
     
    try{
    // initialize Hybrid_Auth with a given file
    $hybridauth = new Hybrid_Auth( $config );
     
    // try to authenticate with the selected provider
    $adapter = $hybridauth->authenticate( $provider_name );
     
    // then grab the user profile
    $user_profile = $adapter->getUserProfile();
    }
    catch( Exception $e ){
    echo "Error: please try again!";
    echo "Original error message: " . $e->getMessage();
    }
     
    # and that's it!
    # beyond that, its up to you sign-in the user if he already exist on your database
    # or sign-up the user if not.
    # the following pseudocode is provided only as an example:
     
    $user_exist = get_user_by_provider_and_id($provider_name, $user_profile->identifier);
     
    // if user exist on database, then same as before
    if( $user_exist ){
    $_SESSION["user_connected"] = true;
    redirect_to("http://www.example.com/user/home");
    }
     
    // if not, create a new one on database
    else{
    create_new_hybridauth_user(
    $provider_name,
    $user_profile->identifier,
    $user_profile->email,
    $user_profile->firstName,
    $user_profile->lastName,
    generate_password()
    );
     
    // flag user as connected whithin your application and redirect him to home page
    $_SESSION["user_connected"] = true;
    redirect_to("http://www.example.com/user/home");
    }
    } 