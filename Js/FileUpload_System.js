
function UploadFile(Form_Name){
    var form = document.forms[Form_Name];
    
    $.ajax({
       url: '../../WBServices/LogoFileUpload_Processor.php',
       type: "POST",
       data: new FormData(form),
       contentType: false,
       cache: false,
       processData: false,
       success: function(e){
           var Res = JSON.parse(e);
           
           if(Res.Result === "true")
               alert("Image Uploaded!");
           else
               alert("Image Not Uploaded!");
           
           window.location.reload();
       },
       error: function(c){
           
       }
    });
    
    
}