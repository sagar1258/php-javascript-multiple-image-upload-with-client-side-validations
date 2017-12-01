<!DOCTYPE html>
<html lang="en">
<head>
  <title>Multi Image upload Demo</title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.6/sweetalert2.all.js"></script>
 <style type="text/css">
 .upload-pic {
 border              : 2px solid #dddfe2;/*border-radius: 4px;*/
 height              : 120px;width: 120px;}
 .backclass{
 background-color    : black;
 }
 .loc_add_pht {
 margin              : 5px !important;
 }
 .add_pht {
 background-repeat   : no-repeat;
 background-position : top 15px center;
 background-size     : 50px;
 border              : 1px solid #ccc;
 color               : #ccc;
 margin              : 0px;
 padding             : 0;
 text-align          : center;
 cursor              : pointer;
 float               : left;
 height              : 120px;
 width               : 120px;
 }
 .photo_view1 { 
 overflow            : hidden;
 cursor              : pointer;
 float               : left;
 margin              : 4px;
 }
 .overlay1 { 
 background          : rgba(0, 0, 0, 0.75);
 bottom              : 0;
 left                : 0;
 opacity             : 0;
 padding             : 0;
 position            : absolute;
 right               : 0;
 text-align          : center;
 top                 : 0;
 transition          : opacity 0.25s ease 0s;
 }
 .photo_view1: hover .overlay1 {
 opacity             : 0.5;
 }
 .plus1 {
 font-family         : Helvetica;
 font-weight         : 900;
 color               : rgba(255,255,255,.85);
 font-size           : 65px;
 }
 .overlay2 { 
 background          : rgba(0, 0, 0, 0.75);
 bottom              : 0;
 left                : 0;
 opacity             : 0;
 padding             : 0;
 position            : absolute;
 right               : 0;
 text-align          : center;
 top                 : 0;
 transition          : opacity 0.25s ease 0s;
 }
 .photo_view2: hover .overlay2 {
 opacity             : 0.5
 }
 .photo_view2{
 margin              : 5px;
 float               : left;
}
 .plus2 {
 font-family         : Helvetica;
 font-weight         : 900;
 color               : rgb(68, 45, 85);
 font-size           : 14px;
 background-color    : #ccc;
 width               : 30px;
 height              : 30px;cursor: pointer;
 display             : block;
 border-radius       : 50%;
 line-height         : 30px;
 margin-left         : 5px;
 margin-top          : 5px;
 }
</style>
</head>
<body>
 <div class="container">
   <form class="form-horizontal" id="fileform" action="action_page.php" method="post" enctype="multipart/form-data" onsubmit="remove_image_code()">
     <div class="col-sm-12 col-md-12 col-lg-12"> 
       <div class="lab_img" id="lab_1">
         <div class="col-sm-12 col-lg-12 col-lg-12" style="float:right;"> 
           <span>
             <a href="javascript:void(0);" id='remove_project' class="remove_project" style="display:none;" >
               <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;"></span>
             </a>
           </span>
         </div>
         <div class="" id="add_lab_div">
           <div class="add_pht upload-pic loc_add_pht" id="div_blank" onclick="return add_image(this)" style="height: 120px;width: 120px; float: left;"> 
             <img src="plus.png" alt="plus-image" style="width:100%;height:100%;" /></div>
             <div class="show_photos" id="show_photos" style="width: auto; display: initial;float: none;">
             </div>
             <div id="div_hidden_photo_list" class="div_hidden_photo_list">
               <input type="file" name="business_images[]" id="business_images" class="business_images" style="display:none" />
             </div>
           </div>
         </div>
       </div>
       <div class="form-group"> 
         <div class="col-sm-offset-1 col-sm-10">
           <button type="submit" class="btn btn-primary">Submit</button>
         </div>
       </div>
     </form>
   </div>
   <script type="text/javascript">
 var total_images = 2;//change count with how many you want to upload..
 var count = 0;
 function add_image(ref) { 
   
   if(count >= total_images){
     swal('Only '+total_images+' files are allowed to upload');
     return false; 
   }
   var image_id = $(ref).closest('.lab_img').attr('id');
   var length = $('.lab_img').length;
   var view_photo_cnt = jQuery('#'+image_id).find('.photo_view').length
   
   jQuery('#'+image_id).last().find( ".div_hidden_photo_list" ).last().find( "input[name='business_images[]']:last" ).click();
   jQuery('#'+image_id).last().find( ".div_hidden_photo_list" ).last().find( "input[name='business_images[]']:last" ).change(function() {
     var files    = this.files;
     var prjct_id = image_id.split('_');
     jQuery('#'+image_id).find('#image'+prjct_id[1]+'_'+(view_photo_cnt+1)).attr('value',files[0]['name']);
     var img, reader;
     var image_ext = files[0]['name'].split('.').pop();

     if(image_ext=="jpg" || image_ext=="png" || image_ext=="gif" || image_ext=="jpeg" || image_ext=="JPG" || image_ext=="PNG" || image_ext=="JPEG" || image_ext=="GIF"){
       file = files[0];
       img  = document.createElement("img");
       img  = new Image();

       img.onload = function() {

         if(this.width > 4000 && this.height > 4000 ) {
           swal('Please select image of 800 x 800 pixels or below');
           $("#"+image_id).find(".show_photos").find(".photo_view2").last().remove();
           $("#"+image_id).find(".div_hidden_photo_list").find("#business_images").last().remove();
           jQuery('#'+image_id).find('#image'+prjct_id[1]+'_'+(view_photo_cnt+1)).val('');
           return false;
         }
       }
     } else {
       swal('Only jpg, png, gif, jpeg type images are allowed');
       jQuery('#'+image_id).last().find( ".div_hidden_photo_list" ).last().find( "input[name='business_images[]']:last" ).unbind('change');
       jQuery('#'+image_id).last().find( ".div_hidden_photo_list" ).last().find( "input[name='business_images[]']:last" ).val('');
   count = count-1;

       return false;
     }
     reader        = new FileReader();
     reader.onload = (function (theImg) {

       return function (evt) {

         tag_src    = evt.target.result;
         theImg.src = evt.target.result;
         var html   = "<div class='photo_view2' onclick='remove_image(this);' style='width:120px;height:120px;position:relative;display: inline-block;'><img src="+ tag_src +" class='add_pht' id='add_pht upload-pic' style='float: left; padding: 0px ! important; margin:0' width='120' height='120'><div class='overlay2'><span class='plus2'>X</span></div></div>";
         jQuery('#'+image_id).last().find('.show_photos').append(html);
         jQuery('#'+image_id).last().find('.div_hidden_photo_list').append('<input type="file" name="business_images[]" id="business_images" class="business_images" style="display:none" />');
         $('#file_name_lab').val('');
       };
     }(img));
     reader.readAsDataURL(file);
   }); 
   count = count+1;
 } 

 function remove_image(elm) {
  console.log(elm);
   var this_index = jQuery(elm).index();
   count          = count - 1;
   jQuery('.lab_img').find(".div_hidden_photo_list").find("input").eq(this_index).remove();
   jQuery(elm).remove();
 }

 function remove_image_code(){
   $( ".div_hidden_photo_list" ).last().find( "input[name='business_images[]']:last" ).remove();
 }

</script>
