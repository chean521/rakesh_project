<?php require("Base/Header1_Master/session_header.php") ?>

<!DOCTYPE html >
<html>
    
    <?php require("Base/Header1_Master/header_master.php"); ?>
    
    <body style="overflow-y: auto;">
        
        <div class="wrapper">
             
          <header>
             <nav class="navbar navbar-inverse navbar-fixed-top">
                 <div class="container-fluid">
                     <div class="navbar-header">
                         <a href=""><img src="../Images/veecotech-d-retina.png" width="150" height="50"></a>
                     </div>
                     <ul class="nav navbar-nav">
                         <li><a href="#homeSection">Home</a></li>
                         <li><a href="#AboutSystemSection">About System</a></li>
                         <li><a href="#AboutUS">About us</a></li>
                         <li><a href="#ContactUS">Contact us</a></li>
                     </ul>
                     
                     <ul class="nav navbar-nav navbar-right">
                         
                         <?php
                            if($Sess_Status == NULL || $Sess_Status == 0){
                                echo LogInDisplay();
                            }
                            else{
                                echo LogOutDisplay($Sess_Admin);
                            }
                         ?>
                         
                     </ul>
                 </div>
             </nav>
          </header>
            
        </div>
        
    <div id ="homeSection" class ="sectionOne"
        <div class ="pimg1">
   
            <div class="ptext">
                <span class ="border trans">
                   INVOICE SYSTEM
                </span>
              
            </div>
            <video autoplay loop class="video-background" muted plays-inline >
                <source src ="../video/4k background footage (ideal for Blockchain Website).mp4" type="video/mp4"
            </video> 
               
        </div>
        
        
        
   
       
        <div id ="AboutSystemSection" class=" sectionTwo">
            <div class ="pimg2">
                 <div class="ptext">
                    <span class ="border trans">
                        About System 
                     </span>
                 </div> 
            </div> 
        
            <section class="section section-two">
                  <p>This invoice system is to create invoice and quotation for your customers and can able track your invoice or quotation that has been created. Moreover, you able to track overdue, receipt and other details in term fast and accurate information so system will reduce your banded and time. However, you also can track your customer details and sales, so you can able to monitor your sales without any loses. Finally, all information or data that will be safe and well protect by this system.</p>
             </section>
        
        </div>
    
        
        <div id ="AboutUS" class=" sectionThree">
             <div class ="pimg3">
                  <div class="ptext">
                     <span class ="border trans">
                         About Us
                      </span>
                  </div>
             </div> 
        
       <section class="section section-one">
             <p>Located in Penang, Malaysia, Veecotech is an experienced web design and development company with a passion for all things online! Established in 2011, we are the leading software and web design agency that provide comprehensive services ranging from web design& development, eCommerce, graphic design to online branding.
We understand the challenges that every business owner faces. That is why VeecoTech emphasizes on understanding your business objectives and to work closely with you. We take pride in our work and we look forward to create long-lasting relationships with our clients that ensure continual success.

Contact us
Our customer support provide the best service in the industry. We’re passionate about our products as well as our customers. We’re always happy to help find the best solution for your business needs.
</p>
        </section>
        
        </div>
        
        
      <div id ="ContactUS" class=" sectionFour">
             <div class ="pimg4">
                  <div class="ptext">
                     <span class ="border trans">
                         Contact Us
                      </span>
                  </div>
             </div> 
        
       <section class="section section-two">
             <p>Our customer support provide the best service in the industry. We’re passionate about our products as well as our customers. We’re always happy to help find the best solution for your business needs.
<br />
<strong>Company</strong><br />
Veecotech Web & Ecommerce Sdn. Bhd. (1281453¬M)<br />
1-1-9, Suntech @ Penang Cybercity, Lintang Mayang Pasir 3 Bayan Baru, Pulau Pinang 11950<br />
info@veecotech.com.my<br />
support@veecotech.com.my<br />
Monday-Friday: 9am – 5.30pm<br />
Saturday & Sunday: off<br />
Public Holiday: off<br />
Phone: +6 04-611 0861<br />
Sales: +6 012-900 6648
</p>
        </section>
        
        </div>
          
        
        <?php require("Base/Header1_Master/footer_master.php"); ?>
       
    </body>
</html>
