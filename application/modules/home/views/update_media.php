<!-- Update album modal start-->
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog frgt-pswd" role="document">
      <div class="modal-content">
         <div class="modal-header bg-img">
            <div class="frgt-head">
               Update Media
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
                    <div id="preData">
                         <?php $img = $album_images->album_attachments;
                            foreach ($img as $val) { ?>
                            <div id="<?php echo $val->id;?>" class="mdi-img-upld mrgn-mdia medi-upld-sze cross-position">
                              <a onclick="removeImage(<?php echo $val->id;?>);"><span class="fa fa-times" style="cursor:pointer;" ></span></a>
                              <img id="pImg<?php echo $val->id; ?>" class="images" src="<?php echo $val->album_image; ?>" />
                            </div>
                      
                         <?php  } ?>
                     </div>
                     <div id="imgBtm" class="medi-upld-sec">
                        <div class="add-mdia-icn">
                           <div class="text-center upload_pic_in_album"> 
                              <label id="imageFoc" for="update_album_file" class="upload_pic">
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
                  <input maxlength="50" id="album_title" class="form-control add-post-frm" name="album_title" placeholder="" type="text" value="<?php echo $album_images->album_title; ?>">
                  <p id="errorTit" style="color:red;" ></p>
               </div>
               <div class="form-group">
                  <label class="label-deco">Description</label>
                  <textarea maxlength="200" id="album_description" class="form-control add-post-frm bordr-media" name="album_description" placeholder="" type="text"><?php echo $album_images->album_description; ?></textarea>
                  <p id="errorDes" style="color:red;" ></p>
               </div>
            </div>
         </div>
         <!--/modal-frgt-body-->
         <div class="container">
            <div class="modal-footer brdr-top">
               <a onclick="updateAlbum()" href="javascript:void(0)"><button type="button" class="btn btn-primary m-btn">Update</button></a>
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
<!-- Update album modal end-->

<input type="hidden" id="imageCount" value="1" >
<input type="hidden" id="update_album_id" value="<?php echo $album_images->id; ?>" >
<input accept="image/*" class="inputfile hideDiv" id="update_album_file" name="album_images" style="display: none;" type="file" multiple>

<script type="text/javascript">
    
    /* Common messages */
    var proceed_err = 'Please fill required fields before proceeding.',
        err_unknown = 'Something went wrong. Please try again.';

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
    $("#update_album_file").change(function() {
        //readURL(this);
        show_loader();
        var _that = $(this),
            album_inp = $('#update_album_id'),
            formData = new FormData();
            //console.log(album_inp.val()); return false;
        formData.append('album_image', $(this)[0].files[0]);
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

    //Update album
    function updateAlbum(){

        $('#errorTit,#errorDes,#errorImg').html('');
        var formData = new FormData();
        var album_inp = $('#update_album_id');
        var imageSelect = 0;
        var writeText = 1;
        var titleText = $('#album_title').val();
        var descriptionText = $('#album_description').val();

        if($.trim(titleText) == ''){
            var writeText = 0;
            $('#errorTit').html('Please insert title');
        }

        if($.trim(descriptionText) == ''){
            var writeText = 0;
            $('#errorDes').html('Please insert descriptionText');
        }
        
        var album_id = album_inp.val();
        if(album_id==''){
            //image is not yet uploaded
            var writeText = 0;
            $('#errorImg').html('Please select image');
        }
        
        formData.append('album_title', titleText);
        formData.append('album_description', descriptionText);
        formData.append('album_id', album_id);
        
        if(writeText == 1){
                
            show_loader(); 
            var url = base_url + "home/Vendorpost/update_media";
            $.ajax({
                url: url,
                type: "POST",
                data:formData, 
                dataType: "json",             
                cache: false,   
                processData: false,
                contentType: false,  
                success: function(data){ 
                    hide_loader();
                    if (data.status == 1){ 
                      //$('#update_modal').click();
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
                          //$('#update_modal').click();
                          toastr.error(data.message);
                          //$('#edit_profile')[0].reset();
                    }
                      
                }
            });
                
        }
        
   }

    $('#album_title').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
    });

    $('#album_description').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
    });


</script>