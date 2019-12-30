 <?php
        $backend_assets =  base_url().'backend_asset/';
    ?>
 <link href="<?php echo base_url(); ?>backend_asset/custom/css/chat.css" rel="stylesheet">
<style type="text/css">
	 .pre-img-modal{display:none;position:fixed;z-index:1;padding-top:12%;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.9);padding-top: 50px;}
.modal-content-cht{margin:auto;display:block;width:80%;max-width:700px;}
#myModal{z-index:99999;}
#myModal .close-img-modal{opacity:1;}
	
.cicle-i{float: right;font-size: 12px;margin-top: 22px;color:#a51d29}
@-webkit-keyframes zoom{from{-webkit-transform:scale(0)}
to{-webkit-transform:scale(1)}
}
@keyframes zoom{from{transform:scale(0)}
to{transform:scale(1)}
}
.close-img-modal{position:absolute;top:15px;right:35px;color:#f1f1f1;font-size:40px;font-weight:bold;transition:0.3s;}
.close-img-modal:hover,
.close-img-modal:focus{color:#bbb;text-decoration:none;cursor:pointer;}
@media only screen and (max-width:700px){.modal-content{width:100%;}
}
/*--added css--*/
.log_div img {
    border-radius: 100%;
    width: 120px;
    height: 120px;
}
.nr-usr-parnt{
  width:100%;
}
</style>
<!--chat page-->
<section class="lowr-job-lst-sec">
	<div class="content-wrapper">
		<section class="chat sec-pad">
	        <div class="vertical-align cstm-head">
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 side_msg">
	                <div class="lft-sec">
	                    <div class="lft-sec-head">
	                        <h5>Messages
	                        </h5>
	                    </div>

	                    <div class="cht-lst">
	                        <div class="chat-search">
	                            <div class="input-group">
	                              <input type="text" class="form-control" placeholder="Search for..." id="searchText">
	                              <span class="input-group-btn">
	                                <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
	                              </span>
	                            </div>
	                        </div>
	                        <div class="chat_list" id="chatHistory">
	                            
	                            <!-- <div class="text-center">
	                                <a href="javascript:void(0)" class="lve-wre-btn clr-proprty mt-0">Load More</a>
	                            </div> -->
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
	                <div class="rgt-sec">
	                    <div class="rgt-headr">
	                        <h4 id="showNameImg" class="msgs_chat"></h4>
	                      <!--   <div class="dropdown pull-right">
	                          <span class="fa fa-comment newMsg" aria-hidden="true"></span>
	                          <a class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" style="cursor: pointer;"><i class="fa fa-ellipsis-v"></i></a>
	                          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
	                            <li><a href="javascript:void(0)">Delete Chat</a></li>
	                            <li><a href="javascript:void(0)">Block</a></li>
	                          </ul>
	                        </div>   -->  
	                    </div>
	                    <div class="clearfix"></div>
	                    <div class="cht-his clearfix">
	                        <!-- <a href="javascript:void(0)"><h5>Show Previous Messages!</h5></a> -->
	                        <div class="chat_msg" id="get_chat">
	                            
	                        </div>

	                        <div class="message_write">
	                            <textarea class="form-control" id="lastMsg" placeholder="Type a Message"></textarea>
	                            <div class="clearfix"></div>
	                            <div class="write_bottom">
	                                <div class="write_upload">
	                                    <label for="file-upload" class="pull-left upload_btn">
	                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp;File Upload
	                                    </label>
	                                    <input type="file" id="file-upload">
	                                </div>
	                                <a href="javascript:void(0)" onclick="sendMsg();" class="lve-wre-btn clr-proprty-green mt-0 pull-right">Send</a>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
		</section>
	</div>
</section>
<!-- image preview modal -->
<div id="myModal" class="pre-img-modal">
    <span class="close-img-modal">&times;</span>
    <img class="modal-content-cht" id="img01">
</div>
<div id="get_chat1" style="display: none;"></div>
<script src="<?php echo $backend_assets ?>custom/js/chat.js"></script>
<script src="<?php echo $backend_assets ?>custom/js/moment.js" ></script>
<script>
	$(function(){

		$(".newMsg").click(function(){

			$(".side_msg").css({
				"left": "0"
			});

		});

		$(".newMsg-back").click(function(){

			$(".side_msg").css({
				"left": "-100%"
			});

		});

	});
</script>