<?php
    if(isset($_POST['submit']))
    {
        //The form has been submitted, prep a nice thank you message
        $output = '<h1>Sent your message successfully!</h1>';
        //Set the form flag to no display (cheap way!)
        $flags = 'style="display:none;"';

        //Deal with the email
        $to = strip_tags($_POST['to']);
        $subject = strip_tags($_POST['subject']);

        $message = strip_tags($_POST['message']);
        $attachment = chunk_split(base64_encode(file_get_contents($_FILES['file']['tmp_name'])));
        $filename = $_FILES['file']['name'];

        $boundary =md5(date('r', time())); 

        $headers = "From:shaheer@github.com\r\nReply-To: shaheer@github.com";
        $headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"_1_$boundary\"";

        $message="This is a multi-part message in MIME format.

--_1_$boundary
Content-Type: multipart/alternative; boundary=\"_2_$boundary\"

--_2_$boundary
Content-Type: text/plain; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

$message

--_2_$boundary--
--_1_$boundary
Content-Type: application/octet-stream; name=\"$filename\" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

$attachment
--_1_$boundary--";

        mail($to, $subject, $message, $headers);
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>MailFile</title>
</head>

<body>
<style>
body {background-color: powderblue;}
h2   {color: blue;}
</style>
<?php error_reporting(0); echo $output; ?>
<h2>&emsp;&emsp; Mail Form by Shaheer</h2>
<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" <?php echo $flags;?>
  <br> To Mail : <input type="text" name="to" required>
   <br/>
   <br>
   Subject : <input type="text" name="subject">
   <br/>
   <br>
   
<label for="message">Message :</label> <textarea name="message" id="message" cols="20" rows="8"></textarea>
<p><label for="file">File &emsp;&ensp;:</label> <input type="file" name="file" id="file"></p>
<p><input type="submit" name="submit" id="submit" value="Send"></p>
</form>
</body>
</html>