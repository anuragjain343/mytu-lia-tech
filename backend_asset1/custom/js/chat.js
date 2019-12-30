// to get all user's chat history list
//get user's chat history
let myId = '1';
let myName = 'Admin';
let myImage = base_url+'backend_asset/custom/images/tulia_logo_40x40.png';

var setValue = function(key,value){

    if($('#'+key).length==0){
        $('<input>').attr({type: 'hidden', id: key, name: key,value:value}).appendTo('head');
    }else{
        $("#"+key).val(value);
    }
    return true;
}

var getValue = function(key){
    return $("#"+key).val();
}

var removeValue = function(key){
    return $("#"+key).val('');
}

//first letter captial
function capitalize(s){

    return s[0].toUpperCase() + s.slice(1);
}

var typingTimer; //timer identifier
var doneTypingInterval = 100; //time in ms, 5 second for example
var $input = $('#searchText'); // get input 

//on keyup, start the countdown
$input.on('keyup', function () {

    clearTimeout(typingTimer);
    typingTimer = setTimeout(getChatHistory, doneTypingInterval); //"getChatHistory" is function for call
});

//on keydown, clear the countdown 
$input.on('keydown', function () {
    clearTimeout(typingTimer);
});

var stringReplace = function(message){

    if(message){

        message = message.replace(/\&/g, '&amp;');
        message = message.replace(/\>/g, '&gt;');
        message = message.replace(/\</g, '&lt;');
        message = message.replace(/\"/g, '&quot;');
        message = message.replace(/\'/g, '&apos;');

        return message;

    }else{
        return '';
    }
}


var arrayshort = function(data){
 var array = [];
          $.each(data, function(key, value) {
              array.push(value);
          });
 return array.sort(function(a, b) {
      var a1 = a.timeStamp,
          b1 = b.timeStamp;
      if (a1 == b1) return 0;
      return a1 < b1 ? 1 : -1;
  });
}

function getChatHistory() {

    $('#chatHistory').html('');

    firebase.database().ref("chat_history").child(myId).on('value', function(snapshot) {

        $('#noErr').html('');

        var array = arrayshort(snapshot.val());

        var search = $('#searchText').val().trim();

        if(search){
            array = array.filter(function(itm){
                if(typeof itm != 'undefined'){
                    userName = (itm.op_name).toLowerCase()
                    return userName.indexOf(search) != -1;
                }
            });
        }

        $('#chatHistory').html('');
        i = 1;

        $.each(array, function(key, value) {

            if(typeof value != 'undefined'){

                var oneMsg = value;  

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
                        oneMsg.message = '<xmp>'+oneMsg.message.substr(0, 20) + '...</xmp>';
                    }
                }

                if(oneMsg.profilePic == ''){
                    oneMsg.profilePic = $('#defaultImg').val();
                }

                var first = (i==1) ? 'first' : '';

                let data = '<div class="nme-pic-mg '+first+'" onclick="showUserChat(this)" data-id=' + oneMsg.op_id + ' data-name='+oneMsg.op_name+' data-img='+oneMsg.profilePic+'><img id="image'+oneMsg.op_id+'" src=' + oneMsg.profilePic + ' /><div class="nme-msg mt-10"><div class="dsply-inlne-blck cht-tme"><h5 id="userList'+oneMsg.op_id+'"class="dsply-inlne-blck-lft mb-0">' + capitalize(oneMsg.op_name) + '</h5><span class="dsply-inlne-blck-rgt">' + time + '</span></div> <div class="clearfix"></div><p>' + oneMsg.message + '</p></div></div>'

                if (oneMsg.op_id == '1') {

                    $('#chatHistory').prepend(data);

                }else{

                    $('#chatHistory').append(data);
                }
            i++;
        }
        });

        if ($('#chatHistory').html() == '') {
            if (search) {
                $('#chatHistory').html('<center style="color:#1976d2;" id="noMsg" >No Match Found..</center> ');
            } else {
                $('#chatHistory').html('<center style="color:#1976d2;" id="noMsg" >No Record Found..</center> ');
            }
        }
    });

}   getChatHistory();

function showUserChat(e = ''){

    if(e == ''){

        setTimeout(function(){ 

            $(".first").click();

        }, 2000);
        
    }else{

        var op_name = $(e).data("name");
        var op_img = $(e).data("img");
        var op_id = $(e).data("id");
        var chatRoom = myId+"_"+op_id; 
        setValue('op_name',op_name);
        setValue('op_img',op_img);
        setValue('op_id',op_id);
        setValue('chatRoom',chatRoom);

        $('#showNameImg').html('<img src= ' + op_img + '> ' + op_name);

        getUserChat();
    }
    
} showUserChat();

function getUserChat(){
    
    let op_id = getValue('op_id');

    let chatRoom = getValue('chatRoom'); 

    setValue('dateC','0');
    var startFrom = Number(getValue('startFrom'));
    getData = firebase.database().ref().child('chat_rooms').child(chatRoom).limitToLast(15);

    if(startFrom){

        getData = firebase.database().ref().child('chat_rooms').child(chatRoom).orderByChild("timeStamp").endAt(startFrom).limitToLast(15);
    }

    getData.on('value',function(rdata){

        rdata = rdata.val();
        setValue('startFrom',0);
        msgC = 1;

        if(rdata){

            if (getValue('startFrom') == 0) {

                var keys = Object.keys(rdata);
                k = keys[0];
                setValue('startFrom',rdata[k].timeStamp);
            }

            $.each(rdata, function(i, item) {

                Time = moment(item.timeStamp).format("hh:mm A");
                
                let uid = (item.op_id == myId) ? myId : item.op_id;
                let c = (item.op_id == myId) ? 'sendr_txt' : 'receivr_txt';
                let d = (item.op_id == myId) ? 'recevr_txt_time ' : '';

                msg = stringReplace(item.message);

                message = item.imageURL=='' ? msg : " <a href='JavaScript:void(0);'><img src='"+item.imageURL+"' class='img-rounded' width='150' height='120' onclick='showImage(this.src);'></a>";

                $('#'+item.timeStamp).remove(); 

                chat = '<div id="'+item.timeStamp+'" class="messges"><div class="'+c+' clearfix "><p>'+message+'</p><div class="receivr_time '+d+'">'+Time+'</div></div></div>';

                startFrom==0 ? $("#get_chat").append(chat) : $("#get_chat1").append(chat);
                msgC++; 
            });

            if (msgC <= 15) {
                setValue('startFrom',0);
            }
            if(startFrom==0){

                $('.chat_msg').animate({scrollTop: $('.chat_msg').prop("scrollHeight")}, 1);

            }else{

                var get_chat1 = $("#get_chat1").html();
                $("#get_chat").prepend(get_chat1);
                $("#get_chat1").html('');
                $(".chat_msg").animate({scrollTop: $(".chat_msg").height()}, 1);
            }
        }
    });
}
 

$('.chat_msg').scroll(function() {
    if ($('.chat_msg').scrollTop() == 0) {
        if (getValue('startFrom') != 0) {
            getUserChat();
        }
    }
});

//for sending the messages
function sendMsg(downloadURL='') { 

    var lastMsg = $.trim($('#lastMsg').val()); 
    let opId = getValue('op_id');
    let opImage = getValue('op_img');
    let opName = getValue('op_name');
    let chatRoom = getValue('chatRoom');
    
    if (lastMsg.length>0 || downloadURL!='') { 

        var userType = $("#user_type").val();
    
        $('#lastMsg').val('');
        imageUrl = downloadURL ? downloadURL : '';

        var msgData = {
            category_name:"",
            deleteby: "",
            deviceToken: "website",
            imageURL: imageUrl,
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
            imageURL: imageUrl,
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
        $('.chat_msg').animate({scrollTop: $('.chat_msg').prop("scrollHeight")}, 1);
    }
}
setValue('startFrom','0');

 // to upload imafe
$("#file-upload").change(function(e) {

    let opId = getValue('op_id');
    let opImage = getValue('op_img');
    let opName = getValue('op_name');
    let chatRoom = getValue('chatRoom');

    var file = e.target.files[0];
    var storageRef = firebase.storage().ref();
    var dataD = Date.now();

    var uploadTask = firebase.storage().ref('Images/'+myId+'_'+opId+'/'+dataD).put(file);
      

    var imageUrl = "<?php echo $frontend_assets ?>images/placeholder-image.png";

    $('.message').append('<div id="removeLi" class="message-body"> <div class="message-main-sender msg-img-sender"> <div class="sender sender1"> <div class="message-text"><img src=' + imageUrl + ' alt="Tulia..." height="100" width="130"></div><span class="message-time pull-right"> Wait</span> </div></div></div>');

    $('.messages').animate({
        scrollTop: $('.messages').prop("scrollHeight")
    }, 1);

    uploadTask.on('state_changed', function(snapshot) {
        var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
        console.log('Upload is ' + progress + '% done');

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

        alert(error)

    }, function() {

        uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {

            sendMsg(downloadURL);

        });
    });  
        
    $('#file-upload').val('');
});
//for image preview
function showImage(imgPath){

    var modal = document.getElementById('myModal');
    //console.log(modal);
    var modalImg = document.getElementById("img01");
    modal.style.display = "block";
    modalImg.src = imgPath;

    var span = document.getElementsByClassName("close-img-modal")[0];

    // When the user clicks on <span>, close the modal
    span.onclick = function() { 
        modal.style.display = "none";
    }
}
