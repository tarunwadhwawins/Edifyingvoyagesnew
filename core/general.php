<?php
$response = array('Success' => false, 'Message' => 'Invalid Request');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && !empty($_GET['action'])) {
    require_once('dbconnection.php');
    $request = $_POST;
    switch($_GET['action']) {
        case 'ConactFormSave':
        $sql = "INSERT INTO `contacts`(`Name`, `Email`, `Service`, `FindUs`, `Phone`, `Message`, `IP`, `URL`) VALUES ('" .mysqli_real_escape_string($conn,$request['name']) . "', '" .mysqli_real_escape_string($conn,$request['email']) . "', '". mysqli_real_escape_string($conn,$request['service'])  . "', '". mysqli_real_escape_string($conn,$request['findus'])  . "', '". mysqli_real_escape_string($conn,$request['phone'])  . "', '". mysqli_real_escape_string($conn,$request['message'])  ."', '". mysqli_real_escape_string($conn,$_SERVER['REMOTE_ADDR']) ."', '". mysqli_real_escape_string($conn,$_SERVER['HTTP_REFERER']) ."')";


        if ($conn->query($sql) === TRUE) {
            
            // Contact Information to Client
           sendEmail('tarunwadhwawins@gmail.com', "Contact Information", userInformationHtml($request));
            
            // Thank you email to User
            $message = customerEmailData($request['quotes_first_name']);
            sendEmail($request['quotes_email'], 'Thank you for Contact', $message);
            $response = array('Success' => true, 'Message' => 'Thank you for contacting Ditstek Innovations. Our team will get back to you shortly with the next steps. ');
        } else {
            $response = array('Success' => false, 'Message' => 'Error while submitting information.');
        }
        break;
    }
}

function userInformationHtml($request) {
    $html = '<p><strong>Name</strong> : '. $request['name'].'</p>';
    $html .= '<p><strong>Email</strong> : '. $request['email'].'</p>';
    $html .= '<p><strong>Service</strong> : '. $request['service'].'</p>';
    $html .= '<p><strong>Find Us</strong> : '. $request['findus'].'</p>';
    $html .= '<p><strong>Phone</strong> : '. $request['phone'].'</p>';
    $html .= '<p><strong>Message</strong>: '. $request['contact_message'].'</p>';
    
    return $html;
}


function customerEmailData($Name) {
    $email_content = '<!doctype html>
                        <html>
                        <head>
                        <meta charset="utf-8">
                        <title>Ditstek Innovations : Email Verification </title>
                        <link rel="icon" type="image/x-icon" href="images/favicon.png">
                        <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
                        </head>
                        <body style="width:100% !important; margin:0 !important; padding:0 !important; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; background-color:#FFFFFF;font-family: Lato, sans-serif;">
                        <table cellpadding="0" cellspacing="0" align="center" border="0" style="max-width:610px;width:100%;margin:auto;padding:0;background-color:#ffffff;color:#222222;overflow:hidden;border-left:1px solid #eee;border-right:1px solid #eee">
                          <tbody>
                            <tr>
                              <td><table align="center" valign="middle" cellpadding="0" cellspacing="0" border="0" style="max-width:610px;width:100%;overflow:hidden;margin:0;padding:0;background-color:#49535c;text-align:center">
                                  <tbody>
                                    <tr>
                                      <td><img style="width:100%" src="https://www.ditstek.com/emailimages/headerbg.jpg" alt="image" class="CToWUd a6T" tabindex="0">
                                        <div class="a6S" dir="ltr" style="opacity: 0.01; left: 846px; top: 119px;">
                                          <div id=":18l" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Download attachment " data-tooltip-class="a1V" data-tooltip="Download">
                                            <div class="aSK J-J5-Ji aYr"></div>
                                          </div>
                                        </div></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                            <tr style="max-width:610px;width:100%;box-sizing:border-box">
                              <td><table align="center" valign="middle" cellpadding="0" cellspacing="0" border="0" style="overflow:hidden;max-width:610px;width:100%;box-sizing:border-box;margin:0;padding:30px 15px 10px">
                                  <tbody>
                                    <tr>
                                      <td style="text-align:left"><p style="color:#575f62;font-family:Lato,sans-serif;font-size:18px;line-height:20px;margin-top:0;margin-bottom:20px;padding:0;text-align:left;"> Hi, '.$Name.' </p>
                                        <p style="color:#575f62;font-family:Lato,sans-serif;font-size:15px;line-height:19px;margin-top:0;margin-bottom:20px;padding:0;font-weight:normal;text-align:left;">Thank you for contacting Ditstek Innovations. <br>
                                          Our team will get back to you shortly with the next steps. </p>
                                        <p style="color:#575f62;font-family:Lato,sans-serif;font-size:15px;line-height:19px;margin-top:0;margin-bottom:20px;padding:0;"> Regards<br>
                                          Ditstek team </p></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                            <tr style="box-sizing:border-box;background-color:#fff;height:22px">
                              <td style="text-align:center;border-left:1px solid #eee;border-right:1px solid #eee">&nbsp;</td>
                            </tr>
                            <tr>
                              <td><table align="center" valign="center" cellpadding="0" cellspacing="0" border="0" style="max-width:610px;width:100%;overflow:hidden;background-color:#193370;padding:30px 20px 5px;box-sizing:border-box">
                                  <tbody>
                                    <tr>
                                      <td><p style="text-align:center;height:30px;overflow:hidden;margin:0"> <a href="https://www.instagram.com/ditstek_innovations/" style="text-decoration:none;display:inline-block;margin:0 5px" target="_blank"><img alt="image" border="0" src="https://www.ditstek.com/emailimages/Instagram.png" height="auto" width="28" style="outline:none;color:#ffffff;display:block;text-decoration:none;border-color:#ececec" class="CToWUd"></a> <a href="https://www.facebook.com/Ditstek" style="text-decoration:none;padding:0;display:inline-block;margin:0 5px" target="_blank"><img alt="image" border="0" src="https://www.ditstek.com/emailimages/fb.png" height="auto" width="28" style="outline:none;color:#ffffff;display:block;text-decoration:none;border-color:#ececec" class="CToWUd"></a> <a href="https://twitter.com/DitsTek" style="text-decoration:none;padding:0;display:inline-block;margin:0 5px" target="_blank"><img alt="image" border="0" src="https://www.ditstek.com/emailimages/Twitter.png" height="auto" width="28" style="outline:none;color:#ffffff;display:block;text-decoration:none;border-color:#ececec" class="CToWUd"></a> <a href="https://www.youtube.com/c/ditstek" style="text-decoration:none;padding:0;display:inline-block;margin:0 5px" target="_blank"><img alt="image" border="0" src="https://www.ditstek.com/emailimages/Youtube.png" height="auto" width="28" style="outline:none;color:#ffffff;display:block;text-decoration:none;border-color:#ececec" class="CToWUd"></a> <a href="https://www.behance.net/DitstekInnovations" style="text-decoration:none;padding:0;display:inline-block;margin:0 5px" target="_blank"><img alt="image" border="0" src="https://www.ditstek.com/emailimages/behance.png" height="auto" width="28" style="outline:none;color:#ffffff;display:block;text-decoration:none;border-color:#ececec" class="CToWUd"></a> <a href="https://www.linkedin.com/company/ditstek-innovations" style="text-decoration:none;padding:0;display:inline-block;margin:0 5px" target="_blank"><img alt="image" border="0" src="https://www.ditstek.com/emailimages/linkedin.png" height="auto" width="28" style="outline:none;color:#ffffff;display:block;text-decoration:none;border-color:#ececec" class="CToWUd"></a> </p>
                                        <p style="color:#fff;font-family:Lato,sans-serif;font-size:15px;line-height:15px;margin-top:15px;margin-bottom:0px;padding:0;font-weight:normal;text-align:center"> <a href="tel:+91-623-942-1395" style="color:#fff;text-decoration:none;font-family:Lato,sans-serif" target="_blank">+91-623-942-1395</a>, <a href="mailto:info@edifyingvoyages.com" style="color:#fff;text-decoration:none;font-family:Lato,sans-serif" target="_blank">info@edifyingvoyages.com</a> </p>
                                        <p style="color:#fff;font-family:Lato,sans-serif;font-size:15px;line-height:15px;margin-top:5px;margin-bottom:0px;padding:0;font-weight:normal;text-align:center"> <a href="https://www.ditstek.com/" style="color:#fff;text-decoration:none;font-family:Lato,sans-serif" target="_blank">www.ditstek.com </a> </p>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                            <tr>
                              <td><table align="center" valign="center" cellpadding="0" cellspacing="0" border="0" style="max-width:610px;width:100%;overflow:hidden;background-color:#193370;padding:10px;box-sizing:border-box">
                                  <tbody>
                                    <tr>
                                      <td><p style="color:#fff;font-size:13px;line-height:15px;margin:0;padding:0;font-weight:normal;text-align:center;font-family:Lato,sans-serif">SCO - 356 , First Floor, 44-D, Chandigarh, 160047</p></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                          </tbody>
                        </table>
                        </body>
                        </html>';
    return $email_content;
}

function sendEmail($to_email, $subject, $message) {
    try {
        $from_email = 'info@edifyingvoyages.com';
        $mailheader = "From: ".$from_email."\r\n"; 
        $mailheader .= "Reply-To: ".$from_email."\r\n"; 
        $mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n"; 


        mail($to_email, $subject, $message, $mailheader) or die('error'); 
    } catch(Exception $ex) {
        echo '<pre>';print_r($ex);die;
    }
}

header('Content-Type: application/json');
echo json_encode($response);die;
?>