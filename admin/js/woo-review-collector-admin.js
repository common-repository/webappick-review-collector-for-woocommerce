(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 */
      $(function() {

          $("#wrc_max_email").on("click",function (){
              alert("Free version only support 1 review request email per order.");
          });

          $(document).on('click','.wcr_tabs li',function(){

              var tab_id = $(this).attr('data-tab');
              $('ul.wcr_tabs li').removeClass('current');
              $('.wcr-tab-content').removeClass('current');
              $(this).addClass('current');
              $('#'+ tab_id).addClass('current');

          });

          // set active of Setting tab

          // //To set default checked in setting tab if not found any localStorage value for active tab


          $("input[name='wrc_webappick_tabs']").on('change',function () {
              var selectedTab = $(this).val();
              sessionStorage.setItem('wrc_active_tab', selectedTab);

          });

          var  activeTab = sessionStorage.getItem('wrc_active_tab');


          if(activeTab === "general"){
              $('#tab1').attr("checked", true);

          }else if(activeTab === "email"){
              $('#tab2').attr("checked", true);

          }else if(activeTab === "blacklist"){
              $('#tab3').attr("checked", true);

          }
          // set active of Setting tab ended


          //Monthly review limit handle

          $(".wrc_monthly_review_limit").click( function(){
              var notice_status = 1;
              if(notice_status === 1){
                  $.post(wrc_dismiss_admin_notice_ajax_obj.wrc_dismiss_admin_notice_ajax_url, {
                      _ajax_nonce: wrc_dismiss_admin_notice_ajax_obj.nonce, //nonce
                      action: "dismiss_admin_notice",
                      notice_status: notice_status
                  }, function (data) {

                  });
              }
          });

          // Send Test Email
          $(document).on("click","#sendTestEmail",function(){
              $("#testEmailSection").show();
          });

          $(document).on("keyup","#wrc_email_body",function(){
              var body=$(this).val();
              $("#emailBodyShow").html(body.replace(/\r?\n/g,'<br/>'));
          });

          $(document).on("keyup","#wrc_email_signature",function(){
              var body=$(this).val();
              $("#emailSignatureShow").html(body.replace(/\r?\n/g,'<br/>'));
          });

          // Get Merchant View
          $(document).on('click',"#send-wrc-email-test", function (event) {
              event.preventDefault();
              var email = $("#wrc-test-email").val();
              if(email==""){
                  alert("Please enter a valid email address.");
                  return ;
              }else{
                  $("#testEmailStatusSection").html("<b style='color: #003f81;'>Sending...</b>");

                  $.post(wrc_test_email_ajax_obj.wrc_test_email_ajax_url, {     //POST request
                      _ajax_nonce: wrc_test_email_ajax_obj.nonce, //nonce
                      action: "send_test_email",               //data
                      email: email               //data
                  }, function (data) {                //callback
                      //insert server response

                      if(data.status === true) {
                          $("#testEmailStatusSection").html("<b style='color:#008000;'>Email Sent Successfully.</b>");
                      }else{
                          $("#testEmailStatusSection").html("<b style='color:#FF0000;'>Email Sent Failed.</b>");

                      }
                      $("#wrc-test-email").val("");


                  });
              }
          });

          //BlackList email removing
          $(document).on('click',"#wrc_remove_blockList", function (event) {
              event.preventDefault();
              var email = $('#wrc_blackList_email_input').val();
              if( !validateEmail(email)){
                  alert('Please Enter a valid email.');
              }else{
                  $("#wrc_blackListEmailStatus").html("<b style='color: #003f81;'>Removing...</b>");

                  $.post(wrc_black_list_email_removing_ajax_obj.wrc_black_list_email_removing_ajax_url, {     //POST request
                      _ajax_nonce: wrc_black_list_email_removing_ajax_obj.nonce, //nonce
                      action: "black_list_email_removing",               //data
                      email: email               //input email
                  }, function (data) {                //callback
                      //insert server response
                      console.log(data);
                      if(data.status === true) {  //For notification showing
                          $("#wrc_review_collection_email_blacklist").html(data.remaining_email);
                          $('#wrc_blackList_email_input').val("");
                          $("#wrc_blackListEmailStatus").html("<b style='color:#008000;'>Email Deleted Successfully.</b>");
                      }else{
                          $("#wrc_blackListEmailStatus").html("<b style='color:#FF0000;'>Email Not Found.</b>");
                      }
                  });
              }
          });

          function validateEmail($email) {
              var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
              return emailReg.test( $email );
          }

	  });

	 /* When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */




})( jQuery );
