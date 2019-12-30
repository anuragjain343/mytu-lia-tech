

<!--vendor category-->
<section id="content" class="site-content sec-pad">
    <div class="container content-container">
    <div class="row mrgn-btm">
    <!--left portion-->
    <!--right-portion-->

    <div  class="total-title">
 
</div>

    <div class="col-lg-offset-1 col-lg-10 col-md-10 col-sm-12">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <section>
                    <header class="vendor-cate-head">
                      <!--   <div class="row">
                            <div class="wrap">
                                <div class="search">
                                    <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $cat_id; ?>">
                                    <input type="text" name="search_name" id="search_name" class="searchTerm vendor-search" placeholder="Search Vendor"  />
                                    <button type="submit" class="searchButton">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div> -->
                       
                <form id="search">
                    <div class="row">
                        <div class="head-txt">
                            <h2>SEARCH FOR EVENT VENDORS</h2>
                        </div> 
                     <div class="wrap" id="ad-select">
                        <div class="row text-center">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                               <div class="form-group" id="search_name"><!-- 
                                  <label class="label-deco label-whte" style="color:white;">I am looking for:</label> -->
                                 <input type="hidden" id ="lt" name="lati"  value="<?php echo $lat; ?>">
                                 <input type="hidden" id ="lng" name="longi" value="<?php echo $long; ?>">
                                  <select class="form-control add-post-frm our-srch bck-img" name="category" id="cat_id">
                                
                                    <option >Select Vendor</option>
                                    <?php foreach($category as $key => $val){ ?>
                                        <option value="<?php echo encoding($val['id']);?>" <?php if(!empty($cat_id) AND !empty($val['id']) AND $cat_id == $val['id']){echo "selected";}?>>
                                            <?php echo $val['name'];?>  
                                        </option>
                                    <?php }?>
                                  </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <!-- <label class="label-deco label-whte" style="color:white;">In:</label> -->
                                
                                <div class="search">
                                    <?php if(!empty($location)){ ?>
                                    <input type="text" class="searchTerm vendor-search our-srch inpt-rel" name="address" id="address_google" placeholder="Enter location" value="<?php echo $location; ?>"/>
                                     <input type="hidden" id="fbUserLocLat" name="fbUserLocLat" value="<?php echo $lat; ?>" >
                                    <input type="hidden" id="fbUserLocLong" name="fbUserLocLong" value="<?php echo $long; ?>">

                                    <?php } else{?>
                                     <input type="text" class="searchTerm vendor-search our-srch inpt-rel" name="address" id="address_google" placeholder="Enter location" value=" " />
                                      <input type="hidden" id="fbUserLocLat" name="fbUserLocLat" value="" >
                                    <input type="hidden" id="fbUserLocLong" name="fbUserLocLong" value="">
                                    <?php }?>

                                   
                                    <span class="fa fa-map-marker our-spn"></span>
                               </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <button type="submit" class="m-btn m-btn3 m-btn2">Search</button>
                            </div>
                        </div>
                    </div>
              </div>
              </form>
                    </header>
                    <div class="woocommerce columns-3">
                        <ul class="product-loop-categories">
                            <!--first vendor-->
                            <div id="ajaxData"></div>
                          
                        </ul><!--/product-loop-categories-->
                    </div><!--/woocommerce columns-3-->
                    <!--pagination-->
                </section>
            </main>
        <!--/pagination-->
        </div>
    </div>
</section>

<div class="modal fade" id="check_login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog frgt-pswd" role="document">
        <div class="modal-content">
            <div class="modal-header bg-img">
                <div class="frgt-head">
                  Login  
                </div><!--/frgt-head-->
            </div>
            <div class="modal-body modal-frgt-body">
                <div class="container">
                    <div class="dlte-cnfrmtn">
                        Please login first to chat with vendor.
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


<script type="text/javascript">
  function show_loader(){ 
        $("div#divLoading").addClass('show');
    }
    function hide_loader(){
        $("div#divLoading").removeClass('show');
    }

   

/*function showpopup(){

    $('#mypopupmodel').modal('show');
}*/
    
 /* window.onload = function () {                                                  
    $('#mypopupmodel').modal('show');                            
  }; */

    $('#search_name').keyup(function() {
        var $th = $(this);
        $th.val($th.val().replace(/(\s{2,})|[^a-zA-Z']/g, ' '));
        $th.val($th.val().replace(/^\s*/, ''));
   });


    var currentRequest;
    $('#search_name').keyup(function() {
        $("#ajaxData").html('');
        pagination(base_url +"home/users/vendor_cat_list/");
    });
        

    pagination(base_url +"home/users/vendor_cat_list/");
    function pagination(url){


        var search_name= $('#search_name').val().trim(),
             cat_id = $('#cat_id').val();
             latitude = $('#lt').val();
            longitude = $('#lng').val();


    


        var currentRequest = $.ajax({
            url: url,
            type: "POST",
            data:{page: url,id:cat_id,letitu:latitude,longitu:longitude},              
            cache: false,   
            beforeSend: function() {
                 show_loader();
                if(currentRequest != null) {
                    currentRequest.abort();
                }

            },                          
            success: function(data){ 
                hide_loader();
              
                $("#ajaxData").html(data);
                $("#ven_cat").addClass("active");
            }
        });
    }


$("#search").submit(function(e){
    e.preventDefault();
     cat_id = $('#cat_id').val();
      address_google = $('#address_google').val();
      fbUserLocLat = $('#fbUserLocLat').val();
      fbUserLocLong = $('#fbUserLocLong').val();
    
     
      if(cat_id=='Select Vendor' && address_google==='') {
         var  current_url =  "http://tulia.tech/home/users/vendorList";
      }
      else if(cat_id === ' ' || cat_id=='Select Vendor') {
        var  current_url =  "http://tulia.tech/home/users/vendorList?location="+address_google+ "&lat="+fbUserLocLat+ "&long="+fbUserLocLong;
       
      }
      else if(address_google==='' ){
      var  current_url =  "http://tulia.tech/home/users/vendorList?id="+cat_id;

      }
       
      else{
        var  current_url =  "http://tulia.tech/home/users/vendorList?id="+cat_id+ "&location="+address_google+ "&lat="+fbUserLocLat+ "&long="+fbUserLocLong;
          //$('div.total-title').text(current_url);
           
      }


      

    $.ajax({
        url: base_url +"home/users/vendor_cat_list/",
        type: "POST",
        data:new FormData(),              
        cache: false,   
        contentType: false,
        processData: false,
        data: new FormData(this),
      
        beforeSend: function() {
             show_loader();
            if(currentRequest != null) {
                currentRequest.abort();
            }  
        },                          
        success: function(data){      
          hide_loader();
            $("#ajaxData").html(data);
            
            $("#ven_cat").addClass("active");
             
            window.history.pushState("object or string", "Title", current_url);
        }
    });
});

//set google place autocomplete in new elements
var loc_inputs = [
    'address_google',
    'fbUserLocLat',
    'fbUserLocLong'
];
var loc_inp_arr = [];
for (var i = 0; i < loc_inputs.length; i++) {
    loc_inp_arr.push(jQuery('#'+loc_inputs[i]));
}
setupAutocomplete(loc_inp_arr, 0);


//google autocomplete setup
function setupAutocomplete(the_input_arr, i) {

    var autocomplete = [];
    var the_input_loc = the_input_arr[0]; //location input jquery object
    var the_input_lat = the_input_arr[1]; //latitude input jquery object
    var the_input_long = the_input_arr[2]; //longitude input jquery object

    autocomplete.push(new google.maps.places.Autocomplete(the_input_loc[0]));
    var idx = autocomplete.length - 1;

    //clear old lat-long on change
    the_input_loc.keydown(function(){
        console.log('in change');
        the_input_loc.removeClass('missfields');
        the_input_lat.val('');
        the_input_long.val('');
    });

    //google.maps.event.addListener(autocomplete[i], 'place_changed', function() {
    google.maps.event.addListener(autocomplete[idx], 'place_changed', function() {

        console.log('in dynamic');

        // Get the place details from the autocomplete object.
        var place = autocomplete[idx].getPlace();

        if (!place.geometry) {
            the_input_loc.addClass('missfields');
            toastr.error(valid_loc_msg);
            return;
        }

        //loaction is correct, grab lat long here
        the_input_loc.removeClass('missfields');
        var place_lat = place.geometry.location.lat();
        var place_long = place.geometry.location.lng();
        the_input_lat.val(place_lat);
        the_input_long.val(place_long);
        
        //get country from location and pre-set it to country dropdown
        var country_dd = jQuery("#country");
        if(country_dd.length>0){
            console.log(place.address_components);
            var componentForm = {
                country: 'short_name'
            };
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    country_dd.intlTelInput("setCountry", val.toLowerCase()); //set country in dropdown
                }
            }
        }
    });
}
 
</script>