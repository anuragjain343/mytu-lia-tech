
    var myId = $.trim($('#myId').val());

    //for registration of user into firebase
    firebase.auth().createUserWithEmailAndPassword(myId+'@tulia.com' ,'123456').catch(function(error) { 
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        console.log(errorMessage);
        console.log(errorCode);
        // ...
      
    });


    //for checking wheather user exist or not
    firebase.auth().signInWithEmailAndPassword(myId+'@tulia.com','123456').catch(function(error) {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        console.log(errorMessage);
        console.log(errorCode);
        // ...
    });

    //called getChat() here to load the chat on page load
    getChat()

    //hide text area and dropdown when on chat avialable i.e. on page load
    $("#dis-field").find("input, button, submit, textarea, select").attr("disabled",true);
    $("#dis-field").hide();
    $("#hide-blk-del").hide();

    //for on scroll pagination
    $('.message').scroll(function() {
        if ($('.message').scrollTop() == 0) {
            if ($('#startFrom').val() != 0) {
                chatPagination()
            }
        }
    });

    //first letter captial
    function capitalize(s){
        return s[0].toUpperCase() + s.slice(1);
    }

    //chat pagination
    function chatPagination() {
     
        
        var chatRoom = $.trim($('#chatRoom').val());
        firebase.database().ref("chat_rooms").child(chatRoom).orderByChild("timeStamp").endAt(Number($('#startFrom').val())).limitToLast(15).on('value', function(snapshot) {

            $('#startFrom').val(0);
            var msgC = 1;
            var runPagination = 1;

            $.each(snapshot.val(), function(key, value) {
                $('#' + key).remove();
                $('#q' + key).remove();
                var skey = 'q'+key;

                if ($('#startFrom').val() == 0) {
                    $('#startFrom').val(value.timeStamp);
                }

                var oneMsg = value;
                if (oneMsg.deleteby != myId) {

                    $('#noMsg').hide();
                    timestamp1 = moment(oneMsg.timeStamp).format('DD/MM/YYYY'); 
                    today = moment(new Date()).format('DD/MM/YYYY');
                    //var today = new Date();
                    if(timestamp1 == today){
                        time = moment(oneMsg.timeStamp).format('hh:mm a');
                    }else{
                        t = moment(oneMsg.timeStamp).format('DD/MM/YYYY hh:mm A');
                        $(".hover-time").addClass("title-time"); 
                        $('.title-time').prop('title', t);
                        time = moment(oneMsg.timeStamp).format('DD/MM/YYYY');

                    }

                    msg = oneMsg.message;
                   // showMsg = msg.replace("<", "&#60;");
                    showMsg = msg.replace(/\&/g, '&amp;');
                    showMsg = showMsg.replace(/\>/g, '&gt;');
                    showMsg = showMsg.replace(/\</g, '&lt;');
                    showMsg = showMsg.replace(/\"/g, '&quot;');
                    showMsg = showMsg.replace(/\'/g, '&apos;');


                    if (oneMsg.op_id == myId) {
                        if (oneMsg.imageURL != '') {
                            $('.paginationChat').append('<div id=' + key + ' class="row message-body"> <div class="message-main-sender"> <div class="sender"> <div class="message-text1"><img onclick="showImage(this.src);" src=' + oneMsg.imageURL + ' alt="Tulia.com..." height="120" width="130"></div></div><div class="clearfix"></div><p id=' + skey + ' class="message-time pull-right hover-time"> ' + time + ' </p> </div></div>');
                        } else {
                            $('.paginationChat').append('<div id=' + key + ' class="row message-body"> <div class="message-main-sender"> <div class="sender"> <div class="message-text1">' + showMsg + '</div></div><div class="clearfix"></div><p id=' + skey + ' class="message-time pull-right hover-time"> ' + time + ' </p> </div></div>');
                        }
                    } else {
                        if (oneMsg.imageURL != '') {
                            $('.paginationChat').append('<div id=' + key + ' class="row message-body"> <div class="message-main-receiver"> <div class="receiver"> <div class="message-text"><img onclick="showImage(this.src);" src=' + oneMsg.imageURL + ' alt="Tulia.com..." height="120" width="130"</div></div><div class="clearfix"></div><p id=' + skey + ' class="message-time1 hover-time"> ' + time + ' </p> </div></div>');
                        } else {
                            $('.paginationChat').append('<div id=' + key + ' class="row message-body"> <div class="message-main-receiver"> <div class="receiver"> <div class="message-text">' + showMsg + '</div></div><div class="clearfix"></div><p id=' + skey + ' class="message-time1 hover-time"> ' + time + ' </p></div></div> ');
                        }
                    }
                } else {
                    runPagination = 0;
                }
                msgC++;
            });

            if (msgC <= 15) {
                $('#startFrom').val(0);
            }
            var topp = '';
            var first_msg_id = $('.message-body:first').attr('id'); 
            $(".message").prepend($('.paginationChat').html());
            $('.paginationChat').html('');
            if (typeof first_msg_id !== 'undefined'){
                var topp = $('#'+first_msg_id).offset().top;
            }
            var scroll_to =  topp - $('.message').height();
            if (runPagination == 1) {
                $('.message').animate({
                    scrollTop: scroll_to
                },1);
            }
        });
    }

    //get user's data from input hidden fields
    var myId = $.trim($('#myId').val());
    var myImage = $.trim($('#myImage').val());
    var myName = $.trim($('#myName').val()); 
    var myEmail = $.trim($('#myEmail').val()); 
    var opId = $.trim($('#op_chat_id').val());
    var opImage = $.trim($('#op_chat_image').val());
    var opName = $.trim($('#op_chat_name').val());
    var chatRoom = $.trim($('#chatRoom').val());


    //block user here(function call when click on block option)
    function blockUser() {

        var chatRoom = $.trim($('#chatRoom').val());
        var op_id = $.trim($('#op_chat_id').val());
        var my_id = $.trim($('#myId').val());

        firebase.database().ref("block").child(chatRoom).once('value', function(snapshot) {

            if (snapshot.exists()) {

                var updates2 = {};
                var offer = {
                    id: 'both',
                    timestamp: Date.now()
                }
                updates2['/block/' + chatRoom] = offer;
                return firebase.database().ref().update(updates2);
            } else {
                var blockData = {
                    id: my_id,
                    timestamp: Date.now()
                };
                var chatKey2 = firebase.database().ref('block').child(chatRoom).set(blockData);
            }
        });

    }

    //unblock user here(function call when click on unblock option)
    function unblockUser() {

        var chatRoom = $.trim($('#chatRoom').val());
        var op_id = $.trim($('#op_chat_id').val());
        var my_id = $.trim($('#myId').val());

        firebase.database().ref("block").child(chatRoom).once('value', function(snapshot) {

            var block_id = snapshot.val().id;
            if (block_id == 'both') {
                block_id = op_id;
                firebase.database().ref().child('block').child(chatRoom).child('id').set(block_id);
            } else {
              if (block_id == my_id) {
                  firebase.database().ref().child('block').child(chatRoom).set(null);
              }
            }
        });
    }

    $('#searchText').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
    });

    //get user's chat history
    function getChatHistory() {
        $('#chatHistory').html('');
        firebase.database().ref("chat_history").child(myId).on('value', function(snapshot) {
            $('#noErr').html('');

            var array = [];
            $.each(snapshot.val(), function(key, value) {
                array.push(value);
            });

            //sort user's chat history according to most recent chat
            array.sort(function(a, b) {
                var a1 = a.timeStamp,
                    b1 = b.timeStamp;
                if (a1 == b1) return 0;
                return a1 < b1 ? 1 : -1;
            });

            var str2 = $('#searchText').val().trim();

            $('#chatHistory').html('');
            $.each(array, function(key, value) {
                addListner(value.op_id)
                var oneMsg = value;  
                var str1 = oneMsg.op_name;
                if (str1.indexOf(str2.toLowerCase()) != -1) {
                    timeStamp = moment(oneMsg.timeStamp).format('DD');
                    var today = new Date();
                    if(timeStamp == today.getDate()){
                        time = moment(oneMsg.timeStamp).format('hh:mm A');
                    }else{
                        time = moment(oneMsg.timeStamp).format('DD/MM/YYYY');
                    }

                    if (oneMsg.imageURL != '' && oneMsg.message == '') {
                        oneMsg.message = '<i class="fa fa-image"></i> IMAGE';
                    } else {
                        if (oneMsg.message.length > 50) {
                            oneMsg.message = oneMsg.message.substr(0, 20) + '...';
                        }
                        oneMsg.message = oneMsg.message.replace(/\&/g, '&amp;');
                        oneMsg.message = oneMsg.message.replace(/\>/g, '&gt;');
                        oneMsg.message = oneMsg.message.replace(/\</g, '&lt;');
                        oneMsg.message = oneMsg.message.replace(/\"/g, '&quot;');
                        oneMsg.message = oneMsg.message.replace(/\'/g, '&apos;');
                    }

                    if(oneMsg.profilePic == ''){
                        oneMsg.profilePic = $('#defaultImg').val();
                    }
                   
                    $('#chatHistory').append('<div class="row sideBar-body" onclick="changeChatUser(' + oneMsg.op_id + ')"><div class="col-sm-3 col-xs-3 sideBar-avatar"><div class="avatar-icon"><img id="image'+oneMsg.op_id+'" src=' + oneMsg.profilePic + '></div></div><div class="col-sm-9 col-xs-9 sideBar-main"><div class="row"><div class="col-sm-8 col-xs-8 sideBar-name"><span id="userList'+oneMsg.op_id+'" class="name-meta">' + capitalize(oneMsg.op_name) + '</span> <p class="cht-shrt-msg">' + oneMsg.message + '</p></div> <div class="col-sm-4 col-xs-4 pull-right sideBar-time"><span class="time-meta pull-right">' + time + '</span></div></div></div></div>');
                }
            });

            if ($('#chatHistory').html() == '') {
                if (str2) {
                    $('#chatHistory').html('<center style="color:#1976d2;" id="noMsg" >No Match Found..</center> ');
                } else {
                    $('#chatHistory').html('<center style="color:#1976d2;" id="noMsg" >No Record Found..</center> ');
                }
            }
        });
    }   getChatHistory();


    function addListner(opId){ 
    
        var userType = $("#user_type").val();
        if(userType == 'user'){
             //update user name image on change
            firebase.database().ref('users').child('vendor').child(opId).on('child_changed', function(snapshot1) {
                firebase.database().ref('users').child('vendor').child(opId).on('value', function(snapshot2) {
                    var opUserData = snapshot2.val();
                    userName = capitalize(opUserData.name);
                    if(opUserData.profilePic == ''){//user image not in user table set default image
                        opUserData.profilePic = $('#defaultImg').val();
                    }
                    $('#userList'+opId).html(userName);
                    $('#image'+opId).attr("src",opUserData.profilePic);
                    //get current chat user id
                    console.log(opUserData);
                    opUserId = $.trim($('#op_chat_id').val());
                    if(opUserId == opId){
                        $('.heading-name-meta').html(userName);
                        $('.chatUserImage').attr("src",opUserData.profilePic);
                        $('#op_chat_image').val(opUserData.profilePic);
                        $('#op_chat_name').val(opUserData.name);
                    }   
                });
            });
            //update chat history list name image on load
            firebase.database().ref('users').child('vendor').child(opId).on('value', function(snapshot3) {
                var opUserData = snapshot3.val(); 
                console.log(opUserData);
                var userName = capitalize(opUserData.name);
                $('#userList'+opId).html(userName);
                $('#image'+opId).attr("src",opUserData.profilePic);
            });
        }else{
            firebase.database().ref('users').child('user').child(opId).on('child_changed', function(snapshot1) {
                firebase.database().ref('users').child('user').child(opId).on('value', function(snapshot2) {
                    var opUserData = snapshot2.val();
                   
                    userName = capitalize(opUserData.name);

                    if(opUserData.profilePic==""){//user image not in user table set default image
                        opUserData.profilePic = $('#defaultImg').val();
                    }
                    $('#userList'+opId).html(userName);
                    $('#image'+opId).attr("src",opUserData.profilePic);
                    //get current chat user id
                    opUserId = $.trim($('#op_chat_id').val());
                    if(opUserId == opId){
                        $('.heading-name-meta').html(userName);
                        $('.chatUserImage').attr("src",opUserData.profilePic);
                        $('#op_chat_image').val(opUserData.profilePic);
                        $('#op_chat_name').val(opUserData.name);  
                    }
                });
            });
            //update chat history list name image on load
            firebase.database().ref('users').child('user').child(opId).on('value', function(snapshot3) {
                var opUserData = snapshot3.val();
                var userName = capitalize(opUserData.name);
                $('#userList'+opId).html(userName);
                $('#image'+opId).attr("src",opUserData.profilePic);
            });
        }
       


    }

    //delete user's chat
    function deleteChat() {

        var chatRoom = $.trim($('#chatRoom').val());
        var op_id = $.trim($('#op_chat_id').val());
        var myid = $.trim($('#myId').val());

     
        firebase.database().ref("chat_rooms").child(chatRoom).once('value', function(snapshot) {

            $.each(snapshot.val(), function(key, value) {

                if(value.deleteby == ''){
                    value.deleteby = myid;
                    firebase.database().ref().child('chat_rooms').child(chatRoom).child(key).set(value);
                    firebase.database().ref('/chat_history/' + myid).child(op_id).set(null);
                }else{
                    if(value.deleteby == myid){
                        firebase.database().ref('/chat_history/' + myid).child(op_id).set(null);
                    }else{
                        firebase.database().ref().child('chat_rooms').child(chatRoom).child(key).set(null);
                        firebase.database().ref('/chat_history/' + myid).child(op_id).set(null);
                    }
                }
            });
        });

        $('#chatDeleteModal').modal('hide');
       
        setTimeout(function() {
            $('.message').html('<center style="color:#1976d2;" id="noMsg" >No Record Found..</center> ');
        }, 1000);
          
    }

   
    //load user chat
    function getChat(){

        var myId = $.trim($('#myId').val());
            chatRoom = $.trim($('#chatRoom').val());

        firebase.database().ref("chat_rooms").child(chatRoom).limitToLast(15).on('child_added', function(snapshot) {
                $('#q' + snapshot.key).remove();
                var skey = 'q'+snapshot.key;

            $('#first-msg').remove();
            var oneMsg = snapshot.val();

            if ($('#startFrom').val() == 0) {
                $('#startFrom').val(oneMsg.timeStamp);
            }

            if (oneMsg.deleteby != myId) {
                
                $('#noMsg').hide();

                timestamp = moment(oneMsg.timeStamp).format('DD/MM/YYYY'); 
                    today = moment(new Date()).format('DD/MM/YYYY');
                    //var today = new Date();
                    if(timestamp == today){
                        time = moment(oneMsg.timeStamp).format('hh:mm a');
                    }else{
                        t = moment(oneMsg.timeStamp).format('DD/MM/YYYY hh:mm A');
                        $(".hover-time").addClass("title-time"); 
                        $('.title-time').prop('title', t);
                        time = moment(oneMsg.timeStamp).format('DD/MM/YYYY');

                    }

                msg = oneMsg.message;
                //showMsg = msg.replace("<", "&#60;");
                showMsg = msg.replace(/\&/g, '&amp;');
                showMsg = showMsg.replace(/\>/g, '&gt;');
                showMsg = showMsg.replace(/\</g, '&lt;');
                showMsg = showMsg.replace(/\"/g, '&quot;');
                showMsg = showMsg.replace(/\'/g, '&apos;');
                if (oneMsg.op_id == myId) {
                    if (oneMsg.imageURL != '') {
                      
                        $('.message #removeLi').remove();
                        $('.message').append('<div id=' + snapshot.key + ' class="row message-body"> <div class="message-main-sender"> <div class="sender"> <div class="message-text1"><img onclick="showImage(this.src);" src=' + oneMsg.imageURL + ' alt="Tulia.com..." height="120" width="130"></div></div><div class="clearfix"></div><p id='+skey+' class="message-time pull-right hover-time"> ' + time + ' </p></div></div> ');
                    } else {
                        $('.message').append('<div id=' + snapshot.key + ' class="row message-body"> <div class="message-main-sender"> <div class="sender"> <div class="message-text">'+ showMsg + '</div></div><div class="clearfix"></div><p id='+skey+' class="message-time pull-right hover-time"> ' + time + ' </p> </div></div>');
                    }
                } else {
                     
                    if (oneMsg.imageURL != '') {
                        $('.message #removeLi').remove();
                        $('.message').append('<div id=' + snapshot.key + ' class="row message-body"> <div class="message-main-receiver"> <div class="receiver"> <div class="message-text"><img onclick="showImage(this.src);" src=' + oneMsg.imageURL + ' alt="Tulia.com..." height="120" width="130"</div></div><div class="clearfix"></div><p id='+skey+' class="message-time1 hover-time"> ' + time + ' </p></div></div> ');
                    } else {
                        $('.message').append('<div id=' + snapshot.key + ' class="row message-body"> <div class="message-main-receiver"> <div class="receiver"> <div class="message-text">' + showMsg + '</div></div><div class="clearfix"></div><p id='+skey+' class="message-time1 hover-time"> ' + time + ' </p> </div></div>');
                    }
                }
                $('.message').animate({
                    scrollTop: $('.message').prop("scrollHeight")
                }, 50);
            }
        });

    }

        //call function for changing the user's chat
    function changeChatUser(op_id) {  
        $("#lastMsg").val('');
        $("#dis-field").find("input, button, submit, textarea, select").attr("disabled",false);
        $("#dis-field").show();
        $("#hide-blk-del").show();
   
        
        var oldChatRoom = $.trim($('#chatRoom').val()); 
        var myId = $.trim($('#myId').val());
        var user_type = $("#user_type").val(); 
        if(user_type == 'user'){
            var chatRoom = $('#chatRoom').val(myId+'_'+op_id);
        }else{
            var chatRoom = $('#chatRoom').val(op_id+'_'+myId);
        }
        
       
        if(oldChatRoom != chatRoom){
            $('#startFrom').val(0);
            $('.message').html('');
            firebase.database().ref("chat_rooms").child(oldChatRoom).off();
        }


        url = base_url + "home/users/chatChange/"; 
        $.ajax({
                url: url ,
                type: "POST",
                data:{'userId':op_id},              
                cache: false,  
                dataType: "json",
                beforeSend: function() { 
                },                          
                success: function(data){  
                    $('#op_chat_name').val(data['fullName']);
                    $('#op_chat_image').val(data['thumbImage']);
                    $('#op_chat_id').val(data['id']);

                    var name = $('#op_chat_name').val();
                    var image = $('#op_chat_image').val();
                    var u_id = $('#op_chat_id').val();
                    $('#o_url').text(name);
                    $('#o_image').attr('src', image);
                }
            });
        getChat()

        //for sending msg on enter press(key event)
        $(document).keypress(function (e) {
            if (e.which == 13 && !e.shiftKey) {
                e.preventDefault();
                var s = $(this).val();
                $(this).val(s+"\n");
                sendMsg();
                $('#lastMsg').val('');
            }
        });


        //for highlighting the current chat
        chatRoom1 = $('#chatRoom').val();
        var r =  chatRoom1.split("_"); 
        
        if(r[1] == op_id){
           // $('#chatHistory .sideBar-body .sideBar-name span').removeClass('fa fa-comment');
            // $("#userList"+op_id).addClass('fa fa-comment');
        }

        getBlockUser()
    }

    //for sending msg on enter press(key event)
    $(document).keypress(function (e) {
        if (e.which == 13 && !e.shiftKey) {
            e.preventDefault();
            var s = $(this).val();
            $(this).val(s+"\n");
            sendMsg();
            $('#lastMsg').val('');
        }
    });

    //for sending the messages
    function sendMsg() { 
        var lastMsg = $.trim($('#lastMsg').val()); 
        opId = $.trim($('#op_chat_id').val());
        opImage = $.trim($('#op_chat_image').val());
        opName = $.trim($('#op_chat_name').val());
        
        chatRoom = $.trim($('#chatRoom').val()); 
        if (lastMsg) { 
            $('.textarea-control').html('');
            firebase.database().ref("block").child(chatRoom).once('value', function(snapshot) {
                if (snapshot.exists()) {
                    if ((snapshot.val().id == myId) || (snapshot.val().id == 'both')) {
                        $('#block_modal').modal('show');
                        $('#blk-usr').text(opName);
                    } else { 
                        $('#op_block_modal').modal('show');
                        $('#blk-usr-by').text(opName);
                    }
                } else {

                    var userType = $("#user_type").val();
                    var userData = {
                        category: "",
                        email:myEmail,
                        firebaseId: "",
                        firebaseToken: "",
                        name: myName.toLowerCase(),
                        profilePic: myImage,
                        uid: myId,
                        userType: userType
                    };
                    if(userType == 'user'){ 
                        var newPostKey = firebase.database().ref('users').child('user').child(myId).set(userData);
                    }else{ 
                        var newPostKey = firebase.database().ref('users').child('vendor').child(myId).set(userData);
                    }
                
                    $('#lastMsg').val('');

                    var msgData = {
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
                    firebase.database().ref().child('chat_rooms').child(chatRoom).push(msgData);

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
                    time = chatData1.timeStamp;
                    $.ajax({
                        url: base_url+"/home/users/chat_notification",
                        type: "POST",
                        data:{id:opId, msg:lastMsg.trim(), time:time},              
                        cache: false,   
                        beforeSend: function() {

                        },                          
                        success: function(data){

                        }
                    });
                }
            });
        }
    }


    //for sending the images 
    document.getElementById("fileInput").onchange = function(e) { 


        var ext = this.value.match(/\.(.+)$/)[1];
        switch(ext)
        {
            case 'jpg':
            case 'JPG':
            case 'png':
            case 'PNG':
            case 'jpeg':
            case 'JPEG':
            case 'gif':
            case 'GIF':
                break;
            default:
                toastr.error('Please select png,jpg,gif and jpeg image formats.');
            this.value='';
        }

        opId = $.trim($('#op_chat_id').val());
        opImage = $.trim($('#op_chat_image').val());
        opName = $.trim($('#op_chat_name').val());

        chatRoom = $.trim($('#chatRoom').val());


        var file = e.target.files[0];
        var storageRef = firebase.storage().ref();
        var dataD = Date.now();

        var uploadTask = firebase.storage().ref('Images/'+myId+'_'+opId+'/'+dataD).put(file);
        
        firebase.database().ref("block").child(chatRoom).once('value', function(snapshot) {
            if (snapshot.exists()) {
                if((snapshot.val().id == myId) || (snapshot.val().id == 'both')) {
                    $('#block_modal').modal('show');
                    $('#blk-usr').text(opName);
                }else{
                    $('#op_block_modal').modal('show');
                    $('#blk-usr-by').text(opName);
                }
            } else {

                var imageUrl = "http://www.mizpahpublishing.com/images/loader.gif";

                $('.message').append('<div id="removeLi" class="row message-body"> <div class="message-main-sender"> <div class="sender"> <div class="message-text"><img src=' + imageUrl + ' alt="Tulia.com..." height="100" width="130"></div><span class="message-time pull-right"> Wait</span> </div></div></div>');

                $('.messages').animate({
                    scrollTop: $('.messages').prop("scrollHeight")
                }, 1);

                uploadTask.on('state_changed', function(snapshot) { 
                    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    console.log('Upload is ' + progress + '% done');

                    var imageUrl = "http://www.mizpahpublishing.com/images/loader.gif";

                    $('.messagedds').append('<li id="removeLi" class="message right appeared"><div class="timeMeta"><div class="text_wrapper"> <img src=' + imageUrl + ' alt="Tulia.com..." height="100" width="100"> </div><span>Loding</span></div></li>');

                    $('.messages').animate({
                        scrollTop: $('.messages').prop("scrollHeight")
                    }, 1);

                    switch (snapshot.state) {
                        case firebase.storage.TaskState.PAUSED:
                            console.log('Upload is paused');
                            $('.messages').animate({
                                scrollTop: $('.messages').prop("scrollHeight")
                            }, 1);
                            break;
                        case firebase.storage.TaskState.RUNNING:
                            console.log('Upload is running');
                            $('.messages').animate({
                                scrollTop: $('.messages').prop("scrollHeight")
                            }, 1);
                            break;
                    }

                }, function(error) {

                }, function() {

                var storageqq = firebase.storage();
                    storageqq.ref('Images/'+myId+'_'+opId+'/'+dataD).getDownloadURL().then(function (url) {

                        var downloadURL = url; 
                            if (lastMsg) {
                            var userType = $("#user_type").val();
                            var userData = {
                                category: "",
                                email:myEmail,
                                firebaseId: "",
                                firebaseToken: "",
                                name: myName.toLowerCase(),
                                profilePic: myImage,
                                uid: myId,
                                userType: userType
                            };
                            
                            if(userType == 'user'){ 
                                var newPostKey = firebase.database().ref('users').child('user').child(myId).set(userData);
                            }else{ 
                                var newPostKey = firebase.database().ref('users').child('vendor').child(myId).set(userData);
                            }
                          
                            var msgData = {
                                category_name:"",
                                deleteby: "",
                                deviceToken: "website",
                                imageURL: downloadURL,
                                message: '',
                                op_id: myId,
                                op_name: myName.toLowerCase(),
                                profilePic: myImage,
                                timeStamp: Date.now()

                            };
                            firebase.database().ref().child('chat_rooms').child(chatRoom).push(msgData);

                            var chatData1 = {
                                category_name:"",
                                deleteby: "",
                                deviceToken: "website",
                                imageURL: downloadURL,
                                message: '',
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
                                imageURL: downloadURL,
                                message: '',
                                op_id: myId,
                                op_name: myName.toLowerCase(),
                                profilePic: myImage,
                                timeStamp: Date.now()
                            };
                            var chatKey2 = firebase.database().ref('/chat_history/' + opId).child(myId).set(chatData2)
                        }

                        $('#fileInput').val('');
                    });
                });
            }
        });
    };


    //getBlockUser()

    //for getting the block users 
    function getBlockUser() {

        chatRoom = $.trim($('#chatRoom').val());
        firebase.database().ref("block").child(chatRoom).on('value', function(snapshot) {
           if (snapshot.exists()) {
                if (snapshot.val().id == myId || snapshot.val().id == 'both') {

                    document.getElementById("block").style.display = "none";
                    document.getElementById("unblock").style.display = "block";
                } else {
                    document.getElementById("block").style.display = "block";
                    document.getElementById("unblock").style.display = "none";
                }
            } else {
                document.getElementById("block").style.display = "block";
                document.getElementById("unblock").style.display = "none";
            }
        });
    }
    $(".loading").hide();

    //for image preview
    function showImage(imgPath){
        var modal = document.getElementById('myModal');
        var modalImg = document.getElementById("img01");
        modal.style.display = "block";
        modalImg.src = imgPath;

        var span = document.getElementsByClassName("close-img-modal")[0];

        // When the user clicks on <span>, close the modal
        span.onclick = function() { 
            modal.style.display = "none";
        }
    }
