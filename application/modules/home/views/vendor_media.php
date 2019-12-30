<?php
   $frontend_assets =  base_url().'frontend_asset/';
   ?>
<!--vendor view media page-->
<section id="view-media" class="sectn-pad">
   <div class="container">
      <!--add media btn-->
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <a href="#">
               <div class="btn-add-pst">
                  <button class="btn-1 icon-plus" data-toggle="modal" data-target="#exampleModal7"><span>Add Media</span></button>
               </div>
            </a>
            <!--/btn-add-pst-->
         </div>
      </div>
      <!--first row-->
      <div id="albumList" class="row">
      </div>
   </div>
</section>
<!--/view-media-->
<!-- Modal -->
<div class="modal fade" id="exampleModal8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   
</div>
<!--/edit delete end-->
<!--edit btn pop -->

<!-- Add media modal start -->
<div class="modal fade" id="exampleModal7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog frgt-pswd" role="document">
      <div class="modal-content">
         <div class="modal-header bg-img">
            <div class="frgt-head">
               Add Media
            </div>
            <!--/frgt-head-->
         </div>
         <div class="modal-body modal-frgt-body">
            <div class="container">
               <!--add media sectn-->
               <div class="media-img-sectn">
                  <div id="apndDiv"  >
                  </div>
                  <!--/mdi-img-upld-->
                  <div id="imgBtm" class="medi-upld-sec">
                     <div class="add-mdia-icn">
                        <div class="text-center upload_pic_in_album"> 
                           <label id="imageFoc" for="file-1" class="upload_pic">
                           <span class="fa fa-upload"></span></label>
                        </div>
                     </div>
                  </div>
               </div>
               <!--/media-img-sectn-->
               <p id="errorImg" style="color:red;" ></p>
               <!--/add media sectn-->
               <!--/view preview-->
               <!--end of add media-->
               <div class="form-group">
                  <label class="label-deco">Title</label>
                  <input maxlength="50" id="titleText" class="form-control add-post-frm" name="phn" placeholder="" type="text">
                  <p id="errorTit" style="color:red;" ></p>
               </div>
               <div class="form-group">
                  <label class="label-deco">Description</label>
                  <textarea maxlength="200" id="descriptionText" class="form-control add-post-frm bordr-media" name="phn" placeholder="" type="text"></textarea>
                  <p id="errorDes" style="color:red;" ></p>
               </div>
            </div>
         </div>
         <!--/modal-frgt-body-->
         <div class="container">
            <div class="modal-footer brdr-top">
               <a onclick="sendMadia()" href="javascript:void(0)"><button type="button" class="btn btn-primary m-btn add_media">Done</button></a>
            </div>
         </div>
         <div class="bck-arrow-clr">
            <div class="arrow-bck close float" data-dismiss="modal" >
               <i class="bck fa fa-arrow-left"></i><span> Back</span>
            </div>
         </div>
         <!--/bck-arrow-clr-->         
      </div>
   </div>
</div>
<!--/add media modal end-->

<!-- Delete album confirmation modal start -->
<div class="modal fade" id="exampleModal9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog frgt-pswd" role="document">
      <div class="modal-content">
         <div class="modal-header bg-img">
            <div class="frgt-head">
               Delete
            </div>
            <!--/frgt-head-->
         </div>
         <div class="modal-body modal-frgt-body">
            <div class="container">
               <div class="dlte-cnfrmtn">
                  Are you sure you want to delete this media ?
               </div>
            </div>
         </div>
         <!--/modal-frgt-body-->
         <div class="container">
            <div class="modal-footer brdr-top">
               <a href="#"><button type="button" onclick="yesDelete();"class="btn btn-primary m-btn">Yes</button></a>
            </div>
         </div>
         <div class="bck-arrow-clr">
            <div class="arrow-bck close float" data-dismiss="modal" >
               <i class="bck fa fa-arrow-left"></i><span> Back</span>
            </div>
         </div>
         <!--/bck-arrow-clr-->         
      </div>
   </div>
</div>
<!--Delete album confirmation modal end-->

<!-- vendor media list ajax -->
<input type="hidden" id="imageCount" value="1" >
<input type="hidden" id="imageDel" value="" >

<input accept="image/*" class="inputfile hideDiv" id="file-1" name="album_images" style="display: none;" type="file" multiple>
<input type="hidden" id="album_id" name="album_id" value="">
<button style="display: none;" id="cickPop" data-toggle="modal" data-target="#exampleModal8" ></button>
<script type="text/javascript">
    
    /* Common messages */
    var proceed_err = 'Please fill required fields before proceeding.',
        err_unknown = 'Something went wrong. Please try again.';

    jQuery.fn.visible = function() {
        return this.css('visibility', 'visible');
    };

    jQuery.fn.invisible = function() {
        return this.css('visibility', 'hidden');
    };

   function addimagePree(img){
       var imageCount = $('#imageCount').val();
   
       $('#apndDiv').append('<div  class="mdi-img-upld mrgn-mdia"><img id="pImg'+imageCount+'" src="https://images.inuth.com/2017/05/1ranbirkapoorsexywallpaper.jpg" /></div>')
       
       var forfor = Number(imageCount)+1;
       document.getElementById("imageFoc").setAttribute("for", "file-"+forfor);
   
        document.getElementById('pImg'+imageCount).src = window.URL.createObjectURL(img);
       if($('#imageCount').val() == 4){
           document.getElementById('imgBtm').style.display = 'none';
       }else{
           $('#imageCount').val( Number($('#imageCount').val())+1);
       }
   }  

  function readURL(input) {
    if (input.files) {
    var filesAmount = input.files.length;

    for (i = 0; i < filesAmount; i++) {

    var reader = new FileReader();

    reader.onload = function(event) {

    var image = new Image(); // or document.createElement('img')
    var width, height;
    image.onload = function() {
    width = this.width;
    height = this.height;
    if((width >= 640) && (height >= 640)){
    var timeId = Date.now()*Math.floor(Math.random() * 20);
    $('#apndDiv').append('<div id="'+timeId+'" class="mdi-img-upld mrgn-mdia medi-upld-sze cross-position"> <a onclick="removeImage('+timeId+');"><span class="fa fa-times" style="cursor:pointer;" ></span></a><img id="pImg'+i+'" class="img-fluid" src="'+event.target.result+'" /></div>');
    }else{
    //swal("Oops!", 'Please upload at least 640x640 dimensions image.', "error");
    }
    };

    image.src = event.target.result;

    }

    reader.readAsDataURL(input.files[i]);
    }
    }
    }
    
    //album upload single image
    $("#file-1").change(function() {
        //readURL(this);
        show_loader();
        var _that = $(this),
            album_inp = $('#album_id'),
            formData = new FormData();
            
        formData.append('album_image', $("#file-1")[0].files[0]);
        formData.append('album_id', album_inp.val());
        
        var url = base_url + "home/Vendorpost/addAlbumImage";
        $.ajax({
            url: url,
            type: "POST",
            data:formData,              
            cache: false,   
            processData: false,
            contentType: false,
            dataType: "json",
            complete:function(){
                hide_loader(); 
            },
            success: function(data){ 
                 if (data.status == 1){
                     
                    //append image here
                    $('#apndDiv').append('<div id="" class="mdi-img-upld mrgn-mdia medi-upld-sze cross-position"> \n\
                        <a onclick="removeImage('+data.image_id+');">\n\
                            <span class="fa fa-times" style="cursor:pointer;" ></span>\n\
                        </a>\n\
                        <img id="pImg'+data.image_id+'" class="img-fluid" src="'+data.album_thumb_image+'" /></div>');
                            
                    album_inp.val(data.album_id); //upadte new album ID

                }else if(data.status == -1){
                    toastr.error(data.message);
                    window.setTimeout(function () {
                        window.location.href = data.url ;
                    }, 1000);
                } else {
                    toastr.error(data.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown){
                toastr.error(err_unknown);
            }
        });
    });
    
    //album image remove/delete
    function removeImage(id){
    
        show_loader(); 
        var formData = new FormData();
        formData.append('album_id', id); //attachment ID
        var url = base_url + "home/Vendorpost/deleteImage";
    
        $.ajax({
            url: url,
            type: "POST",
            data:formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            complete:function(){
                hide_loader(); 
            },
            success: function(data){
                
                if (data.status == 1){ 
                    $('#pImg'+id).closest('.mdi-img-upld').remove(); //image deleted successfully, remove element
                }else if(data.status == -1){
                    toastr.error(data.message);
                    window.setTimeout(function () {
                        window.location.href = data.url ;
                    }, 1000); 
                } else {
                    toastr.error(data.message);
                }
                
            },
            error: function (jqXHR, textStatus, errorThrown){
                toastr.error(err_unknown);
            }
        });
    }

    //save album  
    function sendMadia(){

        $('#errorTit,#errorDes,#errorImg').html('');

        var formData = new FormData();
        var album_inp = $('#album_id');
         //alert(formData);
        var imageSelect = 0;
        var writeText = 1;
       
        var titleText = $('#titleText').val();
        var descriptionText = $('#descriptionText').val();
   
        if($.trim(titleText) == ''){
             var writeText = 0;
             $('#errorTit').html('Please insert title');
        }
        if($.trim(descriptionText) == ''){
             var writeText = 0;
             $('#errorDes').html('Please insert descriptionText');
        }
        
        var album_id = album_inp.val();
        if(album_id == ''){
            //image is not yet uploaded
            var writeText = 0;
            $('#errorImg').html('Please select image');
        }
      
        formData.append('album_title', titleText);
        formData.append('album_description', descriptionText);
        formData.append('album_id', album_id);
        
        if(writeText == 1){

            $(".add_media").invisible();
            show_loader();
            var url = base_url + "home/Vendorpost/update_media";

            $.ajax({
                url: url,
                type: "POST",
                data:formData,     
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data){
                    hide_loader(); 
                    //console.log(data);
                    if (data.status == 1){ 
                        //$('#exampleModal7').click();
                        toastr.success(data.message);
                        window.setTimeout(function () {
                             window.location.href = data.url;
                        }, 1000);

                    }else if(data.status == -1){
                        toastr.error(data.message);
                        window.setTimeout(function () {
                            window.location.href = data.url ;
                        }, 1000); 
                    } else {
                        //$('#exampleModal7').click();
                        $(".add_media").visible();
                        toastr.error(data.message);
                        //$('#edit_profile')[0].reset();
                    }
                }
            });    
        }
    }
   
   function showPopData(a){

      $.ajax({
           url: base_url+"home/users/showAlbumData",
           type: "POST",
           data:{id: a},              
           cache: false,                          
           success: function(data){ 
               $('#cickPop').click();
               $('#exampleModal8').html(data);
           }
       });

   }
   
   function showPopDataqq(a){
    $('#abc').html('');
    $('#crntimg').val(0)
    $('#imgCount').val(0)

    $('#cickPop').click();
    var data = $('#'+a).val();

    data = JSON.parse(data); 
    for (i = 0; i < data.album_attachments.length; ++i) {
      var imgS = 'none';
      if(i == 0){
        imgS = 'nonee';
      }
      $('#abc').append('<img id="imagec'+i+'" class="hideImge" style="display:'+imgS+'" src="'+data.album_attachments[i].album_image+'" alt="Image"  />');
    }
    $('#imgCount').val(data.album_attachments.length);
    $('.pop-detail-head').html(data.album_title);
    $('.pop-detail-time').html(data.time_elapsed);
    $('.pop-detail-para').html(data.album_description);
   }

   function imageC(b){
      if(b == 2){
        $('.hideImge').hide();
        var aa = Number($('#crntimg').val())+1;
        $('#crntimg').val(aa)
        $('#imagec'+aa).show();
        
        if(aa == $('#imgCount').val()){
          $('#crntimg').val(0)
          
          $('#imagec0').show();
        }
      }else{
        $('.hideImge').hide();
        var aa = Number($('#crntimg').val())-1;
        $('#crntimg').val(aa)
        $('#imagec'+aa).show();
        if(aa == -1){
          
          var aa = Number($('#imgCount').val())-1;
          $('#crntimg').val(aa)
          $('#imagec'+aa).show();
        }
      }

   }

   function deleteMedia(id){
      $('#imageDel').val(id)
   }

  function yesDelete(){
    var url = base_url + "home/Vendorpost/deleteAlbum";
    $.ajax({
      url: url,
      type: "POST",
      data:{id:$('#imageDel').val()}, 
      dataType: "JSON",              
      cache: false, 
      success: function(data){ 
         console.log(data);
        if (data.status == 1){ 
            toastr.success(data.message);
            window.setTimeout(function () {
                 window.location.href = data.url;
            }, 2000);

        }else if(data.status == -1){
            toastr.error(data.message);
            window.setTimeout(function () {
                window.location.href = data.url ;
            }, 1000); 
        } else {
                toastr.error(data.message);
                //$('#edit_profile')[0].reset();
        }
      }
    });
  }

  $('#titleText').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
    });

  $('#descriptionText').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
    });

</script>

<input type="hidden" id="crntimg" value="0">


<!-- vendor media list ajax -->
<script type="text/javascript">
   pagination(base_url + "home/users/albumList/");
   function pagination(url){   
       $.ajax({
           url: url,
           type: "POST",
           data:{page: url},              
           cache: false,   
           beforeSend: function() {
              //show_loader(); 
           },                          
           success: function(data){ 
               $("#albumList").html(data);
           }
       });
   }

    function fileValidation(){
       
    var fileInput = document.getElementById('file-1');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    if(!allowedExtensions.exec(filePath)){
        toastr.error('Please select png,jpg and jpeg image formats.');
       // alert('Please upload file having extensions .jpeg/.jpg/.png only.');
        fileInput.value = '';
        $(".add_media").visible();
        return false;
    }else{
     
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                for (i = 0; i < fileInput.files.length; ++i) {
                    document.getElementById('pImg'+i).innerHTML = '<img src="'+e.target.result+'"/>';
                }
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
        return true;
    }
}

</script>

