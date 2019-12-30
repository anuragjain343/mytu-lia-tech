<?php
        $frontend_assets =  base_url().'frontend_asset/';
        /*echo $this->session->userdata('email');
        echo $this->session->userdata('fullName');
        echo $this->session->userdata('id');die;
        echo $this->session->userdata('email');die;
        echo $this->session->userdata('email');die;*/
?>

<!--my post-->
<section id="my-post" class="sectn-pad2">
    <div class="container">
        <!--create button-->  
        <div class="col-lg-8 col-lg-offset-2 col-md-12 col-xs-12">

        </div> 
        <!--button for create-post-->
        <div id="ajaxData">
            
        </div>
    </div>
</section>

<script type="text/javascript">
    
    pagination(base_url + "home/posts/postList/");
    function pagination(url)
    {   
        $.ajax({
            url: url,
            type: "POST",
            data:{page: url},              
            cache: false,   
            beforeSend: function() {
               $("div#divLoading").addClass('show');
            },                          
            success: function(data){ 
                $("div#divLoading").removeClass('show');
                $("#ajaxData").html(data);
            }
        });

    }

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