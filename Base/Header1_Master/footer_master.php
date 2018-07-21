<footer class="main-footer" >
<!-- To the right -->

<!-- Default to the left -->
<strong>Copyright &copy; 2018-2018 <a href="https://www.veecotech.com.my/" id="web_link"> VeecoTech Web & Ecommerce Sdn. Bhd.</a>.</strong>
All rights reserved. • Website powered by VeecoTech CMS We are the client-focused website design and online advertising company based in Prai, Penang, Ipoh, Malaysia.
</footer>

<?php include("UserManage/login_modal.php"); include("UserManage/register_modal.php"); ?> 

<script type="text/javascript">
    function ConfPassView(){
        document.getElementById('Reg_ConfPw').type = "text";
    }

    function ConfPassNorm(){
        document.getElementById('Reg_ConfPw').type = "password";
    }

    function NewPassView(){
        document.getElementById('Reg_UserPw').type = "text";
    }

    function NewPassNorm(){
        document.getElementById('Reg_UserPw').type = "password";
    }
</script>