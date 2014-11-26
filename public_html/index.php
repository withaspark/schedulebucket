<?php
$page = "home";
$title = "";



if (isset($_POST['email'])) {
   $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
   $ipadd = filter_var($_SERVER['REMOTE_ADDR'],FILTER_SANITIZE_SPECIAL_CHARS);
   if ($email) {
      $file = fopen('emails.php','a');
      fwrite($file,$email.",".time().",".$ipadd."\n");
      fclose($file);
      $show_feedback = "<script type='text/javascript'>"
         ."document.getElementById('email').value = 'Thank you!';"
         ."document.getElementById('email').style.backgroundColor = '#aed4af';"
         ."</script>";
   }
   else
      $show_feedback = "<script type='text/javascript'>document.getElementById('email').value = 'Failed...';</script>";
}




include("top.php");
?>

         <h1 style="padding-bottom: 50px;">modern project management for normal people.<span style="font-size: 18px;">&trade;</span></h1>

         <div id="billboard">
              <div class="centered">
                   <h1 style="margin: 10px auto 40px auto;">Under development!</h1>

               <form action="index.php" method="post" onsubmit="if(check_email()) return false;">
                  <p>Want to know when it's ready?</p>
                  <p><input type="text" id="email" name="email" class="text" value="Your email..." onfocus="clear_box('email','Your email...');" onblur="refill_box('email','Your email...');" /></p>
                  <p><input type="submit" class="button centered" value="Join!" /></p>
               </form>
               <?php if (isset($show_feedback)) echo $show_feedback; ?>
            </div>
         </div>

         <div id="left_col">
            <h3>Modern Project Management</h3>
            <p>Today, speed and simplicity are everything. Whether you're coordinating a startup opportunity or
               planning a wedding, you need a tool to manage and communicate your schedule instantly without
               slowing you down with complexities such as gantt charts and slack paths.
            </p>
            <p>Schedule Bucket is all about speed and simplicity. Throw your tasks into Schedule Bucket and
               we'll do the rest!
            </p>
         </div>
         
         <div id="right_col">
            <h3>Perfect for:</h3>
            <ul>
               <li>Business projects</li>
               <li>School projects</li>
               <li>Weddings</li>
               <li>Community events</li>
               <li>Social events</li>
               <li>Family reunions</li>
               <li>and much more</li>
            </ul>
         </div>
         <div class="clear"></div>

   <script type="text/javascript"><!--
   $(document).ready(function(){
      $('#billboard').cycle({ 
         fx:     'fade',
         prev:   '#prev',
         next:     '#next',
         timeout: 4000,
         pause:   1
      });
      $.preloadCssImages();
   });
   function check_email() {
      var el = document.getElementById('email')
      var text = el.value;
      if ((text.search("@") > 0) && (text.lastIndexOf(".") > (text.length - 6)) && (text.lastIndexOf(".") < (text.length - 2)) && (text.length > 8)) {
         return false;
      }
      else {
         el.style.backgroundColor = "#ffa09e";
         return true;
      }
   }
   function clear_box(element,text) {
      var el = document.getElementById(element);
      if (el.value == text)
         el.value = "";
      else if (el.value != "") {
         el.focus();
         el.select();
      }
   }
   function refill_box(element,text) {
      var el = document.getElementById(element);
      if (el.value == "")
         el.value = text;
   }
   // --></script>

<?php
include("bottom.php");
?>