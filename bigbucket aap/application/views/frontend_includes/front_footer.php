
<!---Footer Start Here-->
<?php
$frontend_assets =  base_url().'frontend_asset/';
if(empty($this->session->userdata('id'))){ ?>
<!-- Modal -->
<div class="modal modal-vcenter fade" id="LoginModal" tabindex="-1" role="dialog">
  <div class="modal-dialog lsModal login-popup" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><b>&times;</b></button>
      <div class="modal-body">
        <div class="">
          <div class="loginRight">
            <div class="login-wrapper pdng-login newlsform">   
              <div class="welcme-TuliA-head">
                Welcome To TuliA
              </div>           
            <form class="login-form" id="login_form" action="<?php echo base_url('home/userLogin') ?>">
              <div class="row">                     
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="mrgn-top-rdio">
                    <div class="form-style-10 getUser1">
                      <div class="userType">
                        <div class="Ustype">
                          <span class="radio-inline res-rdio hvr-radial-out">
                            <input onclick=" $('#loginUrEr').html('') " type="radio" name="optradio" id="vendor" value="vendor">
                            <label><span><i class="fa fa-users"></i></span>Vendor</label>
                          </span>
                        </div>
                        <div class="Ustype">
                          <span class="radio-inline hvr-radial-out">
                            <input onclick=" $('#loginUrEr').html('') " type="radio" name="optradio" id="user" value="user" >
                            <label><span><i class="fa fa-user"></i></span>User</label>
                          </span>
                        </div>
                      </div>  
                    </div>
                    <center id="loginUrEr" style="color: red;" ></center>
                  </div>
                  <div class="form-group lin-hgt">
                    <label class="fnt-wt label-deco">Email</label> 
                    <input class="form-control" id="email" name="email" placeholder="" type="text" value="">
                  </div>
                  <div class="form-group lin-hgt">
                    <label class="fnt-wt label-deco">Password</label>
                    <input class="form-control" name="password" placeholder="" type="password" value="">
                  </div>
                  <div class="form-group mrg-bm">
                    <input type="hidden" val="" id="FBdata">
                    <div class="checked">
                      <input id="checkbox-2"  value="remember-me" class="checkbox-custom" name="checkbox-2" type="checkbox">
                      <label for="checkbox-2" class="checkbox-custom-label fnt-wt label-deco">Remember Me</label>
                    </div>
                    <div class="frgt-pswd">
                      <a class="forgot fnt-wt label-deco" onclick="forgotPassword()">Forgot password ?</a>
                    </div> 
                  </div>
                  <div class="login-snd">
                    <a href="javascript:void(0)"><button type="button" class="m-btn login-btn user_login">Login</button></a>
                  </div>
                  <div class="or-text"><span>OR</span></div>
                  <div class="facebook-link">
                    <div id="status"></div>
                    <a href="#" onclick="fbLogin()" id="fbLink"><span class="icon fa fa-facebook"></span> SIGN IN WITH FACEBOOK</a>
                    <div id="userData"></div>
                  </div>
                  <div class="agree signUp-link">
                    Don’t have an account?<a href="#" id="create_account" ><span style="color: #787878 !important;" class="crte-accnt"> Create account</span></a>
                  </div>                    
                </div>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Registration -->
<div class="modal modal-vcenter fade  " id="regModal" tabindex="-1" role="dialog">
  <div class="modal-dialog lsModal signup-popup" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><b>&times;</b></button>
      <div class="modal-body">
        <div class="signupSection">
          <div class="signupLeft">
            <div class="login-wrapper newlsform">
              <div class="welcme-TuliA-head">
                Create Your Account
              </div>
               <div class="mrgn-top-rdio">
                    <div class="form-style-10 getUser">
                      <div class="userType">
                        <div class="Ustype">
                          <span class="radio-inline res-rdio hvr-radial-out">
                            <input onclick=" $('#loginUrEr').html('');$('#ven_category').show(); " type="radio" name="optradio" id="vendor" value="vendor">
                            <label><span><i class="fa fa-users"></i></span>Vendor</label>
                          </span>
                        </div>
                        <div class="Ustype">
                          <span class="radio-inline hvr-radial-out">
                             <input onclick=" $('#loginUrEr').html('');$('#ven_category').hide();" type="radio" name="optradio" id="user" value="user">
                            <label><span><i class="fa fa-user"></i></span>User</label>
                          </span>
                        </div>
                      </div>  
                    </div>
                    <center id="loginUrEr" style="color: red;" ></center>
                </div> 
              <form class="login-form" method="POST" id="registration_form" role="form" action="<?php echo base_url('home/userRegistration') ?>">
                <div class="text-center">
                  <div class="log_div">
                    <img src="<?php echo $frontend_assets ?>img/user-acnt-icn.png" id="pImg">
                    <div class="text-center upload_pic_in_album"> 
                      <input class="inputfile hideDiv" id="file-1" name="image" onchange="document.getElementById('pImg').src = window.URL.createObjectURL(this.files[0]); return fileValidation()"  style="display: none;" type="file" accept="image/png,image/jpg,image/jpeg">
                      <label for="file-1" class="upload_pic">
                      <span class="fa fa-camera"></span></label>
                    </div>
                    <div id="profileImage-err"> </div>
                  </div>                  
                </div>                  
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group lin-hgt">
                      <label class="fnt-wt">Name</label>
                      <input class="form-control" id="fullName" name="fullName" placeholder="" type="text">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group lin-hgt">
                      <label class="fnt-wt">Email</label>
                      <input class="form-control" name="email" placeholder="" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group lin-hgt">
                    <label class="fnt-wt">Password</label>
                    <input class="form-control" id="password" name="password" placeholder="" type="password">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group lin-hgt">
                    <label class="fnt-wt">Confirm Password</label>
                    <input class="form-control" id="cpassword" name="cpassword" placeholder="" type="password">
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">                   
                    <div class="row mr-minus">                      
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">                              
                        <div class="form-group lin-hgt">
                          <label class="fnt-wt">Mobile No.</label>
                          <input class="form-control" id="contactNumber" name="contactNumber" placeholder="" type="text">
                          <input type="hidden" name="countryCode" id="countryCode" value="+254">
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12" id="ven_category"> 
                        <div class="form-group lin-hgt"> 
                          <label class="label-deco fnt-wt">Category</label>
                          <select class="form-control" name="category" id="category">
                            <option value="">Select category</option>
                            <?php foreach ($category as $rows) { ?>
                                <option value="<?php echo $rows['id'] ?>"><?php echo $rows['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <input type="hidden" id="latitude" />  
                      <input type="hidden" id="longitude" />
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group lin-hgt">
                          <label class="fnt-wt">Address</label>
                          <input onkeyup="initialize();"  class="form-control" id="address" name="address" placeholder="" type="text">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="login-snd">
                  <a href="javascript:void(0);"><button type="button" class="m-btn login-btn user_registration" onclick="checkUserSelect();">Sign Up</button></a>
                </div>
                <div class="or-text"><span>OR</span></div>
                <div class="facebook-link">
                    <div id="status"></div>
                    <a href="#" onclick="fbLogin()" id="fbLink1"><span class="icon fa fa-facebook"></span>Sign in with Facebook</a>
                    <div id="userData"></div>
                </div>
                <div class="agree login-link">
                  Already a member? <a href="#" id="login_account" ><span style="color: #787878 !important;" class="crte-accnt" >Login</span></a>
                </div>
              </form>
            </div>
          </div>
          <!-- <div class="signupRight"></div> -->
        </div>
      </div>
    </div>
  </div>
</div>


<!--forget password-->
            <!-- Modal -->
<div class="modal fade" id="forgotPassword_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                    Forget Your Password
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
                <div class="container">
                    <div class="modal-frgt-para">
                        Dont't Worry ! Just fill in your email and we'll help you reset your password.
                    </div>
                    <div class="form-group lin-hgt">
                        <label class="fnt-wt">Email</label>
                        <input class="form-control" id="inputEmail" onkeyup="emptyEmail()" placeholder="Enter email" type="text">
                    </div><!--/form-group-->
                </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
                <div class="modal-footer brdr-top">
                    <a href="javascript:void(0)"><button type="button" id="btnDisEmil" onclick="sendMail()" class="btn btn-primary m-btn" disabled="">Send</button></a>
                </div>                                                                      
            </div>
            <div class="bck-arrow-clr">
                <div class="arrow-bck close float forBtn" data-dismiss="modal" >
                    <i class="bck fa fa-arrow-left"></i><span> Back to login</span>
                </div>
            </div><!--/bck-arrow-clr-->         
        </div>
    </div>
</div>




<script type="text/javascript">
  function emptyEmail(){
    $('#btnDisEmil').prop('disabled', true);
    var mail = $('#inputEmail').val();
    if(mail){
      $('#btnDisEmil').prop('disabled', false);
    }
  }
</script>

<div class="modal fade" id="category_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog slct-ctrgy" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                    Select Your Category
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body">
                <?php foreach ($category as $rows) { ?>
                <div onclick=" $('#select_cat').click();" class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <!--test-->
                        <div class="rad-type">
                            <div class="cat-type">
                                <span class="radio-inline">
                                    <input name="category" price="<?php echo $rows['name'] ?>" type="radio" value="<?php echo $rows['id'] ?>">
                                    <label><?php echo $rows['name'] ?></label>

                                </span>
                            </div><!--/cat-type-->
                        </div><!--/rad-type-->
                        <!--/test-->
                    </div>
                </div>
                <?php } ?>
                <div class="row" style="margin:20px 0 0 0;">
                    <div class="col-lg-12 col-md-12 col-sm-12 slct-btn2">
                        <a href="javascript:void(0)"><button onclick="setVal();" type="button" id="select_cat" class="m-btn sbmt-btn">Done</button></a>
                    </div>
                </div>
            </div>
            <div class="modal-footer brdr-top-disms left-flt">
                <div class="arrow-bck close float" data-dismiss="modal" >
                    <i class="bck fa fa-arrow-left"></i><span> Close</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }else{ ?>
<style type="text/css">
    img[src=""] {
        display: none;
    }
  
</style>
<!-- Chat modal start -->
<input type="hidden" name="defaultImg" id="defaultImg" value="<?php echo base_url().USER_DEFAULT_AVATAR; ?>">
<input type="hidden" name="myId" id="myId" value="<?php echo $this->session->userdata('id') ?>">
<input type="hidden" name="myName" id="myName" value="<?php echo $this->session->userdata('fullName') ?>">
<input type="hidden" name="myEmail" id="myEmail" value="<?php echo $this->session->userdata('email') ?>">
<input type="hidden" name="myImage" id="myImage" value="<?php echo $this->session->userdata('image') ?>">
<input type="hidden" name="" id="user_type" value="<?php echo $this->session->userdata('userType'); ?>">
<input type="hidden" name="chatRoom" id="chatRoom" value="0">
<input type="hidden" id="startFrom" value="0" >
<input type="hidden" name="" id="op_chat_id" value="">
<input type="hidden" name="" id="op_chat_name" value="">
<input type="hidden" name="" id="op_chat_image" value="">
<div class="modal fade chat-modal" id="ChatModal" role="dialog">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="row app-one app">
                    <div class="col-sm-4 side cht-rgt-pdng left_msg">
                        <div class="side-one">
                            <div class="row heading cht-clor">
                                <div class="col-sm-3 col-xs-12 heading-avatar head-msg">
                                    Messages<span class="fa fa-arrow-left newMsg-back" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="row searchBox">
                                <div class="col-sm-12 searchBox-inner">
                                    <div class="form-group has-feedback">
                                        <input id="searchText" class="form-control" name="searchText" placeholder="Search" type="text" onkeyup="getChatHistory()">
                                        <span class="fa fa-search"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row sideBar chat-scrl" id="chatHistory">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 conversation">
                        <div class="row heading cht-clor">
                            <div class="col-sm-2 col-md-1 col-xs-1 heading-avatar">
                                <div class="heading-avatar-icon">
                                    <img src="" id="o_image">
                                </div>
                            </div>
                            <div class="col-sm-8 col-xs-5 heading-name pdng-cstm" id="o_name">
                                <a href="#" id="o_url" class="heading-name-meta cht-redi"></a>
                                <span class="heading-online">Online</span>
                            </div>
                            <!--dropdown-->
                            <div class="col-xs-1">
                                <span class="fa fa-comment newMsg" aria-hidden="true"></span>
                            </div>
                            <div class="col-sm-1 col-xs-1 heading-dot pull-right" id="hide-blk-del">                  
                                <div class="dropdown cht-drpdwn">
                                    <button class="btn btn-secondary dropdown-toggle chtn-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i></button>
                                    <div class="dropdown-menu drop-cht" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item blck" id="block" onclick="blockUser();" href="javascript:void(0)">Block</a>
                                        <a class="dropdown-item blck" id="unblock" onclick="unblockUser();" href="javascript:void(0)" style="display: none;" >Unblock</a>
                                        <!-- <a href="javascript:void(0)" class="dropdown-item" onclick="deleteChat()">Delete</a> -->
                                        <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#chatDeleteModal">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <!--/dropdown-->
                        </div>
                        <div class="message" id="conversation">

                        </div>
                        <div class="row reply" id="dis-field">
                            <div class="col-sm-9 col-xs-8 reply-main">
                                <textarea class="form-control emojiable-option" rows="2" id="lastMsg" placeholder="Type a message here" ></textarea>
                            </div>
                            <div class="col-sm-1 col-xs-1 reply-send" onclick="sendMsg();">
                                <i class="fa fa-send fa-2x" aria-hidden="true"></i>
                            </div>
                            <div class="col-sm-1 col-xs-1 reply-send img-add">
                                <input accept="image" style="display:none;" type="file" name="file-1" id="fileInput">
                                <i onclick="document.getElementById('fileInput').click()" class="fa fa-picture-o fa-2x" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display:none;" class="paginationChat" ></div>
<!-- Chat modal end -->
 <!-- image preview modal -->
<div id="myModal" class="pre-img-modal">
    <span class="close-img-modal">×</span>
    <img class="modal-content-cht" id="img01">
</div>

<!-- Delete chat modal  -->
<div class="modal fade" id="chatDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                    Delete
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
                <div class="container">
                    <div class="dlte-cnfrmtn">
                        Are you sure you want to delete this chat ?
                    </div>
                </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
                <div class="modal-footer brdr-top">
                    <button id="next" onclick="deleteChat();"  type="button" class="btn btn-primary">Yes</button>
                </div>                                                                      
            </div>
            <div class="bck-arrow-clr">
                <div class="arrow-bck close float" data-dismiss="modal" >
                    <i class="bck fa fa-arrow-left"></i><span> Back</span>
                </div>
            </div><!--/bck-arrow-clr-->         
        </div>
    </div>
</div>


<!-- Block modal  -->
<div class="modal fade" id="block_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                    Block
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
                <div class="container">
                    <div class="dlte-cnfrmtn">
                        You blocked <span id="blk-usr"></span>,can't send message. 
                    </div>
                </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
                <div class="modal-footer brdr-top" data-dismiss="modal">
                    <button id="next" type="button" class="btn btn-primary del_btn">Ok</button>
                </div>                                                                      
            </div>       
        </div>
    </div>
</div>


<div class="modal fade" id="op_block_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                    Block
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
                <div class="container">
                    <div class="dlte-cnfrmtn">
                        You are blocked by <span id="blk-usr-by"></span>, can't send any message.
                    </div>
                </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
                <div class="modal-footer brdr-top" data-dismiss="modal">
                    <button id="next" type="button" class="btn btn-primary del_btn">Ok</button>
                </div>                                                                      
            </div>       
        </div>
    </div>
</div>
<?php } ?>

<!--  <footer id="contact">
    <div class="container">
     <div class="foot-img"><img src="<?php echo $frontend_assets ?>img/logo02.png"><img class="img-top" src="<?php echo $frontend_assets ?>img/logo03.png"></div>
      <div class="social-link"><ul><li><a href="https://www.facebook.com/tuliatech/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li><li><a href="https://twitter.com/tulia_app"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
        </li><li><a href="https://www.instagram.com/tulia_app_/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li></ul></div>
      <ul class="footer-contact">
     </ul>
    </div>
</footer> 


<div class="copyright">Copy Right © By Tulia 2017-18 | All Rights Reserved.</div> -->
<section class="footer">
    <div class="row">
            <div class="display-inlne-block">
               <div class="float-lft-sec">                   
                   <div class="footer-lnks mrgn-tp">
                        <ul>
                            <a class="page-scroll" href="<?php echo base_url();?>home/terms_and_conditions/#how-it-wrk"><li>How It Works</li></a>
                            <li>|</li>
                            <a class="page-scroll" href="<?php echo base_url();?>home/terms_and_conditions/#term-condition"><li>Terms and Condition</li></a>
                            <li>|</li>
                            <a class="page-scroll" href="<?php echo base_url();?>home/terms_and_conditions/#privcy-policy"><li>Privacy Policy</li></a>
                            <li>|</li>
                            <a class="page-scroll" href="<?php echo base_url();?>home/terms_and_conditions/#lern-more"><li>Learn More</li></a>
                            <li>|</li>
                            <a class="page-scroll" href="<?php echo base_url();?>home/terms_and_conditions/#cntct-us"><li>Contact Us</li></a>
                        </ul>
                    </div>
               </div> 
               <div class="float-rgt-sec">
                   <div class="foot-img"><img src="<?php echo $frontend_assets ?>img/logo02.png"><img class="img-top" src="<?php echo $frontend_assets ?>img/logo03.png"></div>
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="display-inlne-block">
                <div class="float-lft-sec">
                    <div class="copy-sec">
                        <p>Copy Right © By Tulia 2017-18 | All Rights Reserved.</p>
                    </div>
                </div>
                <div class="float-rgt-sec">
                    <div class="copy-sec">
                        <ul>
                            <span>Follow us on:</span>
                            <a href="https://www.facebook.com/tuliatech/"><li class="fa fa-facebook"></li></a>    
                            <a href="https://twitter.com/tulia_app"><li class="fa fa-twitter"></li></a>
                            <a href="https://www.instagram.com/tulia_app_/"><li class="fa fa-instagram"></li></a>      
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
    </div>
    <div id="divLoading" class="tlr_loader" style="display: none;"></div>
</section>
<div class="modal fade" id="mypopupmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                 Location Update
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
                <div class="container">
                    <div class="dlte-cnfrmtn">
                      Your location is missing. Please update your location or else your account might get deactivated.

                    </div>
                </div>
            </div><!--/modal-frgt-body-->
            <div class="container">
                <div class="modal-footer brdr-top modal-btn1">
                  <button   data-dismiss="modal" type="button" class="btn btn-primary del_btn" >Cancel</button>
                <button   onclick="location.href='<?php echo base_url()?>home/users/editProfile';" type="button" class="btn btn-primary del_btn" >Ok</button>
                
                  
                </div>                                                                      
            </div>       
        </div>
    </div>
</div>
<!-- Back to Top --> 
<a href="#" id="back-to-top" title="Back to top"><img src="<?php echo $frontend_assets ?>img/top-arrow.png" alt=""></a> 

<!-- js file  --> 

<script src="<?php echo $frontend_assets ?>js/bootstrap.js" ></script>
<script src="<?php echo $frontend_assets ?>js/moment.js" ></script>
<script src="<?php echo $frontend_assets ?>js/bootstrap-datetimepicker.min.js" ></script>
<script src="<?php echo $frontend_assets ?>js/owl.carousel.js" ></script> 
<script src="<?php echo $frontend_assets ?>js/sketch.js" ></script>
<!-- <script src="<?php //echo $frontend_assets ?>js/plugins.js"></script> --> 
<script src="<?php echo $frontend_assets ?>js/menuzord.js" ></script> 
<script src="<?php echo $frontend_assets .auto_version('/js/main.js') ?>" ></script>
<!-- <script src="<?php //echo $frontend_assets ?>js/main-min.js" ></script> -->
<script src="<?php echo $frontend_assets ?>toastr/toastr.min.js" ></script>
 <!-- Light Gallery Plugin Js -->
<script src="<?php echo $frontend_assets ?>light-gallery/js/lightgallery.js" ></script>
<script src="<?php  echo $frontend_assets.auto_version('/custom/js/front_common.js') ?>" ></script>
 <!-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js" ></script>  -->

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

 
 
 

<script src="<?php  echo $frontend_assets.auto_version('/custom/js/validation.js') ?>" ></script>
<?php if(!empty($this->session->userdata('id'))){ ?>
<script src="<?php  echo $frontend_assets?>js/chat.js" ></script>
<script src="<?php  echo $frontend_assets?>/custom/js/jquery.emojipicker.js" ></script>
<script src="<?php  echo $frontend_assets?>/custom/js/jquery.emojis.js" ></script>
<script>
    $( document ).ready(function() {
        $('#lastMsg').emojiPicker({
            onShow: function(picker, settings, isActive) {
            }
        });   
    });

</script>
<?php } load_js($front_scripts);  //load required page js ?>

</body>
</html>
<style type="text/css">
    #chatHistory .sideBar-body .sideBar-name span.fa-comment:before{
        color: red;
        position: absolute;
        right: -69px;
    }
</style>
<script>

    function show_loader(){ 
        $("div#divLoading").addClass('show');
    }
    function hide_loader(){
        $("div#divLoading").removeClass('show');
    }

    window.setInterval(function(){
        //myFunction();
    }, 60000);


    
    function myFunction(){
        $.ajax({
            url: '<?php echo base_url() ?>home/Vendorpost/checklogin',
            type: "get",
            data: {},
            cache: false,
            success: function(result) {

                if(result != '0'){

                    $.each(JSON.parse(result), function(key, value) {
                        spawnNotification(value.notification_message.body,value.notification_message.title)
                    });
                }
            }
        });
    }


    Notification.requestPermission().then(function(result) {
        console.log(result);
    });


    Notification.requestPermission();
    function spawnNotification(theBody,theTitle) {
    
        var options = {
            body: theBody,
        }
        var notification = new Notification(theTitle, options);
        notification.onclick = function(event) {
            event.preventDefault(); // prevent the browser from focusing the Notification's tab
        }
        setTimeout(notification.close.bind(notification), 7000);
    }

</script>

