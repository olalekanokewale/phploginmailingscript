<?php
session_unset();
include_once('config/config.php');
include_once('config/function.php');

$successMessage= "";
$errorMessage = "";
$msg="";
//to login now
if(isset($_POST['login']))
{
    $emailAddress = trim($_POST['emailAddress']);
    $password = trim($_POST['password']);
    //$captcha=$_POST['g-recaptcha-response'];
    //check if the value is empty
    if (empty($emailAddress) or empty($password))
    {
        ?>
        <script>
            alert("Please enter your registered email address or password");
        </script>
        <?php
    }
    else 
    {
        $userlog = memberLogin($con, $emailAddress, $password);
        if (!$userlog) 
        {
            $msg = 'error';
            $errorMessage = 'Email Address or Password is Wrong. Try Again';
        }
        else
        {

            setcookie("emailAddress",$userlog->emailAddress,time()+3600,"/");
            setcookie("password",$userlog->password,time()+3600,"/");
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
            $_SESSION['userId'] = $userlog->userId;
            $_SESSION['emailAddress'] = $userlog->emailAddress;
            if($userlog->busCategory == 'Tailoring')
            {
                if($userlog->subscription == 'standard')
                    header("Location: tailor/standard/");
                else if($userlog->subscription == 'optimum')
                    header("Location: tailor/optimum/");
                else if($userlog->subscription == 'premium')
                    header("Location: tailor/premium/");
                else if($userlog->subscription == 'basic')
                    header("Location: tailor/basic/");
            }
             
               
        }
    }
    /*
    if(!$userlog)
    {
        ?>
            <script>
                alert("Email Address or Password is Wrong. Try Again");
                window.location = "index";
            </script>
        <?php
    }
    else
    {
        setcookie("emailAddress", $userlog->emailAddress, time() + 3600, "/");
        setcookie("password", $userlog->password, time() + 3600, "/");
        //store value in session
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (15 * 60);
        $_SESSION['userId'] = $userlog->userId;
        $_SESSION['emailAddress'] = $userlog->emailAddress;
        header("Location: ../member/index");
    }*/
}
?>

<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head><base href="">
    <title>Sign In | Smart Aesthetics Hub </title>
    <meta name="description" content="Smart Aesthetics Hub is a platform that allow Professionals to trade and interact smartly with their customers." />
    <meta name="keywords" content="Contact us, Deliverables,Handmade,Homemade,Readymade,Fashionista in Nigeria,in Ibadan,
            Image Credit,Fashions,Designs,Designers,Quality,Rate,Professions,Firm,Organization,Top Notch in Ibadan, Nigeria" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
        <meta property="og:url" content="https://smartasthetics.com" />
    <meta property="og:site_name" content="Smart Aesthetics Hub" />
    <link rel="shortcut icon" href="../assets/favicon.png" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="../assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <style type="text/css">
        .message
        {
            color: #396;
            font-weight: bold;
            font-size:17px;
            width: 100%;
            padding: 5px;
            text-align: center;
        }
        .error
        {
            color: #FF0000;
            font-weight: bold;
            font-size:17px;
            width: 100%;
            padding: 5px;
            text-align: center;
        }

    </style>
    <script src="jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
                $("#success-alert").alert('close');
                window.location='index';
            }); 
            $("#error-alert").fadeTo(3000, 500).slideUp(500, function(){
                $("#error-alert").alert('close');
            });     
        });
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="d-flex flex-column flex-column-fluid bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(../assets/bkg.jpg);background-size:cover;">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(../assets/media/illustrations/sketchy-1/14-dark.png)">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Logo-->
            <a href="index" class="mb-12">
                <img alt="Logo" src="../assets/mainlogo.png" />
            </a>
            <!--end::Logo-->
            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <!--begin::Form-->
                <form method="post" enctype="multipart/form-data" action="#">
                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">Sign In to Your Account</h1>
                        <!--end::Title-->
                        <!--begin::Link-->
                        <div class="text-gray-400 fw-bold fs-4">
                            <a href="../index.php#pricing" class="link-primary fw-bolder">Create Accounts</a>
                        </div>
                        <!--end::Link-->
                    </div>
                    <!--begin::Heading-->
                    <div class="row fv-row mb-1">
                            <?php  if( isset($msg) and $msg == 'success') 
                                        { ?>
                                            <div class="alert alert-success" id="success-alert">
                                                <strong><?php echo $successMessage; ?></strong>
                                            </div>
                                            <?php  } 
                                            if (isset($msg) and $msg == 'error') { ?>
                                                <div class="alert alert-error" id="error-alert">
                                                <strong><?php echo $errorMessage; ?></strong>
                                                </div>
                                            <?php  } ?>
                    </div>
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fs-6 fw-bolder text-dark">Registered Email Address</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-lg form-control-solid" type="email" name="emailAddress" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$" autocomplete="off" required="required" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-2">
                            <!--begin::Label-->
                            <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                            <!--end::Label-->
                            <!--begin::Link-->
                            <a href="resetPassword" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Input-->
                        <input class="form-control form-control-lg form-control-solid" required="required" type="password" name="password" autocomplete="off" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center">
                        <!--begin::Submit button-->
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5" name="login">
                            <span class="indicator-label">Continue</span>
                        </button>
                        <!--end::Submit button-->
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<script src="../assets/plugins/global/plugins.bundle.js"></script>
<script src="../assets/js/scripts.bundle.js"></script>
<script src="../assets/js/custom/authentication/sign-in/general.js"></script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
