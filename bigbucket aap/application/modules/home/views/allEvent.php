<?php if (empty($check_lat_log->latitude) && empty($check_lat_log->longitude)){ 
echo "<script> window.onload = function () {                                                  
    $('#mypopupmodel').modal('show');                            
  }; </script>";
    ?> 
  <?php  }?>
  
<?php $frontend_assets =  base_url().'frontend_asset/'; ?>
<section id="my-evnts" class="sectn-pad2">
   <input type="hidden" id="totalCount" value="<?php echo $total; ?>">
  <div class="container">
    <!--start of my event listing-->
    <div class="col-lg-8 col-lg-offset-2 col-md-12 col-sm-12 col-xs-12">
     <div id="apndDAta"></div>
      
    </div>
  </div>
</section><!--/my-evnts-->



<script type="text/javascript">
     function show_loader(){ 
        $("div#divLoading").addClass('show');
    }
    function hide_loader(){
        $("div#divLoading").removeClass('show');
    }

var url = base_url +"/home/Vendorpost/event";
pagination(url)
function pagination(url){
	var totalCount = $('#totalCount').val();
	$.ajax({
		url: url,
		type: "get",
		data: {totalCount:totalCount},
		cache: false,
        
        beforeSend: function() {
                    show_loader();
                },
        
		success: function(result) {
           
            hide_loader();
			$('#apndDAta').html(result);
             
		}
	});
}


</script>

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