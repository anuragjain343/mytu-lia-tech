<?php
        $frontend_assets =  base_url().'frontend_asset/';
?> 
<section id="no-post" class="sec-pad">
  <div class="container">
    <div class="row mrgn-btm">
      <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
        <div class="row mrgn-btm">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="no-post-text">
            <div class="post-img">
              <img src="<?php echo $frontend_assets ?>img/m1.png" alt="Image" />
            </div><!--/post-img-->
            <div class="currently">
              <p>Currently You have no media</p>
            </div><!--/currently-->
            <div class="no-post-para">
              <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo</p>
            </div><!--/no-post-para-->    
              <div class="ad-post-btn">
               <a href="#" data-toggle="modal" data-target="#exampleModal7"><button type="button" class="m-btn add-btn no-pst-btn ">Add-media</button></a>
              </div><!--/ad-post-btn-->            
          </div><!--/no-post-text-->
        </div>
      </div>
      </div>      
    </div>
      
  </div>
</section>

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
               <a onclick="sendMadia()" href="#"><button type="button" class="btn btn-primary m-btn">Done</button></a>
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

<input type="hidden" id="imageCount" value="1" >
<input accept="image/*" class="inputfile hideDiv" id="file-1" name="album_images[]"  style="display: none;" type="file" multiple>

<button style="display: none;" id="cickPop" data-toggle="modal" data-target="#exampleModal8" ></button>
  

<script type="text/javascript">


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
        document.getElementById("pImg").setAttribute("for", "file-"+forfor);
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

    $("#file-1").change(function() {
    readURL(this);
    });





  function removeImage(id){
    $('#'+id).remove();
  
    var imgs = $('img.img-fluid'),
        imageArr = [];

        imgs.each(function () {
        imageArr.push($(this).attr('src'));

       
            //alert(reader);
            //alert(timeId);
    

        }); 
         //alert(imageArr);
        //$("#file-1").val(imageArr);
        //document.getElementById('pImg'+i).src = window.URL.createObjectURL(img[i]);
  }


   
   
   function sendMadia(){



       $('#errorTit,#errorDes,#errorImg').html('');

       var formData = new FormData(); // Currently empty
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
      
      var imgs = $('img.img-fluid'),
        imageArr = [];

        imgs.each(function () {
        imageArr.push($(this).attr('src'));

        }); 
       var file_data1 =  imageArr;
       if (file_data1){
         imageSelect = 1;
       }

        //alert(imageArr.length);

      for (i = 0; i < imageArr.length; ++i) {
        var obj = {key :imageArr};
        //alert(obj["key"][i]);
           formData.append("album_images[]", obj["key"][i]);
        }
  
        //alert(formData);
       /*var file_data2 = $('#file-2')[0].files[0];
       if (file_data2){
         formData.append("album_images[]", file_data2);
         imageSelect = 1;
       }
       var file_data3 = $('#file-3')[0].files[0];
       if (file_data3){
         formData.append("album_images[]", file_data3);
         imageSelect = 1;
       }
       var file_data4 = $('#file-4')[0].files[0];
       if (file_data4){
         formData.append("album_images[]", file_data4);
         imageSelect = 1;
       }*/
      
       formData.append('album_title', titleText);
       formData.append('album_description', descriptionText);

       //alert(formData);

       if(imageSelect == 1){
           if(writeText == 1){

            if(file_data1.length > 4){
          $('#errorImg').html('Select max 4 image');
       }else{
            $(".add_media").invisible();
            var img_type = fileValidation(); 
            if(img_type){ 
               show_loader(); 
               var url = base_url + "home/Vendorpost/addAlbum";
                      $.ajax({
                       url: url,
                       type: "POST",
                       data:formData,              
                       cache: false,   
                        processData: false,
                           contentType: false,  
                       success: function(data){ 
                          hide_loader(); 
                        
                          data = JSON.parse(data);
                          console.log(data);
                            if (data.status == 1){ 
                                $('#exampleModal7').click();
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
                                $('#exampleModal7').click();
                                $(".add_media").visible();
                                toastr.error(data.message);
                                //$('#edit_profile')[0].reset();
                        }

                       }
                   });
               }
             }
        }
       }else{
            $(".add_media").visible();
            $('#errorImg').html('Please select image');
       }
     
   
   }


       function fileValidation(){
       
    var fileInput = document.getElementById('file-1');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    if(!allowedExtensions.exec(filePath)){
        toastr.error('Please select png,jpg and jpeg image formats.');
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



