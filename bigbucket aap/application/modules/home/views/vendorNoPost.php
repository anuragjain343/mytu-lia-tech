<?php
        $frontend_assets =  base_url().'frontend_asset/';
?> 
<?php if (empty($check_lat_log->latitude) && empty($check_lat_log->longitude)){ 
echo "<script> window.onload = function () {                                                  
    $('#mypopupmodel').modal('show');                            
  }; </script>";
    ?> 
   
  <?php  }?>
<!--no postsection-->
<section id="no-post" class="sec-pad">
  <div class="container">
    <div class="row mrgn-btm">
      <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
        <div class="row mrgn-btm">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="no-post-text">
            <div class="post-img">
              <img src="<?php echo $frontend_assets ?>img/no-post-icn.png" alt="Image" />
            </div><!--/post-img-->
            <div class="currently">
              <p><?php echo $title; ?></p>
            </div><!--/currently-->
            <div class="no-post-para">
              <p><?php echo $description; ?></p>
            </div><!--/no-post-para-->            
          </div><!--/no-post-text-->
        </div>
      </div>
      </div>      
    </div>
      
  </div>
</section>

<script type="text/javascript">

  function userAuth(){

        var myId = '<?php echo $this->session->userdata('id'); ?>';
        var userType = '<?php echo $this->session->userdata('userType');?>';
        var opId = '1';
        var opName = 'Admin';
        var myName = '<?php echo $this->session->userdata('fullName'); ?>';
        var lastMsg = '';
        var opImage = '<?php echo base_url().'backend_asset/custom/images/tulia_logo_40x40.png';?>';
        var myImage = '<?php echo $this->session->userdata('image');?>';
        var myEmail = '<?php echo $this->session->userdata('email');?>';

        firebase.database().ref("users").child(userType).child(myId).once('value', function(snapshot) {

            if (!snapshot.exists()) {

                var chatData1 = {
                    category_name:"",
                    deleteby: "",
                    deviceToken: "website",
                    imageURL: "",
                    message: lastMsg,
                    op_id: opId,
                    op_name: opName.toLowerCase(),
                    profilePic: opImage,
                    timeStamp: Date.now()
                };
                var chatKey1 = firebase.database().ref('/chat_history/' + myId).child(opId).set(chatData1);

                var chatData2 = {
                    category_name:"",
                    deleteby: "",
                    deviceToken: "website",
                    imageURL: "",
                    message: lastMsg,
                    op_id: myId,
                    op_name: myName.toLowerCase(),
                    profilePic: myImage,
                    timeStamp: Date.now()
                };
                var chatKey2 = firebase.database().ref('/chat_history/' + opId).child(myId).set(chatData2);              
            }

            let userData = {
                category: "",
                email:myEmail,
                firebaseId: "",
                firebaseToken: "",
                name: myName.toLowerCase(),
                profilePic: myImage,
                uid: myId,
                userType: userType
            };
            
            firebase.database().ref('users').child(userType).child(myId).set(userData);
             
        });
       
    } 
    
    $(document).ready(function(){
        userAuth();
    });
</script>
